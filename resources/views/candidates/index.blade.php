<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>MZT test assignment</title>
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet">
      <style>
         body {
            font-family: 'Roboto', sans-serif;
         }
      </style>
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   </head>
   <body>
      <div id="app">
         <div class="w-full p-6 bg-teal-100 text-right font-bold">Your wallet has: <span id="no-of-coins">{{ $coins ?? '?' }}</span> coins</div>
         <candidates :candidates="{{ json_encode($candidates) }}" :desired-soft-skills="{{ json_encode($desiredSoftSkills) }}"></candidates>
         <mvp-candidates></mvp-candidates>
      </div>
      <script src="{{ mix('/js/app.js') }}"></script>
   </body>
</html>