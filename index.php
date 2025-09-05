<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Contact me</title>
</head>

<body>
    <div class="container">
        <form>
            <h3>Neue Aufgabe hinzufügen</h3>
            <label for="name">Aufgabe:</label>
            <input type="text" id="name" placeholder="enter the title of your task here">
            <div class="properties">
                <select id="category" placeholder="enter your email here">
                    <option value="Arbeit">Arbeit</option>
                    <option value="Privat">Privat</option>
                    <option value="Schule">Schule</option>
                </select>
                <select type="text" id="priority" placeholder="enter your email here">
                    <option value="hoch">hoch</option>
                    <option value="mittel">mittel</option>
                    <option value="niedrig">niedrig</option>
                </select>
            </div>
            <br>
            <button type="submit">Aufgabe hinzufügen</button>
        </form>
    </div>
</body>

</html>