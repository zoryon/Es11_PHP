<!DOCTYPE html>
<html lang="en">

<head>
    <!-- style links -->
    <link rel="stylesheet" href="./assets/css/globals.css">

    <!-- scripts -->
    <script src="./assets/js/getConcerti.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
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
        session_start();
        if (isset($_SESSION["es11"])) {
            echo '<a href="/Es11_PHP/api/get/utenti/logout_utente.php">Logout</a>';
        } else {
            echo '<a href="/Es11_PHP/pages/auth/login.php">Login</a>';
        }
        ?>
    </nav>

    <table id="concertiWrapper"></table>
</body>

</html>