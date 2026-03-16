 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>{{ $title ?? 'Adrahan Clothing ' }}</title>

     <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
     <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
     <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
     <link rel="manifest" href="{{ asset('icons/site.webmanifest') }}">
     <meta name="description"
         content="{{ $description ?? 'Shop premium clothing at Adrahan Clothing. Discover modern wardrobe essentials with clean design and quality fabrics.' }}">
     <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" />
     <link href="{{ asset('css/css2/css2.css') }}" rel="stylesheet" />
     <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet" />
     <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Inter:wght@400&display=swap"
         rel="stylesheet">
     <link href="{{ asset('css/custom/style.css') }}" rel="stylesheet" />

     <!-- Meta Pixel Code -->
     <script>
         ! function(f, b, e, v, n, t, s) {
             if (f.fbq) return;
             n = f.fbq = function() {
                 n.callMethod ?
                     n.callMethod.apply(n, arguments) : n.queue.push(arguments)
             };
             if (!f._fbq) f._fbq = n;
             n.push = n;
             n.loaded = !0;
             n.version = '2.0';
             n.queue = [];
             t = b.createElement(e);
             t.async = !0;
             t.src = v;
             s = b.getElementsByTagName(e)[0];
             s.parentNode.insertBefore(t, s)
         }(window, document, 'script',
             'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '1451047986495074');
         fbq('track', 'PageView');
     </script>
     <noscript>
         <img height="1" width="1"
             src="https://www.facebook.com/tr?id=1451047986495074&ev=PageView&noscript=1" />
     </noscript>
     <!-- End Meta Pixel Code -->
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

         const mobileDrawer = document.getElementById('mobileDrawer');
         const mobileMenuToggle = document.getElementById('mobileMenuToggle');
         const mobileDrawerClose = document.getElementById('mobileDrawerClose');
         const mobileDrawerBackdrop = document.getElementById('mobileDrawerBackdrop');

         function openMobileDrawer() {
             if (!mobileDrawer) return;
             mobileDrawer.classList.add('open');
             document.body.style.overflow = 'hidden';
         }

         function closeMobileDrawer() {
             if (!mobileDrawer) return;
             mobileDrawer.classList.remove('open');
             document.body.style.overflow = '';
         }

         if (mobileMenuToggle) {
             mobileMenuToggle.addEventListener('click', openMobileDrawer);
         }

         if (mobileDrawerClose) {
             mobileDrawerClose.addEventListener('click', closeMobileDrawer);
         }

         if (mobileDrawerBackdrop) {
             mobileDrawerBackdrop.addEventListener('click', closeMobileDrawer);
         }

         document.querySelectorAll('.mobile-drawer-nav a').forEach(link => {
             link.addEventListener('click', closeMobileDrawer);
         });

         window.addEventListener('resize', function() {
             if (window.innerWidth >= 992) {
                 closeMobileDrawer();
             }
         });
     </script>

     <x-chat />
 </body>

 </html>
