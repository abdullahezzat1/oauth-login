<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('style')
</head>
<body>

  <div class="container">
    <form action="/action_page.php">
      <div class="row">
        <h2 style="text-align:center">Login with Social Media</h2>

        <div class="col">
          <a href="#" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
          </a>
          <a href="#" class="google btn">
            <i class="fa fa-google fa-fw">
            </i> Login with Google
          </a>
          <a href="#" class="github btn"><i class="fa fa-github fa-fw">
            </i> Login with Github
          </a>

        </div>

      </div>
    </form>
  </div>

</body>
</html>
