<?php 
header("Content-Type: application/json");

include "../db/conf.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Request error");
}

try {
    // if user is not an admin, return 404 (not found)
    if (!isset($_SESSION["es11"]) || $_SESSION["es11"]["isAdmin"] === false) {
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }

    // check whether user exists
    $sql = "SELECT * FROM utenti AS u WHERE u.username = '". $_POST["username"] . "';";

    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if (!$user) {
        throw new Exception("No user was found");
    }

    // check whether user is already an admin
    $sql = "SELECT * FROM admin AS a WHERE a.id = ". $user["id"] . ";";

    $result = $conn->query($sql);
    $isAdmin = $result->fetch_assoc();

    if ($isAdmin) {
        throw new Exception("User is already an admin");
    }

    // promote user to admin by inserting id into admin table
    $sql = "INSERT INTO admin(id) VALUES(" . $user["id"] . ")";
    $result = $conn->query($sql);

    $res = $result->fetch_assoc();

    if (!$res) {
        throw new Exception("Insert failed");
    }

    echo json_encode(["success" => "Admin role was given successfully"]);
} catch(Exception $ex) {
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
    header("Location: /Es11_PHP/pages/admin/new-admin.html");
}
?>