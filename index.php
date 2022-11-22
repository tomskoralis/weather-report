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
</head>
<link rel="stylesheet" href="styles/index.css">
<body>
<?php if (!isset($_GET["location"]) || ($_GET["type"] !== "current" && $_GET["type"] !== "forecast"))
    echo '<meta http-equiv="refresh" content="0; url=/?location=Riga&type=current"/>'?>
<div id="container">
    <div id="top">
        <header>
            <nav>Select a location:
                <a href="/?location=Riga&type=current">Riga</a> |
                <a href="/?location=Vilnius&type=current">Vilnius</a> |
                <a href="/?location=Tallinn&type=current">Tallinn</a><br>
            </nav>
        </header>
        <br>
        <form action="/" method="get">
            <label for="location">Other location:<br></label>
            <input type="text" name="location" id="location" value="<?= $_GET['location'] ?? "Riga" ?>"> <br>
            <input type="radio"
                   name="type"
                   id="current"
                   value="current"
                <?= (isset($_GET['type']) && $_GET['type'] !== "forecast") ? "checked" : "" ?>
            >
            <label for="current">current</label>
            <input type="radio"
                   name="type"
                   id="forecast"
                   value="forecast"
                <?= (isset($_GET['type']) && $_GET['type'] === "forecast") ? "checked" : "" ?>
            >
            <label for="forecast">forecast</label>
            <input type="submit" value="Send">
        </form>
    </div>
    <div id="content">
        <?php require_once 'partials/weatherTable.php' ?>
    </div>
</div>
</body>
</html>