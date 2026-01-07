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

// Check if we are editing a course
$edit_mode = false;
$edit_data = [];

if(isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])){
    $edit_mode = true;
    $edit_id = intval($_GET['edit_id']);
    $res = mysqli_query($con, "SELECT * FROM courses WHERE id=$edit_id");
    if(mysqli_num_rows($res) > 0){
        $edit_data = mysqli_fetch_assoc($res);
    } else {
        $msg = "Course not found!";
        $edit_mode = false;
    }
}

// ✅ Handle Delete Course
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $res = mysqli_query($con, "SELECT image FROM courses WHERE id=$delete_id");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $image_path = "uploads/" . $row['image'];

        // Delete image file if exists
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete record
        if (mysqli_query($con, "DELETE FROM courses WHERE id=$delete_id")) {
            echo "<script>alert('Course deleted successfully!'); window.location.href='/admin';</script>";
            exit;
        } else {
            $msg = "Error deleting course: " . mysqli_error($con);
        }
    } else {
        $msg = "Course not found!";
    }
}

// Handle Add/Edit submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = mysqli_real_escape_string($con, $_POST['title']);
    $point1 = mysqli_real_escape_string($con, $_POST['point1']);
    $point2 = mysqli_real_escape_string($con, $_POST['point2']);
    $point3 = mysqli_real_escape_string($con, $_POST['point3']);
    $point4 = mysqli_real_escape_string($con, $_POST['point4']);
    $point5 = mysqli_real_escape_string($con, $_POST['point5']);
    $point6 = mysqli_real_escape_string($con, $_POST['point6']);
    $point7 = mysqli_real_escape_string($con, $_POST['point7']);
    $point8 = mysqli_real_escape_string($con, $_POST['point8']);
    $point9 = mysqli_real_escape_string($con, $_POST['point9']);
    $point10 = mysqli_real_escape_string($con, $_POST['point10']);
    $regular_price = mysqli_real_escape_string($con, $_POST['regular_price']);
    $sale_price = mysqli_real_escape_string($con, $_POST['sale_price']);
    $plan_type = mysqli_real_escape_string($con, $_POST['plan_type']);
    $info_link = mysqli_real_escape_string($con, $_POST['info_link']); // ✅ new field
// ✅ new field

    // Image handling
    $image = $edit_mode ? $edit_data['image'] : "";
    if(!empty($_FILES['image']['name'])){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir,0777,true);
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    if($edit_mode){
        // Update course
        $sql = "UPDATE courses SET 
        title='$title',
                    point1='$point1',
                    point2='$point2',
                    point3='$point3',
                    point4='$point4',
                    point5='$point5',
                    point6='$point6',
                    point7='$point7',
                    point8='$point8',
                    point9='$point9',
                    point10='$point10',
                    regular_price='$regular_price',
                    sale_price='$sale_price',
                    plan_type='$plan_type',
                    info_link='$info_link',
                                image='$image'
                WHERE id=$edit_id";
        if(mysqli_query($con, $sql)){
            $msg = "Course updated successfully!";
        } else {
            $msg = "Error: ".mysqli_error($con);
        }
    } else {
        // Insert new course
         $sql = "INSERT INTO courses (image, title, point1, point2, point3, point4, point5,point6,point7, point8, point9, point10, regular_price, sale_price, plan_type, info_link)
                VALUES ('$image','$title','$point1','$point2','$point3','$point4','$point5','$point6','$point7','$point8','$point9','$point10','$regular_price','$sale_price','$plan_type','$info_link')";
       
        if(mysqli_query($con, $sql)){
            $msg = "Course added successfully!";
        } else {
            $msg = "Error: ".mysqli_error($con);
        }
    }
}

// Fetch all courses
$courses = mysqli_query($con,"SELECT * FROM courses ORDER BY created_at DESC");
?>

