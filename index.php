<?php

require_once 'vendor/autoload.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>&#9748Weather Report</title>
    <?php if (!isset($_GET["location"]) || ($_GET["type"] !== "current" && $_GET["type"] !== "forecast"))
        echo '<meta http-equiv="refresh" content="0; url=/?location=Riga&type=current"/>'?>
</head>
<link rel="stylesheet" href="styles/index.css">
<body>
<div id="container">
    <div id="top">
        <?php require_once 'partials/header.php' ?>
        <br>
        <?php require_once 'partials/inputLocation.php' ?>
    </div>
    <div id="content">
        <?php require_once 'partials/weatherTable.php' ?>
    </div>
</div>
</body>
</html>