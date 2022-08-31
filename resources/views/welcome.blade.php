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

  {!!App\Http\Helpers\Vite::resources(env("VITE_ENTRY_JS"))!!}
</body>
</html>
