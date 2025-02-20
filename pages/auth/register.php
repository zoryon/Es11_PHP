<?php
// users should not register again if they're already logged in
session_start();

if (isset($_SESSION["es11"])) {
    http_response_code(303);
    header("Location: /Es11_PHP/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- style links -->
    <link rel="stylesheet" href="../../assets/css/globals.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="/Es11_PHP/">Home</a>
            </li>
            <li>
                <a href="/Es11_PHP/pages/autori.html">Autori</a>
            </li>
        </ul>
    </nav>

    <div class="header">
        <h1>Register</h1>
        <a href="./login.php">already have an account?</a>
    </div>
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