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
    <title>SIA Top-Up Refresher Training Course for Door Supervision 2025</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-supervision-know-in-2025" />
    <meta name="description" content="Complete your SIA Top-Up Refresher Training Course for Door Supervision with G Security & Training. Stay compliant with 2025 SIA updates and renew your licence.">
    
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
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">SIA Top-Up Refresher Training Course for Door Supervision – Everything You Need to Know in 2025</h1>
                
                <!-- Initial Paragraph -->
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">If you want to keep working as a licensed door supervisor in the UK, renewing your **SIA licence** is a requirement. Since April 2021 it has been a requirement by the Security Industry Authority (SIA) for everyone who has an SIA licence to undertake **SIA Top-Up Refresher Training** prior to renewing their licence. For 2025, the Top-Up Refresher Training includes new modules, up-to-date safety, and essential legislation to provide you with the skills that are needed from the rapidly changing security industry.
G Security & Training delivers the <a href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-Supervision" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA top-up refresher training course for door supervision</a>, providing you with everything you need to be compliant, confident, and job-ready, whether you are working for clubs, events, retail, or corporate venues.</p>
<p class="text-[17px] font-medium leading-relaxed text-gray-700 mt-2">In this guide, we will answer some of the commonly asked questions relating to this career decision - from course information to potential job prospects. This should help you decide whether taking the <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA Door Supervisor course in Bradford</a> is right for you.</p>
            
                <!-- Featured Image -->
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1755199735/unnamed_k0dtak.jpg" alt="SIA Top-Up Refresher Training Course for Door Supervision" class="rounded-xl shadow-lg my-10 w-full h-auto">
            
                <!-- Table of Contents (Adapted to match numbered sections in the content) -->
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. What is the SIA Top-Up Refresher Course?</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. Can I Do My SIA Top-Up Training Online?</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. How Do I Refresh My SIA Licence?</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. Do I Have to Do SIA Top-Up Training Every 3 Years?</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. How Much Does SIA Renewal Cost?</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. What is the New Training for SIA 2025?</a></li>
                        <li><a href="#section-7" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. Why Choose G Security & Training?</a></li>
                    </ul>
                </div>

                <!-- Article Content (Main Body) -->
                <div class="article-content prose max-w-none text-gray-800">
                    
                    <!-- Section 1 -->
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800">1. What is the SIA Top-Up Refresher Course?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The SIA top-up refresher training course for door supervision is a **7 day mandatory training course** for door supervisors who are renewing their licence. The course aims to refresh your knowledge of legislation, safety procedures, and operational skills conferencing SIA’s requirements.</p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Included in the course in 2025:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Counter-terrorism awareness</li>
                        <li class="my-2">Emergency First Aid updates</li>
                        <li class="my-2">Safeguarding vulnerable persons</li>
                        <li class="my-2">Physical intervention skills update</li>
                        <li class="my-2">Awareness and prevention of drink spiking.</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">The fee starts from **£249** (inclusive of VAT), and it is open to anyone aged 18 upwards who is in possession of a valid SIA Door Supervisor licence or is renewing their licence.</p>
            
                    <!-- Section 2 -->
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800">2. Can I Do My SIA Top-Up Training Online?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Sometimes theory sections of the SIA top-up refresher training course can be delivered online, but **you cannot complete the full course online**. Physical assessments, e.g., physical intervention and first aid, must be in person, according to SIA rules.
</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">That means you will need to attend classroom sessions at an approved training centre, e.g., G Security & Training, to complete the course and pass the assessments.
</p>
                    
                    <!-- Section 3 -->
                    <h2 id="section-3" class="text-3xl font-bold text-gray-800">3. How Do I Refresh My SIA Licence?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Renewing your SIA licence is easy:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">1. **Book your course** - Book onto an approved SIA top-up refresher training course for <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">Door Supervision</a>.</li>
                        <li class="my-2">2. **Complete Training** - Pass all theory and practical assessments.</li>
                        <li class="my-2">3. **Renew** - Complete your application via the SIA website.</li>
                        <li class="my-2">4. **Pay renewal fee** - Currently £184 in 2025.</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700">
If you book early, you can renew up to four months before expiry and keep your existing time on the licence.
</p>
                    
                    <!-- Section 4 -->
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800">4. Do I Have to Do SIA Top-Up Training Every 3 Years?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Yes. Your SIA Door Supervisor licence is for three years, and every time you need to renew, you will need to complete **SIA Top-Up Refresher Training**. This is so all security professionals are up-to-date and aware of any new legislation, safety techniques, and industry best practices.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">If you fail to do this, then the renewal will be refused, and you will be unable to work legally as a door supervisor.
</p>

                    <!-- Section 5 -->
                    <h2 id="section-5" class="text-3xl font-bold text-gray-800">5. How Much Does SIA Renewal Cost?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">In 2025, the **SIA Door Supervisor licence renewal fee is £184** with the SIA. In addition, you will also be required to purchase the SIA top-up refresher training course for door supervision.
</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">We charge from **£250, including VAT, for the course**. Even with this cost, the potential to earn is massive. A competent <a href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">door supervisor</a> can earn up to £3,000 per month, depending on the location, role, or hours you are doing.</p>

                    <!-- Section 6 -->
                    <h2 id="section-6" class="text-3xl font-bold text-gray-800">6. What is the New Training for SIA 2025?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The SIA has released various developments in 2025 to the SIA top-up refresher training syllabus that include:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">**Advanced counter-terrorism** – Awareness of suspicious behaviours in public spaces.</li>
                        <li class="my-2">A safer method of resolving conflict.</li>
                        <li class="my-2">**Spiking awareness** – Prevention and actions responding to spiking.</li>
                        <li class="my-2">**Advanced first aid protocols** – Complying with the latest medical standards.</li>
                    </ul>
                    
                    <!-- Section 7 -->
                    <h2 id="section-7" class="text-3xl font-bold text-gray-800">7. Why Choose G Security & Training?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">When you are renewing your SIA licence, you need a training provider that can meet compliance whilst still giving quality. This is what we provide:</p>

                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Fully accredited for SIA compliance</li>
                        <li class="my-2">Experienced instructors with real-world experience</li>
                        <li class="my-2">Practical training with practical scenarios</li>
                        <li class="my-2">Competitive pricing - from £250 incl. VAT</li>
                        <li class="my-2">High level of pass rates and good student feedback</li>
                    </ul>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Our aim and focus is to help you become competent and confident to deal with a real-life scenario while being compliant with all legal obligations.</p>
                    
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1755200278/portrait-male-security-guard-with-uniform_3_onwxny.jpg" alt="SIA Top-Up Refresher Training Course for Door Supervision" class="rounded-xl shadow-lg my-10 w-full h-auto">

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">These syllabus changes better represent today's modern security challenges and ensure professionals can act to the best of their skills to keep people safe.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">The <a href="https://gsecurityandtraining.co.uk/sia-top-up-refresher-training-course-door-Supervision" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA top-up refresher training course for door supervision</a> is a legal requirement, but it is a good refresher for you to play catch-up, enhance your employability, and create a point of difference in your own career; especially with the latest SIA updates for 2025, it is the most comprehensive it has ever been when it covers safeguarding, counter-terrorism, first aid, and physical intervention.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">We make it easy and affordable through us. Don’t risk leaving it to the last minute if your license needs renewing; just book your SIA Top-Up Refresher Training and continue with your career.</p>
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
