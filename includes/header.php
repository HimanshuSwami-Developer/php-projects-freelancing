<!-- NOTE: This block contains the Notification Bar, Header (with Mobile Menu), and all required
     CSS/JavaScript. The Footer content has been entirely removed as requested. -->

<!-- Load Tailwind CSS, Custom Styles, and Configuration -->
<script src="https://cdn.tailwindcss.com"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    /* Define the strict color palette */
    :root {
        --color-charcoal: #000000;
        --color-accent-blue: #00C1EC;
        --color-white: #ffffff;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    /* Custom style for the diagonal caution striping */
    .caution-striped {
        background-color: var(--color-charcoal);
        /* White stripes for a high-contrast caution look */
        background-image: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.05) 0,
            rgba(255,255,255,0.05) 5px,
            transparent 5px,
            transparent 10px
        );
    }

    /* Styling for the timer boxes to use the approved color scheme */
    .timer-box {
        background-color: var(--color-white);
        color: var(--color-charcoal);
        border: 2px solid var(--color-accent-blue);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        padding: 0.5rem 0.75rem;
        margin-right: 4px; /* Slight gap between boxes */
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.3s;
        min-width: 50px; /* Ensure boxes are readable on mobile */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .timer-box .font-bold {
        font-size: 1.5rem;
        line-height: 1.1;
    }
    .timer-box .text-xs {
        line-height: 1;
        margin-top: 2px;
        text-transform: uppercase;
    }
    .timer-box:last-child {
        margin-right: 0;
    }
</style>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
                colors: {
                    'charcoal': 'var(--color-charcoal)',
                    'accent-blue': 'var(--color-accent-blue)',
                }
            }
        }
    }
</script>

<!-- 1. Attractive Notification Bar (Offer Banner - Black/Blue Theme) -->
<!-- REMOVED sticky, top-0, z-[9999] to prevent it from sticking -->
<div id="notification-bar"
    class="caution-striped text-white flex flex-col md:flex-row items-center justify-between px-4 lg:px-20 py-4 shadow-xl relative">

    <!-- Offer Text Block & Button (Original Content Preserved) -->
    <div class="flex flex-col md:flex-row items-center md:gap-6 gap-3 w-full md:w-auto">

         <!-- Simulated Illustration (Placeholder maintained for SS layout) -->
       <div class="hidden lg:block text-8xl text-accent-blue" aria-hidden="true">
                🕴️
            </div>

        <p class="text-md md:text-xl font-semibold text-center md:text-left leading-snug">
            LIMITED TIME OFFER! Get Flat 10% OFF on all security training courses
        </p>

        <!-- Original Buy Now Button (Blue/White) -->
        <button class="flex-shrink-0">
            <a href="/courses" class="bg-accent-blue text-white px-5 py-2.5 rounded-xl whitespace-nowrap font-bold shadow-lg transition-all duration-300 hover:scale-[1.05]">
                Buy Now
            </a>
        </button>
    </div>

    <!-- Timer Boxes (Original Content Structure Preserved, Blue/White Styling Applied) -->
    <div class="flex justify-center mt-4 md:mt-0">
        <!-- Days -->
        <div class="timer-box">
            <span id="days" class="font-bold">21</span>
            <span class="text-xs">Days</span>
        </div>
        <!-- Hours -->
        <div class="timer-box">
            <span id="hours" class="font-bold">22</span>
            <span class="text-xs">Hours</span>
        </div>
        <!-- Minutes -->
        <div class="timer-box">
            <span id="minutes" class="font-bold">53</span>
            <span class="text-xs">Minutes</span>
        </div>
        <!-- Seconds -->
        <div class="timer-box">
            <span id="seconds" class="font-bold">05</span>
            <span class="text-xs">Seconds</span>
        </div>
    </div>

    <!-- Close Button (Positioned top right) -->
    <button id="close-btn" class="absolute right-4 top-1/2 -translate-y-1/2 md:top-4 md:translate-y-0 text-accent-blue  p-1 rounded-full transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
    </button>
       <!-- Cross Button for Top Contact Bar (Positioning adjusted to right-0) -->
        <!--<button id="close-top-bar-btn" class="absolute right-[5px] top-[-75px] transform -translate-y-1/2 text-accent-blue hover:text-white transition-colors p-1">-->
        <!--    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">-->
        <!--        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />-->
        <!--    </svg>-->
        <!--</button>-->
</div>

