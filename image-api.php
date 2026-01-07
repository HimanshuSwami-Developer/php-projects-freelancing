<?php
include 'admin/assets/config/db.php';

// Initialize image variable
$image = 'admin/media/placeholder.png';

if (isset($_GET['course_name'])) {
    // Sanitize and escape the input to prevent SQL injection
    $courseName = mysqli_real_escape_string($con, $_GET['course_name']);

    // Prepare and execute the query safely
    $res = mysqli_query($con, "SELECT image FROM courses WHERE title='$courseName'");
    
    if ($res === false) {
        // Handle query error
        error_log("Database query failed: " . mysqli_error($con));
    } elseif (mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);
        $imageFile = $data['image'];

        // Check if file exists on server
        $image = (!empty($imageFile) && file_exists('admin/uploads/' . $imageFile)) 
                 ? 'admin/uploads/' . $imageFile 
                 : 'admin/media/placeholder.png';
    }
    
    // Free the result set
    if (is_resource($res)) {
        mysqli_free_result($res);
    }
}

echo json_encode(['image' => $image]);
exit;