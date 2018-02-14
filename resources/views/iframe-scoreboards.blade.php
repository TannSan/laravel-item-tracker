<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/dps_club_scoreboards.css') }}" rel="stylesheet">
    <base target="_parent">
</head>
<body id="iframed">
   @include('partials.scoreboards')
</body>
</html>