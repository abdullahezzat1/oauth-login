<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('style')
  <title>Profile</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <div>
          <img src="{{session('user_picture')}}" alt="">
        </div>
        <h2>{{session('user_first_name')}} {{session('user_last_name')}}</h2>
        <p>Email: {{session('user_email')}}</p>
        <form action="logout" method="GET">
          <input type="submit" value="Logout">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
