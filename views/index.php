<?php

use App\{WeatherCurrently, WeatherForecasts};

/** @var WeatherCurrently | WeatherForecasts $weatherReport */
/** @var string $type */

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
<link rel="stylesheet" href="/styles/styles.css">
<body>
<div id="container">
    <div id="top">
        <header id="navigation">
            <span id="headerText">Weather report</span>
            <span id="selectCity">
                <a href="/?location=Riga&type=current">Riga</a> |
                <a href="/?location=Vilnius&type=current">Vilnius</a> |
                <a href="/?location=Tallinn&type=current">Tallinn</a><br>
            </span>
        </header>
        <form id="locationForm" action="/" method="get">
            <label for="location">Location:<br></label>
            <input id="inputBox" type="text" name="location" id="location" value="<?= $location ?? "Riga" ?>" required>
            <br>
            <input class="submitButton" type="submit" name="type" value="current" accesskey="c">
            <input class="submitButton" type="submit" name="type" value="forecast" accesskey="v">
        </form>
    </div>
    <div id="content">
        <?php
                if (isset($openWeatherMap)) {
        require_once "views/partials/" . ucfirst($type) . "WeatherTable.php";
                }
        ?>
    </div>
    <div id='end'>
        <?php if (isset($weatherReport)) { ?>
            <footer id="timeWhenRetrieved">Weather data retrieved at <?= $weatherReport->getTime() ?> location time
            </footer>
        <?php } ?>
    </div>
</div>
</body>
</html>