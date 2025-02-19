<?php
header("Content-Type: application/json");

include "../../db/conf.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit("Request error");
}

try {
    session_start();

    // if already logged-in return error
    if (isset($_SESSION["es11"])) {
        throw new Exception("Already logged-in. Please logout before trying to log-in again");
    }

    // preparing sql statement
    $sql = "SELECT * FROM utenti AS u WHERE u.username = '" . $_POST["username"] . "';";

    // querying db
    $result = $conn->query($sql);

    $user = $result->fetch_assoc();
    if (!$user) {
        throw new Exception($conn->error);
    }

    // verify password match
    if (!password_verify($_POST["password"], $user["password"])) {
        throw new Exception("Invalid credentials");
    }

    // create session (without password)
    $_SESSION["es11"] = [
        "id" => $user["id"],
        "username" => $user["username"],
    ];

    // automatically verify whether user is an admin or not
    $sql = "SELECT * FROM admin AS u WHERE id = " . $user["id"];
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $_SESSION["es11"]["isAdmin"] = true;
    }
    
    echo json_encode(["success" => "User logged successfully"]);
    header("Location: /Es11_PHP/");
} catch(Exception $ex) {
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
    header("Location: /Es11_PHP/pages/auth/login.html");
}
?>