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
         function handleNavbar() {
             const nav = document.querySelector('.custom-nav');
             if (!nav) return;

             const hero = document.getElementById('homeHero');

             // Non-home pages: always blurred
             if (!hero) {
                 nav.classList.add('nav-scrolled');
                 return;
             }

             // Home page: transparent at top, blurred on scroll
             if (window.scrollY > 50) {
                 nav.classList.add('nav-scrolled');
             } else {
                 nav.classList.remove('nav-scrolled');
             }
         }

         window.addEventListener('scroll', handleNavbar);
         window.addEventListener('load', handleNavbar);
         document.addEventListener('DOMContentLoaded', handleNavbar);

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
         };

         (function() {
             const revealEls = document.querySelectorAll('.reveal, .reveal-stagger');

             document.querySelectorAll('.reveal-stagger').forEach(container => {
                 Array.from(container.children).forEach((child, idx) => {
                     child.style.setProperty('--i', idx);
                 });
             });

             const io = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting) {
                         entry.target.classList.add('is-visible');
                         io.unobserve(entry.target);
                     }
                 });
             }, {
                 threshold: 0.08,
                 rootMargin: '0px 0px -5% 0px'
             });

             revealEls.forEach(el => io.observe(el));
         })();
     </script>
 </body>

 </html>
