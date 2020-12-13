<?php
include "user-pdo.php";
// include "user.php";

$user = new user("'mysql:host=localhost;dbname=classes', 'root', ''");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // var_dump($user->register('etienne31', 'dahooo', 'adri.@grogj.de', 'etienne', 'januski'));
    // echo $user->connect('etienne31', 'dahooo');
    var_dump($user->isConnected());

    ?>
</body>

</html>