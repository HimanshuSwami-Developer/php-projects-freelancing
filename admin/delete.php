<?php 
include("assets/config/db.php");

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($con,"DELETE FROM courses WHERE id=$id");
}

header("Location: index.php");
exit;
