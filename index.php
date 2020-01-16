<?php
require "include/db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main site</title>
</head>
<body>
    <i>
    <?php
        try{
            $connection = new PDO($dsn, $username, $password, $options);
            echo 'connection successful';

        } catch(PDOException $e) {
            echo 'connection failed';
        }     

    ?>
    </i>
</body>
</html>