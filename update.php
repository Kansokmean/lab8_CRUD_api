<?php
require_once 'config/database.php';
require_once 'library/library.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Only POST requests are allowed"]);
    exit;
}

// param
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// form-data
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
$class = isset($_POST['class']) ? $_POST['class'] : null;
$major = isset($_POST['major']) ? $_POST['major'] : null;

if (!$id || !$first_name || !$last_name || !$class || !$major) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}
$tbname = 'students';
$labeight = new labEight();
$updateData = [
    "first_name" => $first_name,
    "last_name" => $last_name,
    "class" => $class,
    "major" => $major
];
$updateResult = $labeight->update($tbname, $updateData, ["id" => $id]);
if ($updateResult) {
    echo json_encode(["result" => true, "message" => "Student updated successfully"]);
} else {
    echo json_encode(["result" => false, "message" => "Failed to update student"]);
}
?>
