<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $_SESSION['course_name']  = $_POST['course_name'] ?? '';
    $_SESSION['course_price'] = $_POST['course_p'] ?? '';
    $_SESSION['course_id']    = $_POST['course_id'] ?? '';

    header("Location: date-select");
    exit; 
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
    <title>SIA Security Training Courses in Leeds & Bradford | G Security & Training</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/" />
    <meta name="description"
        content="Join SIA-approved security, door supervisor & first aid training courses in Leeds & Bradford. Get licensed fast. Book today.">
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
                            Get trained, licensed, and <span class="text">start earning in just 3 weeks</span>.
                        </h1>
                        <p class="text-xl md:text-[13px] font-semibold mb-2 max-w-lg lg:mx-0 mx-auto">
                        If you’re thinking about working in security, you’re probably asking the same questions everyone does. How long does it take? Do I need experience? Will it actually pay well? Fair questions.</p>
    <p class="text-xl md:text-[13px] font-semibold mb-2 max-w-lg lg:mx-0 mx-auto">At <b>G Security & Training</b>, we provide <b>SIA-approved security training courses in Leeds and Bradford</b> that help you get trained, licensed, and earning without dragging the process out. You don’t need prior experience. You don’t need to figure things out on your own. We guide you from training all the way through to applying for your SIA licence — step by step.</p>
    <p class="text-xl md:text-[13px] font-semibold mb-5 max-w-lg lg:mx-0 mx-auto">Security work is consistently in demand across the UK, and with the right training, you could be ready to earn in as little as <b>three weeks</b>.</p>
                        

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
    <span class="text-[#00C1EC] text-xl">⚡️</span>
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
                    <h2 class="text-4xl font-bold text-center text-[#00C1EC] mb-2">Get your SIA license <span class="text-black">to work in security</span></h2>
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
            
            
            <div class="text-center my-10 max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-[#00C1EC] mb-2 ">Here’s how it usually works for most of our learners.</h2>
                <p class="md:text-lg text-[13px]  mb-2  lg:mx-0 mx-auto text-black mt-5">
                    First, you complete your training. Depending on the course you choose, this takes <b>between 3 and 7 days</b>. During this time, you’ll build the core skills needed to work safely, confidently, and legally in security roles.
                </p>
                <p class="md:text-lg text-[13px]  mb-2  lg:mx-0 mx-auto text-black">
                   Next, you pass a short exam and receive your training certificate. After that, you apply for your SIA licence. This part typically takes <b>7–10 days</b>.
                </p>
                <p class="md:text-lg text-[13px]  mb-2  lg:mx-0 mx-auto text-black">
              Once your licence is approved, you can start applying for jobs straight away. Many of our learners go on to earn <b>£14 to £25 per hour</b>, with monthly earnings of up to <b>£3,000</b>, depending on the role and hours you choose to work.
                </p>
            </div>

           <!-- 3. COURSE CATEGORY LISTING SECTION (STATIC DATA WITH POPUP INTEGRATION) -->
<!-- 3. COURSE CATEGORY LISTING SECTION (STATIC DATA WITH POPUP INTEGRATION) -->
<section class="py-16 md:py-24 border-t border-gray-200 bg-white">
    <div class="lg:w-[1280px] mx-auto px-4">
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 text-center mb-16">
            Pick the right <span class="text-[#00C1EC]">training course</span>
            & get started
        </h2>
        
        <p class="md:text-lg text-[13px]  mb-2  lg:mx-0 mx-auto text-black text-center">
              All of our courses are fully approved by the <b>Security Industry Authority (SIA)</b> and designed to be beginner-friendly. Even if you’re completely new to security, the training is structured for you to follow along comfortably.
        </p>

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
            Starts from just £<?php echo $row['sale_price']; ?>
        </span>
    </div>
<?php endif; ?>

                                    <div class="flex items-center justify-between space-x-2">
                                        <a href="<?php echo $row['info_link']; ?>"
                                            class="text-[#00C1EC] font-semibold hover:underline">More Info</a>
                                             <form method="post" class="space-y-4 sharedForm" >
                                         <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                <input type="hidden" name="course_p" value="<?php echo $row['sale_price']; ?>">
                <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
               
                                     <button
                                            class=" bg-[#00C1EC] text-white px-4 py-2 text-sm font-bold rounded-lg"
                                            data-course-name="<?php echo htmlspecialchars($row['title']); ?>"
                                            data-course-price="<?php echo $row['sale_price']; ?>"
                                            data-course-id="<?php echo $row['id']; ?>">
                                            
                                        Book Now
                                    </button>
                                    </form>
                                       
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
            Starts from just £<?php echo $row['sale_price']; ?>
        </span>
    </div>
