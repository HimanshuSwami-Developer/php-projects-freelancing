<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- PHP LOGIC PRESERVED FROM LIVE CODE ---

// Check if course data is set in the session. If not, redirect.
if (!isset($_SESSION['course_id'])) {
  // Note: The original redirect location was 'index', adjusted here for context, 
  // but preserving the original intent to stop processing.
  header("Location: /courses");
  exit();
}

// Include database configuration
include 'admin/assets/config/db.php';


// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// AJAX endpoint: save selected date to session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'select_package') {
  header('Content-Type: application/json; charset=utf-8');

  if (!$con) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
  }

  // Basic validation
  $date = isset($_POST['date']) ? trim($_POST['date']) : '';
  $package_price = isset($_POST['package_price']) ? trim($_POST['package_price']) : '';
  $package = isset($_POST['package']) ? trim($_POST['package']) : '';
  $price = isset($_POST['price']) ? trim($_POST['price']) : '';
  $course = isset($_POST['course']) ? trim($_POST['course']) : '';
  $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;


  if ($date === '' || $course === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing date or course']);
    exit();
  }



  // Save selection in session (use the posted price variable)
  $_SESSION['selected_date'] = $date;
  $_SESSION['selected_package'] = $package;
  $_SESSION['selected_package_price'] = $package_price;
  $_SESSION['selected_price'] = $price;
  $_SESSION['selected_course'] = $course;
  $_SESSION['course_name'] = $course;
  $_SESSION['selected_quantity'] = $quantity;
  $_SESSION['selected_at'] = time();

  echo json_encode(['status' => 'ok']);
  exit();
}


// Helper for safe include
function safe_include($path, $fallback = '')
{
  if (file_exists($path)) {
    include $path;
  } else {
    echo $fallback;
  }
}

// Session variables
$course_id = $_SESSION['course_id'];
$name = $_SESSION['Name'];
$email = $_SESSION['Email'];
$phone = $_SESSION['Phone'];
$price = $_SESSION['Course_Price'];
$course_name = $_SESSION['course_name'] ?? '';



include('admin/assets/config/db.php');

// Fetch all courses from database
$query = "SELECT * FROM courses where id='$course_id' LIMIT 1";
$query_run = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($query_run);

// Fetch course dates
if (!$con)
  die("Database connection failed.");
$stmt = $con->prepare("SELECT * FROM course_dates WHERE course_id=? ORDER BY start_date ASC");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course_dates = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Ordinal helper
function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }
    
    // Helper function to get dates between start and end
    function getDatesBetween($start_date, $end_date) {
        $dates = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);
        while ($current <= $end) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime("+1 day", $current);
        }
        return $dates;
    }


// Training packages data (updated structure)
$training_packages = [];

// $packages_query = mysqli_query($con, "
//     SELECT sp.*, 
//           (SELECT COUNT(*) FROM plan_features pf 
//             INNER JOIN plan_feature_headings h ON pf.heading_id = h.id 
//             WHERE h.plan_id = sp.id AND pf.is_included = 1) AS included_features_count,
//           (SELECT COUNT(*) FROM plan_features pf 
//             INNER JOIN plan_feature_headings h ON pf.heading_id = h.id 
//             WHERE h.plan_id = sp.id AND pf.is_included = 0) AS excluded_features_count
//     FROM subscription_plans sp 
//     WHERE sp.is_active = 1 
//     ORDER BY 
//         CASE sp.plan_key 
//             WHEN 'bronze' THEN 1 
//             WHEN 'gold' THEN 2 
//             WHEN 'platinum' THEN 3 
//             ELSE 4 
//         END
// ");


