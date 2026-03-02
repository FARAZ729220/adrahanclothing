   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


   <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('js/aos/aos.js') }}"></script>
   <script src="{{ asset('js/validation.js') }}"></script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
       gsap.registerPlugin(ScrollTrigger);

       document.addEventListener("DOMContentLoaded", () => {

           // Function to create the stagger animation
           const animateCards = (triggerSelector) => {
               const grid = document.querySelector(triggerSelector);
               if (!grid) return;

               const cards = grid.querySelectorAll(".product-card-container");

               gsap.fromTo(
                   cards, {
                       opacity: 0,
                       y: 40
                   }, {
                       opacity: 1,
                       y: 0,
                       duration: 0.8,
                       stagger: 0.15, // Slightly slower stagger for a premium feel
                       ease: "power2.out",
                       scrollTrigger: {
                           trigger: grid,
                           start: "top 85%",
                           toggleActions: "play none none none",
                       }
                   }
               );
           };

           // Apply to both sections
           animateCards(".product-grid"); // Your Trending Now section
           animateCards(".category-grid"); // Your Shop by Category section
       });


   </script>
