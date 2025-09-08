<?php
$servername = "localhost";  
$username   = "sijajhit_aufgabe";  
$password   = "LAWhajadida19((";  
$dbname     = "sijajhit_aufgabenplaner";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["add"])) {
    $text = htmlspecialchars($_POST["text"]);
    $category = $_POST["category"];
    $priority = $_POST["priority"];

    $stmt = $conn->prepare("INSERT INTO tasks (text, category, priority, done) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("sss", $text, $category, $priority);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST["done"])) {
    $id = intval($_POST["done"]);
    $conn->query("UPDATE tasks SET done = 1 WHERE id = $id");
}

if (isset($_POST["delete"])) {
    $id = intval($_POST["delete"]);
    $conn->query("DELETE FROM tasks WHERE id = $id");
}

$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';

$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

function matchesFilter($task, $filter) {
    if ($filter === 'all') return true;
    if ($filter === 'done') return $task['done'];
    if ($filter === 'open') return !$task['done'];
    return $task['category'] === $filter || $task['priority'] === $filter;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Aufgaben Planer V0.2</title>
</head>
<body>
<div class="container">

    <form method="post">
        <h3>Aufgaben Planer V0.2</h3>
        <label for="text">Aufgabe:</label>
        <input name="text" placeholder="Aufgabe" required>
        <div class="properties">
            <select id="category" name="category">
                <option value="Arbeit">Arbeit</option>
                <option value="Privat">Privat</option>
                <option value="Schule">Schule</option>
            </select>
            <select name="priority" id="priority">
                <option value="hoch">hoch</option>
                <option value="mittel">mittel</option>
                <option value="niedrig">niedrig</option>
            </select>
        </div>
        <button type="submit" name="add">Aufgabe hinzufügen</button>
    </form>

    <br>

    <form method="post">
        <div name="filter" class="properties">
            <label for="filter">Filter nach:</label>
            <select name="filter" id="filter">
                <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Alle</option>
                <option value="done" <?= $filter === 'done' ? 'selected' : '' ?>>nur erledigte</option>
                <option value="open" <?= $filter === 'open' ? 'selected' : '' ?>>nur offene</option>
                <option value="Arbeit" <?= $filter === 'Arbeit' ? 'selected' : '' ?>>Arbeit</option>
                <option value="Privat" <?= $filter === 'Privat' ? 'selected' : '' ?>>Privat</option>
                <option value="Schule" <?= $filter === 'Schule' ? 'selected' : '' ?>>Schule</option>
                <option value="hoch" <?= $filter === 'hoch' ? 'selected' : '' ?>>hoch</option>
                <option value="mittel" <?= $filter === 'mittel' ? 'selected' : '' ?>>mittel</option>
                <option value="niedrig" <?= $filter === 'niedrig' ? 'selected' : '' ?>>niedrig</option>
            </select>
            <button>anwenden</button><br>
        </div>
    </form>

    <h3>Aufgabenliste</h3>
    <table>
        <tr>
            <th>Aufgabe</th>
            <th>Kategorie</th>
            <th>Priorität</th>
            <th>Status</th>
            <th>Aktionen</th>
        </tr>

        <?php if (count($tasks) > 0): ?>
            <?php foreach ($tasks as $task): ?>
                <?php if (matchesFilter($task, $filter)): ?>
                    <tr class="<?= $task['done'] ? 'done' : '' ?>">
                        <td><?= htmlspecialchars($task['text']) ?></td>
                        <td><?= htmlspecialchars($task['category']) ?></td>
                        <td><?= htmlspecialchars($task['priority']) ?></td>
                        <td><?= $task['done'] ? 'Erledigt' : 'Offen' ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <?php if (!$task['done']): ?>
                                    <button name="done" value="<?= $task['id'] ?>">Erledigt</button>
                                <?php endif; ?>
                                <button name="delete" value="<?= $task['id'] ?>">Löschen</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">noch keine Aufgaben!</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>