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
  <div class="container">
    <div class="row">
      <h2 style="text-align:center">Login with Social Media</h2>
      <div class="col">
        {{-- Login with Google --}}
        <form action="{{ env('APP_URL') }}/oauth/redirect/google" method="GET" style="width:100%;">
          <button type="submit" class="google btn">
            <i class="fa fa-google fa-fw"></i>
            Login with Google
          </button>
        </form>

        {{-- Login with Facebook --}}
        <form action="{{ env('APP_URL') }}/oauth/redirect/facebook" method="GET" style="width:100%;">
          <button type="submit" id="facebook-button" class="fb btn" style="width:100%;">
            <i class="fa fa-facebook fa-fw"></i>
            Login with Facebook
          </button>
        </form>


        {{-- Login with Github --}}
        <form action="{{ env('APP_URL') }}/oauth/redirect/github" method="GET" style="width:100%;">
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
