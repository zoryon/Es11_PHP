<?php
session_start();

if (!isset($_SESSION["es11"]) || $_SESSION["es11"]["isAdmin"] === false) {
    // 404 code -> Not Found -> instead of a 303, 'cause an idea of the admin's endpoints should not be given to everyone
    header("Location: ../not-found.html");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promote To Admin Page</title>
</head>

<body>
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