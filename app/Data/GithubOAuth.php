<?php

namespace App\Data;

class GithubOAuth
{
  const CLIENT_ID = 'enter-yours-here';
  const CLIENT_SECRET = 'enter-yours-here';
  public static function getRedirectURI()
  {
    return env('APP_URL') . "/github-login";
  }
}