<?php endif; ?>

                                <div class="flex items-center justify-between space-x-2">
                                    <a href="<?php echo $row['info_link']; ?>"
                                        class="text-[#00C1EC] font-semibold hover:underline transition-colors">More Info</a>
                                        <form method="post" class="space-y-4 sharedForm">
                                       <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                <input type="hidden" name="course_p" value="<?php echo $row['sale_price']; ?>">
                <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
               
               
                                    <button type="submit" name="submit"
                                        class="bg-[#00C1EC] text-white px-5 py-3 font-bold text-base rounded-lg transition duration-200"
                                        data-course-name="<?php echo htmlspecialchars($row['title']); ?>"
                                        data-course-price="<?php echo $row['sale_price']; ?>"
                                        data-course-id="<?php echo $row['id']; ?>">
                                        Book Now
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>



 <div class=" my-10 max-w-4xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-[#00C1EC] mb-2 ">SIA licenses <span class="text-black">you can apply post-training</span></h2>
                <div class=" my-5 md:max-w-2xl mx-auto mx-6">
                <p class="md:text-lg text-[13px]  mb-2  lg:mx-0 mx-auto text-black mt-5">
                   After completing your training, you’ll be eligible to apply for an official SIA licence, which is a mandatory requirement to work legally in the UK security industry.
                </p>
                <p class="md:text-lg text-[13px]  mb-2   mx-auto text-black">
                   Common licences candidates choose are:
                </p>
                <ul class="md:text-lg text-[13px]  mb-2   mx-auto text-black mt-5 ml-6" style="list-style:disc">
                    <li><b>Door Supervisor Licence</b> (also valid for security guard roles)</li>
                    <li><b>Security Guard Licence</b></li>
                </ul>
                <p class="md:text-lg text-[13px]  mb-2  mx-auto text-black">
                  These licences are recognised nationwide and reputable employers check if you have one before hiring you for a particular role.
                </p>
            </div>
            </div>



            <!-- 4. CAREER PATHS SECTION -->
            <div class="py-16 md:py-24 bg-[#f8f8f8]">
                <div class="lg:w-[1280px] mx-auto px-4">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-[#00C1EC] text-center mb-12">
                       Popular careers/opportunities <span class="text-black">after security training</span>
                    </h2>
                    <p class="text-xl text-center text-[#000] mb-8">Our trainers have <b>over three decades of combined experience</b> in frontline security and professional training. They’ve done the job themselves, so they understand what employers look for and how to prepare you properly. You won’t just learn how to pass an exam, you’ll learn how to work confidently once you’re licensed! Meet out team.</p>

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700 flex flex-col hover:border-[#00C1EC] transition duration-300">
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_kak7v0.jpg"
                    alt="Luzuko Mgaga" class="w-full h-56 object-cover">
                <div class="p-5 text-white">
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-semibold text-xl">Luzuko Mgaga</p>
                        <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        With over 10 years of front-line security experience, Luzuko brings hands-on expertise to the classroom. Based in Manchester and Dynamisis PI certified, his <b>conflict management classes</b> are a must-attend for any aspiring professional.
                    </p>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700 flex flex-col hover:border-[#00C1EC] transition duration-300">
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_1_qmxxod.jpg"
                    alt="Muhammad Pervaiz" class="w-full h-56 object-cover">
                <div class="p-5 text-white">
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-semibold text-xl">Muhammad Pervaiz</p>
                        <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        A versatile Manchester-based trainer and Dynamisis PI license holder. Muhammad specializes in <b>First Aid Training</b> and career coaching, helping students master security skills while learning how to <b>land jobs quickly</b>.
                    </p>
                </div>
            </div>

        </div>

        <div class="text-white lg:text-left text-center">
            <h2 class="text-4xl md:text-5xl text-[#00C1EC] mb-6 font-bold">
                A Qualified team<span class="text-white">, to help you every step of the way</span>
            </h2>
            <p class="text-xl text-gray-400 mb-8 leading-relaxed">
                Our trainers have over three decades of combined experience in frontline security and professional training. They’ve done the job themselves, so they understand what employers look for and how to prepare you properly. You won’t just learn how to pass an exam, you’ll learn how to work confidently once you’re licensed!
            </p>
            <a href="/meet-our-team"
                class="inline-block bg-[#00C1EC] hover:bg-[#00a8cc] text-white px-8 py-3 rounded-lg font-bold transition duration-200 shadow-md text-lg">
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
            <span class="text-[#00C1EC]">
                hear it from our happy customers!
            </span>
        </h2>
        <div class="flex flex-wrap items-center gap-4 mb-10">
            <span class="text-yellow-500 text-2xl font-bold">Excellent</span>
            <span class="text-yellow-500 text-3xl">⭐⭐⭐⭐⭐</span>
            <p class="text-gray-600">We’re proud to be rated 5/5 on Google Reviews by over 120+ learners.</p>
        </div>

        <div class="swiper mySwiper pb-12">
            <div class="swiper-wrapper">

                <div class="swiper-slide h-auto">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-[#00C1EC] h-full flex flex-col">
                        <div class="flex items-start mb-4">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-white text-xl font-bold">R</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Richard Owusu Afriyie</p>
                                <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 text-sm leading-relaxed italic">
                                "I just completed a door supervisor training, and it was really informative. The course covered essential skills like conflict resolution and effective communication, which are crucial for the role. I particularly enjoyed the practical scenarios we worked through, as they helped me understand how to handle real-life situations. Overall, it was a valuable experience that has prepared me well for my responsibilities as a door supervisor."
                            </p>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide h-auto">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-[#00C1EC] h-full flex flex-col">
                        <div class="flex items-start mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-white text-xl font-bold">A</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Amir Abbas</p>
                                <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 text-sm leading-relaxed italic">
                                "I had a positive experience. The staff were friendly and supportive, and the teaching methods were effective in helping me understand the material. The course was well-structured, and I appreciated the opportunities to ask questions and engage with the instructors."
                            </p>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide h-auto">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-lg border-t-4 border-[#00C1EC] h-full flex flex-col">
                        <div class="flex items-start mb-4">
                            <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <span class="text-white text-xl font-bold">J</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Jahed Shohag</p>
                                <span class="text-yellow-500 text-sm">⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 text-sm leading-relaxed italic">
                                "I had a great experience with G Security and Training Center. The tutor taught clearly and gave strong focus to practical training, which really helped my learning. The classroom environment was supportive, and the course covered all key areas of door supervision. I am very satisfied and would recommend this center to friends and family."
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>


            <!-- 8. FAQ AND CONTACT SECTION -->
            <div class="py-16 md:py-24 bg-[#f8f8f8]">
                <div class="lg:w-[1280px] mx-auto px-4 grid lg:grid-cols-2 gap-12 items-start">

                    <!-- Left Column: FAQ Accordion (Reused component from previous file) -->
                   <div class="w-full p-4 lg:p-0 order-2 lg:order-1">
    <h2 class="text-4xl text-[#00C1EC] mb-10 text-center lg:text-left font-bold">
        Still got questions? <span class="text-gray-900">We’re here to clear them up for you.</span>
    </h2>
    
    <div class="space-y-4">
        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-1">
                <span class="font-semibold">What exactly is the Door Supervision course?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-1" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">G-Security and Training’s Door Supervision course is a sure-fire way you can gain the necessary skills that help you legally qualify and obtain an SIA license for working in security roles.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-2">
                <span class="font-semibold">Do I need any experience to join?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-2" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">Luckily, you don’t. We’ve trained thousands of freshers who had zero experience in the industry, who are now earning to their highest potential in security.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-3">
                <span class="font-semibold">How long does the course take?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-3" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">The actual training part only takes 3-7 days. The entire process, including exams and license application, usually takes about three weeks.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-4">
                <span class="font-semibold">How much does it cost?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-4" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">The Door Supervision course costs £350. It’s a great investment that often pays for itself in nearly 10 days once you start working.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-5">
                <span class="font-semibold">What jobs can I get after this?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-5" class="collapsess hidden bg-gray-50 text-gray-700">
                <div class="p-4 border-t border-gray-200">
                    <p class="mb-3 font-medium">Common pathways include:</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Door Supervisor / Bouncer</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Event Security / Steward</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Corporate Security Officer</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Retail Security Guard</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Construction Site Security</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Concierge / Reception</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Mobile Patrol Officer</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-[#00C1EC] rounded-full mr-2"></span> Keyholding Services</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-6">
                <span class="font-semibold">Is this qualification actually recognised?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-6" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">Yes! This training allows you to apply for an SIA license, which is the legal requirement and the most common qualification requested by UK security employers.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-7">
                <span class="font-semibold">What if I fail the exam?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-7" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">Don't worry—mishaps happen. We offer plans with multiple free resits and provide expert guidance to ensure you pass comfortably on your next attempt.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-8">
                <span class="font-semibold">Is First Aid training included?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-8" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">Free first aid training is included in our Gold and Diamond plans, as well as our Top-Up courses, giving you an extra edge with employers.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-9">
                <span class="font-semibold">What’s the Top-Up Refresher course for?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-9" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">This is for existing license holders who need to renew their 3-year license. It covers new industry standards and skills developed since your last training.</p>
            </div>
        </div>

        <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200">
            <button class="w-full text-left p-4 bg-white text-gray-900 focus:outline-none flex justify-between items-center transition-all hover:bg-gray-50"
                data-toggle="collapsess" data-target="#faq-home-10">
                <span class="font-semibold">How quickly can I start earning?</span>
                <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="faq-home-10" class="collapsess hidden bg-gray-50 text-gray-700">
                <p class="p-4 border-t border-gray-200">Once you pass and apply for your SIA license (which takes 7-10 days to approve), you can start working immediately. Usually, you're earning within 3-4 weeks.</p>
            </div>
        </div>

        <div class="text-center pt-6">
            <a href="/faqs" class="inline-block border-2 border-[#00C1EC] text-gray-900 px-6 py-3 rounded-lg font-bold hover:bg-[#00C1EC] hover:text-white transition duration-200 shadow-md">
                View All FAQs
            </a>
        </div>
    </div>
</div>

                    <!-- Right Column: Priority/Help Message (Reused component from previous file) -->
                    <div class="w-full p-4 lg:p-0 text-center lg:order-2">
    <div class="bg-gray-100 p-8 rounded-xl shadow-xl border-t-8 border-[#00C1EC]">
        <h2 class="text-3xl font-black text-gray-900 mb-4">Do you need help?</h2>
        <p class="text-xl text-gray-700 mb-6">Our team's got your back.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/447736540149"
                class="text-white bg-green-500 py-3 px-6 rounded-lg font-bold hover:bg-green-600 shadow-md transition duration-200">
                Chat with us
            </a>
            <a href="/faqs"
                class="text-gray-900 bg-white py-3 px-6 rounded-lg font-bold hover:bg-gray-50 shadow-md border border-gray-200 transition duration-200">
                Help centre
            </a>
            <a href="mailto:Info@gsecurityandtraining.co.uk"
                class="text-gray-900 bg-white py-3 px-6 rounded-lg font-bold hover:bg-gray-50 shadow-md border border-gray-200 transition duration-200">
                Email us
            </a>
        </div>
    </div>

    <div class="mt-12 py-10 px-6 bg-white rounded-xl border-2 border-dashed border-gray-200">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">
            Book Your SIA Training Course Today
        </h2>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
If you’re ready to get started, the next step is simple. <a href="/courses" class="text-blue-600">Choose the course</a> that suits you, book your place, and we’ll guide you through the rest. 
<br>
With <b>G Security & Training</b>, you get <b>SIA security training courses in Leeds and Bradford</b> that prepare you for real work. For more doubts, feel free to contact us anytime.
        </p>
        <!--<div class="flex flex-col sm:flex-row gap-4 justify-center">-->
        <!--    <a href="/courses" -->
        <!--        class="inline-block bg-[#00C1EC] text-white px-10 py-4 rounded-lg font-bold hover:bg-[#00a8cc] transition duration-200 shadow-lg text-xl">-->
        <!--        View All Courses-->
        <!--    </a>-->
        <!--    <a href="/contact" -->
        <!--        class="inline-block bg-gray-900 text-white px-10 py-4 rounded-lg font-bold hover:bg-black transition duration-200 shadow-lg text-xl">-->
        <!--        Contact Us-->
        <!--    </a>-->
        <!--</div>-->
        <!--<p class="mt-6 text-sm text-gray-400">Still have doubts? We're available 24/7 to help you decide.</p>-->
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


           
              // Retained: Logic to save data to localStorage before form submission
        document.querySelectorAll('.sharedForm').forEach(form => {
            form.addEventListener('submit', function (e) {
                  const courseName  = this.querySelector('input[name="course_name"]').value;
        const coursePrice = this.querySelector('input[name="course_p"]').value;
        const courseId    = this.querySelector('input[name="course_id"]').value;

        localStorage.setItem('course_name', courseName);
        localStorage.setItem('course_price', coursePrice);
        localStorage.setItem('course_id', courseId);

            });
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