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
          <img src="{{ session('picture') }}" alt="">
        </div>
        <h2>{{ session('name') }}</h2>
        <p>Email: {{ session('email') }}</p>
        <form action="logout" method="GET">
          <input type="submit" value="Logout">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