<!-- 2. Main Navigation Header (White/Black Theme) -->
<!-- REMOVED sticky and top-0 to prevent it from sticking -->
<header class="bg-white shadow-lg z-50">
    <!-- Top Contact Bar (New: Added for better mobile context, using the same content as the old hidden bar) -->
    <div id="top-contact-bar" class="bg-charcoal text-white text-xs py-2 px-6 hidden md:flex items-center justify-between relative">
        <ul class="flex items-center gap-5">
            <!-- NOTE: Facebook link preserved -->
            <li><a href="https://www.facebook.com/profile.php?id=61553690846842" class="hover:text-accent-blue"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M1 5.8c0-1.68 0-2.52.327-3.16a3.02 3.02 0 0 1 1.31-1.31c.642-.327 1.48-.327 3.16-.327h12.4c1.68 0 2.52 0 3.16.327a3.02 3.02 0 0 1 1.31 1.31c.327.642.327 1.48.327 3.16v12.4c0 1.68 0 2.52-.327 3.16a3 3 0 0 1-1.31 1.31c-.642.327-1.48.327-3.16.327h-12.4c-1.68 0-2.52 0-3.16-.327a3 3 0 0 1-1.31-1.31C1 20.718 1 19.88 1 18.2zM5.8 2h12.4c.857 0 1.44 0 1.89.038c.438.035.663.1.819.18c.376.192.498.682.874.874c.08.156.145.38.18.819c.037.45.038 1.03.038 1.89v12.4c0 .857-.001 1.44-.038 1.89c-.036.438-.101.663-.18.819a2 2 0 0 1-.874.874c-.156.08-.381.145-.819.18c-.45.036-1.03.037-1.89.037h-2.78v-8.29h2.33l.366-2.56h-2.69v-1.1q0-.28.037-.507c.107-.643.459-.96 1.2-.96h1.48v-2.45l-.016-.003c-.266-.036-.813-.11-1.83-.11c-2.17 0-3.44 1.14-3.44 3.75v1.38h-2.56v2.56h2.56v8.29h-7.05c-.857 0-1.44 0-1.89-.038c-.438-.035-.663-.1-.819-.18a2 2 0 0 1-.874-.874c-.08-.156-.145-.38-.18-.819c-.037-.45-.037-1.03-.037-1.89V5.8c0-.857 0-1.44.037-1.89c.036-.438.101-.663.18-.819c.192-.376.498-.682.874-.874c.156-.08.381-.145.82-.18c.45-.036 1.03-.037 1.89-.037z" clip-rule="evenodd" /></svg></a></li>
            <!-- NOTE: Instagram link preserved -->
            <li><a href="https://www.instagram.com/gsecurityandtraining/" class="hover:text-accent-blue"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9.52A2.48 2.48 0 1 0 14.48 12A2.48 2.48 0 0 0 12 9.52m9.93-2.45a6.5 6.5 0 0 0-.42-2.26a4 4 0 0 0-2.32-2.32a6.5 6.5 0 0 0-2.26-.42C15.64 2 15.26 2 12 2s-3.64 0-4.93.07a6.5 6.5 0 0 0-2.26.42a4 4 0 0 0-2.32 2.32a6.5 6.5 0 0 0-.42 2.26C2 8.36 2 8.74 2 12s0 3.64.07 4.93a6.9 6.9 0 0 0 .42 2.27a3.9 3.9 0 0 0 .91 1.4a3.9 3.9 0 0 0 1.41.91a6.5 6.5 0 0 0 2.26.42C8.36 22 8.74 22 12 22s3.64 0 4.93-.07a6.5 6.5 0 0 0 2.26-.42a3.9 3.9 0 0 0 1.41-.91a3.9 3.9 0 0 0 .91-1.4a6.6 6.6 0 0 0 .42-2.27C22 15.64 22 15.26 22 12s0-3.64-.07-4.93m-2.54 8a5.7 5.7 0 0 1-.39 1.8A3.86 3.86 0 0 1 16.87 19a5.7 5.7 0 0 1-1.81.35H8.94A5.7 5.7 0 0 1 7.13 19a3.5 3.5 0 0 1-1.31-.86A3.5 3.5 0 0 1 5 16.87a5.5 5.5 0 0 1-.34-1.81V8.94A5.5 5.5 0 0 1 5 7.13a3.5 3.5 0 0 1 .86-1.31A3.6 3.6 0 0 1 7.13 5a5.7 5.7 0 0 1 1.81-.35h6.12a5.7 5.7 0 0 1 1.81.35a3.5 3.5 0 0 1 1.31.86A3.5 3.5 0 0 1 19 7.13a5.7 5.7 0 0 1 .35 1.81V12c0 2.06.07 2.27.04 3.06Zm-1.6-7.44a2.38 2.38 0 0 0-1.41-1.41A4 4 0 0 0 15 6H9a4 4 0 0 0-1.38.26a2.38 2.38 0 0 0-1.41 1.36A4.3 4.3 0 0 0 6 9v6a4.3 4.3 0 0 0 .26 1.38a2.38 2.38 0 0 0 1.41 1.41a4.3 4.3 0 0 0 1.33.26h6a4 4 0 0 0 1.38-.26a2.38 2.38 0 0 0 1.41-1.41a4 4 0 0 0 .26-1.38V9a3.8 3.8 0 0 0-.26-1.38ZM12 15.82A3.81 3.81 0 0 1 8.19 12A3.82 3.82 0 1 1 12 15.82m4-6.89a.9.9 0 0 1 0-1.79a.9.9 0 0 1 0 1.79" /></svg></a></li>
        </ul>
        <ul class="flex items-center gap-6">
            <li class="flex items-center gap-1 text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="#00C1EC" d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7"/></svg>
                Leeds,UK
            </li>
            <!-- NOTE: Mailto link preserved -->
            <li>
                <a href="mailto:Info@gsecurityandtraining.co.uk" class="flex items-center gap-1 hover:text-accent-blue text-gray-300">
                    <!-- This is the Email Icon SVG (Kept as it is functional) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 512 512"><path fill="#00C1EC" fill-rule="evenodd" d="M42.667 64v298.667h171.07a141 141 0 0 1-.404-10.667c0-11.014 1.284-21.728 3.711-32H85.334V128l149.333 129.013L384 128v89.044a137.9 137.9 0 0 1 42.667 18.088V64zm304 42.667l-112 96l-112-96zm62.157 328.822l4.453 24.701q-27.797 9.143-56.67 9.143q-53.137 0-86.464-30.957q-35.476-32.722-35.476-86.617q0-50.847 33.633-83.569q34.708-33.523 88-33.523q48.224 0 79.707 25.985q15.665 12.992 24.419 31.919q8.907 19.57 8.907 43.148q0 37.374-20.733 59.669q-18.582 19.89-41.926 19.89q-24.88 0-27.337-22.616q-15.358 22.616-41.466 22.616q-21.04 0-33.327-12.19q-13.36-13.153-13.361-36.091q0-15.238 6.067-29.914q6.066-14.677 16.816-25.424q20.426-20.37 52.524-20.371q24.265 0 45.305 7.86l-10.289 66.727q-1.536 9.784-1.536 14.275q0 11.068 9.368 11.068q12.286 0 21.962-14.917q11.825-18.126 11.825-42.988q0-34.166-23.037-53.253q-25.493-21.012-63.274-21.012q-29.18 0-53.137 14.436q-22.577 13.634-33.941 36.892q-9.061 18.928-9.061 42.025q0 43.79 30.408 69.454q26.722 22.616 67.882 22.616q23.496 0 49.759-8.982M379.797 315.83q-7.832-2.247-12.746-2.246q-8.754 0-17.355 4.571q-8.6 4.572-14.743 12.592q-12.594 16.2-12.594 36.25q0 11.229 5.529 17.725t15.051 6.496q13.822 0 22.883-11.87q4.76-6.095 7.525-23.579z" clip-rule="evenodd" /></svg>
                    Info@gsecurityandtraining.co.uk
                </a>
            </li>
        </ul>
     
    </div>


    <div class="flex items-center justify-between px-6 py-3 md:px-12 max-w-[1400px] mx-auto">

        <!-- Logo -->
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="/">
            <!-- NOTE: Image URL preserved -->
            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438610/Frame-1_i3ayu6.webp"
                alt="Logo" class="h-16 w-auto" onerror="this.onerror=null; this.src='https://placehold.co/150x60/00C1EC/FFFFFF?text=LOGO+HERE';">
                </a>
        </div>

        <!-- Desktop Nav Links (Center) -->
        <nav class="hidden lg:flex flex-grow justify-center">
            <ul class="flex items-center gap-8">
                <!-- NOTE: All navigation links preserved -->
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/">Home</a></li>
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/courses">Courses</a></li>
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/security-services">Security Services</a></li>
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/about-us">About Us</a></li>
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/contact-us">Contact Us</a></li>
                <li><a class="text-charcoal text-md font-semibold hover:text-accent-blue transition-colors" href="/faqs">FAQs</a></li>
            </ul>
        </nav>

        <!-- Desktop Utility/Action Icons (Right) -->
        <div class="hidden lg:flex items-center gap-6 text-charcoal text-sm font-medium">
            <!-- Distinctive Cart Button (White/Blue) -->
            <!-- NOTE: Cart link preserved -->
            <a href="/cart" class="relative bg-white p-3 rounded-full text-charcoal border-2 border-accent-blue hover:bg-accent-blue hover:text-white transition-colors duration-300 shadow-lg">
                <!-- Cart SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 512 512" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32">
                    <circle cx="176" cy="416" r="16" />
                    <circle cx="400" cy="416" r="16" />
                    <path d="M48 80h64l48 272h256" />
                    <path d="M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128" />
                </svg>
                <!-- Cart Count Badge (Placeholder 3) -->
                <span id="cartCount" class="absolute top-[-4px] right-[-4px] text-[10px] bg-accent-blue w-4 h-4 text-white flex items-center justify-center rounded-full font-bold">3</span>
            </a>
        </div>

        <!-- Mobile Menu + Cart -->
        <div class="flex items-center gap-4 lg:hidden">
            <!-- Mobile Cart -->
            <!-- NOTE: Cart link preserved -->
            <a href="/cart" class="relative group border-accent-blue border-2 p-2 hover:bg-accent-blue rounded-lg transition-colors">
                <!-- Cart SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-charcoal group-hover:stroke-white transition-colors duration-300"
                    width="24" height="24" viewBox="0 0 512 512" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="32">
                    <circle cx="176" cy="416" r="16" />
                    <circle cx="400" cy="416" r="16" />
                    <path d="M48 80h64l48 272h256" />
                    <path d="M160 288h249.44a8 8 0 0 0 7.85-6.43l28.8-144a8 8 0 0 0-7.85-9.57H128" />
                </svg>
                <!-- Cart Count Badge (Placeholder 3) -->
                <span class="absolute top-[-4px] right-[-4px] text-[10px] bg-accent-blue w-4 h-4 text-white flex items-center justify-center rounded-full font-bold">3</span>
            </a>

            <!-- Hamburger -->
            <button id="menu-btn-mobile" class="text-accent-blue focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

    </div>
