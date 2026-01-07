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
    <title>Become Safety Expert | Door Supervision and First Aid Training Leeds</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/from-security-guard-to-safety-expert-door-supervision-first-aid-training-leeds" />
    <meta name="description" content="Boost your career with Door Supervision and First Aid Training. Take the SIA Top Refresher For Door Supervision + First Aid. Earn up to £3,000/month.">
    
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
            padding-bottom: 0.25rem;
        }
        /* Style for main content headings (H2) to match the new design's border/accent color */
        .article-content h2 {
            border-left: 4px solid #00C1EC;
            padding-left: 1rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-size: 1.75rem;
            font-weight: 700;
            color: #111;
        }
        .article-content h3 {
            font-size: 1.25rem; /* Smaller subheadings (H3) */
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
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">From Security Guard to Safety Expert: Unlock Career Growth with Door Supervision and First Aid Training</h1>
                
                <!-- Initial Paragraph -->
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">Becoming a <b>Security Professional</b> is not only about keeping premises safe but rather a progression journey into your career, gaining new skill sets and earning potential. If you're looking for Door Supervision, G Security & Training can help you transition from a basic Security Guard into a multi-faceted safety operative with <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors"> Door Supervision and First Aid Training</a> and the SIA Top Refresher For Door Supervision + First Aid, providing opportunities throughout Leeds, Bradford and West Yorkshire.</p>
            
                <!-- Featured Image -->
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1757849574/stole-house-door-using-iron_k7aevx.webp" alt="Door Supervision and First Aid Training Leeds" class="rounded-xl shadow-lg my-10 w-full h-auto">
            
                <!-- Table of Contents (Based on Live Content Headings) -->
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. Door Supervision and First Aid Training: Skills and Earning Potential</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. How SIA Security and Training Transforms Job Opportunities</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. Maximise Your Downtime: Professional Growth Tips</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. Frequently Asked Questions About Training and Careers</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. Benefits of Choosing G Security & Training</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. Real-World Benefits: Why Security Training Pays Off</a></li>
                        <li><a href="#section-7" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. Take the Next Step: Transform Your Security Career</a></li>
                    </ul>
                </div>

                <!-- Article Content (Main Body) -->
                <div class="article-content prose max-w-none text-gray-800">
                    
                    <!-- Section 1 -->
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">1.</span> Door Supervision and First Aid Training: Skills and Earning Potential</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">When you invest in <b>Door Supervision and First Aid Training</b>, you'll learn important skills for emergencies, health & safety, and conflict management while also increasing your chances of earning: </p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"><span class="font-bold text-[#00C1EC]">Earning Potential:</span> <b>£3,000 per month</b></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">The benefits of investing in this training include: </p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">SIA approved certification which is acceptable all across the UK</li>
                        <li class="my-2">Emergency response skills for real-life situations</li>
                        <li class="my-2">Health and safety awareness every employer needs their staff to have</li>
                        <li class="my-2">Potential for career progression in clubs, corporate sites, and events</li>
                    </ul>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Taking the SIA Top Refresher For Door Supervision + First Aid will not only help you to maintain your qualification, allowing you to remain competitive in the industry for higher-paid roles, but will also give you: </p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"><span class="font-bold text-[#00C1EC]">Earning Potential:</span> <b>£3,000 per month</b></p>
            
                    <!-- Section 2 -->
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">2.</span> How SIA Security and Training Transforms Job Opportunities</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Completing these courses gives you exciting careers in a variety of roles beyond conventional security roles:</p>
                    
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Door Supervisor working events, clubs and corporate venues</li>
                        <li class="my-2">Corporate security officer</li>
                        <li class="my-2">Emergency response and first aid officer roles</li>
                    </ul>

                    <p class="text-[17px] leading-relaxed text-gray-700">Employers in Leeds, Bradford and West Yorkshire are looking for employees with SIA-approved certification, therefore, Door Supervision and First Aid Training and undertaking the <a href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-Supervision" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Top Refresher For Door Supervision + First Aid</a> to enhance your professional development and income is an excellent decision.</p>
                    
                    <!-- Section 3 -->
                    <h2 id="section-3" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">3.</span> Maximise Your Downtime: Professional Growth Tips</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Even when in the off time with everything said and done, your time is non productive: </p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><b>Learn More:</b> Practice every scenario you learn in Door Supervision and First Aid Training.</li>
                        <li class="my-2"><b>Don't Forget:</b> Check the SIA Top Refresher For Door Supervision + First Aid and perform every month.</li>
                        <li class="my-2"><b>Network:</b> Connect with agents, your peers and mentors in Leeds, Bradford and West Yorkshire.</li>
                        <li class="my-2"><b>Career Planning:</b> Write down promotions or certifications you would like. Identify target promotions or certifications for your long-term aims.</li>
                    </ul>
                    
                    <!-- Section 4 -->
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">4.</span> Frequently Asked Questions About Training and Careers</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Q1: What do Door Supervision and First Aid Training include?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Emergency first-aid, SIA regulations, conflict management, and health & safety duties.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Q2: Who should consider the SIA Top Refresher For Door Supervision + First Aid?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> If you have an SIA Door Supervisor license or first-aid certification, you fit into this category because it's important to refresh/keep your licensing/credentials active, valid and up to date.</p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Will these courses help me get work?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Definitely! Completing Door Supervision and First Aid Training or the <a href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-Supervision" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Top Refresher For Door Supervision + First Aid</a> will improve your employability and increase your pay prospects in Leeds, Bradford and West Yorkshire.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Q4: How long are the training courses?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Most courses last anywhere from 1–2 days of training, with training designed to fit in around you.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Q5: Will employers recognize these qualifications?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Yes, all G Security & Training's courses are approved by the SIA, and are widely respected throughout the UK.</p>

                    <!-- Section 5 -->
                    <h2 id="section-5" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">5.</span> Benefits of Choosing G Security & Training</h2>
                    
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Industry-Trained Instructors:</span> Instructors with experience from the real-world will help your learning.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Experiential Learning:</span> Hands-on learning and practice in real-world environments.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Flexible Scheduling:</span> New courses designed for your lifestyle.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">SIA Certification:</span> SIA certification for the whole of the UK.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Career Guidance:</span> Guidance on obtaining security jobs in Leeds, Bradford and West Yorkshire.</li>
                    </ul>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Completing the Door Supervision and First Aid Training or the SIA Top Refresher For Door Supervision + First Aid means you have both skills and earning potential to progress your career.</p>


                    <!-- Section 6 -->
                    <h2 id="section-6" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">6.</span> Real-World Benefits: Why Security Training Pays Off</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Investing in Door Supervision and First Aid Training means so much more than certification, it means changing your career and income:</p>

                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Increased earning potential:</span> Up to £3,000 per month</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Confidence:</span> to deal with emergencies and difficult incidents</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Extended professional network:</span> in the security sector</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Greater career mobility:</span> within corporate and event security</li>
                    </ul>


                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">The SIA Top Refresher For Door Supervision + First Aid will help you keep your skills fresh, giving you an edge and increased earning potential.</p>

                    
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1757850020/portrait-male-security-guard-with-uniform_3_q6evd6.webp" alt="Door Supervision and First Aid Training Leeds" class="rounded-xl shadow-lg my-10 w-full h-auto">


                    <!-- Section 7 -->
                    <h2 id="section-7" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">7.</span> Take the Next Step: Transform Your Security Career</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">It is up to you! With your own future career, earning potential and everything else that's on the line enroll in <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">Door Supervision and First Aid Training</a> or SIA Top Refresher For Door Supervision + First Aid at G Security & Training today. Become an SIA certified safety professional with options for job opportunities and a salary potential of up to <b>£3,000 a month</b> in Leeds, Bradford and West Yorkshire.
You can do this! It's your future. Your next big opportunity is about you upgrading your skills and certifications today.</p>

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
