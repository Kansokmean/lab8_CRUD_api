<?php
require_once 'config/database.php';
require_once 'library/library.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    echo json_encode(["status" => "error", "message" => "Only DELETE requests are allowed"]);
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Student ID is required"]);
    exit;
}
$tbname = 'students';
$labeight = new labEight();

$deleteResult = $labeight->delete($tbname, ['id' => $id]);
if ($deleteResult) {
    echo json_encode(["result" => true, "message" => "Student deleted successfully"]);
} else {
    echo json_encode(["result" => false, "message" => "Failed to delete student"]);
}

?>
