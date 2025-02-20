<?php
include "../../db/conf.php";

$res = new Response();

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $res->setStatusCode(405);
        throw new Exception("Method not allowed");
    }

    session_start();

    // if already logged-in return error
    if (isset($_SESSION["es11"])) {
        $res->setStatusCode(303);
        throw new Exception("Already logged-in. Please logout before trying to log-in again");
    }

    // preparing sql statement
    $sql = "SELECT * FROM utenti AS u WHERE u.username = '" . $_POST["username"] . "';";

    // querying db
    $result = $conn->query($sql);

    $user = $result->fetch_assoc();
    if (!$user) {
        $res->setStatusCode(404);
        throw new Exception($conn->error);
    }

    // verify password match
    if (!password_verify($_POST["password"], $user["password"])) {
        $res->setStatusCode(401);
        throw new Exception("Invalid credentials");
    }

    // create session (without password)
    $_SESSION["es11"] = [
        "id" => $user["id"],
        "username" => $user["username"],
        "isAdmin" => false
    ];

    // automatically verify whether user is an admin or not
    $sql = "SELECT * FROM admin AS u WHERE id = " . $user["id"] . ";";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $_SESSION["es11"]["isAdmin"] = true;
    }
    
    $res->setStatusCode(200)
        ->redirect("/Es11_PHP/index.php")
        ->send();
    echo json_encode(["success" => "User logged successfully"]);
} catch(Exception $ex) {
    $res->redirect("/Es11_PHP/pages/auth/login.php")
        ->send();
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>