<?php
session_start();
include("assets/config/db.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $res = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header("Location: index");
            exit;
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background:#f1f1f1; display:flex; justify-content:center; align-items:center; height:100vh; }
        .login-box { background:#fff; padding:30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); width:350px; }
        input { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
        button { background:#007BFF; color:#fff; border:none; padding:10px; width:100%; border-radius:5px; font-size:16px; cursor:pointer; }
        h2 { text-align:center; }
        p { color:red; text-align:center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if($msg) echo "<p>$msg</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
