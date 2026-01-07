<?php
include("include/header.php");
include("include/sidebar.php");
include("assets/config/db.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit;
}


$msg = "";
$edit_mode = false;
$edit_data = [];

// ✅ Edit Mode
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = intval($_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM users WHERE id=$edit_id");
    if (mysqli_num_rows($res) > 0) {
        $edit_data = mysqli_fetch_assoc($res);
    } else {
        $msg = "User not found!";
        $edit_mode = false;
    }
}

// ✅ Delete User
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if (mysqli_query($con, "DELETE FROM users WHERE id=$delete_id")) {
        echo "<script>alert('User deleted successfully!'); window.location.href='user.php';</script>";
        exit;
    } else {
        $msg = "Error deleting user: " . mysqli_error($con);
    }
}

// ✅ Add / Update User
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if ($edit_mode) {
        $sql = "UPDATE users SET 
                    name='$name', 
                    email='$email', 
                    role='$role'";
        if (!empty($_POST['password'])) {
            $sql .= ", password='$password'";
        }
        $sql .= " WHERE id=$edit_id";

        if (mysqli_query($con, $sql)) {
            $msg = "User updated successfully!";
        } else {
            $msg = "Error: " . mysqli_error($con);
        }
    } else {
        if (empty($_POST['password'])) {
            $msg = "Password is required for new users!";
        } else {
            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES ('$name', '$email', '$password', '$role')";
            if (mysqli_query($con, $sql)) {
                $msg = "User added successfully!";
            } else {
                $msg = "Error: " . mysqli_error($con);
            }
        }
    }
}

// ✅ Fetch all users
$users = mysqli_query($con, "SELECT * FROM users ORDER BY created_at DESC");
?>

<main class="dashboard-gssecurity-main" style="padding:20px;">
    <div style="font-size:28px; margin-bottom:20px;">
        <?php echo $edit_mode ? "Edit User" : "Create User"; ?>
    </div>

    <?php if ($msg) echo "<p style='color:green; font-weight:bold; margin-bottom:15px;'>$msg</p>"; ?>

    <div style="background:#fff; padding:25px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); max-width:600px; margin-bottom:40px;">
        <form method="POST" style="display:grid; grid-gap:15px;">
            <label style="font-weight:bold;">Full Name</label>
            <input type="text" name="name" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['name']) : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">Email</label>
            <input type="email" name="email" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['email']) : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">Password <?php if($edit_mode) echo '(Leave blank to keep current)'; ?></label>
            <input type="password" name="password" style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <label style="font-weight:bold;">Role</label>
            <select name="role" style="padding:8px; border-radius:5px; border:1px solid #ccc;">
                <option value="admin" <?php if ($edit_mode && $edit_data['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($edit_mode && $edit_data['role'] === 'user') echo 'selected'; ?>>User</option>
            </select>

            <button type="submit" style="background:#007BFF; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
                <?php echo $edit_mode ? "Update User" : "Create User"; ?>
            </button>
        </form>
    </div>

    <div style="font-size:28px; margin-bottom:15px;">All Users</div>
    <table style="width:100%; border-collapse:collapse; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background:#007BFF; color:#fff;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Name</th>
                <th style="padding:12px;">Email</th>
                <th style="padding:12px;">Role</th>
                <th style="padding:12px;">Created At</th>
                <th style="padding:12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($users) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($users)) { ?>
                <tr style="border-bottom:1px solid #ccc;">
                    <td style="padding:10px;"><?php echo $row['id']; ?></td>
                    <td style="padding:10px;"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td style="padding:10px;"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td style="padding:10px;"><?php echo $row['role']; ?></td>
                    <td style="padding:10px;"><?php echo $row['created_at']; ?></td>
                    <td style="padding:10px;">
                        <a href="?edit_id=<?php echo $row['id']; ?>" style="padding:6px 12px; background:orange; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold;">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?');" style="padding:6px 12px; background:red; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold;">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center; padding:15px;">No users found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>
