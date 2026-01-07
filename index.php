<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- PHP LOGIC PRESERVED FROM LIVE CODE ---
    $name = $_POST['Name'];
    $_SESSION['Name'] = $name;
    $email = $_POST['Email'];
    $_SESSION['Email'] = $email;
    $phone = $_POST['Phone'];
    $_SESSION['Phone'] = $phone;
    $_SESSION['Course_Price'] = $_POST['course_p'];
    $_SESSION['course_name'] = $_POST['course_name'];
    // The following line was duplicated in the live code, preserving the effect
    $_SESSION['course_name'] = $_POST['course_name'];
    $_SESSION['course_id'] = $_POST['course_id'];

    // Email details
    $to = "bookings@gsecurityandtraining.co.uk";
    $subject = "🚀 New Lead: Client Interested in Your Course!";

    $body = "You have received a new message from your website form.\n\n";
    $body .= "FullName: $name\n";
    $body .= "Phone: $phone\n";
    $body .= "Email: $email\n\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect to select-option.php
        header("Location: date-select");
        exit();
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // echo "Invalid access.";
}
?>
<?php
include('admin/assets/config/db.php');

// Fetch all courses from database
$query = "SELECT * FROM courses";
$query_run = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIA Security Training Courses Leeds | SIA Security Courses Leeds​</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/" />
    <meta name="description"
        content="Enhance your career with a professional security training courses Leeds. Learn security courses leeds​ like risk assessment, and leadership in security operations.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- ADDED SWIPER AND GLIDE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.min.css"
        xintegrity="sha512-Yd2qF+Hh+g7tW5o9uO3gqE0G/m3XpM8jYf5k9v4eFw2hQkE4FpQ5fK4vF4dF8Fk/jXQo4QJ/g/t2h/T5o/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.min.css"
        xintegrity="sha512-F/m0m1wVv5YF5Z2XgX4J9o9gQ5s+J0q5k4y5b7g4i5b0y5f4k5a5d5e5f5g5h5i5j5k5l5m5n5o5p5q5r5s5t5u5v5w5x5y5z5"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php include "includes/head.php" ?>

    <style>
        /* Custom Styles to maintain visual consistency */
        .hero-background {
            background-color: #1a1a1a;
        }

        @media (max-width: 1024px) {
            .hero-background {
                background-color: #1a1a1a;
            }
        }

        .text-shadow-light {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
        }

        .trust-accent {
            background-color: #00c1ec;
            background-image: linear-gradient(to right, #00C1EC, #00e0ff);
        }

        /* Specific styling for the re-integrated slider to ensure it fits the dark theme */
        .full-width-slider-section {
            background-color: #1a1a1a;
            padding: 40px 0;
        }

        .full-width-slider-section img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        /* Glide specific overrides for styling (Applies to both carousels) */
        .glide__bullets {
            text-align: center;
            margin-top: 20px;
        }

        .glide__bullet {
            background-color: #ccc;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            border: none;
            margin: 0 4px;
        }

        .no-scroll {
            overflow: hidden !important;
            position: fixed;
            /* Fixes position relative to the viewport */
            width: 100%;
            height: 100%;
        }

        .glide__bullet--active {
            background-color: #00C1EC;
        }

        /* Style adjustments for course cards */
        .course-card ul li {
            font-size: 0.9rem;
            /* text-sm equivalent */
        }

        .course-card .flex-1 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* NEW POPUP STYLES: Full width on mobile, max-w-md on desktop */
        .popup-form {
            width: 95%;
            /* Makes it full width on small screens */
            max-width: 448px;
            /* Max width remains for larger screens */
            left: 50%;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
        }
            .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    </style>

</head>


<body class="bg-white" id="main-body">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div>
        <?php include "includes/header.php" ?>

        <!-- body: Main Content Area (Starting with light gray background) -->
        <div class="bg-[#f8f8f8]">

            <!-- 1. HERO SECTION: Dynamic Text, Image, and Trust Badges -->
            <div class="hero-background pt-16 pb-12 md:pt-24 md:pb-20">
                <div class="lg:w-[1280px] mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center">

                    <!-- Left Column: Marketing Message -->
                    <div class="text-white lg:text-left text-center">
                        <p class="text-lg font-semibold text-[#00C1EC] mb-2">Join the 400,000+ people already working in security!
                        </p>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                            Get trained, licensed, and <span class="text-[#00C1EC]">start earning in just 3 weeks</span>.
                        </h1>
                        <p class="text-xl md:text-[13px] font-semibold mb-8 max-w-lg lg:mx-0 mx-auto">
                          Earn £14 to £25 an hour with consistently in-demand, flexible, and stable-paying security jobs. No prior experience needed. We teach you everything.
                        </p>

                        <!-- Hero CTAs -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="/courses"
                                class="inline-block bg-[#00C1EC] text-white px-8 py-3 rounded-lg font-bold  transition duration-200 shadow-lg text-[16px]">
                               Find an SIA-approved course
                            </a>
                            <a href="/faqs"
                                class="inline-block bg-white text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition duration-200 shadow-lg text-[16px]">
                                Which license do I need?
                            </a>
                        </div>

                        <!-- Mini Trust Bar -->
<div
<div
  class="flex flex-wrap mt-10 justify-center lg:justify-start text-sm text-gray-300 font-medium border-t border-gray-700 pt-4"
>
  <div class="flex items-center gap-1 w-1/2 px-3 py-2 box-border">
    <span class="text-[#00C1EC] text-xl">⚡</span>
    Highly-rated, experienced trainers
  </div>

  <div class="flex items-center gap-1 w-1/2 px-3 py-2 box-border">
    <span class="text-[#00C1EC] text-xl">🌈</span>
    SIA-approved training & certification
  </div>

  <div class="flex items-center gap-1 w-1/2 px-3 py-2 box-border">
    <span class="text-[#00C1EC] text-xl">🏆</span>
    Proven: 95% pass rate on first attempt
  </div>

  <div class="flex items-center gap-1 w-1/2 px-3 py-2 box-border">
    <span class="text-[#00C1EC] text-xl">✨</span>
    Trusted: 5,000+ success stories
  </div>
</div>



                    </div>

                    <!-- Right Column: Video Placeholder -->
                    <div
                        class="w-full h-full min-h-[300px] bg-gray-800 rounded-xl shadow-2xl overflow-hidden flex items-center justify-center border-4 border-[#00C1EC]">
                        <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761715585/Frame_1000007536_tlvru6.png"
                            alt="Security training video placeholder" class="w-full h-full object-cover opacity-70">
                        <!--<button-->
                        <!--    class="absolute p-4 bg-white rounded-full shadow-lg hover:bg-gray-100 transition duration-200">-->
                        <!--    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24">-->
                        <!--        <path fill="#00C1EC" d="M9 18V6l7.5 6z" />-->
                        <!--    </svg>-->
                        <!--</button>-->
                    </div>
                </div>
            </div>





            <!-- --- IMAGE SLIDER SECTION (Glide.js) --- -->
            <div class="full-width-slider-section bg-white">
                <div class="lg:w-[1280px] mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center text-gray-900 mb-2">Get your SIA license to work in security</h2>
                        <!--Four Steps To Get Employed In The-->
                        <!--Security Industry</h2>-->
                    <!--<p class="text-2xl font-bold text-center text-[#00C1EC] my-8">Get your SIA license to work in security-->
                    <!--</p>-->

                    <!-- Glide Container -->
                    <div class="relative glide glide-01 mt-10 ">
                        <!-- Slides -->
                        <div class="glide__track" data-glide-el="track">
                            <ul class="glide__slides">
                                <li class="glide__slide pb-10"><img
                                        src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761716638/1_sxz9sj.png"
                                        alt="Two security officers walking through commercial premises"></li>
                                <li class="glide__slide pb-10"><img
                                        src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761716638/2_kn7oz8.png"
                                        alt="Male security officer monitoring premises outdoors"></li>
                                <li class="glide__slide pb-10"><img
                                        src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761716638/3_mybgvl.png"
                                        alt="Security professional with radio in event setting"></li>
                                <li class="glide__slide pb-10"><img
                                        src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761716639/4_oeiwc9.png"
                                        alt="Security guard with headset standing near glass building"></li>
                            </ul>
                        </div>

                        <!-- Arrows -->
                        <div class="glide__arrows hidden sm:block" data-glide-el="controls">
                            <button
                                class="glide__arrow glide__arrow--left bg-white p-2 rounded-full shadow-md opacity-70 hover:opacity-100 transition-opacity duration-300"
                                data-glide-dir="<"
                                style="left: 0; transform: translateY(-50%); position: absolute; top: 50%;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="#00C1EC" d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6l6 6z" />
                                </svg>
                            </button>
                            <button
                                class="glide__arrow glide__arrow--right bg-white p-2 rounded-full shadow-md opacity-70 hover:opacity-100 transition-opacity duration-300"
                                data-glide-dir=">"
                                style="right: 0; transform: translateY(-50%); position: absolute; top: 50%;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="#00C1EC" d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6l-6 6z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Bullets -->
                        <div class="glide__bullets mt-10" data-glide-el="controls[nav]">
                            <button class="glide__bullet" data-glide-dir="=0"></button>
                            <button class="glide__bullet" data-glide-dir="=1"></button>
                            <button class="glide__bullet" data-glide-dir="=2"></button>
                            <button class="glide__bullet" data-glide-dir="=3"></button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- --- END IMAGE SLIDER SECTION --- -->

           <!-- 3. COURSE CATEGORY LISTING SECTION (STATIC DATA WITH POPUP INTEGRATION) -->
<!-- 3. COURSE CATEGORY LISTING SECTION (STATIC DATA WITH POPUP INTEGRATION) -->
<section class="py-16 md:py-24 border-t border-gray-200 bg-white">
    <div class="lg:w-[1280px] mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 text-center mb-16">
            Pick the right <span class="text-[#00C1EC]">training course</span>
            & get started
        </h2>

        <!-- MOBILE/TABLET SCROLL -->
        <div class="block lg:hidden mt-8">
            <div id="mobileCourseScroll"
                class="flex space-x-6 snap-x snap-mandatory pb-4 overflow-x-auto cursor-grab active:cursor-grabbing hide-scrollbar select-none scroll-smooth">
                <?php if (mysqli_num_rows($query_run) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
                        <?php
                        $imagePath = (!empty($row['image']) && file_exists('admin/uploads/' . $row['image']))
                            ? 'admin/uploads/' . htmlspecialchars($row['image'])
                            : 'https://via.placeholder.com/400x300?text=No+Image';
                        $original_price = $row['regular_price'];
                        $sale_price = $row['sale_price'];
                        $discount = 0;
                        if ($original_price > 0 && $sale_price < $original_price) {
                            $discount = round((($original_price - $sale_price) / $original_price) * 100);
                        }
                        ?>
                        <div
                            class="flex-none w-[85%] sm:w-[70%] bg-white rounded-xl overflow-hidden shadow-xl border-t-8 border-[#00C1EC] snap-center flex flex-col justify-between">
                            <div class="relative">
                                <img src="<?php echo $imagePath; ?>"
                                    alt="<?php echo htmlspecialchars($row['title']); ?>"
                                    class="w-full h-48 object-cover">
                                <?php if (stripos($row['title'], 'Door Supervision') !== false): ?>
                                   <?php if (stripos($row['title'], 'Door Supervision + Free First Aid') !== false): ?>
    <span
        class="absolute top-0 right-0 bg-[#00C1EC] text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
        🔥 TOP SELLING
    </span>
<?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="p-5 flex flex-col flex-1 justify-between">
                                <div>
                                    <h3 class="text-xl font-bold mb-3 text-gray-900 min-h-[60px] flex items-center">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </h3>
                                    <ul class="text-gray-700 text-sm space-y-2 mb-4">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <?php if (!empty($row['point' . $i])): ?>
                                                <li class="flex items-start gap-2">
                                                    <?php echo htmlspecialchars($row['point' . $i]); ?>
                                                </li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                                <div>
                                   <?php
$title = strtolower($row['title']);
$isDoorSupervision = (
    strpos($title, 'door supervision') !== false &&
    strpos($title, 'top-up') === false &&
    strpos($title, 'refresher') === false
);
?>

<?php if ($isDoorSupervision): ?>
    <div class="flex flex-col gap-1 mb-4">
        <span class="text-gray-500 text-sm line-through">£<?php echo $row['regular_price']; ?></span>
        <span class="text-2xl font-extrabold text-[#00C1EC]">
            £<?php echo $row['sale_price']; ?>
            <span class="text-xs font-semibold text-gray-600">(<?php echo $discount; ?>% off)</span>
        </span>
    </div>
<?php else: ?>
    <div class="flex flex-col gap-1 mb-4">
        <span class="text-gray-700 font-semibold text-base">
            Starting at just £<?php echo $row['sale_price']; ?>
        </span>
    </div>
<?php endif; ?>

                                    <div class="flex items-center justify-between space-x-2">
                                        <a href="<?php echo $row['info_link']; ?>"
                                            class="text-[#00C1EC] font-semibold hover:underline">More Info</a>
                                        <button
                                            class="book-now-btn bg-[#00C1EC] text-white px-4 py-2 text-sm font-bold rounded-lg"
                                            data-course-name="<?php echo htmlspecialchars($row['title']); ?>"
                                            data-course-price="<?php echo $row['sale_price']; ?>"
                                            data-course-id="<?php echo $row['id']; ?>">
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-600">No courses found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- DESKTOP GRID -->
        <div
            class="hidden lg:grid lg:grid-cols-2 xl:grid-cols-3 gap-12 justify-center max-w-4xl mx-auto xl:max-w-none mt-12">
            <?php
            mysqli_data_seek($query_run, 0);
            if (mysqli_num_rows($query_run) > 0):
                while ($row = mysqli_fetch_assoc($query_run)):
                    $imagePath = (!empty($row['image']) && file_exists('admin/uploads/' . $row['image']))
                        ? 'admin/uploads/' . htmlspecialchars($row['image'])
                        : 'https://via.placeholder.com/400x300?text=No+Image';
                    $original_price = $row['regular_price'];
                    $sale_price = $row['sale_price'];
                    $discount = 0;
                    if ($original_price > 0 && $sale_price < $original_price) {
                        $discount = round((($original_price - $sale_price) / $original_price) * 100);
                    }
            ?>
                    <div
                        class="course-card bg-white rounded-xl overflow-hidden shadow-2xl border-t-8 border-[#00C1EC] hover:shadow-3xl transition-shadow duration-300 flex flex-col">
                        <div class="relative flex-shrink-0">
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"
                                class="w-full h-56 object-cover">
                            <?php if (stripos($row['title'], 'Door Supervision') !== false): ?>
                              <?php if (stripos($row['title'], 'Door Supervision + Free First Aid') !== false): ?>
    <span
        class="absolute top-0 right-0 bg-[#00C1EC] text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
        🔥 TOP SELLING
    </span>
<?php endif; ?>

                            <?php endif; ?>
                        </div>
                        <div class="p-6 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-2xl font-black mb-4 text-gray-900 min-h-[72px] flex items-center">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h3>
                                <ul class="text-gray-700 text-sm space-y-3 my-4 list-none p-0">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <?php if (!empty($row['point' . $i])): ?>
                                            <li class="flex items-start gap-2">
                                                <?php echo htmlspecialchars($row['point' . $i]); ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <div>
                                <?php
$title = strtolower($row['title']);
$isDoorSupervision = (
    strpos($title, 'door supervision') !== false &&
    strpos($title, 'top-up') === false &&
    strpos($title, 'refresher') === false
);
?>

<?php if ($isDoorSupervision): ?>
    <div class="flex flex-col gap-1 mb-6 mt-4">
        <span class="text-gray-500 text-base line-through">£<?php echo $row['regular_price']; ?></span>
        <span class="text-3xl font-extrabold text-[#00C1EC]">
            £<?php echo $row['sale_price']; ?>
            <span class="text-sm font-semibold text-gray-600">(<?php echo $discount; ?>% off)</span>
        </span>
    </div>
<?php else: ?>
    <div class="flex flex-col gap-1 mb-6 mt-4">
        <span class="text-gray-700 font-semibold text-lg">
            Starting at just £<?php echo $row['sale_price']; ?>
        </span>
    </div>
<?php endif; ?>

                                <div class="flex items-center justify-between space-x-2">
                                    <a href="<?php echo $row['info_link']; ?>"
                                        class="text-[#00C1EC] font-semibold hover:underline transition-colors">More Info</a>
                                    <button
                                        class="book-now-btn bg-[#00C1EC] text-white px-5 py-3 font-bold text-base rounded-lg transition duration-200"
                                        data-course-name="<?php echo htmlspecialchars($row['title']); ?>"
                                        data-course-price="<?php echo $row['sale_price']; ?>"
                                        data-course-id="<?php echo $row['id']; ?>">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>







            <!-- 4. CAREER PATHS SECTION -->
            <div class="py-16 md:py-24 bg-[#f8f8f8]">
                <div class="lg:w-[1280px] mx-auto px-4">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 text-center mb-12">
                       Popular careers/opportunities after security training
                    </h2>
                    <p class="text-xl text-center text-[#00C1EC] mb-8">A sneak peek into the roles you’ll be able to work in after your Door Supervisor Training.</p>

                    <!-- Career Cards -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Career 1 -->
                        <div
                            class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2"><span
                                    class="text-[#00C1EC] text-2xl">🍸</span>  Nightclub Doorman</h3>
                            <!--<p class="text-gray-600 text-sm">Training required: Door Supervisor Training</p>-->
                            <p class="text-base font-semibold text-gray-900 my-2">Earn up to: <span
                                    class="text-[#00C1EC]">£13-£25</span></p>
                            <p class="text-gray-500 text-xs mb-4">20 - 48 hours a week (usually includes weekends)</p>
                            <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline">View Details
                                →</a>
                        </div>

                        <!-- Career 2 -->
                        <div
                            class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2"><span
                                    class="text-[#00C1EC] text-2xl">🛍️</span> Retail Security Officer</h3>
                            <!--<p class="text-gray-600 text-sm">Training required: Door Supervisor Training</p>-->
                            <p class="text-base font-semibold text-gray-900 my-2">Earn up to: <span
                                    class="text-[#00C1EC]"> £13-£15</span></p>
                            <p class="text-gray-500 text-xs mb-4">20 - 48 hours a week (usually includes weekends)</p>
                            <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline">View Details
                                →</a>
                        </div>

                        <!-- Career 3 -->
                        <div
                            class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2"><span
                                    class="text-[#00C1EC] text-2xl">🪪️</span>  Event Security</h3>
                            <!--<p class="text-gray-600 text-sm">Training required: CCTV Training</p>-->
                            <p class="text-base font-semibold text-gray-900 my-2">Earn up to: <span
                                    class="text-[#00C1EC]">£13-£15</span></p>
                            <p class="text-gray-500 text-xs mb-4">20 - 48 hours a week (usually includes weekends)</p>
                            <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline">View Details
                                →</a>
                        </div>

                        <!-- Career 4 -->
                        <div
                            class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center gap-2"><span
                                    class="text-[#00C1EC] text-2xl">🏢</span> Corporate Security</h3>
                            <!--<p class="text-gray-600 text-sm">Training required: Door Supervisor Training</p>-->
                            <p class="text-base font-semibold text-gray-900 my-2">Earn up to: <span
                                    class="text-[#00C1EC]">£12-£16</span></p>
                            <p class="text-gray-500 text-xs mb-4">20 - 48 hours a week (usually includes weekends)</p>
                            <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline">View Details
                                →</a>
                        </div>

                    </div>

                    <!--<div class="text-center mt-12">-->
                    <!--    <a href="/security-services"-->
                    <!--        class="inline-block border-2 border-[#00C1EC] text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-[#00C1EC] hover:text-white transition duration-200 shadow-md text-lg">-->
                    <!--        View all Services-->
                    <!--    </a>-->
                    <!--</div>-->
                </div>
            </div>


            <!-- 6. TRAINER PROFILES SECTION (DARK BACKGROUND) -->
            <div class="py-16 md:py-24 bg-[#1a1a1a]">
                <div class="lg:w-[1280px] mx-auto px-4 grid lg:grid-cols-2 gap-12 items-center">

                    <!-- Left Column: Trainers Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Trainer Profile 1 -->
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_kak7v0.jpg"
                                alt="Trainer Profile 1" class="w-full h-48 object-cover">
                            <div class="p-3 text-white">
                                <p class="font-semibold text-lg">Luzuko Mgaga</p>
                                <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                        <!-- Trainer Profile 2 -->
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_1_qmxxod.jpg"
                                alt="Trainer Profile 2" class="w-full h-48 object-cover">
                            <div class="p-3 text-white">
                                <p class="font-semibold text-lg">Muhammad Pervaiz</p>
                                <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                        <!-- Trainer Profile 3 -->
                        <!--<div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700">-->
                        <!--    <img src="https://placehold.co/300x300/444444/ffffff?text=Trainer+Dave"-->
                        <!--        alt="Trainer Profile 3" class="w-full h-48 object-cover">-->
                        <!--    <div class="p-3 text-white">-->
                        <!--        <p class="font-semibold text-lg">Dave Watts</p>-->
                        <!--        <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- Trainer Profile 4 -->
                        <!--<div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700">-->
                        <!--    <img src="https://placehold.co/300x300/444444/ffffff?text=Trainer+Zowie"-->
                        <!--        alt="Trainer Profile 4" class="w-full h-48 object-cover">-->
                        <!--    <div class="p-3 text-white">-->
                        <!--        <p class="font-semibold text-lg">Zowie Jennings</p>-->
                        <!--        <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>

                    <!-- Right Column: CTA -->
                    <div class="text-white lg:text-left text-center">
                        <h2 class="text-4xl md:text-5xl text-[#00C1EC] mb-6">
                           A Qualified team<span class="text-white">, to help you every step of the way</span>
                        </h2>
                        <p class="text-xl text-gray-300 mb-8">
                          They’ve done it themselves. So they know what it takes to make you competent. Simply lean on 3+ decades of industry expertise for your security training and licensure.
                        </p>
                        <a href="/meet-our-team"
                            class="inline-block bg-[#00C1EC] text-white px-8 py-3 rounded-lg font-bold  transition duration-200 shadow-md text-lg">
                            View all trainers
                        </a>
                    </div>
                </div>
            </div>

            <!-- 7. REAL STORIES / REVIEWS SECTION (USES SWIPER FOR TESTIMONIALS) -->
            <div class="py-16 md:py-24 bg-white">
                <div class="lg:w-[1280px] mx-auto px-4">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-black mb-3">
                        Don’t trust us blindly,
                        <span class="text-accent-blue">
                            hear it from our happy customers!
                        </span>
                    </h2>
                    <div class="flex items-center gap-4 mb-10">
                        <span class="text-yellow-500 text-2xl font-bold">Excellent</span>
                        <span class="text-yellow-500 text-3xl">⭐⭐⭐⭐⭐</span>
                        <p class="text-gray-600">We are rated 5/5 on Google Reviews by 120+ people.</p>
                    </div>

                    <!-- Testimonial Swiper Container -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">

                            <!-- Slide 1 (Yash - Content Mapped from live code testimonial) -->
                            <div class="swiper-slide h-auto">
                                <div
                                    class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-[#00C1EC] h-full flex flex-col justify-between">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white text-xl font-bold">R</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Richard owusu Afriyie</p>
                                            <!--<span class="text-yellow-500">⭐⭐⭐⭐⭐</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <!--<h4 class="font-bold text-lg text-gray-900 mb-2">Excellent experience with G-->
                                        <!--    Security</h4>-->
                                        <p class="text-gray-700 text-sm ">"I just completed a door supervisor training, and it was really informative. The course covered essential skills like conflict resolution and effective communication, which are crucial for the role. I particularly enjoyed the practical scenarios we worked through, as they helped me understand how to handle real-life situations. Overall, it was a valuable experience that has prepared me well for my responsibilities as a door supervisor."</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 (Richard - Content Mapped from live code testimonial) -->
                            <div class="swiper-slide h-auto">
                                <div
                                    class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-gray-300 h-full flex flex-col ">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white text-xl font-bold">A</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Amir Abbas</p>
                                            <!--<span class="text-yellow-500">⭐⭐⭐⭐⭐</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <!--<h4 class="font-bold text-lg text-gray-900 mb-2">Really informative door-->
                                        <!--    supervisor training</h4>-->
                                        <p class="text-gray-700 text-sm leading-relaxed">"I had a positive experience. The staff were friendly and supportive, and the teaching methods were effective in helping me understand the material. The course was well-structured, and I appreciated the opportunities to ask questions and engage with the instructors."</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 (Moussa Jawara - Content Mapped from live code testimonial) -->
                            <div class="swiper-slide h-auto">
                                <div
                                    class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-gray-300 h-full flex flex-col justify-between">
                                    <div class="flex items-start mb-4">
                                        <div
                                            class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white text-xl font-bold">J</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Jahed Shohag</p>
                                            <!--<span class="text-yellow-500">⭐⭐⭐⭐⭐</span>-->
                                        </div>
                                    </div>
                                    <div>
                                        <!--<h4 class="font-bold text-lg text-gray-900 mb-2">Highly recommend this company-->
                                        <!--</h4>-->
                                        <p class="text-gray-700 text-sm leading-relaxed">"I had a great experience with G Security and Training Center. The tutor taught clearly and gave strong focus to practical training, which really helped my learning. The classroom environment was supportive, and the course covered all key areas of door supervision. I am very satisfied and would recommend this center to friends and family."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination/Bullets -->
                        <div class="swiper-pagination mt-10"></div>
                    </div>

                    <!--<div class="text-center mt-12">-->
                    <!--    <a href="/about-us"-->
                    <!--        class="inline-block border-2 border-[#00C1EC] text-gray-900 px-8 py-3 rounded-lg font-bold hover:bg-[#00C1EC] hover:text-white transition duration-200 shadow-md text-lg">-->
                    <!--        Read more reviews-->
                    <!--    </a>-->
                    <!--</div>-->
                </div>
            </div>


            <!-- 8. FAQ AND CONTACT SECTION -->
            <div class="py-16 md:py-24 bg-[#f8f8f8]">
                <div class="lg:w-[1280px] mx-auto px-4 grid lg:grid-cols-2 gap-12 items-start">

                    <!-- Left Column: FAQ Accordion (Reused component from previous file) -->
                    <div class="w-full p-4 lg:p-0 order-2 lg:order-1">
                        <h2 class="text-4xl  text-[#00C1EC] mb-10 text-center lg:text-left">
                            Still got questions? <span class=" text-gray-900 ">We’re here to clear them up for you.</span>
                        </h2>
                        <div class="space-y-4">
                            <!-- FAQ 1 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-1">
                                    <span class="font-semibold">What exactly is the Door Supervision course?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-1" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">An G-Security and Training’s Door Supervision course is a sure-short way you can gain the necessary skills that help you legally qualify and obtain an SIA license for working in security roles.</p>
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-2">
                                    <span class="font-semibold">Do I need any experience to join?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-2" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">Luckily, you don’t. We’ve trained thousands of freshers who had zero experience in the industry, who are now earning to their highest potential in security.</p>
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-3">
                                    <span class="font-semibold">How long does the course take?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-3" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200"> The actual training part only takes 3-7 days. So, you’ll be able to manage it with other commitments or jobs on the side. Once you’re ready, giving a small exam would let you go ahead with applying for a licence. The entire process usually takes three weeks.  </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 4 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-4">
                                    <span class="font-semibold">How much does it cost?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-4" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">If you’re going to be applying for a license for the first time, the Door Supervision course is for you. It costs £350, and pays for itself in nearly 10 days once you start earning. </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 5 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-5">
                                    <span class="font-semibold">What jobs can I get after this?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-5" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200"> There are multiple roles available once you finish your security training in Leeds. Jobs in this industry are always in demand, and you would be able to expect stable pay. The most common pathways are -
                                    <ul class="mt-1 ml-10 list-disc" >

<li>Door Supervisor / Bouncer</li>
<li>Event Security / Steward</li>
<li>Corporate Security Officer</li>
<li>Retail Security Guard</li>
<li>Construction Site Security</li>
<li>Concierge / Reception Security</li>
<li>Mobile Patrol Officer</li>
<li>Keyholding Services</li>
</ul>
  </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 6 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-6">
                                    <span class="font-semibold">Is this qualification actually recognised by employers?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-6" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">Yes! As mentioned, the security training lets you apply for an SIA license, which is widely recognised and in fact the most common requirement of reputed employers.</p>
                                </div>
                            </div>
                            
                              <!-- FAQ 7 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-7">
                                    <span class="font-semibold">What if I fail the exam?
</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-7" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">It’s okay, we know that sometimes mishaps happen. To safeguard you against such situations, we have plans that offer multiple free resits/retakes. With the guidance and support of our expert trainers, you’ll be able to clear the exam with no problems.   </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 8 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-8">
                                    <span class="font-semibold">Do you include first aid training or is that separate?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-8" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">Free first aid training is included in Gold and Diamond plans of the Door Supervision course and also for the Top-Up Refresher course. That gives you an extra edge and helps you stand out in the eyes of potential employers. </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 9 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-9">
                                    <span class="font-semibold">What’s the Top-Up Refresher course for?</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-9" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">The <b>SIA Top-Up Refresher For Door Supervision</b> course is for people who have already worked in security but wish to renew their license after its 3-year tenure. In this course, they can easily gain any new skills that have entered the market since they last took their security training.  </p>
                                </div>
                            </div>
                            
                              <!-- FAQ 10 -->
                            <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
                                <button
                                    class="w-full text-left p-4 bg-white text-gray-900  focus:outline-none flex justify-between items-center transition-all"
                                    data-toggle="collapsess" data-target="#faq-home-10">
                                    <span class="font-semibold">
How quickly can I start earning after I pass?
</span>
                                    <svg class="w-5 h-5 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="faq-home-10" class="collapsess hidden bg-gray-50 text-gray-700">
                                    <p class="p-4 border-t border-gray-200">Once you pass, you’ll be able to apply for a license with the SIA immediately. Once your license is approved, which usually takes 7-10 days, you can begin to apply for security jobs and start earning. Overall, anywhere between 3-4 weeks.</p>
                                </div>
                            </div>
                            

                            <div class="text-center pt-6">
                                <a href="/faqs"
                                    class="inline-block border-2 border-[#00C1EC] text-gray-900 px-6 py-3 rounded-lg font-bold hover:bg-[#00C1EC] hover:text-white transition duration-200 shadow-md">
                                    View All FAQs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Priority/Help Message (Reused component from previous file) -->
                    <div class="w-full p-4 lg:p-0 text-center lg:text-left order-1 lg:order-2">
                        <div class="bg-gray-100 p-8 rounded-xl shadow-xl border-t-8 border-[#00C1EC]">
                            <h2 class="text-3xl font-black text-gray-900 mb-4">Do you need help?</h2>
                            <p class="text-xl text-gray-700 mb-6">Our team's got your back.</p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="https://wa.me/447736540149"
                                    class="text-white bg-green-500 py-3 px-6 rounded-lg font-bold hover:bg-green-600 shadow-md">
                                    Chat with us
                                </a>
                                <a href="/faqs"
                                    class="text-gray-900 bg-white py-3 px-6 rounded-lg font-bold hover:bg-gray-50 shadow-md border border-gray-200">
                                    Help centre
                                </a>
                                <a href="mailto:Info@gsecurityandtraining.co.uk"
                                    class="text-gray-900 bg-white py-3 px-6 rounded-lg font-bold hover:bg-gray-50 shadow-md border border-gray-200">
                                    Email us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <!-- ACCREDITATION AND TRUST SECTION -->
            <div class="py-16 bg-gray-100">
                <div class="lg:w-[1280px] mx-auto px-4 grid sm:grid-cols-3 grid-cols-1 sm:gap-7 gap-12 items-center">
                    <div>
                        <h3 class="text-4xl md:text-5xl text-gray-900 font-black leading-tight">
                            Trusted & Accredited <span class="text-[#00C1EC]">Security Training</span>
                        </h3>
                    </div>

                    <div class="flex items-center justify-center"><img
                            src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438611/Frame-9_zw5aln.webp"
                            alt="Security guard receiving SIA training certificate" class="rounded-lg shadow-xl"></div>

                    <div class="flex items-center justify-center">
                        <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438611/Frame-8_bisg2b.webp"
                            alt="Group of trainees in classroom during security training course"
                            class="rounded-lg shadow-xl">
                    </div>
                </div>
            </div>

    <?php include "includes/footer.php" ?>
        </div>


        <!-- Footer: NOTE: Original PHP include is at the end of the file -->
    </div>

    <script>
        // POPUP LOGIC: Dynamically targets ONE shared popup
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Get the body element to apply the scroll lock class
            const bodyElement = document.getElementById('main-body');

            // 2. Create and append the single, shared overlay and form container
            const sharedOverlay = document.createElement('div');
            sharedOverlay.className = 'popup-overlay fixed inset-0 bg-black bg-opacity-70 z-[9998] hidden';
            document.body.appendChild(sharedOverlay);

            const sharedFormContainer = document.createElement('div');
            sharedFormContainer.className = 'popup-form fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 rounded-xl shadow-2xl z-[9999] w-11/12 max-w-md hidden';
            sharedFormContainer.innerHTML = `
            <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Enter your details to Buy Now!</h3>
            <form method="post" class="space-y-4" id="sharedForm">
                <div class="absolute top-4 right-4 cursor-pointer text-gray-500 hover:text-gray-900 close-popup-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
                <input type="text" name="Name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-[#00C1EC] focus:border-[#00C1EC]">
                <input type="email" name="Email" placeholder="Your Email" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-[#00C1EC] focus:border-[#00C1EC]">
                <input type="tel" name="Phone" placeholder="Phone Number" maxlength="12" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-[#00C1EC] focus:border-[#00C1EC]">
                <input type="hidden" name="course_name" value="">
                <input type="hidden" name="course_p" value="">
                <input type="hidden" name="course_id" value="">
                <button type="submit" name="submit" class="w-full bg-[#00C1EC] text-white font-bold p-3 rounded-lg shadow-md  transition-opacity">
                    Submit & Continue
                </button>
            </form>
        `;
            document.body.appendChild(sharedFormContainer);
            const sharedForm = document.getElementById('sharedForm');

            // 3. Functions to control popup state (with SCROLL LOCK FIX)
            const showPopup = (title, price, id) => {
                // Update shared form fields with course data
                sharedForm.querySelector('input[name="course_name"]').value = title;
                sharedForm.querySelector('input[name="course_p"]').value = price;
                sharedForm.querySelector('input[name="course_id"]').value = id;

                // Show popup and overlay
                sharedOverlay.classList.remove('hidden');
                sharedFormContainer.classList.remove('hidden');

                // **SCROLL LOCK FIX: Apply the class**
                if (bodyElement) {
                    bodyElement.classList.add('no-scroll');
                }
            };

            const hidePopup = () => {
                sharedOverlay.classList.add('hidden');
                sharedFormContainer.classList.add('hidden');

                // **SCROLL LOCK FIX: Remove the class**
                if (bodyElement) {
                    bodyElement.classList.remove('no-scroll');
                }
            };

            // 4. Event listeners for all "Book Now" buttons to open the *shared* popup
            document.querySelectorAll('.book-now-btn').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const title = this.getAttribute('data-course-name') || this.getAttribute('data-course-title');
                    const price = this.getAttribute('data-course-price');
                    const id = this.getAttribute('data-course-id');
                    showPopup(title, price, id);
                });
            });

            // 5. Event listeners for closing the popup
            sharedOverlay.addEventListener('click', hidePopup);
            sharedFormContainer.querySelector('.close-popup-btn').addEventListener('click', hidePopup);

            // 6. Form submission logic (Saves to localStorage)
            sharedForm.addEventListener('submit', function (e) {
                // Get input values
                const name = sharedForm.elements['Name'].value;
                const email = sharedForm.elements['Email'].value;
                const phone = sharedForm.elements['Phone'].value;

                // Save in localStorage before submission
                localStorage.setItem('Name', name);
                localStorage.setItem('Email', email);
                localStorage.setItem('Phone', phone);

                // PHP handles the actual submission and redirection
            });

        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

          const slider = document.getElementById('mobileCourseScroll');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => isDown = false);
    slider.addEventListener('mouseup', () => isDown = false);
    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 1; // scroll speed
        slider.scrollLeft = scrollLeft - walk;
    });

            // SWIPER TESTIMONIAL CAROUSEL INITIALIZATION
            new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 30, // Space between slides
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                // Responsive settings for testimonials 
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    }
                }
            });

            // FAQ ACCORDION TOGGLE
            document.querySelectorAll('[data-toggle="collapsess"]').forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const target = document.querySelector(targetId);

                    // Collapse all others
                    document.querySelectorAll('.collapsess').forEach(collapse => {
                        if (collapse.id !== target.id && !collapse.classList.contains('hidden')) {
                            collapse.classList.add('hidden');
                            // Reset other button styles and icons
                            const otherButton = document.querySelector(`[data-target="#${collapse.id}"]`);
                            if (otherButton) {
                                otherButton.classList.remove('bg-[#00C1EC]', 'text-white');
                                otherButton.classList.add('bg-white', 'text-gray-900');
                                const otherIcon = otherButton.querySelector('svg');
                                if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                            }
                        }
                    });

                    // Toggle the clicked one
                    target.classList.toggle('hidden');
                    const isOpen = !target.classList.contains('hidden');

                    // Toggle button styles
                    button.classList.toggle('bg-[#00C1EC]', isOpen);
                    button.classList.toggle('text-white', isOpen);
                    button.classList.toggle('bg-white', !isOpen);
                    button.classList.toggle('text-gray-900', !isOpen);

                    const icon = button.querySelector('svg');
                    icon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                    icon.style.transition = 'transform 0.3s';
                });
            });

        });
    </script>

    <?php include "includes/foot.php" ?>
</body>

</html>