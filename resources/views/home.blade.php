<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('style')
  <title>OAuth Login</title>
</head>
<body>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId: 'enter-yours-here'
        , autoLogAppEvents: true
        , xfbml: true
        , version: 'v14.0'
      });


      let facebookBtn = document.getElementById('facebook-button')
      facebookBtn.addEventListener('click', function() {
        FB.login(function(response) {
          console.log(response);
          let accessToken = response.authResponse.accessToken;
          let userID = response.authResponse.userID;
          let state = facebookBtn.getAttribute('data-state');
          let redirectURL = `${window.location}facebook-login?access_token=${accessToken}&user_id=${userID}&state=${state}`;
          window.location = redirectURL;
        }, {
          scope: 'public_profile,email'
        });

      });

    };

  </script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

  <div class="container">
    <div class="row">
      <h2 style="text-align:center">Login with Social Media</h2>
      <div class="col">
        {{-- Login with Google --}}
        <form action="https://accounts.google.com/o/oauth2/v2/auth" method="GET" style="width:100%;">
          <input type="hidden" name="client_id" value="{{session('google_client_id')}}">
          <input type="hidden" name="response_type" value="code">
          <input type="hidden" name="scope" value="openid email profile">
          <input type="hidden" name="redirect_uri" value="{{session('google_redirect_uri')}}">
          <input type="hidden" name="state" value="{{session('state')}}">
          <button type="submit" class="google btn">
            <i class="fa fa-google fa-fw"></i>
            Login with Google
          </button>
        </form>

        {{-- Login with Facebook --}}
        <button id="facebook-button" data-state="{{session('state')}}" class="fb btn" style="width:100%;">
          <i class="fa fa-facebook fa-fw"></i>
          Login with Facebook
        </button>


        {{-- Login with Github --}}
        <form action="https://github.com/login/oauth/authorize" method="GET" style="width:100%;">

          <input type="hidden" name="client_id" value="{{session('github_client_id')}}">
          <input type="hidden" name="redirect_uri" value="{{session('github_redirect_uri')}}">
          <input type="hidden" name="scope" value="read:user">
          <input type="hidden" name="state" value="{{session('state')}}">
          <button type="submit" class="github btn">
            <i class="fa fa-github fa-fw"></i>
            Login with Github
          </button>
        </form>
      </div>
    </div>
  </div>



</body>


</html>
