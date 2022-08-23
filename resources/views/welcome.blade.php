<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{env("APP_NAME")}}</title>
</head>
<body>
  <div id="root">
    please enable javascript
  </div>

  @if(env("APP_ENV") === "local")
    <!-- you are in development mode -->
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/resources/js/app.jsx"></script>
  @elseif(env("APP_ENV") === "production")
    <!-- you are in production mode -->
    <link rel="stylesheet" href="{{env("APP_URL")}}/build/{{ $manifest['resources/js/app.css']['file'] }}" />
    <script type="module" src="{{env("APP_URL")}}/build/{{ $manifest['resources/js/app.jsx']['file'] }}"></script>
  @endif
</body>
</html>
