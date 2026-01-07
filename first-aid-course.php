<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['Name'] = $_POST['Name'];
    $_SESSION['Email'] = $_POST['Email'];
    $_SESSION['Phone'] = $_POST['Phone'];
    $_SESSION['Course_Price'] = $_POST['course_p'];
    $_SESSION['course_name'] = $_POST['course_name'];
    $_SESSION['course_id'] = $_POST['course_id'];
    header("Location: date-select");
    exit();
}
?>

<?php
include('admin/assets/config/db.php');
$request_uri = $_SERVER['REQUEST_URI'];  
$path_parts = explode('/', trim($request_uri, '/'));  
$endpoint = end($path_parts);  

$query = "SELECT * FROM courses WHERE info_link = ? ORDER BY created_at DESC LIMIT 1";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $endpoint);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$course = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>First Aid Training Courses Leeds | Mandatory SIA Requirement</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training/" />
    <meta name="description" content="Book HSE-compliant Emergency First Aid training in Leeds. Mandatory for SIA Door Supervision and Top-Up licenses. 1-day certification starting from £99.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
        .tab-content { display: none; animation: fadeIn 0.4s ease-in-out; padding: 2rem; color: #000; border: 1px solid #00C1EC; border-top: none; border-radius: 0 0 6px 6px; }
        .tab-content.current { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .security-course-tabs { display: flex; list-style: none; padding: 0; margin-bottom: 0; border-bottom: 2px solid #00c1ec; }
        .security-course-tabs .tab-link { padding: 12px 20px; cursor: pointer; font-size: 18px; font-weight: 600; transition: all 0.3s; border-top-left-radius: 6px; border-top-right-radius: 6px; color: #000; margin-right: 4px; }
        .security-course-tabs .tab-link:hover { background-color: rgba(0, 193, 236, 0.1); }
        .security-course-tabs .tab-link.current { color: #fff; background-color: #00c1ec; }
        .content-title { font-size: 2rem; font-weight: 800; color: #1a1a1a; margin-bottom: 1rem; line-height: 1.2; }
        .content-subtitle-new { font-size: 1.25rem; font-weight: 700; color: #00C1EC; margin-top: 1.5rem; margin-bottom: 0.5rem; display: block; }
        .feature-paragraph { font-size: 1rem; margin-top: 1.2rem; display: flex; align-items: flex-start; gap: 12px; }
        .feature-icon { font-size: 1.4rem; color: #00C1EC; flex-shrink: 0; }
        .content-list { list-style: none; padding-left: 0; margin-top: 1rem; }
        .content-list li { position: relative; padding-left: 25px; margin-bottom: 8px; }
        .content-list li::before { content: "✓"; position: absolute; left: 0; color: #00C1EC; font-weight: bold; }
    </style>
    
    <?php include "includes/head.php" ?>
</head>

<body class="bg-[#f8f8f8]">
    <?php include "includes/header.php" ?>

    <div class="bg-[#f8f8f8] py-10 min-h-screen">
        <div class="container mx-auto p-4 sm:p-6 max-w-[1280px]">
            <div class="space-y-4 max-w-4xl">
                <h1 class="text-4xl sm:text-5xl font-black text-black leading-tight">
                    Emergency <span class="text-accent-blue">First Aid Training</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-800 leading-relaxed">
                    First Aid training is a <b>mandatory requirement</b> for obtaining or renewing your SIA licence. Whether you are starting fresh or topping up your qualification, our HSE-compliant course equips you with life-saving skills.
                </p>
                <div class="flex flex-wrap gap-3">
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-md text-sm font-bold border border-red-200">Mandatory for SIA</span>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-sm font-bold border border-green-200">1-Day Certification</span>
                </div>
            </div>

            <div class="bg-white text-black p-6 sm:p-10 rounded-2xl shadow-xl mt-10 flex flex-col md:flex-row justify-between items-stretch border-t-8 border-[#00C1EC]">
                <div class="w-full md:w-[65%] space-y-6">
                    <h2 class="text-2xl font-black border-b border-gray-100 pb-4">Essential Information</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div>
                            <span class="text-gray-500 text-xs uppercase tracking-widest font-bold">Course Duration</span>
                            <p class="text-xl font-bold flex items-center mt-1">
                                <i class="fa fa-clock-o text-accent-blue mr-2"></i> 1 Full Day (8:30am - 5:00pm)
                            </p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-xs uppercase tracking-widest font-bold">Availability</span>
                            <p class="text-xl font-bold flex items-center mt-1">
                                <i class="fa fa-calendar text-accent-blue mr-2"></i> Every Monday
                            </p>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-gray-500 text-xs uppercase tracking-widest font-bold">Required For</span>
                            <p class="text-lg font-semibold mt-1 text-gray-800 italic">
                                Mandatory for Door Supervision, SIA Top-Up Refresher, CCTV, and Close Protection.
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-accent-blue">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-gray-600 font-bold uppercase text-xs">Starting from:</p>
                            <p class="text-gray-600 font-bold uppercase text-xs">Earning Potential:</p>
                        </div>
                        <div class="flex justify-between items-end">
                            <p class="text-5xl font-black text-green-600">£99<span class="text-lg font-normal text-gray-400 ml-1">Inc. VAT</span></p>
                            <p class="text-right text-2xl font-black text-gray-900">£3,000<span class="block text-xs font-normal text-gray-500">Average Monthly Salary</span></p>
                        </div>
                    </div>

                    <button id="book-now-btn" class="w-full bg-accent-blue hover:bg-[#009ACD] text-white py-5 rounded-xl font-black text-xl shadow-lg transition-all transform hover:-translate-y-1">
                        View Course Dates and Prices
                    </button>
                </div>

                <div class="hidden md:flex w-[30%] flex-col justify-center items-center bg-gray-50 rounded-xl p-4 ml-6">
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1760267999/2_cdhxwc.png" alt="First Aid Certificate" class="w-full h-auto drop-shadow-2xl">
                    <p class="mt-4 text-center text-sm font-bold text-gray-400">Nationally Recognised Certification</p>
                </div>
            </div>

            <div class="mt-16">
                <ul class="security-course-tabs overflow-x-auto">
                    <li class="tab-link current" data-tab="tab-1">Course Overview</li>
                    <li class="tab-link" data-tab="tab-2">What You'll Learn</li>
                    <li class="tab-link" data-tab="tab-3">SIA Requirements</li>
                </ul>

                <div id="tab-1" class="tab-content current bg-white">
                    <h2 class="content-title">Why First Aid Training is Non-Negotiable</h2>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        The SIA recently updated its regulations, making **Emergency First Aid at Work (EFAW)** a legal prerequisite for frontline staff. This ensures that every security professional is not just a deterrent for crime, but a capable first responder in medical crises.
                    </p>
                    <div class="grid md:grid-cols-2 gap-6 mt-8">
                        <div class="p-5 border border-gray-100 rounded-lg shadow-sm">
                            <b class="text-accent-blue block mb-2">Stand Out to Employers</b>
                            <p class="text-sm text-gray-600">First Aid is a highly valued skill. Companies prefer hiring candidates who are already certified as it reduces their onboarding costs.</p>
                        </div>
                        <div class="p-5 border border-gray-100 rounded-lg shadow-sm">
                            <b class="text-accent-blue block mb-2">Confidence in Emergencies</b>
                            <p class="text-sm text-gray-600">Gain the confidence to handle cardiac arrests, heavy bleeding, or choking until paramedics arrive on the scene.</p>
                        </div>
                    </div>
                </div>

                <div id="tab-2" class="tab-content bg-white">
                    <h2 class="content-title">1-Day Intensive Curriculum</h2>
                    <p class="mb-4 font-bold text-gray-700">This HSE-compliant course covers the following practical modules:</p>
                    <div class="grid md:grid-cols-2 gap-x-10">
                        <ul class="content-list text-gray-700">
                            <li>Role and responsibilities of a First Aider</li>
                            <li>Assessing an incident and calling for help</li>
                            <li>Managing an unresponsive casualty (Recovery Position)</li>
                            <li>CPR (Adult) and Use of AED (Defibrillators)</li>
                            <li>Management of Choking</li>
                        </ul>
                        <ul class="content-list text-gray-700">
                            <li>Control of external bleeding and shock</li>
                            <li>Managing minor injuries (burns, scalds, splinters)</li>
                            <li>Catastrophic bleeding management (Tourniquets)</li>
                            <li>Seizure management and fainting</li>
                            <li>Recording and Reporting accidents (RIDDOR)</li>
                        </ul>
                    </div>
                </div>

                <div id="tab-3" class="tab-content bg-white">
                    <h2 class="content-title">Frequently Asked Questions</h2>
                    <span class="content-subtitle-new">Do I need this for my Top-Up license?</span>
                    <p class="text-gray-700 mb-4">Yes. You cannot renew your Door Supervision or Security Guarding license without a valid First Aid certificate (minimum 12 months validity remaining).</p>
                    
                    <span class="content-subtitle-new">How long is the certificate valid for?</span>
                    <p class="text-gray-700 mb-4">The Emergency First Aid at Work (EFAW) certificate is valid for **3 years**.</p>

                    <span class="content-subtitle-new">Is the exam difficult?</span>
                    <p class="text-gray-700">The assessment is mostly practical (demonstrating CPR and bandaging) followed by a simple multiple-choice paper. Most students pass comfortably on the first try!</p>
                </div>
            </div>
        </div>

        <?php include "includes/footer.php" ?>
    </div>

    <div id="popup-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8); z-index:9998;"></div>

    <div id="popup-form" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:40px; border-radius:16px; width:90%; max-width:450px; z-index:9999; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); border-top: 8px solid #00C1EC;">
        <h3 class="text-2xl font-black text-center text-gray-900 mb-2">Secure Your Spot</h3>
        <p class="text-center text-gray-500 mb-8">Enter your details to view available dates for Leeds and Bradford.</p>

        <form method="post" class="space-y-4">
            <input type="text" name="Name" placeholder="Full Name" required class="w-full p-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-accent-blue outline-none">
            <input type="email" name="Email" placeholder="Email Address" required class="w-full p-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-accent-blue outline-none">
            <input type="tel" name="Phone" placeholder="Phone Number" maxlength="12" required class="w-full p-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-accent-blue outline-none">

            <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($course['title'] ?? 'First Aid Training'); ?>">
            <input type="hidden" name="course_p" value="<?php echo htmlspecialchars($course['sale_price'] ?? '99'); ?>">
            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id'] ?? '0'); ?>">
            
            <button type="submit" name="submit" class="w-full bg-accent-blue text-white py-4 rounded-lg font-black text-lg hover:bg-black transition-colors">
                Continue to Booking
            </button>
        </form>
    </div>

    <script>
        document.getElementById("book-now-btn").addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("popup-overlay").style.display = "block";
            document.getElementById("popup-form").style.display = "block";
        });

        document.getElementById("popup-overlay").addEventListener("click", function () {
            document.getElementById("popup-overlay").style.display = "none";
            document.getElementById("popup-form").style.display = "none";
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.security-course-tabs .tab-link');
            const contents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetTab = tab.getAttribute('data-tab');
                    tabs.forEach(t => t.classList.remove('current'));
                    contents.forEach(c => c.classList.remove('current'));
                    tab.classList.add('current');
                    document.getElementById(targetTab).classList.add('current');
                });
            });
        });
    </script>
</body>
</html>