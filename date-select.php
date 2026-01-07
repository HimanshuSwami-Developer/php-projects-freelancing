<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- PHP LOGIC PRESERVED FROM LIVE CODE ---

// Check if course data is set in the session. If not, redirect.
if (!isset($_SESSION['course_id'])) {
  header("Location: /courses");
  exit();
}

// Include database configuration
include 'admin/assets/config/db.php';

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// AJAX endpoint: save selected date/package to session
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

  // Save selection in session
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

// Session variables
$course_id = $_SESSION['course_id'];
// Checking for both lowercase and uppercase variants to ensure stability
$price = $_SESSION['course_price'] ?? $_SESSION['Course_Price'] ?? 0;
$course_name = $_SESSION['course_name'] ?? '';

// Fetch course details
$query = "SELECT * FROM courses where id='$course_id' LIMIT 1";
$query_run = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($query_run);

// Fetch course dates
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

// Fetch Training packages
$training_packages = [];
$packages_query = mysqli_query($con, "
    SELECT sp.* FROM subscription_plans sp 
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
    $headings_query = mysqli_query($con, "SELECT h.id AS heading_id, h.heading_text FROM plan_feature_headings h WHERE h.plan_id = $plan_id ORDER BY h.sort_order ASC");
    $headings = [];
    while ($heading = mysqli_fetch_assoc($headings_query)) {
        $heading_id = (int)$heading['heading_id'];
        $features_query = mysqli_query($con, "SELECT feature_text, is_included FROM plan_features WHERE heading_id = $heading_id ORDER BY sort_order ASC");
        $features = [];
        while ($feature = mysqli_fetch_assoc($features_query)) {
            $features[] = ['text' => $feature['feature_text'], 'is_included' => (bool)$feature['is_included']];
        }
        $headings[] = ['heading' => $heading['heading_text'], 'features' => $features];
    }
    $training_packages[$package['plan_key']] = [
        'id' => $plan_id,
        'name' => $package['name'],
        'subtitle' => $package['subtitle'],
        'original_price' => (float)$package['original_price'],
        'sale_price' => (float)$package['sale_price'],
        'payment_note' => $package['payment_note'],
        'feature_groups' => $headings,
        'is_most_popular' => ($package['plan_key'] === 'gold')
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>G Security and Training | Select Date</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { 'accent-blue': '#00C1EC', 'charcoal': '#181818' },
          boxShadow: { 'elevation': '0 20px 40px -15px rgba(0, 0, 0, 0.2)' }
        }
      }
    }
  </script>
  <style>.rotate-180 { transform: rotate(180deg); }</style>
  <?php include "includes/head.php" ?>
</head>

