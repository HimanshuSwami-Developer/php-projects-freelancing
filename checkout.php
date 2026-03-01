<?php
session_start();
include("admin/assets/config/db.php");
// if (!isset($_SESSION['Name'])) {
//   header("Location: index"); // or your form page
//   exit();
// }


// Session data
$name = $_SESSION['Name'] ?? 'N/A';
$email = $_SESSION['Email'] ?? 'N/A';
$phone = $_SESSION['Phone'] ?? 'N/A';
$price = $_SESSION['Course_Price'] ?? 'N/A';
$course_name = $_SESSION['course_name'] ?? 'N/A';
$address = $_SESSION['Address'] ?? 'N/A';
$city = $_SESSION['City'] ?? 'N/A';
$zip = $_SESSION['Zip'] ?? 'N/A';


// PayPal redirect data (GET)
$currency = 'GBP';
// If you used custom_id during order creation
$package_name = 'N/A';
$course_date = 'N/A';
$course_name = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>G Security and Training | Checkout</title>
  <?php include "includes/head.php" ?>
</head>

<body class="bg-white">
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <div>
    <?php include "includes/header.php" ?>

    <!-- body -->

    <div class="max-w-6xl mx-auto px-4 py-10">
      <h1 class="text-3xl font-bold mb-8 text-center">Checkout</h1>
      <form class="space-y-4" id="paypalForm">
        <div class="grid md:grid-cols-2 gap-8">

          <!-- Billing Details -->
          <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Billing Details</h2>

            <div>
              <label class="block mb-1 font-medium">Full Name</label>
              <input type="text" name="full_name" class="w-full border px-4 py-2 rounded-md" placeholder="Enter Name"
                required />
            </div>

            <div>
              <label class="block mb-1 font-medium">Email</label>
              <input type="email" name="email" class="w-full border px-4 py-2 rounded-md" placeholder="Enter Email"
                required />
            </div>

            <div>
              <label class="block mb-1 font-medium">Phone</label>
              <input type="tel" name="phone" class="w-full border px-4 py-2 rounded-md" placeholder="Phone Number"
                required />
            </div>

            <div>
              <label class="block mb-1 font-medium">Address</label>
              <input type="text" name="address" class="w-full border px-4 py-2 rounded-md" placeholder="Enter Address"
                required />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block mb-1 font-medium">City</label>
                <input type="text" name="city" class="w-full border px-4 py-2 rounded-md" placeholder="Enter City"
                  required />
              </div>

              <div>
                <label class="block mb-1 font-medium">ZIP</label>
                <input type="text" name="zipcode" class="w-full border px-4 py-2 rounded-md" placeholder="Enter Zipcode"
                  required />
              </div>
            </div>

          </div>

          <!-- Order Summary -->
          <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Order Summary</h2>

            <div class="space-y-4">
              <div class="flex justify-between">
                <div>
                  <h3 id="course" class="font-[500]"></h3>
                  <h4 id="cdate" class="text-[13px]"></h4>
                </div>
                <span class="font-[500]" id="subtotal"></span>
              </div>


              <div class="border-t pt-4 flex justify-between font-semibold">
                <span>Total</span>
                <span id="total"></span>
              </div>
            </div>


            <button type="submit" class="mt-6 w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700">
              Place Order
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
  </div>

  <!-- Toggle Script -->
  <?php include "includes/foot.php" ?>
  <script
    src="https://www.paypal.com/sdk/js?client-id=BAA9jvA10CUbiuRE8FwduWofXpTHgTD-7lTYT-7E5BiHZxsJE49pezoyBFg4fBxCwbeceoHzlLtN0wljxg"></script>


  <script>
              function convertDateFormat(input) {
        
          if (!input) return "";
        
          const dayMap = {
            Mon: "Monday",
            Tue: "Tuesday",
            Wed: "Wednesday",
            Thu: "Thursday",
            Fri: "Friday",
            Sat: "Saturday",
            Sun: "Sunday"
          };
        
          let [start, end] = input.split(" - ");
        
          function formatPart(part) {
            let match = part.match(/(\d+\w+)\s(\w+),\s(\w+)/);
            if (!match) return part;
        
            let date = match[1];       // 2nd
            let shortDay = match[2];   // Mon
            let month = match[3];      // Mar
        
            return `${date} ${month}, ${dayMap[shortDay] || shortDay}`;
          }
        
          return formatPart(start) + " - " + formatPart(end);
        }



    document.addEventListener('DOMContentLoaded', function () {
      const cartPackage = JSON.parse(localStorage.getItem('cartPackage') || '{}');

      if (cartPackage && Object.keys(cartPackage).length > 0) {
        const packagePrice = parseFloat(cartPackage.package_price) || 0;
        const subtotal = packagePrice;

        const subtotalEl = document.getElementById("subtotal");
        const planPriceEl = document.getElementById("plan_price");
        const cdateEl = document.getElementById("cdate");
        const totalEl = document.getElementById("total");
        const course = document.getElementById("course");
       
        
        if (course) course.textContent = cartPackage.course || '';
        if (subtotalEl) subtotalEl.textContent = `£${subtotal.toFixed(2)}`;
        if (planPriceEl) planPriceEl.textContent = `£${packagePrice.toFixed(2)}`;
        if (cdateEl) cdateEl.textContent = convertDateFormat(cartPackage.date);
        if (totalEl) totalEl.textContent = `£${subtotal.toFixed(2)}`;
      } else {
        console.warn('No cartPackage found in localStorage.');
      }
    })
  </script>

  <script>
    document.getElementById('paypalForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);
      const data = {};

      formData.forEach((value, key) => { data[key] = value; });

      data.course = "<?php echo $course_name; ?>";

      let rawTotal = document.getElementById("total").textContent.trim();
      let numericAmount = rawTotal.replace(/[^\d.]/g, '');

      if (!numericAmount || isNaN(numericAmount)) {
        alert("Invalid total amount.");
        return;
      }

      const cartPackage = JSON.parse(localStorage.getItem('cartPackage') || '{}');
      data.amount = parseFloat(numericAmount).toFixed(2);
      data.packageName = cartPackage.package || '';
      data.date = cartPackage.date || '';
      data.course_id = parseInt(localStorage.getItem('course_id')) || 0;
      data.course_date_id = parseInt(cartPackage.dateId) || 0;
      data.subscription_plan_id = parseInt(cartPackage.packageId) || 0;
      data.payment_status = 'pending';


      console.log('Checkout Data:', data);

      try {
        const response = await fetch('create_order', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.approval_url) {
          window.location.href = result.approval_url;
        } else {
          alert('Error creating PayPal order.');
        }

      } catch (err) {
        console.error('Payment Error:', err);
        alert('An error occurred during checkout.');
      }
    });
  </script>

</body>

</html>