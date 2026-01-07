<?php
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Email details
    $to = "bookings@gsecurityandtraining.co.uk";
    $subject = "New Contact Form Submission from $firstName $lastName";

    $body = "You have received a new message from your website contact form.\n\n";
    $body .= "First Name: $firstName\n";
    $body .= "Last Name: $lastName\n";
    $body .= "Contact: $contact\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        $msg = "Thank you! Your message has been sent.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    // echo "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIA Security Training Courses Bradford | Expert Event Security Services</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/security-services/" />
    <meta name="description" content="Secure your event with professional event security services. Trained staff for crowd control, access management, and venue safety across the UK.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <?php include "includes/head.php" ?>
    <style>
        .accordion-grid {
         
        }

        .accordion-item {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 200px;
            cursor: pointer;
        }

        .accordion-item:hover {
            flex: 2;
            height: 300px;
        }

        .accordion-item:hover .content {
            opacity: 1;
            transform: translateY(0);
        }

        .content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.3s ease;
            text-align: center;
        }

        .accordion-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-[#f8f8f8]">
   <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <?php
   if($msg){
  ?>  
    <div style="position: fixed;
    z-index: 999;
    background: green;
    right: 0;
    padding: 10px 20px;
    color: #fff;
    border-radius: 10px;
    top: 150px;">
        <?php echo $msg; ?>
    </div>
   <?php } ?> 
    <div>
        <?php include "includes/header.php" ?>

        <!-- body -->
        <div class="">
            <div
                class="relative sm:h-80 w-full bg-[url('https://res.cloudinary.com/dgalk9xcx/image/upload/v1744570822/Screenshot-2025-03-22-220637-1_xx32sj.webp')] bg-cover bg-center">
                <!-- Black overlay with 50% opacity -->
                <div class="absolute inset-0 bg-black opacity-50"></div>

                <!-- Centered content -->
                <div class="relative sm:h-80 w-full bg-[url('/your-image.jpg')] bg-cover bg-center">
                    <!-- Black overlay with 50% opacity -->
                    <div class="absolute inset-0 bg-black opacity-50"></div>

                    <!-- Centered content -->
                    <div class="relative z-10 flex items-center justify-center h-full text-white text-center sm:mx-auto mx-7">
                        <div class="flex flex-col items-center gap-2">
                            <h1 class="sm:text-[40px] text-[30px] text-[#00C1EC] font-bold sm:mt-0 mt-5">
                              G Security And Training Security Professional Services
                            </h1>
                            <p class="mt-5 text-white sm:w-[70%]">
                                Our team of highly skilled and experienced security professionals is dedicated to delivering top-tier protection for our clients and their assets. Each guard undergoes rigorous screening and selection to uphold our high standards, ensuring dependable and trustworthy service. Additionally, our team is extensively trained and well-informed on security protocols and awareness.
                            </p>
                        </div>
                    </div>
                </div>



            </div>
            <div class="container mx-auto ">
                <section class="pt-10 xl:w-[1280px] lg:w-[1080px] md:w-[767px] sm:w-[580px] sm:mx-auto mx-4">
                    <div class="accordion-grid grid sm:grid-cols-3 grid-cols-1 gap-5">
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438611/Frame-10_clcyak.webp" alt="ACT Counter Terrorism">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">Action Counters Terrorism</h3>
                                <p  class="text-sm">The Action Counters Terrorism (ACT) Security e-Learning program offers specialized training designed for frontline security professionals.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438612/Frame-11_vbvfbw.webp" alt="ACT Awareness E-Learning">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">ACT Awareness E-Learning</h3>
                                <p  class="text-sm">The ACT Awareness e-Learning program delivers accredited training to help UK organizations counter contemporary terrorist threat.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438612/Frame-12_t97eii.webp" alt="Ask for Angela">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">Ask for Angela</h3>
                                <p class="text-sm">The Ask for Angela campaign enables individuals in unsafe situations to discreetly seek help by using the codeword "Angela." Trained staff respond accordingly.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438613/Frame-13_lkdwfu.webp" alt="First Aid">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">First Aid</h3>
                                <p class="text-sm">We deliver prompt and professional first aid services, with trained staff prepared to handle various medical emergencies and ensure safety.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438613/Frame-14_tqptbi.webp" alt="SCAN Training">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">SCAN Training</h3>
                                <p class="text-sm">SCAN Training offers expert security programs, equipping individuals with the skills and techniques to handle safety challenges.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1744438613/Frame-15_dgqdhg.webp" alt="CPL Learning">
                            <div class="content">
                                <h3 class="text-lg font-bold  mt-2">CPL Learning</h3>
                                <p class="text-sm">CPL - Learning provides specialized security training, equipping individuals with the expertise to manage safety challenges effectively and professionally.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="py-16 px-10 sm:px-28 sm:text-center">
                    <h2 class="text-[42px] font-bold text-[#00C1EC] mb-4">Building Safer Environments with Trusted Security & <span class="text-[#00C1EC]">Services</span></h2>
                    <p class="text-black text-[18px] sm:px-20 sm:mx-auto mb-12">
                        Whether you need corporate security, event protection, or specialized security training, we deliver tailored solutions to meet your specific needs. Trust us to safeguard what matters most with reliable, professional, and industry-compliant security services.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-5xl mx-auto">
                        <div class="p-6  shadow-lg sm:mt-0 mt-3" style="background: linear-gradient(313deg, #000, #041f25);">
                            <div class=" mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                                    <path fill="#00c1ec" d="M16 17v2H2v-2s0-4 7-4s7 4 7 4m-3.5-9.5A3.5 3.5 0 1 0 9 11a3.5 3.5 0 0 0 3.5-3.5m3.44 5.5A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4M15 4a3.4 3.4 0 0 0-1.93.59a5 5 0 0 1 0 5.82A3.4 3.4 0 0 0 15 11a3.5 3.5 0 0 0 0-7" />
                                </svg>
                            </div>
                            <h3 class="text-xl text-white text-left  font-semibold mb-2">Door Supervision Security</h3>
                            <p class="text-white text-left mt-2">Our G Security Door Supervision service ensures a safe and secure environment with trained professionals overseeing entry points.</p>
                        </div>
                        <div class="p-6  shadow-lg sm:mt-0 mt-3" style="background: linear-gradient(353deg, #00c1ec, #0a4856);">
                            <div class=" mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20">
                                    <path fill="#fff" d="M19 11a7.5 7.5 0 0 1-3.5 5.94L10 20l-5.5-3.06A7.5 7.5 0 0 1 1 11V3c3.38 0 6.5-1.12 9-3c2.5 1.89 5.62 3 9 3zm-9 1.08l2.92 2.04l-1.03-3.41l2.84-2.15l-3.56-.08L10 5.12L8.83 8.48l-3.56.08L8.1 10.7l-1.03 3.4L10 12.09z" />
                                </svg>
                            </div>
                            <h3 class="text-xl text-white text-left font-semibold mb-2">Events Security</h3>
                            <p class="text-white text-left mt-2">G Security and Training offers premium event security packages to ensure your event runs seamlessly and successfully.</p>
                        </div>
                        <div class="p-6  shadow-lg sm:mt-0 mt-3" style="background: linear-gradient(313deg, #000, #041f25);">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                                    <path fill="#00c1ec" d="M18 8h-1V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2M9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9zm4 8.723V18h-2v-2.277c-.595-.346-1-.984-1-1.723a2 2 0 1 1 4 0c0 .738-.405 1.376-1 1.723" />
                                </svg>
                            </div>
                            <h3 class="text-xl text-white text-left font-semibold mb-2">Static Sites Security</h3>
                            <p class="text-white text-left mt-2">We provide professional security services for static sites, ensuring round-the-clock protection and safety for your premises.</p>
                        </div>
                    </div>
                </section>

                <section class="py-16 px-4 text-center">
                    <h2 class="text-[48px] font-bold mb-8 text-black">Want Us to Call You Back ?</h2>
                    <form method="post" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-400 text-left mb-2" for="firstName">First Name</label>
                                <input class="w-full p-2 bg-[#eee] text-black rounded" type="text" id="firstName" name="firstName" placeholder="First Name" required>
                            </div>
                            <div>
                                <label class="block text-gray-400 text-left mb-2" for="lastName">Last Name</label>
                                <input class="w-full p-2 bg-[#eee] text-black rounded" type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-400 text-left mb-2" for="contact">Contact</label>
                                <input class="w-full p-2 bg-[#eee] text-black rounded" type="text" id="contact" name="contact" placeholder="Contact" required>
                            </div>
                            <div>
                                <label class="block text-gray-400 text-left mb-2" for="email">Email</label>
                                <input class="w-full p-2 bg-[#eee] text-black rounded" type="email" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-400 text-left mb-2" for="message">Message</label>
                            <textarea class="w-full p-2 bg-[#eee] text-black rounded" id="message" name="message" placeholder="Message" rows="4"></textarea>
                        </div>
                        <button type="submit" name="submit" class="w-full border-[1px] border-[#00C1EC] p-2 rounded text-white bg-[#00C1EC]  transition duration-300">Submit</button>
                    </form>
                </section>
            </div>

        </div>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>
    </div>

    <!-- Toggle Script -->
    <?php include "includes/foot.php" ?>
</body>

</html>