<main class="dashboard-gssecurity-main" style="padding:20px;">
    <div class="dashboard-gssecurity-title" style="font-size:28px; margin-bottom:20px;">
        <?php echo $edit_mode ? "Edit Course" : "Create Course"; ?>
    </div>

    <?php if($msg){ echo "<p style='color:green;font-weight:bold; margin-bottom:15px;'>$msg</p>"; } ?>

    <!-- Add/Edit Form -->
    <div style="background:#fff; padding:25px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); max-width:800px; margin-bottom:40px;">
        <form action="" method="POST" enctype="multipart/form-data" style="display:grid; grid-gap:15px;">
            <label style="font-weight:bold;">Course Image</label>
            <input type="file" name="image" style="padding:8px; border-radius:5px; border:1px solid #ccc;">
            <?php if($edit_mode && $edit_data['image']){ ?>
                <img src="uploads/<?php echo $edit_data['image']; ?>" width="150" style="margin:10px 0; border-radius:5px; border:1px solid #ccc;">
            <?php } ?>

            <label style="font-weight:bold;">Course Title</label>
            <input type="text" name="title" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['title']) : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <?php for($i=1;$i<=10;$i++){ ?>
                <label style="font-weight:bold;">Point <?php echo $i; ?></label>
                <input type="text" name="point<?php echo $i; ?>" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['point'.$i]) : ''; ?>" style="padding:8px; border-radius:5px; border:1px solid #ccc;">
            <?php } ?>

            <div style="display:grid; grid-template-columns:1fr 1fr; grid-gap:15px;">
                <div>
                    <label style="font-weight:bold;">Regular Price</label>
                    <input type="number" name="regular_price" step="0.01" value="<?php echo $edit_mode ? $edit_data['regular_price'] : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
                <div>
                    <label style="font-weight:bold;">Sale Price</label>
                    <input type="number" name="sale_price" step="0.01" value="<?php echo $edit_mode ? $edit_data['sale_price'] : ''; ?>" required style="padding:8px; border-radius:5px; border:1px solid #ccc;">
                </div>
            </div>

            <label style="font-weight:bold;">Plan Type</label>
            <input type="text" name="plan_type" value="<?php echo $edit_mode ? htmlspecialchars($edit_data['plan_type']) : ''; ?>"  style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <!-- ✅ New Info Link Field -->
            <label style="font-weight:bold;">Info Link (optional)</label>
            <input type="text" name="info_link" placeholder="https://example.com/more-info" 
                   value="<?php echo $edit_mode ? htmlspecialchars($edit_data['info_link']) : ''; ?>" 
                   style="padding:8px; border-radius:5px; border:1px solid #ccc;">

            <button type="submit" style="background:#007BFF; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
                <?php echo $edit_mode ? "Update Course" : "Create Course"; ?>
            </button>
        </form>
    </div>

    <!-- Courses Table -->
    <div class="dashboard-gssecurity-title" style="font-size:28px; margin-bottom:15px;">All Courses</div>
    <table style="width:100%; border-collapse:collapse; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background:#007BFF; color:#fff; text-align:left;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Image</th>
                <th style="padding:12px;">Title</th>
                <th style="padding:12px;">Points</th>
                <th style="padding:12px;">Regular Price</th>
                <th style="padding:12px;">Sale Price</th>
                <th style="padding:12px;">Plan Type</th>
                <th style="padding:12px;">Info Link</th>
                <th style="padding:12px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($courses)>0): ?>
            <?php while($row=mysqli_fetch_assoc($courses)){ ?>
                <tr style="border-bottom:1px solid #ccc; transition:background 0.3s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                    <td style="padding:10px;"><?php echo $row['id']; ?></td>
                    <td style="padding:10px;"><img src="uploads/<?php echo $row['image']; ?>" width="80" style="border-radius:5px;"></td>
                    <td style="padding:10px;"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td style="padding:10px;">
                        <ul style="margin:0; padding-left:15px;">
                            <?php for($i=1;$i<=10;$i++){ ?>
                                <li><?php echo htmlspecialchars($row['point'.$i]); ?></li>
                            <?php } ?>
                        </ul>
                    </td>
                    <td style="padding:10px;">£<?php echo $row['regular_price']; ?></td>
                    <td style="padding:10px;">£<?php echo $row['sale_price']; ?></td>
                    <td style="padding:10px;"><?php echo $row['plan_type']; ?></td>
                    <td style="padding:10px;">
                        <?php if(!empty($row['info_link'])): ?>
                            <a href="<?php echo htmlspecialchars($row['info_link']); ?>" target="_blank" style="color:#007BFF; text-decoration:underline;">View</a>
                        <?php else: ?>
                            <span style="color:#999;">N/A</span>
                        <?php endif; ?>
                    </td>
                   <td style="padding:10px; display:flex; flex-wrap:wrap; gap:8px;">
                        <a href="?edit_id=<?php echo $row['id']; ?>" 
                           style="padding:6px 12px; background:orange; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold;">
                           Edit
                        </a>
                    
                        <a href="?delete_id=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this course?');"
                           style="padding:6px 12px; background:red; color:#fff; border-radius:5px; text-decoration:none; font-weight:bold;">
                           Delete
                        </a>
                    </td>

                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="9" style="text-align:center; padding:15px;">No courses found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>
