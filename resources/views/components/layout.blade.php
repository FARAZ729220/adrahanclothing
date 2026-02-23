 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>{{ $title ?? 'Adrahan Clothing ' }}</title>
     <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" />
     <link href="{{ asset('css/css2/css2.css') }}" rel="stylesheet" />
     <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet" />
     <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

     <link href="{{ asset('css/custom/style.css') }}" rel="stylesheet" />
     <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback" defer></script>

 </head>

 <body>


     <x-navbar />


     <main>
         {{ $slot }}
     </main>

     <x-footer />

     <x-scripts />

     {{ $scripts ?? '' }}


 </body>

 </html>
