<?php
session_start();

if (!isset($_SESSION["es11"]) || $_SESSION["es11"]["isAdmin"] === false) {
    // 404 code -> Not Found -> instead of a 303, 'cause an idea of the admin's endpoints should not be given to everyone
    http_response_code(404);
    header("Location: ../not-found.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- style links -->
    <link rel="stylesheet" href="../../assets/css/globals.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promote To Admin Page</title>
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
        
        <?php 
        if (isset($_SESSION["es11"])) {
            echo '<a href="/Es11_PHP/api/get/utenti/logout_utente.php">Logout</a>';
        } else {
            echo '<a href="/Es11_PHP/pages/auth/login.php">Login</a>';
        }
        ?>
    </nav>

    <form action="../../api/post/admin/new-admin.php" method="POST">
        <div>
            <label for="username">Username to promote to admin</label>
            <input id="username" name="username" type="text">
        </div>
        <button type="submit">
            promote
        </button>
    </form>
</body>

</html>