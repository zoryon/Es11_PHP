<?php 
include "../../db/conf.php";

session_start();

$res = new Response();

try {
    if (!isset($_SESSION["es11"])) {
        $res->setStatusCode(401);
        throw new Exception("User is not logged-in");
    }

    session_destroy();

    $res->setStatusCode(200)
        ->redirect("/Es11_PHP/pages/auth/login.php")
        ->send();
    echo json_encode(["success" => "User successfully logged-out"]);
} catch(Exception $ex) {
    $res->redirect("/Es11_PHP/index.php")
        ->send();
    echo json_encode(["success" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>