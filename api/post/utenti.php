<?php
header("Content-Type: application/json");

include "../db/conf.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit("Request error.");
}

try {
    $userType = isset($_POST["user_type"]) ? $_POST["user_type"] : "utenti";
    if ($userType !== "admin" && $userType !== "utenti") {
        throw new Exception($conn->error);
    }

    $sql = "SELECT * FROM utenti AS u WHERE u.username = '" . $_POST["username"] . "';";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $user = $result->fetch_assoc();

    if (!$user) {
        throw new Exception($conn->error);
    }

    if (!password_verify($_POST["password"], $user["password"])) {
        throw new Exception($conn->error);
    }

    // verify user is an admin, if selected
    if ($userType === "admin") {
        $userId = $user["id"];

        $sql = "SELECT * FROM admin AS u WHERE id = " . $userId;
        $resultIsAdmin = $conn->query($sql);

        if (!$resultIsAdmin || $resultIsAdmin->num_rows !== 1) {
            throw new Exception("Not authorized");
        }
    }

    setcookie('authorised', 'true', time() + 3600, "/");     
    echo json_encode(["success" => "User logged successfully"]);

    header("Location: /Es11_PHP/");
} catch(Exception $ex) {
    echo json_encode(["error" => "Database error: " . $ex->getMessage()]);
    header("Location: /Es11_PHP/pages/auth/login.html");
}
?>