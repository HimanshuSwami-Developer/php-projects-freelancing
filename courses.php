<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $_SESSION['Name'] = $name;
    $email = $_POST['Email'];
    $_SESSION['Email'] = $email;
    $phone = $_POST['Phone'];
    $_SESSION['Phone'] = $phone;
    $_SESSION['Course_Price'] = $_POST['course_p'];
    $_SESSION['course_id'] = $_POST['course_id'];

    // Email details
    $to = "bookings@gsecurityandtraining.co.uk";
    $subject = "ðŸš€ New Lead: Client Interested in Your Course!";

    $body = "You have received a new message from your website form.\n\n";
    $body .= "FullName: $name\n";
    $body .= "Phone: $phone\n";
    $body .= "Email: $email\n\n";
    // Including course context for the recipient
    if (isset($_POST['course_name'])) {
        $body .= "Course Name: " . $_POST['course_name'] . "\n";
    }
    if (isset($_POST['course_p'])) {
        $body .= "Price: Â£" . $_POST['course_p'] . "\n";
    }


    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect to date-select page on successful submission
        header("Location: date-select");
        exit();
    } else {
        // Display an error message if mail fails (preserved from original logic)
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // echo "Invalid access.";
}

// Add variable to track success of redirection/email send for the $msg notification logic
$msg_success = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>
<?php
include('admin/assets/config/db.php');

// Fetch all courses from database
$query = "SELECT * FROM courses";
$query_run = mysqli_query($con, $query);

// Count total courses for the carousel logic
$course_count = mysqli_num_rows($query_run);
// Reset internal pointer to reuse the data in the while loop below
if ($course_count > 0) {
    mysqli_data_seek($query_run, 0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accredited SIA Security Training Courses | Leeds - UK Nationwide</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/courses/" />
    <meta name="description"
        content="Start your security career with certified SIA training courses. Door supervision, CCTV, and more are available across the UK. Contact for more information.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'accent-blue': '#00C1EC',
                        'charcoal': '#181818',
                    }
                }
            }
        }
    </script>

    <style>
        /* Base styles for the pop-up components - styled primarily with Tailwind now */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Darker overlay for focus */
        z-index: 9998;
        transition: opacity 0.3s;
    }

    .popup-form {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        /* Tailwind handles styling: bg-white p-6 rounded-xl shadow-2xl */
    }

    /* 🚨 1. Full-width/Responsive Form: Target screens smaller than 640px (mobile) */
    @media (max-width: 639px) {
        .popup-form {
            width: 90vw !important; 
            max-width: none !important; /* Remove max-width restriction on small screens */
            /* Ensure the form content can scroll if needed on tiny screens */
            max-height: 90vh; 
            overflow-y: auto;
        }
    }

    /* 🚨 2. CRITICAL FIX: Freeze Background scrolling for all devices, especially mobile */
    /* Target HTML to prevent scrollbar from shifting due to body position:fixed */
    .no-scroll {
        overflow: hidden !important; 
    }

    /* Target BODY to anchor the viewport and stop scrolling on iOS/Safari */
    body.no-scroll {
        position: fixed; 
        top: 0; 
        left: 0; 
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
    
    /* New code includes the 'Trending' icon SVG - ensure it is styled correctly */
    .trending-icon {
        color: #fcea2b;
        /* Yellow color from the new design SVG path fill */
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    /* New: Hide scrollbar in the mobile carousel */
    .carousel-mobile-only {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .carousel-mobile-only::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    </style>

    <?php include "includes/head.php" ?>
</head>


<body class="bg-[#f8f8f8]">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>

    <?php
    if (isset($msg) && $msg) {
        ?>
        <div
            style="position: fixed; z-index: 999; background: green; right: 0; padding: 10px 20px; color: #fff; border-radius: 10px; top: 150px;">
            <?php echo $msg; ?>
        </div>
    <?php } ?>

    <div>
        <?php include "includes/header.php" ?>

       <div class="bg-[#f8f8f8] py-20">
  <h1 class="sm:text-[48px] text-[36px] font-bold text-center text-black">
    Our Security Training Courses
  </h1>

  <div
    x-data="{ 
      courseCount: <?php echo $course_count; ?>, 
      activeIndex: 0, 
      isMobile: window.innerWidth < 768, 
      updateActiveIndex() {
        if (!this.isMobile) return;
        const container = this.$refs.courseContainer;
        if (!container) return;
        const scrollLeft = container.scrollLeft;
        const cardWidth = container.querySelector('.course-card-wrapper').offsetWidth;
        let newIndex = Math.round(scrollLeft / (cardWidth + 24)); 
        this.activeIndex = Math.max(0, Math.min(newIndex, this.courseCount - 1));
      },
      checkIsMobile() {
        this.isMobile = window.innerWidth < 768;
      }
    }"
    @resize.window="checkIsMobile"
    x-ref="courseContainer"
    @scroll.passive="updateActiveIndex"
    class="max-w-[1280px] mx-auto mt-12 py-10"
  >
    <div
      :class="{
        'grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:px-6': !isMobile,
        'flex overflow-x-auto snap-x snap-mandatory space-x-6 pb-4 px-4 carousel-mobile-only': isMobile
      }"
      class="mx-auto"
    >
      <?php if ($course_count > 0): ?>
        <?php $counter = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($query_run)): ?>
          <?php 
            $title = strtolower($row['title']); 
