<?php

namespace App\Http\Controllers;

use App\Data\GithubOAuth;
use App\Data\GoogleOAuth;
use App\Models\User;
use Google\Client;
use Google\Service\Oauth2;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class GETController extends Controller
{
    public function newHome()
    {
        return view('new_home');
    }

    public function home()
    {
        if (session('user_logged_in') === true) {
            return redirect('/profile');
        }


        session([
            'state' => session()->getId() . ";" . session()->token(),
            'google_client_id' => GoogleOAuth::CLIENT_ID,
            'google_redirect_uri' => GoogleOAuth::getRedirectURI(),
            'github_client_id' => GithubOAuth::CLIENT_ID,
            'github_redirect_uri' => GithubOAuth::getRedirectURI(),
        ]);
        return view('home');
    }


    public function googleLogin()
    {
        //validate state: session id and csrf token
        $state = explode(";", $_GET['state']);
        session()->setId($state[0]);
        session()->start();
        if (session()->token() !== $state[1]) {
            return new Response("Invalid state parameter", 401);
        }

        $g_client = new Client();
        $g_client->setClientId(GoogleOAuth::CLIENT_ID);
        $g_client->setClientSecret(GoogleOAuth::CLIENT_SECRET);
        $g_client->setRedirectUri(GoogleOAuth::getRedirectURI());
        $g_client->addScope('email');
        $g_client->addScope('profile');
        $token = $g_client->fetchAccessTokenWithAuthCode($_GET['code']);
        $g_client->setAccessToken($token['access_token']);

        $google_oauth = new Oauth2($g_client);
        $profile = $google_oauth->userinfo->get();


        //check if the id exists
        $users_count = User::where('email', $profile->email)->count();
        if ($users_count === 0) {
            //add the user
            $user = new User();
            $user->first_name = $profile->givenName;
            $user->last_name = $profile->familyName;
            $user->email = $profile->email;
            $user->picture = $profile->picture;
            $user->third_party_id = $profile->id;
            $user->save();
        } else {
            //edit the user
            User::where('email', $profile->email)
                ->update([
                    'first_name' => $profile->givenName,
                    'last_name' => $profile->familyName,
                    'email' => $profile->email,
                    'picture' => $profile->picture,
                    'third_party_id' => $profile->id,
                ]);
        }

        //set the user state: logged in
        session([
            'user_logged_in' => true,
            'user_email' => $profile->email,
            'user_first_name' => $profile->givenName,
            'user_last_name' => $profile->familyName,
            'user_picture' => $profile->picture,
        ]);

        //redirect to profile
        return redirect('/profile');
    }



    public function facebookLogin()
    {
        $state = explode(";", $_GET['state']);
        session()->setId($state[0]);
        session()->start();
        if (session()->token() !== $state[1]) {
            return new Response("Invalid state parameter", 401);
        }

        $query = http_build_query([
            'fields' => 'first_name,last_name,email,picture',
            'access_token' => $_GET['access_token']
        ]);

        $profile_res = Http::get("https://graph.facebook.com/{$_GET['user_id']}?$query");
        $profile = json_decode($profile_res->body(), true);

        $existing_profiles = User::where('email', $profile['email'])->count();
        if ($existing_profiles === 0) {
            //create new user
            $user = new User();
            $user->first_name = $profile['first_name'];
            $user->last_name = $profile['last_name'];
            $user->email = $profile['email'];
            $user->picture = $profile['picture']['data']['url'];
            $user->third_party_id = $profile['id'];
            $user->save();
        } else {
            //update existing user
            User::where('email', $profile['email'])
                ->update([
                    'first_name' => $profile['first_name'],
                    'last_name' => $profile['last_name'],
                    'email' => $profile['email'],
                    'picture' => $profile['picture']['data']['url'],
                    'third_party_id' => $profile['id'],
                ]);
        }

        //set the user state: logged in
        session([
            'user_logged_in' => true,
            'user_email' => $profile['email'],
            'user_first_name' => $profile['first_name'],
            'user_last_name' => $profile['last_name'],
            'user_picture' => $profile['picture']['data']['url'],
        ]);

        return redirect('/profile');
    }



    public function githubLogin()
    {
        $state = explode(";", $_GET['state']);
        session()->setId($state[0]);
        session()->start();
        if (session()->token() !== $state[1]) {
            return new Response("Invalid state parameter", 401);
        }

        $query = http_build_query([
            'client_id' => GithubOAuth::CLIENT_ID,
            'client_secret' => GithubOAuth::CLIENT_SECRET,
            'code' => $_GET['code'],
            'redirect_uri' => GithubOAuth::getRedirectURI(),
        ]);

        $tokens_res = Http::post("https://github.com/login/oauth/access_token?$query");

        parse_str($tokens_res->body(), $tokens);

        $profile = json_decode(
            Http::withHeaders([
                'Authorization' => "token {$tokens['access_token']}",
            ])->get("https://api.github.com/user")->body(),
            true
        );

        $profile_name = explode(" ", $profile['name']);

        $users_count = User::where('email', $profile['email'])->count();
        if ($users_count === 0) {
            //add new user
            $user = new User();
            $user->first_name = $profile_name[0];
            $user->last_name = end($profile_name);
            $user->email = $profile['email'];
            $user->picture = $profile['avatar_url'];
            $user->third_party_id = $profile['id'];
            $user->save();
        } else {
            //update existing user
            User::where('email', $profile['email'])
                ->update([
                    'first_name' => $profile_name[0],
                    'last_name' => end($profile_name),
                    'email' => $profile['email'],
                    'picture' => $profile['avatar_url'],
                    'third_party_id' => $profile['id'],
                ]);
        }

        //login
        session([
            'user_logged_in' => true,
            'user_first_name' => $profile_name[0],
            'user_last_name' => end($profile_name),
            'user_email' => $profile['email'],
            'user_picture' => $profile['avatar_url'],
        ]);

        return redirect('/profile');
    }



    public function profile()
    {
        if (session('user_logged_in') !== true) {
            return redirect('/');
        }

        return view('profile');
    }



    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
