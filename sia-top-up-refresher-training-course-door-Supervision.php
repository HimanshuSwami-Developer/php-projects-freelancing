<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PHP Logic strictly preserved from the live detail page for session handling
    $_SESSION['Name'] = $_POST['Name'];
    $_SESSION['Email'] = $_POST['Email'];
    $_SESSION['Phone'] = $_POST['Phone'];
    $_SESSION['Course_Price'] = $_POST['course_p'];
    $_SESSION['course_name'] = $_POST['course_name'];
    $_SESSION['course_id'] = $_POST['course_id'];

    // Redirect to select-option.php on successful form submission
    header("Location: date-select");
    exit();
} else {
    // echo "Invalid access.";
}
?>


<?php
include('admin/assets/config/db.php');

// Get the last part of the URL (like /deep)
$request_uri = $_SERVER['REQUEST_URI'];  
$path_parts = explode('/', trim($request_uri, '/'));  
$endpoint = end($path_parts);  // Example: "deep"

// Fetch only one matching course
$query = "SELECT * FROM courses WHERE info_link = ? ORDER BY created_at DESC LIMIT 1";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $endpoint);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$course = mysqli_fetch_assoc($result); // Get single row as associative array
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Canonical URL and Metadata preserved from the live code -->
    <title>SIA top-up refresher training course for Door Supervision in Leeds</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-supervision" />
    <meta name="description" content="Join our 3-day SIA top-up refresher training course for door supervision in Leeds with First Aid for £250, includes SIA security guard refresher training to help you.">
    
    <!-- Load required scripts and styles from the new code -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Custom Tailwind Configuration -->
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
    
    <!-- Custom CSS for New Design Elements (Tabs/Features) -->
    <style>
        /* Simple tab transition (copied from new code) */
        .tab-content {
          display: none;
          animation: fadeIn 0.4s ease-in-out;
          padding: 2rem;
          color: #000; /* Text is black on light background */
          border: 1px solid #00C1EC; 
          border-top: none;
          border-radius: 0 0 6px 6px;
        }
        .tab-content.current {
          display: block;
        }
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(10px); }
          to { opacity: 1; transform: translateY(0); }
        }

        /* --- Tabs Styling (copied from new code) --- */
        .security-course-tabs {
            display: flex;
            list-style: none;
            padding: 0;
            margin-bottom: 0; 
            border-bottom: 2px solid #00c1ec; 
        }

        .security-course-tabs .tab-link {
            padding: 12px 20px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            color: #000; 
            margin-right: 4px;
        }

        .security-course-tabs .tab-link:hover {
            color: #000;
            background-color: rgba(0, 193, 236, 0.1); 
        }

        .security-course-tabs .tab-link.current {
            color: #000; 
            background-color: #00c1ec; 
            border-bottom: 2px solid #00c1ec; 
        }
        
        /* Map old live code styles to new element structure */
        .course-details-item p {
            line-height: 1.5;
            margin-top: 0.5rem;
        }
        .course-details-item span.font-bold {
            color: #000;
        }
        
        /* Typography styles for tab content (based on new design intent) */
        .content-subtitle-new {
            font-size: 1.25rem; 
            font-weight: 700;
            color: #00C1EC; 
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        .content-text {
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Responsive design adjustments */
        @media (max-width: 640px) {
            .security-course-tabs {
                flex-direction: column;
            }
            .security-course-tabs .tab-link {
                margin-right: 0;
                margin-bottom: 4px;
                border-radius: 6px;
            }
            .tab-content {
                padding: 1rem;
            }
        }
    </style>
    
    <?php include "includes/head.php" ?>
</head>

<body class="bg-[#f8f8f8]">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <div>
        <?php include "includes/header.php" ?>

        <!-- BODY -->
        <div class="bg-[#f8f8f8] py-10 min-h-screen">

            <!-- Main Course Block (Adapted from New Code Design) -->
            <div class="container mx-auto p-4 sm:p-6 max-w-[1280px]">
                <div class="space-y-4 sm:space-y-6">
                    <!-- Title (Adapted from live code) -->
                    <h1 class="text-3xl sm:text-4xl font-bold text-black">
                        Level 2 Door Supervisor Refresher Course</span>
                    </h1>
                    <!-- Subheading (Adapted from live code) -->
                    <p class="text-black sm:text-lg">
                        The Level 2 Door Supervisor Refresher Training is compulsory training for door supervisors with expiring SIA
                        licencing. You will stay compliant with SIA standards and refresh your skillset to adapt to the
                        challenges faced in security today.
                    </p>
                    <p class="text-base sm:text-lg italic">
                        Renew your SIA Licence and elevate your career potential now
                    </p>
                </div>


                <div class="mt-6 md:mt-0 w-full">
                    <div
                        class="bg-white text-black p-6 sm:p-8 rounded-xl shadow-2xl space-y-4 sm:space-y-6 mt-10 flex flex-col md:flex-row justify-between items-start border-t-4 border-[#00C1EC]">

                        <!-- Left Column: Course Details -->
                        <div class="w-full md:w-[70%] order-2 md:order-1">

                            <h2 class="text-2xl sm:text-3xl font-extrabold text-black mb-4 border-b-2 border-gray-100 pb-2">
                                Level 2 Door Supervisor Refresher Course Details
                            </h2>

                            <div class="space-y-3 text-sm sm:text-base grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Course Name:</span>
                                    <span class="text-lg font-semibold text-[#00C1EC]">Level 2 Door Supervisor Refresher</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Duration:</span>
                                    <span class="text-lg font-semibold">3 Days Course (Including First Aid)</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Mandatory Requirement For:</span>
                                    <span class="text-lg font-semibold text-red-600">SIA Door Supervisor Licence Renewal</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Age Requirement:</span>
                                    <span class="text-lg font-semibold">18+ years</span>
                                </p>
                                
                                <p class="text-gray-700 col-span-1 sm:col-span-2">
                                    <span class="font-bold text-black block mb-0.5">Key Modules:</span>
                                    <span class="text-lg font-semibold">Terror Threat Awareness, Vulnerability Awareness, Enhanced Physical Intervention Skills</span>
                                </p>
                            </div>

                            <div
                                class="mt-6 pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center">

                                <div class="mb-4 sm:mb-0">
                                    <p class="text-gray-700 text-sm">Course Fee From:</p>
                                    <p class="text-4xl font-extrabold text-green-600">
                                        £250 <span class="text-xl font-normal text-gray-500">Incl. VAT</span>
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-gray-700 text-sm">Estimated Earning Potential:</p>
                                    <p class="text-2xl font-bold text-black">
                                        Up to <span class="text-[#00C1EC] text-3xl font-extrabold">£3k</span> a month
                                    </p>
                                </div>
                            </div>

                            <!-- Book Now Button (Uses preserved ID 'book-now-btn') -->
                            <div class="mt-8 w-full">
                                <button id="book-now-btn"
                                    style="background-color:#00C1EC; color:white; padding:15px 50px; font-size:18px; font-weight:bold; border:none; border-radius:8px; cursor:pointer; width:100%; transition: background-color 0.3s ease, transform 0.1s ease; box-shadow: 0 4px 6px rgba(0, 193, 236, 0.4);"
                                    onmouseover="this.style.backgroundColor='#009ACD';"
                                    onmouseout="this.style.backgroundColor='#00C1EC';"
                                    onmousedown="this.style.transform='translateY(1px)';">
                                    View Course Dates and Prices
                                </button>
                            </div>

                        </div>

                        <!-- Right Column: Image/Icon -->
                        <div class="w-full md:w-[25%] flex justify-center items-center order-1 md:order-2 mb-6 md:mb-0">
                            <!-- Placeholder image adapted from new code style -->
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1754595801/portrait-male-security-guard-with-radio-station-camera-screens_gfkzvh.webp"
                                alt="Security Training Icon"
                                style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                                onmouseover="this.style.transform='scale(1.03)';"
                                onmouseout="this.style.transform='scale(1.0)';">
                        </div>
                    </div>

                    <!-- Pop-up Overlay (Preserved IDs) -->
                    <div id="popup-overlay"
                        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); z-index:9998;">
                    </div>

                    <!-- Pop-up Form (Preserved IDs and Inputs) -->
                    <div id="popup-form"
                        style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:30px; border-radius:12px; width:90%; max-width:450px; z-index:9999; box-shadow:0 15px 30px rgba(0,0,0,0.3); border-top: 5px solid #00C1EC;">
                        <h3 style="margin-top:0; text-align:center; color:#333;" class="text-xl font-bold mb-4">
                            Enter your details to Buy Now!
                        </h3>
                        <p style="text-align:center; color:gray; margin-bottom: 20px;">Secure your spot and proceed to select a date.</p>

                        <form method="post" onsubmit="saveCourseToLocalStorage()">
                            <!-- Input styling adapted from new code pop-up while preserving inline style structure -->
                            <input type="text" name="Name" placeholder="Your Name" required
                                style="width:100%; padding:12px; margin-bottom:15px; border-radius:6px; border:1px solid #ddd; font-size:16px;">

                            <input type="email" name="Email" placeholder="Your Email" required
                                style="width:100%; padding:12px; margin-bottom:15px; border-radius:6px; border:1px solid #ddd; font-size:16px;">

                            <input type="tel" name="Phone" placeholder="Phone Number" maxlength="12" required
                                style="width:100%; padding:12px; margin-bottom:20px; border-radius:6px; border:1px solid #ddd; font-size:16px;">

                            <!-- Hidden Inputs Preserved from Live Code -->
                            <input type="hidden" name="course_name" value="<?php echo htmlspecialchars($course['title']); ?>">
                                <input type="hidden" name="course_p" value="<?php echo htmlspecialchars($course['sale_price']); ?>">
                                 <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                <button type="submit" name="submit"
                                    style="background-color:#00C1EC; color:white; padding:10px; width:100%; border:none; border-radius:4px; cursor:pointer;">Submit
                                    & Continue</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 3-Step Feature Block (Copied from New Code) -->
            <div class="mt-5 max-w-[1280px] mx-auto px-4 sm:px-6">
                <section class="mx-auto py-12">
                    <div class="mb-12">
                        <p class="uppercase text-[#00C1EC] font-medium tracking-wider">How it works</p>
                        <h2 class="text-3xl md:text-4xl font-bold mt-2 text-black">3 simple steps to Renew your Security Career
                        </h2>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">

                        <!-- Step 1 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 1</span>

                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 20 20">
                                        <path fill="#00C1EC" fill-rule="evenodd"
                                            d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Refreshed</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Enroll in the Level 2 Door Supervisor Refresher Training to update your knowledge on new threats,
                                vulnerability awareness, and enhanced physical intervention skills.
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 2</span>

                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 20 20">
                                        <path fill="#00C1EC" fill-rule="evenodd"
                                            d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Certified</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Pass the written and practical assessments (including emergency first aid) to gain your
                                certificate, proving your compliance with the latest SIA standards.
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 3</span>

                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 20 20">
                                        <path fill="#00C1EC" fill-rule="evenodd"
                                            d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045" />
                                    </svg>
                                </span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Renewed</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Submit your new certificate to the SIA to successfully renew your Door Supervisor
                                Licence and continue working legally in the private security industry.
                            </p>
                        </div>

                    </div>
                </section>
            </div>

            <!-- Course Overview Text (Mapped from live code) -->
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 py-10">
                <h3 class="content-subtitle-new">Renew Your Licence with Confidence</h3>
                <p class="content-text text-black">In 3 days (this includes emergency first aid training), you will complete your Level 2 Door Supervisor Refresher Training and develop new knowledge in terror threat awareness, vulnerability awareness (including spiking prevention), and enhanced physical intervention skills. This course is crucial for anyone working in the private security industry, including anyone needing to complete SIA Security Refresher Training or SIA Security Guard Refresher Training for a new licence.</p>

                <h3 class="content-subtitle-new">First Aid Included</h3>
                <p class="content-text text-black">Your package will include Emergency First Aid (the qualification you need to attend the Top-Up course), which you will do on day 1. Then you will complete the two-day refresher training. All of this for £249. </p>

                <h3 class="content-subtitle-new">Why Is This Course Important?</h3>
                <p class="content-text text-black">Even if you have many years of experience, you cannot renew your Door Supervisor licence without completing the Level 2 Door Supervisor refresher training. In order to be in alignment with the latest standards of safety, legal, and security, you need to refresh your skills. </p>

                <h3 class="text-2xl font-bold mt-6 text-[#00C1EC]">Free Bonus</h3>
                <p class="content-text text-black mt-2">Book now and receive emergency first aid training within your door supervisor top-up package, as it is completed by all delegates at the course, and as it is an SIA requirement for you to undertake this training in advance of attending the course.</p>
            </div>

            <!-- Tabbed Content Section (Adapted from New Code) -->
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 pb-10">
                <ul class="security-course-tabs">
                    <li class="tab-link current" data-tab="tab-1">Course Details</li>
                    <li class="tab-link" data-tab="tab-2">Course Content</li>
                    <li class="tab-link" data-tab="tab-3">FAQs</li>
                </ul>

                <!-- TAB 1: Course Details (Mapped from live code) -->
                <div id="tab-1" class="tab-content current bg-white">
                    <div class="grid md:grid-cols-2 gap-x-12 gap-y-6">
                        <div class="course-details-item">
                            <p class="text-[#00C1EC]"><span class="font-bold text-black">Course Name:</span> Level 2 Door Supervisor Refresher</p>
                        </div>
                        <div class="course-details-item">
                            <p><span class="font-bold">Price:</span> Door Supervisor £249 (with First Aid)<br>Security Officer from £99.99</p>
                        </div>
                        <div class="course-details-item">
                            <p><span class="font-bold">Duration:</span>Door Supervisor: 3 Days (with Emergency First Aid + Level 2 Door Supervisor Refresher Training)<br>
                            Security Officer: 1 Day (SIA Security Guard Refresher Training, First Aid optional)</p>
                        </div>
                        <div class="course-details-item">
                            <p><span class="font-bold">Delivery Mode: </span>Classroom only (not available online)<br>
                            Available at a number of UK training centres</p>
                        </div>
                        <div class="course-details-item">
                            <p><span class="font-bold">Mandatory Requirement For:</span> SIA Door Supervisor Licence</p>
                        </div>
                        <div class="course-details-item">
                            <p><span class="font-bold">Age Requirement:</span> 18+ years</p>
                        </div>
                        <div class="course-details-item md:col-span-2">
                            <p><span class="font-bold">Changes to Modules include: </span><br>
                                <strong>Terror Threat Awareness -</strong> How to identify and respond to new threats <br>
                                <strong>Vulnerability Awareness -</strong> Safeguarding vulnerable adults and how to reduce risks, including spiking <br>
                                <strong>Enhanced Physical Intervention Skills -</strong> Using the correct methods to avoid potential incidents while engaging in conflict management <br>
                                <strong>Search Skills -</strong> How to undertake searches lawfully and professionally <br>
                                <strong>Public Protection Measures -</strong> Keeping the elements under control to undertake duties safely</p>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Course Content (Mapped from live code) -->
                <div id="tab-2" class="tab-content bg-white">
                    <p class="content-text text-black">The Level 2 Door Supervisor Refresher Training is made up of two units:</p>

                    <span class="content-subtitle-new">Unit 1: Principles of Working as a Door Supervisor in the Private Security Industry (Refresher):</span>
                    <ul class="list-disc pl-8 content-text text-black">
                        <li>Awareness of Terror Threats.</li>
                        <li>Awareness of Vulnerability & Safeguarding.</li>
                        <li>Awareness of Search Procedures and Safety Protocols.</li>
                        <li>Professional Values & Conduct and Communication.</li>
                    </ul>

                    <span class="content-subtitle-new">Unit 2: Application of Physical Intervention (Refresher):</span>
                    <ul class="list-disc pl-8 content-text text-black">
                        <li>Physical Intervention Techniques and Skills.</li>
                        <li>Safe Escorting and Removal Techniques.</li>
                        <li>The Law and Physical Intervention.</li>
                        <li>Risk Assessment and Incident Reporting.</li>
                    </ul>

                    <p class="content-text text-black mt-4">This same structure applies to the SIA Security Refresher Training and SIA Security Guard and Door Supervisors Refresher Training, but the content will be tailored to their particular role.</p>

                    <h3 class="content-subtitle-new">Assessment methods:</h3>
                    <ul class="list-disc pl-8 content-text text-black">
                        <li>Multiple Choice Testing.</li>
                        <li>Practical demonstrations of physical intervention.</li>
                    </ul>
                </div>

                <!-- TAB 3: FAQs (Mapped from live code) -->
                <div id="tab-3" class="tab-content bg-white">
                    <h3 class="content-subtitle-new">What is the Level 2 Door Supervisor Refresher course?</h3>
                    <p class="content-text text-black">The Level 2 Door Supervisor Refresher Training is a revised training course for door supervisor and security officer licence holders, comprised of the following new modules: Terror Threat Awareness, Vulnerability Awareness, and Enhanced Physical Intervention Skills, which focuses on current industry and legal requirements.</p>

                    <h3 class="content-subtitle-new">How do I refresh my SIA license?</h3>
                    <p class="content-text text-black">You refresh your licence by successfully completing the Level 2 Door Supervisor Refresher Training in your category or the SIA Security Guard Refresher Training as a security officer. Once you have received your certificate, you can apply to the SIA for license renewal.</p>

                    <h3 class="content-subtitle-new">Do I have to do Level 2 Door Supervisor Refresher training every 3 years?</h3>
                    <p class="content-text text-black">Yes. SIA requires licence holders to complete Level 2 Door Supervisor Refresher Training or SIA Security Refresher Training every time they renew their licence, which usually occurs every three years.</p>

                    <h3 class="content-subtitle-new">Can I do my Level 2 Door Supervisor Refresher training online?</h3>
                    <p class="content-text text-black">No. The Level 2 Door Supervisor Refresher Training has practical physical intervention assessments in it that cannot be completed online; they require you to demonstrate your physical ability in person.</p>

                    <h3 class="content-subtitle-new">How do you do a refresher course?</h3>
                    <p class="content-text text-black">To complete a refresher course, you can book an approved Level 2 Door Supervisor Refresher Training or SIA Security Guard Refresher Training with a licensed training provider. Attend the face-to-face training (3 days if including first aid), pass the written and practical assessments, and submit your renewal application to the SIA.</p>
                </div>
            </div>
            
            <!-- Original Footer Include -->
            <?php include "includes/footer.php" ?>

        </div>

    </div>

    <!-- Pop-up Script (Preserved logic from live code, simplified styling removal) -->
    <script>

function saveCourseToLocalStorage() {
    const courseName = document.querySelector('input[name="course_name"]').value;
    const coursePrice = document.querySelector('input[name="course_p"]').value;
    const courseId = document.querySelector('input[name="course_id"]').value;

    localStorage.setItem('course_id', courseId);
    localStorage.setItem('course_name', courseName);
    localStorage.setItem('course_price', coursePrice);
}


        // Show popup on button click
        document.getElementById("book-now-btn").addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("popup-overlay").style.display = "block";
            document.getElementById("popup-form").style.display = "block";
        });

        // Close popup if user clicks outside
        document.getElementById("popup-overlay").addEventListener("click", function () {
            document.getElementById("popup-overlay").style.display = "none";
            document.getElementById("popup-form").style.display = "none";
        });
        
        // Tab Functionality Script (Copied from new code)
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.security-course-tabs .tab-link');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetTab = tab.getAttribute('data-tab');

                    // Remove 'current' class from all tabs and content
                    tabs.forEach(t => t.classList.remove('current'));
                    contents.forEach(c => c.classList.remove('current'));

                    // Add 'current' class to the clicked tab and its content
                    tab.classList.add('current');
                    document.getElementById(targetTab).classList.add('current');
                });
            });
        });

    </script>

    <!-- Toggle Script -->
    <?php include "includes/foot.php" ?>
</body>

</html>