</header>

<!-- Mobile Menu Dropdown (UPDATED) -->
<div id="mobile-menu-dropdown" class="lg:hidden bg-charcoal text-white shadow-xl hidden z-40 relative">
    <ul class="flex flex-col gap-1 p-4">
        <!-- NOTE: All navigation links preserved -->
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3 border-b border-gray-700" href="/">Home</a></li>
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3 border-b border-gray-700" href="/courses">Courses</a></li>
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3 border-b border-gray-700" href="/security-services">Security Services</a></li>
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3 border-b border-gray-700" href="/about-us">About Us</a></li>
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3 border-b border-gray-700" href="/contact-us">Contact Us</a></li>
        <li><a class="font-semibold text-[18px] hover:text-accent-blue transition-colors block py-3" href="/faqs">FAQs</a></li>
    </ul>
</div>

<!-- Essential Header and Timer Scripts -->
<script>
    // --- Header Functionality ---

    // 1. Notification Bar Close
    document.getElementById('close-btn').addEventListener('click', () => {
        const bar = document.getElementById('notification-bar');
        // Use class list for smooth hiding
        bar.classList.add('hidden');
    });

    // 2. Mobile Menu Toggle
    const menuBtn = document.getElementById('menu-btn-mobile');
    const mobileMenu = document.getElementById('mobile-menu-dropdown');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // 3. Top Contact Bar Close (UPDATED)
    const closeTopBarBtn = document.getElementById('close-top-bar-btn');
    const topContactBar = document.getElementById('top-contact-bar');
    const mainHeader = document.querySelector('header'); // Target the main header

    if (closeTopBarBtn && topContactBar) {
        closeTopBarBtn.addEventListener('click', () => {
            topContactBar.classList.add('hidden');
            // No sticky header means no need to adjust top position.
        });
    }

    // 4. Simple Countdown Timer
    function updateTimer() {
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        // Initial values taken from the placeholder HTML content
        let totalSeconds =
            (parseInt(daysEl.textContent) * 24 * 3600) +
            (parseInt(hoursEl.textContent) * 3600) +
            (parseInt(minutesEl.textContent) * 60) +
            parseInt(secondsEl.textContent);

        function tick() {
            // Stop if time runs out
            if (totalSeconds < 0) {
                daysEl.textContent = '00';
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                clearInterval(timerInterval);
                return;
            }

            const days = Math.floor(totalSeconds / (3600 * 24));
            const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);

            // Update the DOM elements, padding with '0'
            daysEl.textContent = String(days).padStart(2, '0');
            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');

            totalSeconds--;
        }

        // Start the timer immediately
        tick();
        const timerInterval = setInterval(tick, 1000);
    }

    // Initialize the timer on window load
    window.onload = updateTimer;

</script>
