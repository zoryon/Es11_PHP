<?php
include "../db/conf.php";

$res = new Response();

try {
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        $res->setStatusCode(405);
        throw new Exception("Method Not Allowed"); 
    }

    $sql = "SELECT * FROM concerti";
    $result = $conn->query($sql);
    
    if (!$result) {
        $res->setStatusCode(500);
        throw new Exception($conn->error);
    }

    $concerti = $result->fetch_all(MYSQLI_ASSOC);

    $res->setStatusCode(200)
        ->send();
    echo json_encode($concerti);
} catch(Exception $ex) {
    $res->send();
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>