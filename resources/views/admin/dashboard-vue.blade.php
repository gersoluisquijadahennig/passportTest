<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{asset('img/favicon.ico')}}" />
    @vite('resources/css/app.css')
    @routes
    @inertiaHead
  </head>
  <body style="margin-bottom: 0px;">
    @inertia
    @vite('resources/js/app.js')
  </body>
</html>