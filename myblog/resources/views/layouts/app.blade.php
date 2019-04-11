<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <title>{{ config('app.name', 'MyBlog') }}</title>
    </head>
    <body>
      <div class="">
          @include('inc.navbar')
      </div>
      <div class="container">
          @include('inc.message')
          @yield('content')
      </div>

      <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
      <script>
          CKEDITOR.replace( 'article-ckeditor' );
      </script>
    </body>
</html>
