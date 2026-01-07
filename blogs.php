<?php
session_start();

// --- PHP LOGIC PRESERVED FROM LIVE CODE ---
// This is the lead capture logic from the original file, preserved exactly as provided.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $_SESSION['Name'] = $name;
    $email = $_POST['Email'];
    $_SESSION['Email'] = $email;
    $phone = $_POST['Phone'];
    $_SESSION['Phone'] = $phone;
    $_SESSION['Course_Price'] = $_POST['course_p'];
    // Note: 'course_name' is included in your live code, but was not in the POST logic, ensuring compatibility.
    // $_SESSION['course_name'] = $_POST['course_name']; 

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
    <title>SIA Training Leeds | G Security and Training</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/blogs" />
    <meta name="description" content="Start your security career with SIA Training Leeds by G Security and Training. Expert instruction, full certification, and career-ready skills — enrol today in Leeds.">
    
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

    <style>
        /* Ensures the height is calculated correctly for alignment */
        .blog-card-wrapper {
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            /* Enforce vertical stretching */
            display: flex;
            flex-direction: column;
            height: 100%; 
        }
        .blog-card-wrapper:hover {
             box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
             transform: translateY(-2px);
        }
        /* Fixes the image scaling on hover */
        .blog-image {
            transition: transform 0.5s ease;
        }
        .blog-card-wrapper:hover .blog-image {
            transform: scale(1.05);
        }
        /* Ensures the text content area expands to take up remaining space */
        .blog-content {
             flex-grow: 1;
             display: flex;
             flex-direction: column;
             justify-content: space-between; /* Pushes the metadata to the bottom */
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
        <div class="bg-[#f8f8f8] py-20 min-h-screen">
            <h1 class="text-[48px] font-[700] text-center text-[#00C1EC]">
                Our Blogs
            </h1>
            
            <!-- Top Row of Blogs (3 columns) -->
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-[1280px] gap-8 mx-auto mt-12 px-6 lg:px-10">

                <!-- Blog Post 1 -->
                <div class="h-full">
                    <a href="security-career-sia-security-training-courses-leeds-uk" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1751051150/image_2_nam75f.webp" alt="Start Your Security Career with SIA Security Training Courses in Leeds">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        Start Your Security Career with SIA Security Training Courses in Leeds
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">18th August 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>

                <!-- Blog Post 2 -->
                <div class="h-full">
                    <a href="door-supervision-training-bradford-sia-licence-courses" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1752424620/security-guards-workspace_1_hsuwto.webp" alt="Door Supervision Training Bradford – Everything You Need to Know">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        Door Supervision Training Bradford – Everything You Need to Know
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">5th September 2025</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Blog Post 3 -->
                <div class="h-full">
                    <a href="sia-door-supervisor-course-in-bradford-worth-it-uk" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1754595801/portrait-male-security-guard-with-radio-station-camera-screens_gfkzvh.webp" alt="SIA Door Supervisor Course in Bradford – Is It Worth It in the UK?">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        SIA Door Supervisor Course in Bradford – Is It Worth It in the UK?
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">26th September 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
            </div>
            
            <!-- Separator (Hidden on mobile) -->
            <div class="my-10 max-w-[1280px] mx-auto hidden sm:block">
                <hr class="border-gray-300">
            </div>

            <!-- Bottom Row of Blogs (3 columns) -->
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-[1280px] gap-8 mx-auto mt-10 px-6 lg:px-10">
            
                <!-- Blog Post 4 -->
                <div class="h-full">
                    <a href="Sia-top-up-refresher-training-course-door-supervision-know-in-2025" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1755199735/unnamed_k0dtak.jpg" alt="SIA Top-Up Refresher Training Course for Door Supervision">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        SIA Top-Up Refresher Training Course for Door Supervision – Everything You Need to Know in 2025
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">15th October 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
                
                <!-- Blog Post 5 -->
                <div class="h-full">
                    <a href="from-security-guard-to-safety-expert-door-supervision-first-aid-training-leeds" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1757849574/stole-house-door-using-iron_k7aevx.webp" alt="From Security Guard to Safety Expert: Unlock Career Growth with Door Supervision and First Aid Training">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        From Security Guard to Safety Expert: Unlock Career Growth with Door Supervision and First Aid Training
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">27th October 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
                
                <!-- Blog Post 6 -->
                <div class="h-full">
                    <a href="sia-security-training-courses-leeds-building-safer-future" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1758047717/Gemini_Generated_Image_7onuk47onuk47onu_lfqhdt.png" alt="SIA Security Training Courses Leeds – Building a Safer Future">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        SIA Security Training Courses Leeds – Building a Safer Future
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">4th November 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
                
                <!-- Blog Post 7 -->
                <div class="h-full">
                    <a href="security-guard-training-leeds-sia-license" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image float-left mr-6" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1763967773/portrait-male-security-guard-with-uniform_23-2150368771_xcddps.avif" alt="Security Guard Training in Leeds: Everything to know">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        Security Guard Training in Leeds: Everything to know
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">24th November 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
                
                <!-- Blog Post 8 -->
                <div class="h-full">
                    <a href="how-to-get-an-sia-licence-types-costs-requirements-and-job-options" class="block h-full">
                        <div class="blog-card-wrapper bg-white rounded-xl overflow-hidden">
                            <div class="overflow-hidden">
                                <img class="w-full h-48 object-cover blog-image float-left mr-6" src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1764701673/Untitled-design-81-compressed_tmtwok.jpg" alt="How to Get an SIA Licence? Types, Costs, Requirements & Job Options">
                            </div>
                            <div class="p-5 blog-content">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-[#00C1EC] transition-colors duration-300">
                                        How to Get an SIA Licence? Types, Costs, Requirements & Job Options
                                    </h2>
                                </div>
                                <!-- New Design Metadata -->
                                <div class="flex items-center justify-between text-sm pt-2 border-t border-gray-100 mt-4">
                                    <p class="text-[#313137] font-[400] text-sm">GET TRAINING</p>
                                    <p class="text-[#313137] font-[400] text-sm">3rd December 2025</p>
                                </div>
                            </div>
                        </div>
                    </a> 
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