$isDoorSupervision = (
  strpos($title, 'door supervision') !== false &&
  strpos($title, 'top-up') === false &&
  strpos($title, 'refresher') === false
);

          ?>

          <div class="h-full bg-black rounded-xl overflow-hidden shadow-2xl relative course-card-wrapper flex flex-col"
            :class="{
              'w-[calc(100vw-32px)] sm:w-full flex-shrink-0 snap-center': isMobile
            }">

            <div class="relative">
              <img
                class="w-full h-52 object-cover transition-transform duration-500 hover:scale-110"
                src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>"
                alt="Door supervision training Bradford"
              >

              <?php if ($isDoorSupervision): ?>
                <div
                  class="absolute bg-[#00C1EC] text-white text-xs font-semibold p-1 px-3 rounded-full flex items-center gap-1 top-3 left-3 shadow-md">
                  🔥 Top Selling
                </div>
              <?php endif; ?>
            </div>

            <div class="p-5 flex flex-col flex-grow">
              <div class="flex-grow">
                <!-- Fixed heading height for alignment -->
                <h2 class="text-2xl font-bold text-white mb-4 transition-colors duration-300 min-h-[64px] flex items-start">
                  <?php echo htmlspecialchars($row['title']); ?>
                </h2>

                <ul class="text-white list-disc list-inside space-y-3">
                  <?php for ($i = 1; $i <= 10; $i++): ?>
                    <?php if (!empty($row['point' . $i])): ?>
                      <li class="flex items-start gap-2 mt-1">
                        <?php echo htmlspecialchars($row['point' . $i]); ?>
                      </li>
                    <?php endif; ?>
                  <?php endfor; ?>
                </ul>
              </div>

             <?php
$title = strtolower($row['title']);
$isDoorSupervision = (
  strpos($title, 'door supervision') !== false &&
  strpos($title, 'top-up') === false &&
  strpos($title, 'refresher') === false
);
?>

<?php if ($isDoorSupervision): ?>
  <div class="text-white mt-8">
    <p class="text-base line-through text-gray-400">
      £<?php echo htmlspecialchars($row['regular_price']); ?>
    </p>
    <p class="text-2xl font-extrabold text-[#00C1EC]">
      £<?php echo htmlspecialchars($row['sale_price']); ?>
      <span class="text-sm text-gray-300">
        (<?php
          $discount = 0;
          if ($row['regular_price'] > 0 && $row['sale_price'] < $row['regular_price']) {
            $discount = round((($row['regular_price'] - $row['sale_price']) / $row['regular_price']) * 100);
          }
          echo $discount;
        ?>% off)
      </span>
    </p>
  </div>
<?php else: ?>
  <div class="text-white mt-8 text-2xl font-extrabold">
    <p>
      Starting at just
      <span class="text-accent-blue">&pound;<?php echo htmlspecialchars($row['sale_price']); ?></span>
    </p>
  </div>
<?php endif; ?>


              <div class="flex items-center justify-between mt-8">
                <div class="w-1/2 pr-2">
                  <button
                    data-course-index="<?php echo $counter; ?>"
                    class="book-now-btn w-full text-black rounded-lg bg-accent-blue p-3 shadow-lg hover:bg-opacity-90 transition-opacity"
                  >
                    BOOK NOW
                  </button>
                </div>
                <div class="w-1/2 pl-2 text-right">
                  <a
                    href="<?php echo htmlspecialchars($row['info_link']); ?>"
                    class="inline-flex items-center gap-2 text-white underline text-sm font-semibold hover:text-accent-blue transition-colors"
                  >
                    More Info
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                      <path fill="currentColor" fill-rule="evenodd"
                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                  </a>
                </div>
              </div>
            </div>

            <!-- Popup Section -->
            <div id="popup-overlay-<?php echo $counter; ?>" class="popup-overlay hidden"></div>
            <div id="popup-form-<?php echo $counter; ?>"
              class="popup-form bg-white p-6 rounded-xl shadow-2xl hidden w-11/12 max-w-sm">
              <div class="flex justify-end mb-2">
                <button
                  data-course-index="<?php echo $counter; ?>"
                  class="close-popup-btn-<?php echo $counter; ?> text-gray-500 hover:text-gray-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <h3 class="text-xl font-semibold text-charcoal mb-4 text-center">
                Enter your details to Buy Now!
              </h3>
              <form method="post" class="courseForm space-y-4">
                <input type="text" name="Name" placeholder="Your Name" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-accent-blue focus:border-accent-blue">
                <input type="email" name="Email" placeholder="Your Email" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-accent-blue focus:border-accent-blue">
                <input type="tel" name="Phone" placeholder="Phone Number" maxlength="12" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-accent-blue focus:border-accent-blue">

                <input type="hidden" name="course_name"
                  value="<?php echo htmlspecialchars($row['title']); ?>">
                <input type="hidden" name="course_p" value="<?php echo $row['sale_price'] ?>">
                <input type="hidden" name="course_id" value="<?php echo $row['id'] ?>">

                <button type="submit" name="submit"
                  class="w-full bg-accent-blue text-white font-bold p-3 rounded-lg shadow-md hover:bg-opacity-90 transition-opacity">
                  Submit & Continue
                </button>
              </form>
            </div>
          </div>

          <?php $counter++; ?>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-black">No courses found.</p>
      <?php endif; ?>
    </div>

    <div x-show="isMobile" class="flex justify-center mt-6">
      <?php for ($i = 0; $i < $course_count; $i++): ?>
        <span
          :class="{'bg-accent-blue': activeIndex === <?php echo $i; ?>, 'bg-gray-300': activeIndex !== <?php echo $i; ?>}"
          class="w-3 h-3 mx-1 rounded-full transition-colors duration-300"></span>
      <?php endfor; ?>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>
