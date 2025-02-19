<?php
// users should not register again if they're already logged in
session_start();

if (isset($_SESSION["es11"])) {
    http_response_code(303);
    header("Location: ../../index.html");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>

<body>
    <form action="../../api/post/utenti/register_utente.php" method="POST">
        <div>
            <label for="username">Username</label>
            <input id="username" name="username" type="text">
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password">
        </div>
        <button type="submit">
            send
        </button>
    </form>
</body>

</html>