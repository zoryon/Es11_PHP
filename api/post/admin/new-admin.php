<?php 
include "../../db/conf.php";

session_start();

$res = new Response();

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $res->setStatusCode(405);
        throw new Exception("Method not allowed");
    }

    // if user is not an admin, return 404 (not found)
    if (!isset($_SESSION["es11"]) || $_SESSION["es11"]["isAdmin"] === false) {
        $res->setStatusCode(404);
        throw new Exception("Not found");
    }

    // check whether user exists
    $sql = "SELECT * FROM utenti AS u WHERE u.username = '". $_POST["username"] . "';";

    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        $res->setStatusCode(404);
        throw new Exception("No user was found");
    }

    // check whether user is already an admin
    $sql = "SELECT * FROM admin AS a WHERE a.id = ". $user["id"] . ";";

    $result = $conn->query($sql);
    $isAdmin = $result->fetch_assoc();

    if ($isAdmin) {
        $res->setStatusCode(500);
        throw new Exception("User is already an admin");
    }

    // promote user to admin by inserting id into admin table
    $sql = "INSERT INTO admin(id) VALUES(" . $user["id"] . ")";
    $result = $conn->query($sql);

    if (!$result) {
        $res->setStatusCode(500);
        throw new Exception("Insert failed");
    }

    $res->setStatusCode(200)
        ->redirect("/Es11_PHP/pages/admin/new-admin.php")
        ->send();
    echo json_encode(["success" => "Admin role was given successfully"]);
} catch(Exception $ex) {
    $res->redirect("/Es11_PHP/pages/admin/new-admin.php")
        ->send();
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>