$packages_query = mysqli_query($con, "
    SELECT sp.*, 
           (SELECT COUNT(*) FROM plan_features pf 
            INNER JOIN plan_feature_headings h ON pf.heading_id = h.id 
            WHERE h.plan_id = sp.id AND pf.is_included = 1) AS included_features_count,
           (SELECT COUNT(*) FROM plan_features pf 
            INNER JOIN plan_feature_headings h ON pf.heading_id = h.id 
            WHERE h.plan_id = sp.id AND pf.is_included = 0) AS excluded_features_count
    FROM subscription_plans sp 
    WHERE sp.is_active = 1 AND sp.course_id = '$course_id'
    ORDER BY 
        CASE sp.plan_key 
            WHEN 'bronze' THEN 1 
            WHEN 'gold' THEN 2 
            WHEN 'platinum' THEN 3 
            ELSE 4 
        END
");


while ($package = mysqli_fetch_assoc($packages_query)) {
    $plan_id = (int)$package['id'];
// Fetch all feature headings and their features for this plan
$headings_query = mysqli_query($con, "
    SELECT h.id AS heading_id, h.heading_text
    FROM plan_feature_headings h
    WHERE h.plan_id = $plan_id
    ORDER BY h.sort_order ASC
");

$headings = [];
while ($heading = mysqli_fetch_assoc($headings_query)) {
    $heading_id = (int)$heading['heading_id'];

    // Get all features under this heading
    $features_query = mysqli_query($con, "
        SELECT feature_text, is_included
        FROM plan_features
        WHERE heading_id = $heading_id
        ORDER BY sort_order ASC
    ");

    $features = [];
    while ($feature = mysqli_fetch_assoc($features_query)) {
        $features[] = [
            'text' => $feature['feature_text'],
            'is_included' => (bool)$feature['is_included']
        ];
    }

    $headings[] = [
        'heading' => $heading['heading_text'],
        'features' => $features
    ];
}

// Now attach it to your package array
$training_packages[$package['plan_key']] = [
    'id' => $plan_id,
    'name' => $package['name'],
    'subtitle' => $package['subtitle'],
    'original_price' => (float)$package['original_price'],
    'sale_price' => (float)$package['sale_price'],
    'payment_note' => $package['payment_note'],
    'feature_groups' => $headings, // ✅ corrected key
    'is_most_popular' => ($package['plan_key'] === 'gold')
];

}


// Determine the date array and course details to display
// $current_dates = ($course_id == "C1") ? $dates_c1 : $dates_c2;
// $course_details = ($course_id == "C1") ? [
//     'title' => "Door Supervision + Free First Aid",
//     'duration' => "7 Days Course",
//     'list' => [
//         'Includes Emergency First Aid Training.',
//         'Suite 2, Holbeck House, 116 Dewsbury Rd, Leeds LS11 6XD',
//         'Earning potential of £14 p/h to £25 p/h',
//         'Timings: 8:30 a.m. - 5:00 p.m.',
//     ],
//     'is_recommended' => true
// ] : [
//     'title' => "SIA Top Refresher For Door Supervision + First Aid",
//     'duration' => "3 Days Course",
//     'list' => [
//         'Monday: Emergency First Aid',
//         'Friday & Saturday: Refresher Training',
//         'Suite 2, Holbeck House, 116 Dewsbury Rd, Leeds LS11 6XD',
//         'Earning potential of £14 p/h to £25 p/h',
//         'Timings: 8:30 a.m. - 5:00 p.m.',
//     ],
//     'is_recommended' => false
// ];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>G Security and Training | Select Date</title>
  <!-- Load required scripts and styles -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- Custom Tailwind Configuration -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'accent-blue': '#00C1EC',
            'charcoal': '#181818',
          },
          boxShadow: {
            // Clean, modern elevation shadow
            'elevation': '0 20px 40px -15px rgba(0, 0, 0, 0.2)', /* Adjusted shadow for light background */
          }
        }
      }
    }
  </script>
  
<style>
.rotate-180 {
  transform: rotate(180deg);
}
</style>


  <?php include "includes/head.php" ?>
</head>