</div>




        <script>
    // --- Pop-up Form Logic for Multiple Courses ---
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM loaded - initializing popups');

        // 🚨 CRITICAL FIX: Helper functions to control scroll on both HTML and BODY
        function disableScroll() {
            // Add to both HTML and BODY for maximum cross-browser compatibility
            document.documentElement.classList.add('no-scroll');
            document.body.classList.add('no-scroll');
        }

        function enableScroll() {
            document.documentElement.classList.remove('no-scroll');
            document.body.classList.remove('no-scroll');
        }
        
        // Helper function to close specific popup
        function closePopup(courseIndex) {
            const overlay = document.getElementById(`popup-overlay-${courseIndex}`);
            const form = document.getElementById(`popup-form-${courseIndex}`);

            if (overlay && form) {
                overlay.classList.add('hidden');
                form.classList.add('hidden');
                enableScroll(); // 🚨 Enable scrolling when closed
                console.log('Popup closed for course:', courseIndex);
            }
        }

        // Helper function to close all popups (for ESC key/open-click)
        function closeAllPopups() {
            const openOverlays = document.querySelectorAll('.popup-overlay:not(.hidden)');
            
            if(openOverlays.length > 0) {
                enableScroll(); // 🚨 Ensure scrolling is re-enabled if any popup was open
            }

            openOverlays.forEach(overlay => {
                overlay.classList.add('hidden');
            });

            document.querySelectorAll('.popup-form:not(.hidden)').forEach(form => {
                form.classList.add('hidden');
            });

            console.log('All popups closed');
        }

        // Add event listeners to all book now buttons
        const bookNowButtons = document.querySelectorAll('.book-now-btn');

        bookNowButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const courseIndex = this.getAttribute('data-course-index');
                console.log('Opening popup for course:', courseIndex);

                const overlay = document.getElementById(`popup-overlay-${courseIndex}`);
                const form = document.getElementById(`popup-form-${courseIndex}`);

                if (overlay && form) {
                    closeAllPopups(); // Ensure only one is open at a time
                    overlay.classList.remove('hidden');
                    form.classList.remove('hidden');
                    disableScroll(); // 🚨 Disable scrolling when opened
                }
            });
        });

        // Event delegation for ALL close buttons and overlay click
        document.addEventListener('click', function (e) {
            // Check if clicked element is a close button
            const closeBtn = e.target.closest('[class*="close-popup-btn"]');
            if (closeBtn) {
                e.preventDefault();
                const courseIndex = closeBtn.getAttribute('data-course-index');
                closePopup(courseIndex);
                return;
            }

            // Check if clicked on overlay
            if (e.target.classList.contains('popup-overlay')) {
                const courseIndexMatch = e.target.id.match(/popup-overlay-(\d+)/);
                if (courseIndexMatch) {
                    const courseIndex = courseIndexMatch[1];
                    closePopup(courseIndex);
                }
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAllPopups();
            }
        });

        // Retained: Logic to save data to localStorage before form submission
        document.querySelectorAll('.courseForm').forEach(form => {
            form.addEventListener('submit', function (e) {
                const courseName = this.querySelector('input[name="course_name"]').value;
                const coursePrice = this.querySelector('input[name="course_p"]').value;
                const courseId = this.querySelector('input[name="course_id"]').value;

                localStorage.setItem('course_name', courseName);
                localStorage.setItem('course_price', coursePrice);
                localStorage.setItem('course_id', courseId);
            });
        });
    });
</script>

        <?php include "includes/foot.php" ?>
    </div>
</body>

</html>