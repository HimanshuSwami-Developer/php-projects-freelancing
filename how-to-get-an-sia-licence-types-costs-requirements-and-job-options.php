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
    $subject = "🚀 New Lead: Client Interested in Your Course!";

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
    <title>SIA Licence Explained: Types, Jobs You Can Get, and Salary Expectations</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/how-to-get-an-sia-licence-types-costs-requirements-and-job-options" />
    <meta name="description" content="Need an SIA licence? Here’s a simple guide to help you with choosing the right license and the application process so you can get licensed quickly.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
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

        <div class="bg-[#f8f8f8] py-12 md:py-20 min-h-screen">
            <div class="max-w-7xl mx-auto bg-white p-6 md:p-12 rounded-xl shadow-2xl border-t-8 border-[#00C1EC] transition-shadow duration-500">

                <a href="blogs" class="text-[#00C1EC] text-sm font-semibold hover:underline mb-8 inline-block transition-colors">← Back to Our Blogs</a>
                
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">How to Get an SIA Licence? Types, Costs, Requirements & Job Options</h1>
                
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">Here in the UK, anyone who wants to legally work in the security industry, needs to have an <b>SIA license</b> first. But, how exactly do you get an <b>SIA licence</b> and which one should you choose from the many types of licenses? Let’s first go through everything one by one, so you’re not confused by the time you actually sit down to <b>apply for SIA license</b>.</p>
                
                
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1764701673/Untitled-design-81-compressed_tmtwok.jpg" alt="SIA Licence Explained: Types, Jobs You Can Get, and Salary Expectations" class="rounded-xl shadow-lg my-10 w-full h-auto">
                
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. What Is an SIA Licence and Who Needs One?</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. Types of SIA Licences (Choose the Right One Before You Apply)</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. SIA Licence Requirements (What You Need Before You Apply)</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. How Much Does an SIA Licence Cost?</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. SIA Training Courses (Before You Apply)</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. SIA Licence Application: Step-by-Step Guide</a></li>
                        <li><a href="#section-7" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. How Long Does It Take to Get an SIA Licence?</a></li>
                        <li><a href="#section-8" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">8. Jobs You Can Get With an SIA Licence (and Salaries to Expect)</a></li>
                        <li><a href="#section-9" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">9. Start Your SIA Licence Journey</a></li>
                    </ul>
                </div>

                <div class="article-content prose max-w-none text-gray-800">
                    
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">1.</span> What Is an SIA Licence and Who Needs One?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Alright, straight to the point. An <b>SIA licence</b> is basically your golden ticket to work in the UK security industry. No badge, no gig. The <b>Security Industry Authority (SIA)</b> is the official referee for everything in the private security world, and they’re the ones who decide whether you’re allowed to step into the field or sit on the sidelines.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">If you want to be a door supervisor in a nightclub, a security guard in a retail store, the person watching a wall of CCTV screens at 3 a.m., or even someone doing close protection work for VIPs, you need this licence. That’s the law, not a gentle suggestion. Employers can’t legally hire you without it, and they take that seriously because getting caught is a nightmare for them.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">The cool part is that there isn’t just one badge. There are several <b>SIA license types</b>, each tied to the exact job you want. It makes sure the right people are trained for the right kind of work.</p>
                    
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">2.</span> Types of SIA Licences (Choose the Right One Before You Apply)</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">This is where a lot of people overthink things, so let’s keep it simple. If you want the most flexible option, the <b>Door Supervisor licence</b> is the one almost everyone starts with. It lets you work in pubs, clubs, festivals and pretty much everywhere you’d expect a security presence. It also covers everything a normal Security Guard licence does.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">The <b>Security Guard licence</b> is more for people guarding buildings, doing retail security and hanging out at corporate reception desks without worrying about drunk people trying backflips off couches. It’s solid but limited. <b>CCTV operators</b> take a different road entirely because their job is all about monitoring screens and spotting trouble early. No physical stuff, just sharp observation and good judgment. Then there’s <b>close protection</b>, the high-end badge. It’s the one for bodyguards and VIP security, and the training is much more intense than for the other types of licenses.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Whatever you choose affects everything that comes next, from the training style to the total bill you’ll pay for courses. Think of it as choosing your character in a game. Pick wisely before you start your <b>SIA license</b> journey.</p>
                    
                    <h2 id="section-3" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">3.</span> SIA Licence Requirements (What You Need Before You Apply)</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Before hitting the apply button, the SIA expects a few basics from you. You need to be at least <b>18</b> and legally allowed to work in the UK. You also need the right ID documents, and if your passport photo looks like it belongs to another planet, now’s the time to sort that out.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">The SIA checks your criminal record through a <b>DBS check</b>, and they’re very methodical about it. Not every mistake in your past automatically disqualifies you, but honesty is non-negotiable. They also expect you to have reasonable English skills because you’ll be dealing with people, procedures and safety information daily. And yes, the training course is mandatory. You can’t <b>apply for SIA license</b> and hope the SIA just trusts your vibe. They want proof you’ve been trained for the licence type you’re aiming for, which loops us back to picking the right course from the start.</p>
                    
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">4.</span> How Much Does an SIA Licence Cost?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Let’s talk numbers because everyone wants to know <b>how much is an SIA license</b> before they commit. The official <b>SIA license cost</b> is <b>£184</b> for your main badge. No negotiation, no discount codes, no seasonal sale. That <b>SIA license fee</b> is locked in by the SIA.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">The real variable cost is the training. A Door Supervisor course can go anywhere from about <b>£200 to £300</b> depending on where you live and who’s running the class. CCTV training usually falls around <b>£150 to £250</b>. Then you’ve got the tiny stuff: passport-style photos, ID checks if needed, and possibly a resit fee if you mess up an exam. Renewal later on costs roughly the same as applying fresh, so when it’s time to <b>renew SIA license</b>, you’ll see a familiar number on your bank screen.</p>

                    <h2 id="section-5" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">5.</span> SIA Training Courses (Before You Apply)</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Before you step into security, you’ve got to take the right <a href="https://gsecurityandtraining.co.uk/courses" class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors">SIA training course</a>. The SIA doesn’t teach these themselves. They approve training centres, and you pick one that fits your schedule and budget.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Door Supervisor courses usually last around a week, and they’re loaded with everything from first aid to dealing with aggression to physical intervention. There’s a lot of hands-on stuff, and the assessments feel like you’re being prepped for real-life moments rather than trick questions. CCTV courses are shorter, usually a few days, and they’re all about laws, surveillance rules, reporting incidents and understanding how to operate the systems.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Once you finish your course and pass the assessments, that’s when you <b>apply for SIA license</b>. No pass, no licence. Pretty straightforward.</p>

                    <h2 id="section-6" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">6.</span> SIA Licence Application: Step-by-Step Guide</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Here’s the no-drama guide to getting it done. First, <b>create your SIA online account</b>. It takes minutes. Then finish your training and wait for your certificate to come through. Gather your documents, get your DBS check done and make sure every detail matches across every form. Typos matter more than you think.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Once your documents are solid, fill in your application, submit everything and pay the <b>SIA license fee</b>. After that, it’s just waiting. The SIA processes everything in stages, and if your background check is clean and your documents aren’t a puzzle, things move pretty smoothly. And finally, your badge shows up in the post, and you’re officially in the game. That’s the entire <b>obtaining SIA license</b> experience in a nutshell.</p>

                    <h2 id="section-7" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">7.</span> How Long Does It Take to Get an SIA Licence?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">The timeline isn’t too wild. Most training courses take anywhere from three days to a week, depending on the licence. After that, you wait for your certificate to land, which usually happens within a week. Once you submit your application, the SIA typically takes a couple of weeks to process everything, sometimes longer if they’re busy or your documents need extra checks.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">If everything goes smoothly, getting your <b>SIA licence</b> from start to finish usually takes somewhere between <b>three and six weeks</b>. Delays mostly come from missing documents or DBS check hiccups, so tighten that part up early.</p>
                    
                    <h2 id="section-8" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">8.</span> Jobs You Can Get With an SIA Licence (and Salaries to Expect)</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Once you’ve got your <b>SIA security license</b>, you can slot into a bunch of roles. Door supervisors are the heartbeat of late-night venues and events. Security guards are everywhere from shopping centres to corporate buildings. CCTV operators are the quiet heroes behind the screens, keeping an eye out for trouble before it becomes chaos. Event security, retail security, corporate protection, stadium work, construction site security — you name it, there's a slot for you.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700">Salaries vary, but here’s the reality you’ll see out there:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Retail and Static Guarding:</span> Often hover around <b>£10.50 to £12.50</b> an hour.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Door Supervisors:</span> Can hit <b>£11 to £15</b> depending on the city and the venue.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">CCTV Operators:</span> Usually float between <b>£11 and £14</b> an hour.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Corporate Security:</span> Sometimes sneaks up to <b>£16</b> an hour.</li>
                        <li class="my-2"><span class="font-bold text-[#00C1EC]">Close Protection:</span> That’s the big money lane, with daily rates going from <b>£150 to £300</b> once you’ve built a reputation.</li>
                    </ul>

                    
                    <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1764701966/shutterstock_1259350306_id1lkg.webp" alt="SIA Licence Explained: Types, Jobs You Can Get, and Salary Expectations" class="rounded-xl shadow-lg my-10 w-full h-auto">


                    <h2 id="section-9" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">9.</span> Start Your SIA Licence Journey</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">If you’re ready to dive into the industry, the best thing you can do is train properly from the start. The right centre makes the process way less stressful. They walk you through what documents you need, help you avoid mistakes on your application and give you the kind of training that actually makes sense in the real world.</p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Look for trainers, like GSecurity and Training, for example, who know what the job really feels like, not people reading from a PowerPoint slide. Find a centre with solid pass rates, flexible scheduling and no sneaky extra fees. You can check out ours too. Doesn’t matter if you’re booking your<b>SIA training course</b> or about to <b>apply for SIA license</b>, the sooner you begin, the sooner you can start earning and building your path in the industry.</p>

                </div>
            </div>
        </div>

        <?php include "includes/footer.php" ?>

    </div>

    <?php include "includes/foot.php" ?>
</body>

</html>