<body class="bg-white">
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>

  <div>
    <!-- Notification Bar / Header Include -->
    <?php include "includes/header.php" ?>

    <!-- body: Main Content Area (Light Gray Background) -->
    <div class="course-dates-container bg-[#f8f8f8] py-12 md:py-20 min-h-screen">

      <!-- Course Card Container -->
      <div
        class="lg:w-[1024px] lg:mx-auto mx-4 mt-12 mb-16 bg-white text-gray-900 rounded-xl shadow-elevation overflow-hidden course-section border-t-8 border-[#00C1EC]">


        <!-- Course Details Container (Header) -->
        <div class="p-6 md:p-8 pt-4 border-b border-gray-100">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-end">
            <div class="mb-4 md:mb-0">
              <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-1">
                <?= htmlspecialchars($row['title']) ?></h2>
              <p class="text-red-600 font-black text-base">Hurry Up! Few seats left</p>
            </div>

            <div class="text-right flex flex-col items-end">
              <!-- Price Callout: Uses dynamic $price variable -->
              <span class="text-gray-500 text-xl mr-3 font-normal line-through">£<?= number_format($price + 50, 2) ?>
              </span>
              <span
                class="text-[#00C1EC] text-5xl lg:text-6xl font-extrabold tracking-tight">£<?= number_format($price, 2) ?></span>
            </div>
          </div>

          <!-- Enhanced Feature List (Uses dynamic course_details array) -->
          <ul class="mt-8 text-gray-700 space-y-4 list-none p-0">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <?php if (!empty($row['point' . $i])): ?>
                <li class="flex items-start gap-4">
               
                  <div class="text-gray-900 text-base font-medium leading-snug">
                    <?= htmlspecialchars($row['point' . $i]) ?>
                  </div>
                </li>
              <?php endif; ?>
            <?php endfor; ?>
          </ul>
        </div>

        <!-- Toggle Button: Prominent blue button -->
        <div>
          <button
            class="toggle-dates-btn w-full text-white py-4 bg-[#00C1EC] font-bold text-lg hover:bg-white hover:text-[#00C1EC] transition duration-200 uppercase tracking-widest">
            View Course Dates ▼
          </button>
        </div>

        <!-- Course Dates (Very Light Gray Background for separation) -->
        <div class="course-dates hidden p-6 border-t border-gray-200 bg-gray-50">
          <h3 class="text-xl font-bold border-b border-gray-200 pb-3 mb-4 text-gray-900">Choose your course dates</h3>
          <p class="text-gray-600 text-sm mb-4">* All prices are inclusive of VAT</p>

          <!-- Date Selection Loop (MAPPED FROM LIVE PHP LOOP) -->

          <?php if (!empty($course_dates)): ?>
                   <?php foreach ($course_dates as $d):
        $status = strtolower($d['status']);
        $isBookable = !in_array($status, ['full', 'cancelled', 'closed']);
        $start = new DateTime($d['start_date']);
        $end = new DateTime($d['end_date']);
        
        // Format dates based on the same logic as admin panel
        $formattedDate = '';
        $allDates = getDatesBetween($d['start_date'], $d['end_date']);
        
        if (!empty($d['selected_dates'])) {
            $selected = json_decode($d['selected_dates'], true);
            $startFormatted = ordinal((int)$start->format('j')) . ' ' . $start->format('D, M');
            $endFormatted = ordinal((int)$end->format('j')) . ' ' . $end->format('D, M');
            
            // Case 1: Same start and end date
            if ($d['start_date'] == $d['end_date']) {
                $formattedDate = $startFormatted;
            }
            // Case 2: All dates in range are selected
            elseif (count($selected) == count($allDates)) {
                $formattedDate = $startFormatted . ' - ' . $endFormatted;
            }
            // Case 3: Only specific dates are selected
            else {
                $formattedDate = $startFormatted . ' - ' . $endFormatted;
                // Add the specific selected dates as a subtitle
                $selectedDatesDisplay = [];
                foreach ($selected as $selectedDate) {
                    $dateObj = new DateTime($selectedDate);
                    $selectedDatesDisplay[] = ordinal((int)$dateObj->format('j')) . ' ' . $dateObj->format('D');
                }
                $selectedDatesString = implode(' - ', $selectedDatesDisplay);
            }
        } else {
            // Fallback: if no selected_dates data, show simple range
            $formattedDate = ordinal((int)$start->format('j')) . ' ' . $start->format('D, M') . ' - ' . 
                           ordinal((int)$end->format('j')) . ' ' . $end->format('D, M');
        }
    ?>
        <div class="mt-3 p-3 rounded border flex items-center justify-between <?= !$isBookable ? 'opacity-60 bg-gray-50' : '' ?>">
            <div>
                <div class="font-medium"><?= htmlspecialchars($formattedDate) ?></div>
                
                <?php if (isset($selectedDatesString)): ?>
                    <div class="text-sm text-blue-600 mt-1">
                        Course Dates are : <?= htmlspecialchars($selectedDatesString) ?>
                    </div>
                    <?php unset($selectedDatesString); // Clear for next iteration ?>
                <?php endif; ?>
                <div class="text-xs <?= $isBookable ? 'text-green-600' : 'text-red-500' ?>">
                  <?= htmlspecialchars(ucfirst($d['status'] ?? '')) ?>
                  <span class="text-red-500">
                    <?= htmlspecialchars($d['seats_left_text'] ?? '') ?>
                  </span>
                </div>

            </div>
            
            <div class="flex items-center space-x-3">
                <div class="text-sm">
                    <s class="text-gray-400">£<?= number_format($d['price'] + 50, 2) ?></s>
                    <div class="font-semibold">£<?= number_format($d['price'], 2) ?></div>
                </div>
                <button
                    class="select-date-btn bg-[#00C1EC] text-white px-4 py-2 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                    data-dateId="<?= htmlspecialchars($d['id']) ?>" 
                    data-date="<?= htmlspecialchars($formattedDate) ?>"
                    data-course="<?= htmlspecialchars($row['title']) ?>" 
                    data-price="<?= htmlspecialchars($d['price']) ?>"
                    data-quantity="1" 
                    <?= !$isBookable ? 'disabled' : '' ?>
                >
                    <span class="btn-text">Select</span>
                    <span class="btn-loading hidden">Processing...</span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
       </div>
        </div>


      <?php else: ?>
        <div class="text-center py-8 text-red-700">
          No Course Dates Available. Please contact support.
        </div>

      <?php endif; ?>
    </div>
  </div>

  </div>
  </div>


