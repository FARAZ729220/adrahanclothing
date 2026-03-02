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
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Inter:wght@400&display=swap"
         rel="stylesheet">
     <link href="{{ asset('css/custom/style.css') }}" rel="stylesheet" />
 </head>

 <body>


     <x-navbar />


     <main>
         {{ $slot }}
     </main>



     <x-footer />

     <x-scripts />

     {{ $scripts ?? '' }}

     <script>
         window.setCartBadge = function(count) {
             const badge = document.getElementById('cartCountBadge');
             if (!badge) return;

             count = Number(count || 0);

             if (count > 0) {
                 badge.textContent = count;
                 badge.style.display = 'inline-block';
             } else {
                 badge.style.display = 'none';
             }
         }
     </script>
 </body>

 </html>
