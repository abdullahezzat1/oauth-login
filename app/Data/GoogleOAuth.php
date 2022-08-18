<?php

namespace App\Data;

class GoogleOAuth
{
  const CLIENT_ID = 'enter-yours-here';
  const CLIENT_SECRET = 'enter-yours-here';
  const SCOPE = "openid profile email";
  public static function getRedirectURI()
  {
    return env('APP_URL') . "/google-login";
  }
}