<body class="bg-white">
  <?php include "includes/header.php" ?>

  <div class="course-dates-container bg-[#f8f8f8] py-12 md:py-20 min-h-screen">
    <div class="lg:w-[1024px] lg:mx-auto mx-4 mt-12 mb-16 bg-white text-gray-900 rounded-xl shadow-elevation overflow-hidden course-section border-t-8 border-[#00C1EC]">
      
      <div class="p-6 md:p-8 pt-4 border-b border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end">
          <div>
            <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-1"><?= htmlspecialchars($row['title']) ?></h2>
            <p class="text-red-600 font-black text-base">Hurry Up! Few seats left</p>
          </div>
          <div class="text-right flex flex-col items-end">
            <span class="text-gray-500 text-xl mr-3 font-normal line-through">£<?= number_format($price + 50, 2) ?></span>
            <span class="text-[#00C1EC] text-5xl lg:text-6xl font-extrabold">£<?= number_format($price, 2) ?></span>
          </div>
        </div>
        <ul class="mt-8 text-gray-700 space-y-4">
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php if (!empty($row['point' . $i])): ?>
              <li class="flex items-start gap-4">
                <div class="text-gray-900 text-base font-medium"><?= htmlspecialchars($row['point' . $i]) ?></div>
              </li>
            <?php endif; ?>
          <?php endfor; ?>
        </ul>
      </div>

      <button class="toggle-dates-btn w-full text-white py-4 bg-[#00C1EC] font-bold text-lg hover:bg-gray-100 hover:text-[#00C1EC] transition duration-200 uppercase">
        View Course Dates ▼
      </button>

      <div class="course-dates hidden p-6 border-t border-gray-200 bg-gray-50">
        <h3 class="text-xl font-bold mb-4">Choose your course dates</h3>
        <?php if (!empty($course_dates)): ?>
          <?php foreach ($course_dates as $d): 
              $status = strtolower($d['status']);
              $isBookable = !in_array($status, ['full', 'cancelled', 'closed']);
              $start = new DateTime($d['start_date']);
              $end = new DateTime($d['end_date']);
              $formattedDate = ordinal((int)$start->format('j')) . ' ' . $start->format('D, M') . ' - ' . ordinal((int)$end->format('j')) . ' ' . $end->format('D, M');
          ?>
            <div class="mt-3 p-3 rounded border flex items-center justify-between <?= !$isBookable ? 'opacity-60 bg-gray-50' : '' ?>">
              <div>
                <div class="font-medium"><?= htmlspecialchars($formattedDate) ?></div>
                <div class="text-xs <?= $isBookable ? 'text-green-600' : 'text-red-500' ?>"><?= ucfirst($d['status']) ?></div>
              </div>
              <div class="flex items-center space-x-3">
                <div class="text-sm font-semibold">£<?= number_format($d['price'], 2) ?></div>
                <button class="select-date-btn bg-[#00C1EC] text-white px-4 py-2 rounded" 
                        data-dateid="<?= $d['id'] ?>" 
                        data-date="<?= $formattedDate ?>" 
                        data-course="<?= htmlspecialchars($row['title']) ?>" 
                        data-price="<?= $d['price'] ?>" 
                        <?= !$isBookable ? 'disabled' : '' ?>>
                  <span class="btn-text">Select</span>
                  <span class="btn-loading hidden">...</span>
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div id="packages-section" class="hidden my-5 max-w-[1024px] mx-auto my-10">
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-gray-900">Rely on 20+ years of Security Training expertise</h2>
    </div>
    
    <div class="hidden lg:grid grid-cols-1 lg:grid-cols-3 gap-4">
      <?php foreach ($training_packages as $key => $package): ?>
          <?php include 'package-card.php'; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <div id="packageConfirmPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-96 text-center shadow-lg">
      <h2 class="text-xl font-semibold mb-3 text-red-600">Important Notice</h2>
      <p class="mb-4">This plan doesn’t include <strong>First Aid training</strong>, which is mandatory for SIA licensing.</p>
      <div class="flex justify-center gap-4">
        <button id="popupYes" class="bg-yellow-500 text-white px-4 py-2 rounded">Switch to Gold</button>
        <button id="popupNo" class="bg-gray-300 px-4 py-2 rounded">Continue with Bronze</button>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php" ?>

  <script>
    let selectedDateData = null;

    document.addEventListener('DOMContentLoaded', function () {
      
      // Toggle Dates
      document.querySelector('.toggle-dates-btn').addEventListener('click', function() {
        const datesDiv = document.querySelector('.course-dates');
        datesDiv.classList.toggle('hidden');
        this.textContent = datesDiv.classList.contains('hidden') ? 'View Course Dates ▼' : 'Hide Course Dates ▲';
      });

      // Select Date Logic
      document.querySelectorAll('.select-date-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
          const date = this.dataset.date;
          const dateId = this.dataset.dateid;
          const price = this.dataset.price;
          const course = this.dataset.course;
          
          selectedDateData = { dateId, date, price, course, quantity: 1 };

          // CRITICAL FIX: Flexible matching for redirection
          const courseLower = course.toLowerCase();
          const needsPackages = courseLower.includes("door supervisor") || courseLower.includes("refresher");

          if (needsPackages) {
            // Show packages
            document.getElementById('packages-section').classList.remove('hidden');
            document.querySelector('.course-dates-container').classList.add('hidden');
            document.getElementById('packages-section').scrollIntoView({ behavior: 'smooth' });
          } else {
            // Direct to cart
            await saveToCart(selectedDateData);
          }
        });
      });

      // Package selection logic
      document.querySelectorAll('.select-package-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
          let pName = this.dataset.package;
          let pPrice = this.dataset.packagePrice;
          let pId = this.dataset.packageId;

          if (pName.toLowerCase() === 'bronze') {
            document.getElementById('packageConfirmPopup').classList.remove('hidden');
            const choice = await new Promise(res => {
              document.getElementById('popupYes').onclick = () => res('gold');
              document.getElementById('popupNo').onclick = () => res('bronze');
            });
            document.getElementById('packageConfirmPopup').classList.add('hidden');
            
            if (choice === 'gold') {
               // Logic to find Gold data or just redirect to cart with modified data
               pName = 'Gold'; pPrice = '349'; pId = '2'; // Update these based on actual gold IDs
            }
          }

          const finalData = { ...selectedDateData, package: pName, package_price: pPrice, packageId: pId };
          await saveToCart(finalData);
        });
      });

      async function saveToCart(data) {
        const form = new FormData();
        form.append('action', 'select_package');
        for (const key in data) form.append(key, data[key]);

        try {
          const res = await fetch(window.location.href, { method: 'POST', body: form });
          const json = await res.json();
          if (json.status === 'ok') window.location.href = 'cart';
        } catch (err) { alert('Connection error'); }
      }
    });
  </script>
</body>
</html>