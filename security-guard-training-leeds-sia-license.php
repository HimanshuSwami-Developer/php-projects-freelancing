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
    <title>Security Guard Training Leeds: Everything to Know</title>
    <link rel="canonical" href="https://gsecurityandtraining.co.uk/from-security-guard-to-safety-expert-door-supervision-first-aid-training-leeds" />
    <meta name="description" content="Thinking about getting a security guard training course in Leeds? Know about courses, costs, how you can get an SIA license in 2025, and more.">
    
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
                
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 border-b-4 pb-4 border-[#00C1EC] leading-tight">Security Guard Training in Leeds: Everything to know</h1>
                
                <p class="text-[17px] font-medium leading-relaxed text-gray-700 mb-8">It doesn’t matter if you’re a local, a new immigrant, or a student looking for work in Leeds. If you’ve been around, you know that there’s a strong demand for security guards in the city, considering its growing nightlife. Part-time or full-time, anyone who wants to earn good wants to know what it takes to work in security.
But today’s guards don’t have their duties limited to just standing outside a shop. They are expected to do much more. Preventing crime, controlling access to the premises, and monitoring complex systems like CCTVs? Just a fraction of the iceberg.
So yeah, nobody can claim that patrolling is a guard’s sole job in 2025.
Considering the nature of this demanding task, the government has made an <b>SIA license</b> mandatory for guards to get hired. Moreover, to hold this license, candidates must complete an <b>SIA-approved security guard training</b>. Sounds overwhelming? It’s actually easier than it looks.
Three easy steps—training, passing an easy exam, and applying for a license—and you’re all ready to start earning your first check. Let’s understand what this training is all about and how much security guard courses usually cost in Leeds.</p>
                
                <img src="https://res.cloudinary.com/dgalk9xcx/image/upload/v1763967773/portrait-male-security-guard-with-uniform_23-2150368771_xcddps.avif" alt="Security Guard Training in Leeds: Everything to know" class="rounded-xl shadow-lg my-10 w-full h-auto">
                
                <div class="bg-[#e3f2fd] border border-[#00C1EC]/50 p-6 rounded-lg mb-10 shadow-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-[#00C1EC]/30 pb-2">Article Contents</h3>
                    <ul class="space-y-3 text-gray-700 list-none p-0">
                        <li><a href="#section-1" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">1. What is security guard training?</a></li>
                        <li><a href="#section-2" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">2. Security guard vs. door supervisor training</a></li>
                        <li><a href="#section-3" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">3. SIA’s requirements for becoming a security guard</a></li>
                        <li><a href="#section-4" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">4. What does the SIA security guard course include?</a></li>
                        <li><a href="#section-5" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">5. How much does the SIA course cost?</a></li>
                        <li><a href="#section-6" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">6. Security guard training in Leeds: What to expect</a></li>
                        <li><a href="#section-7" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">7. How to get your SIA license?</a></li>
                        <li><a href="#section-8" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">8. Career paths after security guard training</a></li>
                        <li><a href="#section-9" class="text-[#00C1EC] hover:underline transition-colors block p-1 -ml-1">9. Frequently Asked Questions</a></li>
                    </ul>
                </div>

                <div class="article-content prose max-w-none text-gray-800">
                    
                    <h2 id="section-1" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">1.</span> What is security guard training?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">As the name suggests, it’s something you need to undergo to legally work as a <b>security officer in Leeds</b>. Or in the UK, for that matter. So basically, jobs at private security, retail security, corporate roles, and events all require you to complete an <b>SIA-approved security guard training</b> before you even apply for a license, let alone those positions. This training is what prepares you for situations that may come up regularly.
On a side note, security guard training is not the same as SIA door supervisor training.</p>
                    
                    <h2 id="section-2" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">2.</span> Security guard vs. door supervisor training</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">While a <b>door supervisor license</b> allows you to work in nightclubs, pubs, and venues, a <b>security guard license</b> would let you work in daytime roles. Mostly without any physical intervention elements. In the latter, your training modules wouldn’t include skills like Conflict Management or Physical Intervention. But, do note that a door supervisor’s license will let them work as a security guard if they wish to, but the opposite is not true.
But then, a door supervisor’s work hours are also irregular and inconsistent. Since they usually need to work in pubs, clubs, and other licensed venues. So if you’re someone who would prefer more <b>stable and predictable work hours</b> and refrains from night shifts, a security guard training might be the better option.</p>

                    <h2 id="section-3" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">3.</span> SIA’s requirements for becoming a security guard</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">So, there are a few conditions to keep in mind before you apply for an <b>SIA license</b>. You may apply, but it wouldn’t be approved if you’re not:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><b>18 years or older</b></li>
                        <li class="my-2">Have a <b>legal right to work in the UK</b></li>
                        <li class="my-2">Passing a <b>criminal record check</b></li>
                        <li class="my-2">Passing an <b>identity check</b></li>
                        <li class="my-2">Trained in an <b>SIA-recognised course</b></li>
                        <li class="my-2">Qualified for <b>Emergency First Aid at Work</b></li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">In addition, if you do pass all of the parameters above and get a license, keep in mind that you’ll need to <b>renew it every three years</b>. Each time, after retaking a small refresher training to keep in sync with the industry standards.</p>
                    
                    <h2 id="section-4" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">4.</span> What does the SIA security guard course include?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">For starters, there are a few basics that every SIA security guard course should include in its training and course content:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Working in the <b>Private Security Industry</b></li>
                        <li class="my-2">Communication  <b>Conflict Management</b></li>
                        <li class="my-2"><b>Incident Response</b></li>
                        <li class="my-2"><b>Health Safety</b></li>
                        <li class="my-2"><b>Emergency Procedures</b></li>
                        <li class="my-2">Basic Physical Awareness (not full physical intervention)</li>
                    </ul>

                    <h2 id="section-5" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">5.</span> How much does the SIA course cost?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">SIA courses cost between <b>£180 and £220 in Leeds</b>. But for the Door Supervisor license, the cost of SIA training may go up to £299 due to more skillful training. Still, prices do vary based on providers and their credibility.</p>

                    <h2 id="section-6" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">6.</span> Security guard training in Leeds: What to expect</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">As already mentioned, the demand for security guards in <b>Leeds</b> is <b>high in 2025</b> and would remain strong in the following year. So, for anyone who is in a dilemma of whether they should opt for an SIA training course in Leeds or not, it’s the perfect time to do so.
Training usually takes a <b>week</b>. And once you have finished it, you are immediately eligible to apply for your <b>SIA license</b>. Let’s understand the process of applying as well.</p>
                    
                    <h2 id="section-7" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">7.</span> How to get your SIA license?</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">So, your SIA license application would be done in <b>6 simple steps</b>. Anyone who is asking how to get an SIA license should only do the following, one by one.</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2">Complete SIA-approved training</li>
                        <li class="my-2">Pass your assessments</li>
                        <li class="my-2">Get an Emergency First Aid certification</li>
                        <li class="my-2">Submit your <a class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors" href="https://www.gov.uk/guidance/apply-for-an-sia-licence">SIA application online</a></li>
                        <li class="my-2">Undergo identity check + DBS</li>
                        <li class="my-2">Wait for approval (2-6 weeks)</li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">To avoid delays, your best bet is to submit complete documents. That reduces the chances of rejection. Moreover, the place you pick to get trained from would also help you with your application process. Once submitted, you can easily <b>track your application</b> through the SIA portal.</p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">Now, we’ve gone through the entire process, but what are the scopes after you hold an SIA license?</p>

                    <h2 id="section-8" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">8.</span> Career paths after security guard training</h2>
                    <p class="text-[17px] leading-relaxed text-gray-700">Anyone with an SIA license can work in security careers and roles like:</p>
                    <ul class="text-[17px] leading-relaxed text-gray-700">
                        <li class="my-2"><b>Retail security</b></li>
                        <li class="my-2"><b>Corporate offices</b></li>
                        <li class="my-2">Events, arenas, festivals</li>
                        <li class="my-2">Hospitality</li>
                        <li class="my-2"><b>Construction site security</b></li>
                    </ul>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2">And not just that, you can <b>upgrade your license</b> for CCTV, Door Supervisor, and Close Protection roles anytime with add-on training. Specifically for individuals who have completed <a class="font-bold text-[#00C1EC] hover:text-blue-700 transition-colors" href="https://gsecurityandtraining.co.uk/door-supervision-first-aid-training">Door Supervisor training</a>, employment opportunities are ample. Large companies like FSH Security actively recruit.</p>
                    
                    <h2 id="section-9" class="text-3xl font-bold text-gray-800"><span class="font-extrabold text-accent-blue">9.</span> Frequently Asked Questions</h2>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">How long does the SIA security guard course take?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Most SIA security guard training courses take at least <b>7 days</b> to complete. If you’re opting for First Aid Training too, add 1 extra day.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Can you fail the SIA exam?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Yes. Failing is most certainly a possibility. This can be prevented if you choose a course that offers free resits. Without paying anything extra, you’ll be able to retake the test.</p>
                    
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Do you need first aid training?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Yes. For most SIA roles now, <b>Emergency First Aid at Work (EFAW)</b> has been made mandatory. This training is given before your actual SIA security guard or door supervisor course starts.</p>

                    <p class="text-[17px] leading-relaxed text-gray-700 mt-4"><span class="font-bold text-[#00C1EC]">Is door supervisor training better than security guard training?</span></p>
                    <p class="text-[17px] leading-relaxed text-gray-700 mt-2"> <strong>A:</strong> Honestly, depends on the type of job you want.
                        <ul class="text-[17px] leading-relaxed text-gray-700 mt-2">
                            <li class="my-2"><b>Door Supervisor licence</b> = More flexible. Covers bars, clubs, events, retail, and corporate.</li>
                            <li class="my-2"><b>Security Guard licence</b> = Daytime roles only; Cannot work in licensed premises (pubs, nightclubs). This can be a downside if you’re looking to earn more.</li>
                        </ul>
                    </p>


                    </div>
            </div>
        </div>

        <?php include "includes/footer.php" ?>

    </div>

    <?php include "includes/foot.php" ?>
</body>

</html>