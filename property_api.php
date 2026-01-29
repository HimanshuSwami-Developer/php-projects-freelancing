<?php
header('Content-Type: application/json');
require_once __DIR__ . "/config/db.php";


$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT 
    id,
    title,
    room_type,
    property_type,
    location,
    type,
    beds,
    baths,
    area,
    image_thumbnail,
    images_gallery,
    status,
    rating,
    description,
    created_at
FROM properties
ORDER BY created_at DESC";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {

    $data[] = [
        "id" => (int)$row['id'],
        "title" => $row['title'],
        "room_type" => $row['room_type'],
        "property_type" => $row['property_type'],
        "location" => $row['location'],
        "type" => $row['type'],
        "beds" => (int)$row['beds'],
        "baths" => (int)$row['baths'],
        "area" => (int)$row['area'],
        "image_thumbnail" => $row['image_thumbnail'],
        "images_gallery" => json_decode($row['images_gallery'], true), // IMPORTANT
        "status" => $row['status'],
        "rating" => (float)$row['rating'],
        "description" => $row['description'],
        "created_at" => $row['created_at']
    ];
}

echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