<div id="packages-section" class="hidden my-5 max-w-[1024px] mx-auto my-10">
  <div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-900 mb-1">
      Rely on 20+ years of Security Training expertise to get licensed
    </h2>
  </div>

  <?php if (!empty($training_packages)): ?>

    <?php
      // Define custom order for packages
      $ordered_keys = ['bronze', 'gold', 'platinum'];
      $ordered_packages = [];
      foreach ($ordered_keys as $key) {
        if (isset($training_packages[$key])) {
          $ordered_packages[$key] = $training_packages[$key];
        }
      }
    ?>

    <!-- Mobile Tabs -->
    <div class="lg:hidden mb-6">
      <div class="flex justify-center gap-2 bg-gray-100 rounded-full p-1 shadow-inner">
        <?php foreach ($ordered_packages as $key => $package): ?>
          <button class="tab-btn flex-1 text-center px-4 py-2 text-sm font-semibold rounded-full transition-all duration-300
             text-gray-600 hover:text-white hover:bg-blue-500" data-tab="<?= $key ?>">
            <?= ucfirst($key) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Mobile Cards -->
    <div class="lg:hidden mt-4">
      <?php foreach ($ordered_packages as $key => $package): ?>
        <div class="package-tab hidden" id="tab-<?= $key ?>">
          <?php include 'package-card.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Desktop Grid -->
    <div class="hidden lg:grid grid-cols-1 lg:grid-cols-3 gap-4">
      <?php foreach ($ordered_packages as $key => $package): ?>
        <?php include 'package-card.php'; ?>
      <?php endforeach; ?>
    </div>
    
    <div id="packageConfirmPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-lg p-6 w-96 max-w-full text-center">
    <h2 class="text-xl font-semibold mb-3 text-red-600">Important Notice</h2>
    <p class="text-gray-700 mb-4 leading-relaxed">
      This plan doesn’t include the mandatory requirement of <strong>Emergency First Aid training</strong>.
    </p>
    <p class="text-gray-700 mb-6 leading-relaxed">
      Please note: Having a <strong>First Aid Certification</strong> in order to get your
      <strong>SIA Level 2 Door Supervisor</strong> certification is mandatory.
    </p>
    <p class="text-gray-800 font-medium mb-6">Do you want to switch to the Gold Plan?</p>
    <div class="flex justify-center gap-4">
      <button id="popupYes" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Yes</button>
      <button id="popupNo" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">I understand continue with Same Plan</button>
    </div>
  </div>
