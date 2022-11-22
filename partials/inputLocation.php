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