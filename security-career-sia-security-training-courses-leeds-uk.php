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
    <title>SIA Security Training Courses in Leeds | G Security and Training</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/security-career-sia-security-training-courses-leeds-uk" />
    <meta name="description" content="Join SIA Security Training Courses in Leeds with G Security and Training. Get certified, boost your career, and work legally in the UK’s security industry.">
    
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
        }
        /* Style for headings to match the new design's border/accent color */
        .article-content h2 {
            border-left: 4px solid #00C1EC;
            padding-left: 1rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
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
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">Start Your Security Career with SIA Security Training Courses in Leeds</h1>
                
                <!-- Initial Paragraph -->
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">When it comes to establishing a successful career in the security industry, <a href="https://gsecurityandtraining.co.uk/" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA security training courses in Leeds</a> are the gateway to your new opportunities. As an ever-increasing demand for qualified security personnel rises, so too does the importance of your training and acquiescence. Whatever your pathway into the industry is set to be, whether it is as a door supervisor, CCTV operator or working in close protection, getting a course certified through SIA approved training in Leeds will get your career on the fast track to success.</p>
            
                <!-- Featured Image -->
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1751051150/image_2_nam75f.webp" alt="SIA Security Training Courses in Leeds" class="rounded-xl shadow-lg my-10 w-full h-auto">
            
                <!-- Table of Contents: Stronger visual emphasis with light blue background (Mapped from new code) -->
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#why-sia" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. Why are SIA Security Training Courses in Leeds the Best Choice?</a></li>
                        <li><a href="#what-covered" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. What is Covered in SIA Security Training Courses?</a></li>
                        <li><a href="#types" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. Types of SIA Security Training Courses in Leeds</a></li>
                        <li><a href="#benefits" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. The benefits of completing your SIA Security Training</a></li>
                        <li><a href="#why-train" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. Why train with G Security and Training?</a></li>
                        <li><a href="#who-should" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. Who Should Complete SIA Security Training?</a></li>
                        <li><a href="#path" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. Your Path Toward a Safe Secure Life</a></li>
                    </ul>
                </div>

                <!-- Article Content (Main Body) -->
                <div class="article-content prose max-w-none text-gray-800">
                    
                    <!-- Section 1 -->
                    <h2 id="why-sia" class="text-3xl font-bold text-gray-800">Why are SIA Security Training Courses in Leeds the Best Choice?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">As Leeds becomes a significant business destination for all types of events and nightlife, the demand for professional security services is perpetually increasing. Therefore, the demand for trained, licensed and professional security personnel will continue to rise. SIA security training courses in Leeds provide both the requisite skills, legal knowledge and confidence to service the sector appropriately. </p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mb-8">These courses are not generic training before you go on to make application for a licence. These courses meet the guidelines of the **Security Industry Authority (SIA)**. Successful completion of an SIA approved course is essential for anyone looking to apply for an SIA licence, and work legally in the security industry, in the UK.</p>
            
                    <!-- Section 2 -->
                    <h2 id="what-covered" class="text-3xl font-bold text-gray-800">What is Covered in SIA Security Training Courses in Leeds?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mb-8">Whether you're new to the industry or looking to gain more skills, Security Training Courses in Leeds cover all the important topics that apply to all modern security roles. Each part of the course is taught by professionals with real industry experience in their respective fields which makes it easier to learn the practical elements and understand the wider concepts that are covered.</p>
                    
                    <!-- Section 3 -->
                    <h2 id="types" class="text-3xl font-bold text-gray-800">Types of SIA Security Training Courses in Leeds</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mb-6">If you choose to train with a well-known provider, G Security and Training you will get access to a selection of SIA courses that are tailored to different roles in security:</p>

                    <h3 class="text-2xl font-bold text-[#00C1EC] mt-6 mb-2">1. Door Supervisors Course</h3>
                    <p class="text-[17px] leading-relaxed text-gray-700">Probably one of the most common security training courses in Leeds, it allows you to work in a number of places including nightclubs, events, retail, and licensed premises. The door supervisor course covers several areas, like managing conflict and following emergency procedures.</p>
                    
                    <h3 class="text-2xl font-bold text-[#00C1EC] mt-6 mb-2">2. CCTV (Public Space Surveillance) Course</h3>
                    <p class="text-[17px] leading-relaxed text-gray-700">The CCTV (Public Space Surveillance) course is given to students who have an interest in surveillance and/or tech. It gives you the skills to operate a CCTV system as a professional in an ethical way. The use of CCTV systems are in high demand within retail, malls, councils and corporate settings.</p>
                    
                    <h3 class="text-2xl font-bold text-[#00C1EC] mt-6 mb-2">3. Security Guarding Course</h3>
                    <p class="text-[17px] leading-relaxed text-gray-700">SIA security training courses in Leeds is suitable for anyone working within the office sector, construction sites, or retail security who does not have a licence for premises authorized to serve alcohol.</p>
                    
                    <h3 class="text-2xl font-bold text-[#00C1EC] mt-6 mb-2">4. Close Protection Course</h3>
                    <p class="text-[17px] leading-relaxed text-gray-700">If you are interested in working in executive protection or celebrity protection, the close protection course is an advanced course that includes training on risk management, surveillance, and personal safety. </p>

                    <!-- Section 4 -->
                    <h2 id="benefits" class="text-3xl font-bold text-gray-800">The benefits of completing your SIA Security Training Courses in Leeds</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Are you still wondering if going through security training courses in Leeds is worth it? Here are some things SIA Security Training Courses can do for you: </p>
                    <ul class="text-[17px] leading-relaxed text-gray-700 list-disc pl-5 mt-4 space-y-3">
                        <li class="my-2 border-b border-gray-100 pb-2"><b>Legal Compliance:</b> You will legally work with your SIA.</li>
                        <li class="my-2 border-b border-gray-100 pb-2"><b>Career Progression:</b> You can apply for better-paying jobs.</li>
                        <li class="my-2 border-b border-gray-100 pb-2"><b>Professionalism:</b> You will be confident when handling difficult situations in the right manner and legally.</li>
                        <li class="my-2 border-b border-gray-100 pb-2"><b>Flexibility:</b> You can do your <a href="https://gsecurityandtraining.co.uk/" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA security training courses in Leeds</a> over a number of formats including weekend classes, evenings, and intensive courses. </li>
                    </ul>
                    
                    <!-- Pull Quote / Highlight Box -->
                    <div class="bg-[#e0f7fa] border-l-8 border-[#00C1EC] p-6 mt-8 mb-8 rounded-r-lg shadow-sm italic text-gray-800">
                        <p class="font-semibold text-lg">"Leeds has one of the most productive job markets for security professionals, from bars and clubs to events, retail, and corporate contracts."</p>
                    </div>

                    <!-- Section 5 -->
                    <h2 id="why-train" class="text-3xl font-bold text-gray-800">Why train with G Security and Training?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The choice of training provider is just as important as the training course itself. G Security and Training is one of the most trusted SIA training providers in Leeds. Their focus on providing quality training and education, real life training simulations, and hands on support will help learners stand out in a crowded market.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mb-8">We have a proud history of great student feedback, meaning every student leaves confident, skilful, and career-ready.</p>

                    <!-- Section 6 -->
                    <h2 id="who-should" class="text-3xl font-bold text-gray-800">Who Should Complete SIA Security Training Courses in Leeds?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">These courses would suit:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700 list-disc pl-5 mt-4 space-y-3">
                        <li class="my-2">Anyone who wishes to embark on a new career in security</li>
                        <li class="my-2">Security guards wanting to upgrade their qualifications</li>
                        <li class="my-2">Event stewards and marshals</li>
                        <li class="my-2">Ex-service and police transitioning to civilian roles</li>
                        <li class="my-2">Students who are looking for part-time work in the security industry</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mb-8">You don’t need to have previous experience, the courses are friendly and start supporting you from day one.</p>

                    <!-- Section 7 -->
                    <h2 id="path" class="text-3xl font-bold text-gray-800">Your Path Toward a Safe Secure Life</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Choosing to complete SIA security training courses in Leeds isn’t just about passing an exam, it is about creating a future. The demand for security professionals is growing, high-profile occasions to everyday businesses, there is always a need for trained professionals.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">And with Leeds being one of the most sought-after cities in the UK for nightlife, sports, and concert venues, there will always be a demand for trained professionals. Making the investment into your training now, provides yourself with a better path toward a long-term future in a high-demand industry.</p>
                    
                    <!-- Secondary Image -->
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1751051150/image_2_1_sfe5nj.webp" alt="SIA Security Training Courses in Leeds" class="my-10 rounded-xl shadow-lg w-full h-auto">
                    
                    <p class="text-[17px] leading-relaxed text-gray-700">If you want to take control of your future and be part of one of the UK's most integral industries, <a href="https://gsecurityandtraining.co.uk/" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA security training courses in Leeds</a> are the best starting point; they are cheap, easy to access, and extremely rewarding to those who put in the time and effort.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">So, take the first step now —even if you are just starting or even if you are just looking to add to your current qualifications! there is no better time to enrol and start making a difference!</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 font-semibold mt-6 text-center">Are you ready to get started in your new career? Contact G Security and Training today to book your place in the next SIA approved training course in Leeds.</p>
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
