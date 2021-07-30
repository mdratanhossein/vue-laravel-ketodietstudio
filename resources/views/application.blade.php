<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Keto Diet Studio</title>

    <link rel="stylesheet" href="{{ asset(mix('css/main.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/iconfont.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/vuesax.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  </head>
  <body>

    <div id="app"></div>

    <!-- <script src="js/app.js"></script> -->
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script src="https://js.stripe.com/v3/"></script>

  </body>
</html>
