<?php
include "../../db/conf.php";

$res = new Response();

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $res->setStatusCode(405);
        throw new Exception("Method not allowed");
    }
    
    $hashedPasswd = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // preparing sql statement
    $sql = "INSERT INTO utenti(username, password) VALUES('". $_POST["username"] . "', '" . $hashedPasswd . "')";

    // querying db
    $result = $conn->query($sql);

    if (!$result) {
        $res->setStatusCode(500);
        throw new Exception("Insert failed");
    }

    $res->setStatusCode(200)
        ->redirect("/Es11_PHP/pages/auth/login.php")
        ->send();
    echo json_encode(["success" => "User was registered successfully"]);
} catch(Exception $ex) {
    $res->redirect("/Es11_PHP/pages/auth/register.php")
        ->send();
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
} finally {
    $conn->close();
}

exit();
?>