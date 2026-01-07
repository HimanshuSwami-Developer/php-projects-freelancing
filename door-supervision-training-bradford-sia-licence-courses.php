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
    <title>Door Supervision Training Bradford | SIA Licence Courses</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/door-supervision-training-bradford-sia-licence-courses" />
    <meta name="description" content="Looking for door supervision training Bradford? Get all your top questions answered with G Security and Training. Start your SIA licence courses now!">
    
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
        }
        .article-content h3 {
            font-size: 1.25rem; /* Smaller subheadings for emphasis in text */
            font-weight: bold;
            color: #000;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
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
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">Door Supervision Training Bradford – Everything You Need to Know</h1>
                
                <!-- Initial Paragraph -->
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">If you are considering work in the security field, one of the best things to do is to complete <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">door supervision training Bradford</a>. This training will help you get a job in bars, clubs, events, retail, or other venues. If you are new to the job market or leaving one career for another, this short guide to SIA licence courses will help you answer the most common questions people have about door supervision training Bradford.
Let’s break it down simply, nothing too complicated.</p>
            
                <!-- Featured Image -->
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1752424620/security-guards-workspace_1_hsuwto.webp" alt="door supervision training Bradford" class="rounded-xl shadow-lg my-10 w-full h-auto">
            
                <!-- Table of Contents (Adapted to match numbered sections in the content) -->
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. What Is Door Supervision Training Bradford?</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. Who Requires Door Supervision Training Bradford?</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. How Long Does The Course Take?</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. Is The Course Hard?</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. What Jobs Can I Get After The Course?</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. Why Choose G Security and Training?</a></li>
                        <li><a href="#section-7" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. The Real Benefits of Door Supervision Training Bradford</a></li>
                        <li><a href="#section-8" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">8. Is it worthwhile?</a></li>
                    </ul>
                </div>

                <!-- Article Content (Main Body) -->
                <div class="article-content prose max-w-none text-gray-800">
                    
                    <!-- Section 1 -->
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800">1. What Is Door Supervision Training Bradford?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Door Supervision Training Bradford is a professional course that gives you all the information you need to work legally as a **door supervisor** in the UK. Door supervisor training will cover the right skills, which are:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Handling conflict and emergency situations</li>
                        <li class="my-2">Understanding of the law</li>
                        <li class="my-2">Physical intervention techniques</li>
                        <li class="my-2">Communication and customer service</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700">When you have achieved the door supervision training qualification, you can apply for your **SIA licence courses**. You need this if you want to work legally in the security industry.</p>
            
                    <!-- Section 2 -->
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800">2. Who Requires Door Supervision Training Bradford?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Anyone who is looking to work in roles relating to the provision of security that involves guarding property, guarding people, or dealing with the public at licensed premises (e.g., nightclubs, pubs, etc.) will need door supervision training in Bradford.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">But it's not just bouncers. Many people take the door supervision training Bradford to work in retail security, events, corporate buildings, and even festivals. If you want to feel confident and competent in responding professionally to difficult situations, you will need this SIA licence courses training.</p>
                    
                    <!-- Section 3 -->
                    <h2 id="section-3" class="text-3xl font-bold text-gray-800">3. How Long Does The Course Take?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Usually, the coursework lasts for 4 to 6 days, depending on the provider, as the course consists of instructor & classroom based learning, practical-based sessions, and exams. You will study a number of modules, such as:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Working in the private security industry</li>
                        <li class="my-2">Conflict management</li>
                        <li class="my-2">Physical intervention skills</li>
                        <li class="my-2">Responsibilities of door supervision</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700">Once you have completed the course and passed, you will get a certificate, and you can then apply for your SIA licence courses.</p>
                    
                    <!-- Section 4 -->
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800">4. Is The Course Hard?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Many people worry that a course may be too difficult. The truth is that door supervision training Bradford is straightforward and practical, and it is aimed at people from all backgrounds. Even if you've never had security experience, the trainers will guide you all the way.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">If you come to the course and listen and take part in the class, you should find it an easy and enjoyable experience.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">At G Security and Training, we provide training with clarity, support, and a friendly atmosphere, so you never feel lost.</p>

                    <!-- Section 5 -->
                    <h2 id="section-5" class="text-3xl font-bold text-gray-800">5. What Jobs Can I Get After The Course?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">When you have completed your <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">door supervision training Bradford</a> your SIA licence courses will be the gateway to job options. Here are some roles that are common:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Door supervisor at bars/clubs</li>
                        <li class="my-2">Event security</li>
                        <li class="my-2">Festival security</li>
                        <li class="my-2">Retail security officer</li>
                        <li class="my-2">Hotel/corporate building security</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700">This qualification is all the rage in the current job market of the UK security industry. Employers frequently prefer applicants who have up-to-date training and an SIA badge.</p>

                    <!-- Section 6 -->
                    <h2 id="section-6" class="text-3xl font-bold text-gray-800">6. Why Choose G Security and Training?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">G Security and Training will help you all the way through, from training to SIA licence courses help. Our trainers are experienced, approachable, and focused on your success; we help everyone from those new to security to those refreshing their skills.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Our door supervision training Bradford meets different expectations and learning speeds.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">We also assist with finding job placements following the course, so you can start your first job with nowhere near the uncertainty of the future.</p>

                    <!-- Section 7 -->
                    <h2 id="section-7" class="text-3xl font-bold text-gray-800">7. The Real Benefits of Door Supervision Training Bradford</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700"><span class="font-bold text-[#00C1EC]">Better job opportunities –</span> More venues are hiring trained and licensed staff.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700"><span class="font-bold text-[#00C1EC]">Higher pay –</span> Security roles that require SIA licence courses tend to pay more.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700"><span class="font-bold text-[#00C1EC]">Personal development –</span> Learn how to remain calm, manage conflict, and be able to communicate.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700"><span class="font-bold text-[#00C1EC]">Legal requirements –</span> Correct training = no fines = no trouble.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700"><span class="font-bold text-[#00C1EC]">Job security –</span> The demand for trained security employees is always there.</p>
                    
                    <!-- Section 8 -->
                    <h2 id="section-8" class="text-3xl font-bold text-gray-800">8. Is it worthwhile?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Yes, even the door supervision training Bradford cost can be recouped fairly quickly when you begin working. Generally speaking, you can recover your costs within a few shifts. There is also a great demand for trained security people, so you will have great job impregnation going forward.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">If you are ready to change your life and take a step into a new career, then <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">door supervision training Bradford</a> is the right way to go. It is a short course that is cheap, and for many it will shape their future. You may want a job in nightlife, events, or corporate security; this training allows you to step into your new career with confidence and professionalism.</p>
                    
                    <!-- Final Image -->
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1752424621/security-guard-workspace_1_rbclcx.webp" alt="door supervision training Bradford" class="my-10 rounded-xl shadow-lg w-full h-auto">
                    
                    <p class="text-[17px] leading-relaxed text-gray-700">Do not hesitate; the time is now! Start your journey with G Security and Training, the leading training provider in Bradford for SIA licence courses!</p>

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
