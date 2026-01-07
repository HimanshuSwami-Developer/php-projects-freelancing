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
    $_SESSION['course_name'] = $_POST['course_name'];

    // Redirect to select-option.php
    // Email details
    $to = "bookings@gsecurityandtraining.co.uk";
    $subject = "ðŸš€ New Lead: Client Interested in Your Course!";

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIA Door Supervisor Course in Bradford – Is It Worth It in the UK?</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/sia-door-supervisor-course-in-bradford-worth-it-uk" />
    <meta name="description" content="Considering the SIA Door Supervisor Course in Bradford? Explore course details, costs, duration, and earning potential to see if it’s the right career move for you.">
    
    <!-- Load required scripts and styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
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
    
    <!-- Custom Styles for Article Layout -->
    <style>
        /* Ensures lists use standard disc styling and correct spacing in article content */
        .article-content ul {
            list-style: disc;
            padding-left: 1.5rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .article-content li {
            margin-bottom: 0.5rem;
            /* Added padding-bottom to separate list items slightly, matching modern blog style */
            padding-bottom: 0.25rem;
        }
        /* Style for headings to match the new design's border/accent color */
        .article-content h2 {
            border-left: 4px solid #00C1EC;
            padding-left: 1rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-size: 1.75rem; /* Slightly smaller for numbered list headings */
            font-weight: 700;
            color: #111;
        }
        .article-content h3 {
            font-size: 1.25rem; /* Smaller subheadings for emphasis in text */
            font-weight: bold;
            color: #000;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .article-content p, .article-content ul {
            font-size: 17px;
            line-height: 1.6;
        }
    </style>
    
    <?php include "includes/head.php" ?>
</head>

<body class="bg-[#f8f8f8]">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <div>
        <?php include "includes/header.php" ?>

        <!-- body -->
        <!-- Body Container: Uses light grey background for page depth -->
        <div class="bg-[#f8f8f8] py-12 md:py-20 min-h-screen">
            <!-- Main Blog Content Card: Centered, white background, rounded, and lifted with heavy shadow and blue top border -->
            <div class="max-w-7xl mx-auto bg-white p-6 md:p-12 rounded-xl shadow-2xl border-t-8 border-[#00C1EC] transition-shadow duration-500">

                <!-- Link to Blog Index -->
                <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline mb-8 inline-block transition-colors">← Back to Our Blogs</a>
            
                <!-- Article Header: Title with heavy blue underline (styled to match new code) -->
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">SIA Door Supervisor Course in Bradford – Is It Worth It in the UK?</h1>
                
                <!-- Initial Paragraph -->
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">If you are thinking about a career in security, it is likely that you have researched the SIA Door Supervisor course in Bradford. If you are planning to work at licensed venues, events, or festivals, or at a retail location, training as a **door supervisor** is a good way into the security industry in the United Kingdom.
</p>
<p class="text-[17px] font-medium leading-relaxed text-gray-700 mt-2">In this guide, we will answer some of the commonly asked questions relating to this career decision - from course information to potential job prospects. This should help you decide whether taking the <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Door Supervisor course in Bradford</a> is right for you.</p>
            
                <!-- Featured Image -->
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1754595801/portrait-male-security-guard-with-radio-station-camera-screens_gfkzvh.webp" alt="SIA Security Training Courses in Bradford" class="rounded-xl shadow-lg my-10 w-full h-auto">
            
                <!-- Table of Contents (Adapted to match numbered sections in the content) -->
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. What Is Required to Be a Door Supervisor?</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. How Long Is the SIA Door Supervisor Course?</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. Is the SIA Door Supervisor Course Difficult?</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. How Much Does the SIA Door Supervisor Course in Bradford Cost?</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. How Much Do Door Supervisors Get Paid in the UK?</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. Is It Worth Being a Door Supervisor?</a></li>
                    </ul>
                </div>

                <!-- Article Content (Main Body) -->
                <div class="article-content prose max-w-none text-gray-800">
                    
                    <!-- Section 1 -->
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800">1. What Is Required to Be a Door Supervisor?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">In order to work as a door supervisor legally in the UK, you must hold a valid **SIA Door Supervisor Licence**. This licence is issued by the Security Industry Authority (SIA), the regulator government organization in charge of regulating private security in the UK.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">In order to apply for the license, you will need to undertake approved training; for example, a **Door Supervision and First Aid Training course** from G Security & Training in Bradford is a full-service option and offers all of the necessary content and practical aspects to ensure you meet the SIA training standards fully.</p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">You will need to:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">be 18 years of age or older</li>
                        <li class="my-2">hold a valid First Aid qualification (normally Emergency First Aid at work – EFAW)</li>
                        <li class="my-2">complete an identity and criminal history checks</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">The **SIA Door Supervisor course in Bradford** would make you aware of all these requirements.</p>
            
                    <!-- Section 2 -->
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800">2. How Long Is the SIA Door Supervisor Course?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The course duration may differ slightly from training provider to provider, but G Security & Training runs the full course, including first aid training, over **7 days**. This duration will cover all required classroom training and also incorporate the necessary testing/practice.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">The course is intensive but not insurmountable, and professional trainers will lead you through essential elements such as conflict management, physical interventions, and security protocols.</p>
                    
                    <!-- Section 3 -->
                    <h2 id="section-3" class="text-3xl font-bold text-gray-800">3. Is the SIA Door Supervisor Course Difficult?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Many learners ask if the course is difficult, and the honest answer is: it depends on the learner. The <a href="https://gsecurityandtraining.co.uk/door-supervision-training-bradford-sia-licence-courses" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Door Supervisor course in Bradford</a> is designed to be attainable for most adults, including people who have had no previous experience in security.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">G Security & Training does everything with a practical emphasis and a supportive approach to build learners confidence and competence. If you attend and engage with the course activities and treat the assessments seriously, it should be highly achievable.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">It should also be acknowledged that learners will cover sensitive topics during the course, including managing aggression and working with vulnerable people - so maturity and a professional attitude are important.</p>
                    
                    <!-- Section 4 -->
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800">4. How Much Does the SIA Door Supervisor Course in Bradford Cost?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The cost of training can vary from provider to provider and from area to area. For example, at G Security & Training, we have the SIA Door Supervisor course in Bradford priced from **£350 (including VAT)**. That's £350 total for the door supervisor training, and that also covers the first aid course you need.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">We believe it represents a one-off cost for the student with long-term earning potential, and you can gain employment in a number of industries, including hospitality, retail, and events.</p>
                    
                    <!-- Section 5 -->
                    <h2 id="section-5" class="text-3xl font-bold text-gray-800">5. How Much Do Door Supervisors Get Paid in the UK?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Frequently people ask about the pay. The pay varies depending on your experience, location, and the venue in which you carry out the job. A qualified door supervisor can usually earn between **£14 and £25 an hour**.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Based on current hourly rates and average hours worked per week, some earn up to **£3,000 per month**. This is particularly true for those door supervisors working full-time and in high-demand areas such as nightlife security or for large-scale events.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Overall, taking an <a href="https://gsecurityandtraining.co.uk/door-supervision-training-bradford-sia-licence-courses" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Door Supervisor course in Bradford</a> can be considered a great next step for anyone who is looking for a flexible work schedule and job security.</p>

                    <!-- Section 6 -->
                    <h2 id="section-6" class="text-3xl font-bold text-gray-800">6. Is It Worth Being a Door Supervisor?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">This is a great career path for those who are assertive and responsible and are effective at engaging with people. As a door supervisor, you will be committed to safeguarding public safety, defusing conflict, and preserving public order—all while enjoying different job roles and opportunities to develop in the industry.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">If you are happy working with people, being active, and having a degree of responsibility, then yes, it is worth it. When you hold an SIA licence as a door supervisor, it opens the door to similar occupations such as **CCTV operator, close protection agent, and event security personnel**.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">When you carried out your **SIA Door Supervisor course in Bradford** at an accredited centre like G Security & Training, this allowed you to build a course for these requirements.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">It can be overwhelming when you start a new career. But when you are looking to become a door supervisor, the specific steps to do this are pretty clear-cut. You must be over 18, pass a background check, and successfully complete the <a class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors" href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training">SIA Door Supervisor course in Bradford</a>. This only bespeaks less than 7 days of your time, which could allow you to earn a steady income of nearly £3,000 a month.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">G Security & Training offers clear guidance and the full course offering, the Door Supervisors course offering First Aid plus Door Supervisors, and a pathway to adhering to the SIA legislation.</p>

                    <!-- Final Image -->
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1754595801/portrait-male-security-guard-with-barbed-wire-fence_hfrnlr.webp" alt="SIA Security Training Courses in Bradford" class="my-10 rounded-xl shadow-lg w-full h-auto">
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Whether you are looking to forge your path towards a new direction or take your first step into the world of security, this may lead to the opportunity for long-term success and personal growth.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 font-semibold mt-6 text-center">Do not hesitate; the time is now! Start your journey with G Security and Training, the leading training provider in Bradford for SIA licence courses!</p>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>

    </div>

    <!-- Toggle Script -->
    <?php include "includes/foot.php" ?>
</body>

</html>