</div>

    <!-- First Aid Training Note -->
    <div class="mt-10 bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center shadow-sm">
      <h3 class="text-xl font-semibold text-blue-700 mb-2">First Aid Training</h3>
      <p class="text-gray-700 max-w-2xl mx-auto">
        Complementary training included with most of our packages.<br>
        Equip yourself with the skills to help people who may have gotten injured at your workplace.<br>
        <span class="font-medium text-blue-600">Stand apart from the crowd with an additional skillset.</span>
      </p>
    </div>

  <?php else: ?>
    <div class="text-center py-8 text-yellow-700">
      No Packages Available. Please add subscription plans from admin panel.
    </div>
  <?php endif; ?>
</div>



  <!-- Footer Include -->
  <?php include "includes/footer.php" ?>



  <!-- JavaScript to toggle course dates and handle selection (Preserved LIVE CODE logic using new classes) -->

  <script>
    const CSRF_TOKEN = <?= json_encode($_SESSION['csrf_token']) ?>;

    document.addEventListener('DOMContentLoaded', function () {
   const dropdowns = [
    { headingId: "heading_gold", menuId: "menu_gold" },
    { headingId: "heading_platinum", menuId: "menu_platinum" }
  ];

  dropdowns.forEach(({ headingId, menuId }) => {
    const heading = document.getElementById(headingId);
    const list = document.getElementById(menuId);

    if (!heading || !list) return;

    // Check if the heading contains "Everything in"
    if (heading.textContent.trim().includes("Everything in")) {
      // Style and icon
      heading.classList.add("cursor-pointer", "flex", "justify-between", "items-center");

      const arrow = document.createElement("span");
      arrow.innerHTML = "&#9662;";
      arrow.classList.add("text-gray-500", "ml-2", "transition-transform", "duration-200");
      heading.appendChild(arrow);

      // Hide initially
      list.classList.add("hidden");

      // Add click event
      heading.addEventListener("click", function () {
        // Close all dropdowns inside the same section (gold/platinum)
        dropdowns.forEach(({ headingId: otherHeadingId, menuId: otherMenuId }) => {
          if (otherHeadingId !== headingId && otherMenuId !== menuId) return;
          const otherList = document.getElementById(otherMenuId);
          const otherHeading = document.getElementById(otherHeadingId);
          const otherArrow = otherHeading?.querySelector("span");

          if (otherHeading !== heading && otherList && otherList.tagName === "UL") {
            otherList.classList.add("hidden");
            otherArrow?.classList.remove("rotate-180");
          }
        });

        // Toggle clicked one
        list.classList.toggle("hidden");
        arrow.classList.toggle("rotate-180");
      });
    }
  });

  const tabs = document.querySelectorAll('.tab-btn');
  const tabContents = document.querySelectorAll('.package-tab');

  function showTab(tabKey) {
    // Show/hide tab contents
    tabContents.forEach(tab => {
      tab.classList.toggle('hidden', tab.id !== `tab-${tabKey}`);
    });

    // Highlight active tab button
    tabs.forEach(btn => {
      const isActive = btn.dataset.tab === tabKey;
      btn.classList.toggle('bg-blue-500', isActive);
      btn.classList.toggle('text-white', isActive);
      btn.classList.toggle('shadow', isActive);
      btn.classList.toggle('text-gray-600', !isActive);
    });
  }

  // ✅ Show the first tab by default (not tabs[1])
  if (tabs.length > 0) {
    showTab(tabs[1].dataset.tab);
  }

  // ✅ Handle tab click events
  tabs.forEach(btn => {
    btn.addEventListener('click', () => showTab(btn.dataset.tab));
  });

  // Optional: track selected package (placeholder)
  let selectedPackage = null;

  // ✅ Toggle course dates visibility
  document.querySelectorAll('.toggle-dates-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const courseSection = btn.closest('.course-section');
      if (!courseSection) return;

      const dates = courseSection.querySelector('.course-dates');
      if (!dates) return;

      dates.classList.toggle('hidden');
      btn.textContent = dates.classList.contains('hidden')
        ? 'View Course Dates ▼'
        : 'Hide Course Dates ▲';
    });
  });


      document.querySelectorAll('.select-date-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
          if (this.disabled) return;

          const date = this.dataset.date;
          const dateId = this.getAttribute('data-dateId');
          const price = this.dataset.price;
          const course = this.dataset.course;
          const quantity = this.dataset.quantity || 1;

          // store for later package selection
          selectedDateData = { dateId, date, price, course, quantity };

          this.disabled = true;
          this.querySelector('.btn-text').classList.add('hidden');
          this.querySelector('.btn-loading').classList.remove('hidden');

    if (course == "Level 2 Door Supervisor" || course == "SIA Top-Up Refresher For Door Supervision + First Aid") {
      
          try {
            // Show packages section
            document.getElementById('packages-section').classList.remove('hidden');

            // Hide all date containers
            document.querySelectorAll('.course-dates-container').forEach(el => el.classList.add('hidden'));

            // Smooth scroll to packages
            document.getElementById('packages-section').scrollIntoView({ behavior: 'smooth' });

            this.disabled = false;
            this.querySelector('.btn-text').classList.remove('hidden');
            this.querySelector('.btn-loading').classList.add('hidden');
          } catch (e) {
            console.error(e);
            alert('Error: ' + e.message);
            this.disabled = false;
            this.querySelector('.btn-text').classList.remove('hidden');
            this.querySelector('.btn-loading').classList.add('hidden');
          }
    } else {

            // Optional: Save in localStorage
            try {
              localStorage.setItem('cartPackage', JSON.stringify({
                ...selectedDateData,
                packageId: 0,
                package: course,
                package_price: price,
                original_price: price
              }));
            } catch (e) {
              console.warn('localStorage not available', e);
            }

            // Highlight selected card
            // document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
            // this.closest('.package-card').classList.add('selected');

            // Prepare data for API
            const form = new FormData();
            form.append('action', 'select_package');
            form.append('dateId', selectedDateData.dateId);
            form.append('date', selectedDateData.date);
            form.append('price', selectedDateData.price);
            form.append('course', selectedDateData.course);
            form.append('quantity', selectedDateData.quantity);
            form.append('packageId', selectedDateData.packageId);
            form.append('package', selectedDateData.package);
            form.append('package_price', selectedDateData.package_price);

            console.log('Submitting package selection:', {
              date: selectedDateData.date,
              price: selectedDateData.price,
              course: selectedDateData.course,
              quantity: selectedDateData.quantity,
              // package: packageName,
              // packagePrice,
            });

            try {
              const res = await fetch(window.location.href, {
                method: 'POST',
                body: form,
                credentials: 'same-origin'
              });
              const json = await res.json();

              if (json && json.status === 'ok') {
                window.location.href = 'cart';
              } else {
                alert('Could not save package. Try again.');
              }
            } catch (err) {
              console.error(err);
              alert('Network error. Try again.');
            }
    }
        });
      });


      document.querySelectorAll('.select-package-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const popup = document.getElementById('packageConfirmPopup');
          const popupYes = document.getElementById('popupYes');
          const popupNo = document.getElementById('popupNo');
          let packageId = this.getAttribute('data-package-id');
          let packageName = this.getAttribute('data-package');
          let packagePrice = this.getAttribute('data-package-price');
          const originalPrice = this.getAttribute('data-original-price');

          if (!selectedDateData) {
            alert('Please select a date first.');
            return;
          }

        if (packageName.toLowerCase() === 'bronze') { // Optional: Save in localStorage
        
        
         popup.classList.remove('hidden');

        // Wait for user choice
        const userChoice = await new Promise(resolve => {
          popupYes.onclick = () => { popup.classList.add('hidden'); resolve('yes'); };
          popupNo.onclick = () => { popup.classList.add('hidden'); resolve('no'); };
        });

        if (userChoice === 'yes') {
          // Convert to gold package
          packageName = 'Gold';
          packageId = '2'; // Your gold package ID
          packagePrice = '349'; // Your gold price (example)
        }

        
          try {
            localStorage.setItem('cartPackage', JSON.stringify({
              ...selectedDateData,
              packageId: packageId,
              package: packageName,
              package_price: packagePrice,
              original_price: originalPrice
            }));
          } catch (e) {
            console.warn('localStorage not available', e);
          }

          // Highlight selected card
          document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
          this.closest('.package-card').classList.add('selected');

          // Prepare data for API
          const form = new FormData();
          form.append('action', 'select_package');
          form.append('dateId', selectedDateData.dateId);
          form.append('date', selectedDateData.date);
          form.append('price', selectedDateData.price);
          form.append('course', selectedDateData.course);
          form.append('quantity', selectedDateData.quantity);
          form.append('packageId', selectedDateData.packageId);
          form.append('package', selectedDateData.package);
          form.append('package_price', selectedDateData.package_price);

          console.log('Submitting package selection:', {
            date: selectedDateData.date,
            price: selectedDateData.price,
            course: selectedDateData.course,
            quantity: selectedDateData.quantity,
            // package: packageName,
            // packagePrice,
          });

          try {
            const res = await fetch(window.location.href, {
              method: 'POST',
              body: form,
              credentials: 'same-origin'
            });
            const json = await res.json();

            if (json && json.status === 'ok') {
              window.location.href = 'cart';
            } else {
              alert('Could not save package. Try again.');
            }
          } catch (err) {
            console.error(err);
            alert('Network error. Try again.');
          }
        }   else{
               try {
            localStorage.setItem('cartPackage', JSON.stringify({
              ...selectedDateData,
              packageId: packageId,
              package: packageName,
              package_price: packagePrice,
              original_price: originalPrice
            }));
          } catch (e) {
            console.warn('localStorage not available', e);
          }

          // Highlight selected card
          document.querySelectorAll('.package-card').forEach(card => card.classList.remove('selected'));
          this.closest('.package-card').classList.add('selected');

          // Prepare data for API
          const form = new FormData();
          form.append('action', 'select_package');
          form.append('dateId', selectedDateData.dateId);
          form.append('date', selectedDateData.date);
          form.append('price', selectedDateData.price);
          form.append('course', selectedDateData.course);
          form.append('quantity', selectedDateData.quantity);
          form.append('packageId', selectedDateData.packageId);
          form.append('package', selectedDateData.package);
          form.append('package_price', selectedDateData.package_price);

          console.log('Submitting package selection:', {
            date: selectedDateData.date,
            price: selectedDateData.price,
            course: selectedDateData.course,
            quantity: selectedDateData.quantity,
            // package: packageName,
            // packagePrice,
          });

          try {
            const res = await fetch(window.location.href, {
              method: 'POST',
              body: form,
              credentials: 'same-origin'
            });
            const json = await res.json();

            if (json && json.status === 'ok') {
              window.location.href = 'cart';
            } else {
              alert('Could not save package. Try again.');
            }
          } catch (err) {
            console.error(err);
            alert('Network error. Try again.');
          }
        } 
          });

      });

    });
  </script>

  <!-- Include foot.php -->
  <?php include "includes/foot.php" ?>
</body>

</html>