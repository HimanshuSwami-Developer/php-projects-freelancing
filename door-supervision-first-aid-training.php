<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PHP Logic strictly preserved from the live detail page for session handling
    $_SESSION['Name'] = $_POST['Name'];
    $_SESSION['Email'] = $_POST['Email'];
    $_SESSION['Phone'] = $_POST['Phone'];
    $_SESSION['course_price'] = $_POST['course_p'];
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
    <title>First Aid Training Courses Leeds |Door Supervision Training</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training/" />
    <meta name="description" content="Book HSE-compliant first aid training courses in Leeds. Ideal for workplaces, schools and security staff. Certification included for door supervision training.">
    
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
        .content-title {
            font-size: 2.25rem; /* text-[36px] equivalent */
            font-weight: 700; /* font-[600] equivalent */
            color: #00c1ec;
            margin-bottom: 1rem;
        }
        .content-subtitle {
            font-size: 1.25rem; /* text-[20px] equivalent */
            font-weight: 700;
            color: #000;
            margin-top: 1rem;
        }
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
        .feature-paragraph {
            font-size: 1rem; 
            margin-top: 1rem;
            display: flex;
            align-items: flex-start;
        }
        .feature-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            line-height: 1; /* Aligns icon vertically */
            color: #00C1EC;
        }
        .content-list {
            list-style: disc;
            padding-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
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
                        FAST TRACK YOUR SECURITY CAREER WITH<br>
                        <span class="text-[#00C1EC]">Level 2 Door Supervisor</span>
                    </h1>
                    <!-- Subheading (Adapted from live code) -->
                    <p class="text-black sm:text-lg">
                        Gain your <strong>SIA License</strong> and earn up to <strong>£3,000/month</strong> in security
                        roles across retail, corporate and hospitality.
                    </p>
                    <p class="text-base sm:text-lg italic">
                        Secure your <strong>SIA License</strong> and elevate your career potential now
                    </p>
                </div>


                <div class="mt-6 md:mt-0 w-full">
                    <div
                        class="bg-white text-black p-6 sm:p-8 rounded-xl shadow-2xl space-y-4 sm:space-y-6 mt-10 flex flex-col md:flex-row justify-between items-start border-t-4 border-[#00C1EC]">

                        <!-- Left Column: Course Details -->
                        <div class="w-full md:w-[70%] order-2 md:order-1">

                            <h2 class="text-2xl sm:text-3xl font-extrabold text-black mb-4 border-b-2 border-gray-100 pb-2">
                               Level 2 Door Supervision Course Details
                            </h2>

                            <!-- Course Info Grid (Mapped from live code content) -->
                            <div class="space-y-3 text-sm sm:text-base grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Course Name:</span>
                                    <span class="text-lg font-semibold text-[#00C1EC]">Level 2 Door Supervisor</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Duration:</span>
                                    <span class="text-lg font-semibold">7 Days</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Mandatory Requirement For:</span>
                                    <span class="text-lg font-semibold text-red-600">SIA Door Supervisor Licence</span>
                                </p>
                                
                                <p class="text-gray-700">
                                    <span class="font-bold text-black block mb-0.5">Age Requirement:</span>
                                    <span class="text-lg font-semibold">18+ years</span>
                                </p>
                                
                                <p class="text-gray-700 col-span-1 sm:col-span-2">
                                    <span class="font-bold text-black block mb-0.5">Included:</span>
                                    <span class="text-lg font-semibold">Full DLevel 2 oor Supervision Qualification + Emergency First Aid Training</span>
                                </p>
                            </div>

                            <div
                                class="mt-6 pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center">

                                <div class="mb-4 sm:mb-0">
                                    <p class="text-gray-700 text-sm">Course Fee From:</p>
                                     <p class="text-4xl font-extrabold text-green-600">
                                        £<?= isset($course['sale_price']) ? number_format((float)$course['sale_price'], 2) : '0.00' ?>
                                        <span class="text-xl font-normal text-gray-500">Incl. VAT</span>
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
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438610/Frame-2-1_fp6rjf.webp"
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

                            <!-- Hidden Inputs Preserved from Live Code (CRITICAL INTEGRATION) -->
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
                        <h2 class="text-3xl md:text-4xl font-bold mt-2 text-black">3 simple steps to start your Security Career
                        </h2>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">

                        <!-- Step 1 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 1</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#00C1EC" fill-rule="evenodd" d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045"/></svg></span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Licensed</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Begin your journey by enrolling in an accredited training program. Learn essential
                                security skills and obtain the required licence to start your professional path.
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 2</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill="#00C1EC" fill-rule="evenodd" d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045"/></svg></span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Security</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Once licensed, gain hands-on experience with real-world security training. Strengthen
                                your knowledge of surveillance, access control, and customer safety procedures.
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-white border border-[#eee] rounded-xl py-5 px-6 shadow-lg">
                            <div class="flex items-center mb-4 justify-between">
                                <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">Step 3</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="#00C1EC" fill-rule="evenodd" d="m2.542 2.154l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.448-.475 0-.98l7.08-6.918l-6.754-6.763q-.356-.514.066-.935q.422-.42.951-.045m9 0l7.254 7.26q.204.21.204.483a.73.73 0 0 1-.204.5l-7.575 7.398q-.575.476-1.022 0q-.449-.475 0-.98l7.08-6.918l-6.754-6.763q-.355-.514.066-.935q.422-.42.951-.045"/></svg></span>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Get Employed</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Start your career in the security industry with high-demand roles. Work as a door
                                supervisor, security officer, or CCTV operator and build a stable, rewarding future.
                            </p>
                        </div>
                    </div>
                </section>
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
                    <h2 class="content-title">SIA Door Supervisor and Free First Aid Training Course</h2>
                    <h3 class="content-subtitle">The SIA Door Supervisor and Free First Aid Training Course is designed for individuals who want to work legally as a Door Supervisor or Security Guard in the UK.</h3>

                    <!-- Content block 1 -->
                    <p class="feature-paragraph">
                        <span class="feature-icon">⚡</span>
                        <span>
                            <b class="text-[#00c1ec]">High Demand, Great Opportunities!</b>
                            With a significant shortage of security professionals in the industry, now is the ideal time to obtain your SIA Licence and enter the security sector. This 7-day course equips you with the essential knowledge and skills needed to pass your exam and apply for your SIA Licence.
                        </span>
                    </p>

                    <!-- Content block 2 -->
                    <p class="feature-paragraph">
                        <span class="feature-icon">✅</span>
                        <span>
                            <b class="text-[#00c1ec]">Free First Aid Training Included</b>
                            As part of the course, you’ll also receive complimentary First Aid training, enhancing your skill set and employability.
                        </span>
                    </p>

                    <!-- Content block 3 -->
                    <p class="feature-paragraph">
                        <span class="feature-icon">💰</span>
                        <span>
                            <b class="text-[#00c1ec]">Lucrative Career Prospects</b>
                            With your SIA Licence, you can earn up to £3,000/month by securing roles in various sectors such as:
                        </span>
                    </p>

                    <ul class="content-list text-black">
                        <li>Door Supervisor for nightclubs, bars, and restaurants</li>
                        <li>Event Security</li>
                        <li>Corporate Security Officer</li>
                        <li>Retail Security</li>
                        <li>Loss Prevention Officer And more!</li>
                    </ul>

                    <!-- Content block 4 -->
                    <h3 class="content-subtitle">Door Supervisor Licence vs Security Guard Licence</h3>
                    <p class="content-text text-black">Many people wonder about the difference between these two licences. Here’s a simple explanation:</p>

                    <ul class="content-list text-black">
                        <li>A Door Supervisor Licence qualifies you to work as both a <b>Door Supervisor</b> and a <b>Security Guard</b>.</li>
                        <li>A Security Guard Licence restricts you to Manned Guarding roles only.</li>
                        <li>Since a Door Supervisor Licence offers <b>more flexibility and wider career opportunities</b>, most employers prefer candidates with this qualification.</li>
                    </ul>
                    <p class="content-text text-black">Take the next step toward a rewarding career in the security industry today!</p>
                </div>

                <!-- TAB 2: Course Content (Mapped from live code) -->
                <div id="tab-2" class="tab-content bg-white">
                    <h2 class="content-subtitle">The 7-day SIA Door Supervisor and Free First Aid Training Course is structured into four comprehensive units, covering everything from legal regulations to advanced physical intervention techniques.</h2>

                    <div>
                        <span class="content-subtitle-new">Unit 1: Working in the Private Security Industry</span>
                        <p class="content-text text-black">This unit focuses on understanding the legal framework and operational requirements for private security roles. Key topics include:</p>
                        <ul class="content-list text-black">
                            <li> Legal Aspects of the Private Security Industry</li>
                            <li> Health and Safety Regulations for Security Operatives</li>
                            <li>Fire Safety Awareness and Emergency Procedures</li>
                            <li>Effective Communication and Customer Care</li>
                        </ul>
                    </div>

                    <div>
                        <span class="content-subtitle-new">Unit 2: Working as a Door Supervisor</span>
                        <p class="content-text text-black">Gain insights into the responsibilities and challenges of working as a Door Supervisor, including:</p>
                        <ul class="content-list text-black">
                            <li>Professional Standards and Behavioral Expectations</li>
                            <li>Civil and Criminal Law in Security Contexts</li>
                            <li> Effective Search Procedures</li>
                            <li>Arrest Protocols and Legal Boundaries</li>
                            <li>Drug Awareness and Handling Procedures</li>
                            <li>Recording Incidents and Preserving Crime Scenes</li>
                            <li>Licensing Law Compliance</li>
                            <li>Emergency Procedures and Crowd Management</li>
                        </ul>
                    </div>

                    <div>
                        <span class="content-subtitle-new">Unit 3: Conflict Management for the Private Security Industry</span>
                        <p class="content-text text-black">This unit prepares you to manage and resolve conflicts effectively, with topics such as:</p>
                        <ul class="content-list text-black">
                            <li>Identifying and Minimizing Risks</li>
                            <li>Defusing Tense Situations</li>
                            <li>Conflict Resolution and Post-Conflict Analysis</li>
                            <li>Communication and Conflict Management Skills for Door Supervisors</li>
                        </ul>
                    </div>

                    <div>
                        <span class="content-subtitle-new">Unit 4: Physical Intervention Skills for the Private Security Industry</span>
                        <p class="content-text text-black">Learn essential techniques and legal considerations related to physical intervention, including:</p>
                        <ul class="content-list text-black">
                            <li>Fundamentals of Physical Intervention</li>
                            <li>Legal Aspects and Responsibilities</li>
                            <li>Safe Application of Physical Intervention Techniques</li>
                            <li>First Aid Training</li>
                        </ul>
                        <p class="content-text text-black">In addition to the core units, this course includes <b>free First Aid training</b>, ensuring that you are fully equipped to handle medical emergencies, which is a <b>mandatory requirement</b> for obtaining your SIA Licence.</p>
                        <p class="content-text text-black mt-3">Complete this course to gain the expertise needed for a successful career in the security industry.</p>
                    </div>
                </div>

                <!-- TAB 3: FAQs (Mapped from live code) -->
                <div id="tab-3" class="tab-content bg-white">
                    <h3 class="content-subtitle-new">What Qualification do i need to be a Level 2 Door Supervisior?</h3>
                    <p class="content-text text-black">To become a Door Supervisor, you need an <b>SIA Door Supervisor Licence</b>. You will need to take a Door Supervisor training course to apply for the licence. It is also <b>mandatory</b> to have a first aid qualification before you start your training course.</p>

                    <h3 class="content-subtitle-new">When Can I Apply for my SIA License?</h3>
                    <p class="content-text text-black">You can apply for your SIA Licence as soon as you have <b>passed your course</b>.</p>

                    <h3 class="content-subtitle-new">Who is this Course for?</h3>
                    <p class="content-text text-black">This course is for individuals wishing to obtain the SIA Door Supervisor Licence and work in the following front-line roles:</p>
                    <ul class="content-list text-black">
                        <li>Corporate Security Guarding</li>
                        <li>Manned Guarding</li>
                        <li>Retail Security Guarding</li>
                        <li>Site Security</li>
                        <li>Music or Sporting Event Security</li>
                        <li>Nightclub / Restaurant Security</li>
                        <li>Shopping Centre Security</li>
                        <li>Loss Prevention Officer</li>
                        <li>Office Building Security Guarding and more…</li>
                    </ul>
                </div>
            </div>
            
            <!-- Original Footer Include -->
            <?php include "includes/footer.php" ?>

        </div>

    </div>

    <!-- Pop-up Script (Preserved logic from live code) -->
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
            
            // Set first tab as current on load if none is set
            if (tabs.length > 0 && !document.querySelector('.security-course-tabs .tab-link.current')) {
                 tabs[0].classList.add('current');
                 document.getElementById(tabs[0].getAttribute('data-tab')).classList.add('current');
            }

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
