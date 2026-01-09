<?php
session_start();
require_once __DIR__ . '/db.php';

/* ===============================
   FORCE LOGOUT IF INACTIVE
================================ */

if (isset($_SESSION['user_id'])) {

    $conn = getDB();

    $stmt = $conn->prepare("
        SELECT is_active 
        FROM users 
        WHERE emp_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // ❌ User removed or inactive → logout
    if (!$user || (int)$user['is_active'] === 0) {
        session_unset();
        session_destroy();

        header("Location: /login.php?inactive=1");
        exit;
    }
}



//  <form action="mail.php" method="POST" class="space-y-6">
//           <div class="grid md:grid-cols-2 gap-6">
//             <div>
//               <label class="text-[10px] uppercase font-black tracking-widest text-gray-500 ml-1">Your Name</label>
//               <input type="text" name="name" required placeholder="Full Name" 
//                 class="mt-2 w-full rounded-2xl form-input px-6 py-4 text-sm font-semibold" />
//             </div>
//             <div>
//               <label class="text-[10px] uppercase font-black tracking-widest text-gray-500 ml-1">Email Address</label>
//               <input type="email" name="email" required placeholder="email@gmail.com"
//                 class="mt-2 w-full rounded-2xl form-input px-6 py-4 text-sm font-semibold" />
//             </div>
//           </div>

//           <div>
//             <label class="text-[10px] uppercase font-black tracking-widest text-gray-500 ml-1">Mobile Number</label>
//             <input type="tel" name="phone" required placeholder="+91 ..."
//               class="mt-2 w-full rounded-2xl form-input px-6 py-4 text-sm font-semibold" />
//           </div>

//           <div>
//             <label class="text-[10px] uppercase font-black tracking-widest text-gray-500 ml-1">Message / Requirements</label>
//             <textarea name="message" rows="4" required placeholder="How can we help you?"
//               class="mt-2 w-full rounded-2xl form-input px-6 py-4 text-sm font-semibold"></textarea>
//           </div>

//           <button type="submit" 
//             class="w-full btn-premium py-5 rounded-2xl shadow-xl flex items-center justify-center gap-4 text-sm">
//             Initialize Consultation <i class="fa-solid fa-arrow-right-long text-xs"></i>
//           </button>
//         </form>
      