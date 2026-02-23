   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


   <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('js/aos/aos.js') }}"></script>
   <script src="{{ asset('js/validation.js') }}"></script>

   <script>
       $(function() {

           // ✅ AOS init (if loaded)
           if (typeof AOS !== "undefined") {
               AOS.init({
                   duration: 1000,
                   once: true
               });
           }

           // ✅ Navbar blur on scroll (Works on every page)
           var $nav = $("#mainNav");

           function handleNavScroll() {
               if (!$nav.length) return;

               if ($(window).scrollTop() > 50) {
                   $nav.addClass("scrolled");
               } else {
                   $nav.removeClass("scrolled");
               }
           }

           // run once on load + on scroll
           handleNavScroll();
           $(window).on("scroll", handleNavScroll);


           // ✅ Stats Counter (Only runs if stats exists on the page)
           var $stats = $(".stats-container");

           if ($stats.length) {

               function animateCounters() {
                   $stats.find(".counter").each(function() {
                       var $counter = $(this);
                       var target = parseInt($counter.data("target"), 10) || 0;
                       var speed = target > 50 ? 200 : 50; // same logic as your JS
                       var increment = target / speed;
                       var current = 0;

                       function updateCount() {
                           current += increment;

                           if (current < target) {
                               $counter.text(Math.ceil(current));
                               setTimeout(updateCount, 20);
                           } else {
                               $counter.text(target);
                           }
                       }

                       updateCount();
                   });
               }

               // IntersectionObserver (If supported)
               if ("IntersectionObserver" in window) {
                   var observer = new IntersectionObserver(function(entries, obs) {
                       entries.forEach(function(entry) {
                           if (entry.isIntersecting) {
                               animateCounters();
                               obs.unobserve(entry.target);
                           }
                       });
                   }, {
                       threshold: 0.5
                   });

                   observer.observe($stats.get(0)); // ✅ jQuery element to DOM element
               } else {
                   // Fallback: if old browser, run immediately
                   animateCounters();
               }
           }

       });

       $(document).ready(function() {

           var $filters = $('.filter-btn');
           var $items = $('.portfolio-item');

           function filterItems(category) {

               $items.removeClass('show'); // hide all first

               $items.each(function() {
                   var $item = $(this);

                   if (category === 'all' || $item.data('category') === category) {
                       // restart animation trick
                       $item.removeClass('show');
                       void this.offsetWidth;
                       $item.addClass('show');
                   }
               });
           }

           // click handler
           $filters.on('click', function() {
               $filters.removeClass('active');
               $(this).addClass('active');

               var category = $(this).data('filter');
               filterItems(category);
           });

           // ✅ page load pe "All" ka filter apply karo
           filterItems('all');
       });
   </script>
