<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.0.2/glide.js"></script>
<script>
    var glide01 = new Glide('.glide-01', {
        type: 'carousel',
        focusAt: 0,
        perView: 2,
        autoplay: 2000,
        animationDuration: 700,
        gap: 24,
        classes: {
            activeNav: '[&>*]:bg-slate-700',
        },
        breakpoints: {
            1024: {
                perView: 2
            },
            640: {
                perView: 1
            }
        },
    });

    glide01.mount();
    var glide02 = new Glide('.glide-02', {
        type: 'carousel',
        focusAt: 1,
        perView: 3,
        autoplay: 3000,
        animationDuration: 700,
        gap: 24,
        classes: {
            activeNav: '[&>*]:bg-slate-700',
        },
        breakpoints: {
            1024: {
                perView: 2
            },
            640: {
                perView: 1
            }
        },
    });

    glide02.mount();
</script> 
<script>
    // Mobile Menu Toggle
    const btn = document.getElementById("menu-btn");
    const menu = document.getElementById("mobile-menu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });

    // Close Notification Bar
    const closeBtn = document.getElementById("close-btn");
    const notificationBar = document.getElementById("notification-bar");

    if (closeBtn && notificationBar) {
        closeBtn.addEventListener("click", () => {
            notificationBar.style.display = "none";
        });
    }

    // Countdown Timer
    // Set the target date (21 days, 22 hours, 53 minutes, and 5 seconds from now)
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 21);
    targetDate.setHours(targetDate.getHours() + 22);
    targetDate.setMinutes(targetDate.getMinutes() + 53);
    targetDate.setSeconds(targetDate.getSeconds() + 5);

    function updateCountdown() {
        const now = new Date();
        const timeDifference = targetDate - now;

        if (timeDifference <= 0) {
            // If the countdown is over, set all values to 0
            document.getElementById("days").textContent = "00";
            document.getElementById("hours").textContent = "00";
            document.getElementById("minutes").textContent = "00";
            document.getElementById("seconds").textContent = "00";
            clearInterval(countdownInterval); // Stop the timer
            return;
        }

        // Calculate days, hours, minutes, and seconds
        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

        // Update the DOM with leading zeros
        document.getElementById("days").textContent = days.toString().padStart(2, "0");
        document.getElementById("hours").textContent = hours.toString().padStart(2, "0");
        document.getElementById("minutes").textContent = minutes.toString().padStart(2, "0");
        document.getElementById("seconds").textContent = seconds.toString().padStart(2, "0");
    }

    // Update the countdown every second
    const countdownInterval = setInterval(updateCountdown, 1000);

    // Run the countdown immediately on page load
    updateCountdown();
    </script>

    <script>
        function updateCartCount() {
         const cart = JSON.parse(localStorage.getItem('cartItems')) || [];
         console.log(cart)
         document.getElementById('cartCount').textContent = cart.quantity;
      }
      updateCartCount()
    </script>

<script>
           
            
    document.querySelectorAll(".book-now-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            const parent = btn.parentElement;
            const overlay = parent.querySelector(".popup-overlay");
            const form = parent.querySelector(".popup-form");

            overlay.style.display = "block";
            form.style.display = "block";

            overlay.addEventListener("click", function () {
                overlay.style.display = "none";
                form.style.display = "none";
            });
        });
    });

            
</script>