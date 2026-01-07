<?php
session_start();

// --- LIVE TEAM DATA ---
$team_members = [
    [
        'name' => 'Luzuko Mgaga',
        'bio' => 'Luzuko has worked as front line security for over 10 years! He has the kind of hand-on experience most of us would like to learn from. Based in Manchester, he’s completed the PI module from Dynamisis, a well-recognised training provider. And when you do learn from him in person, you wouldn’t want to miss out on his conflict management classes.',
        'image_url' => 'https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_kak7v0.jpg',
    ],
    [
        'name' => 'Muhammad Pervaiz',
        
        'bio' => 'Muhammad also hails from Manchester and conducts security training at many centres there and across the UK. Now, with him, you won’t just be learning about security skills, but also how to land jobs quickly. And with a PI license from Dynamisis, comes an expertise in First Aid Training and the versatility every student needs.',
        'image_url' => 'https://res.cloudinary.com/dgalk9xcx/image/upload/v1761595701/WhatsApp_Image_2025-10-25_at_00.23.32_1_qmxxod.jpg',
    ],
    // If you add more members, they will automatically fit into the 2-column layout.
];
// --- END LIVE TEAM DATA ---

// NOTE: No form submission logic is needed for this static content page.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meet Our Team | G Security and Training</title>
    <meta name="description" content="Meet the experienced and dedicated team behind G Security and Training, committed to delivering professional security services and top-tier SIA training.">
    
    <!-- Load required scripts and styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'accent-blue': '#00C1EC',
                        'charcoal': '#181818',
                        'light-gray-bg': '#f8f8f8',
                    }
                }
            }
        }
    </script>
    
    <?php include "includes/head.php" ?>
</head>

<body class="bg-light-gray-bg">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <div>
        <?php include "includes/header.php" ?>

        <!-- Body -->
        <div class="bg-light-gray-bg py-12 md:py-20 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Page Header -->
                <div class="text-center mb-16">
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-4">
                        A qualified team, <span class="text-accent-blue">to help you every step of the way </span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto text-center">
                        They’ve done it themselves. So they know what it takes to make you competent. Simply lean on 3+ decades of industry expertise for your security training and licensure.
                    </p>
                </div>

                <!-- Team Grid (Adjusted to lg:grid-cols-2 for the new wide cards) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <?php foreach ($team_members as $member) { ?>
                        
                        <!-- Team Member Card: VERTICAL BLOCK Layout -->
                        <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition duration-300 hover:scale-[1.02] hover:shadow-2xl h-full border-t-4 border-accent-blue">
                            
                            <!-- Image Section (Fixed height for consistent display) -->
                            <div class="relative w-full overflow-hidden">
                                <!-- Image height set to h-72 to show more of the face and prevent tight cropping -->
                                <img src="<?= $member['image_url'] ?>" alt="<?= $member['name'] ?>" 
                                     class="w-full h-72 object-cover object-center transition-transform duration-500 hover:scale-105">
                            </div>
                            
                            <!-- Content Section (Simple block layout) -->
                            <div class="p-6">
                                <div>
                                    <h3 class="text-3xl font-black text-gray-900 mb-1"><?= $member['name'] ?></h3>
                                    <!-- Use a slightly faded accent blue for the role title -->
                                    <!--<p class="text-lg font-semibold text-accent-blue/80 mb-4"><?= $member['title'] ?></p>-->
                                    
                                    <blockquote class="text-gray-700 text-lg leading-relaxed border-l-4 border-gray-200 pl-4 italic">
                                        "<?= $member['bio'] ?>"
                                    </blockquote>
                                </div>
                                
                                <!-- Placeholder for CTAs/Links if needed -->
                                <!--<div class="mt-4">-->
                                <!--    <span class="text-sm font-medium text-gray-500">Industry Expertise: 30+ Years</span>-->
                                <!--</div>-->
                            </div>
                        </div>

                    <?php } ?>
                </div>

                <!-- Call to Action Banner -->
                <div class="mt-20 p-10 bg-white rounded-xl shadow-2xl border-t-8 border-gray-400 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Ready to Join the Security Industry?</h2>
                    <p class="text-lg text-gray-700 mb-6">Start your journey with the team that supports your success from day one.</p>
                    <a href="courses" class="inline-block bg-accent-blue text-white px-8 py-3 rounded-lg font-bold  transition duration-200 shadow-lg text-lg">
                        View Training Courses
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
