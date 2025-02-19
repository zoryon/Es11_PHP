<?php
header("Content-Type: application/json");

include "../db/conf.php";

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    exit("Request error.");
}

try {
    $sql = "SELECT * FROM concerti";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception($conn->error);
    }

    $concerti = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($concerti);
} catch(Exception $ex) {
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>