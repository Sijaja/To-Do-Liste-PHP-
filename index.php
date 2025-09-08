<?php
session_start();
if (!isset($_SESSION["tasks"])) {
    $_SESSION["tasks"] = [];
}
if (isset($_POST["add"])) {
    $task = [
        "id" => uniqid(),
        "text" => htmlspecialchars($_POST["text"]),
        "category" => $_POST["category"],
        "priority" => $_POST["priority"],
        "done" => false
    ];
    $_SESSION["tasks"][] = $task;
}

if (isset($_POST["done"])) {
    foreach ($_SESSION["tasks"] as &$task) {
        if ($task["id"] === $_POST["done"]) {
            $task["done"] = true;
        }
    }
    unset($task);
}
if (isset($_POST['delete'])) {
    $_SESSION['tasks'] = array_filter($_SESSION['tasks'], function ($task) {
        return $task['id'] !== $_POST['delete'];
    });
}
$filter = $_POST['filter'] ?? 'all';

function matchesFilter($task, $filter)
{
    if ($filter === 'all')
        return true;
    if ($filter === 'done')
        return $task['done'];
    if ($filter === 'open')
        return !$task['done'];
    if ($filter === 'category')
        return $task['Arbeit'];
    if ($filter === 'category')
        return $task['Privat'];
    if ($filter === 'category')
        return $task['Schule'];
    if ($filter === 'priority')
        return $task['hoch'];
    if ($filter === 'priority')
        return $task['mittel'];
    if ($filter === 'priority')
        return $task['niedrig'];
    return $task['category'] === $filter || $task['priority'] === $filter;
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Contact me</title>
</head>

<body>
    <div class="container">
        <form method="post">
            <h3>Aufgaben Planer V0.1</h3>
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

            <?php foreach ($_SESSION['tasks'] as $task): ?>

                <?php if (matchesFilter($task, $filter)): ?>

                    <tr class="<?= $task['done'] ? 'done' : '' ?>">

                        <td><?= $task['text'] ?></td>

                        <td><?= $task['category'] ?></td>

                        <td><?= $task['priority'] ?></td>

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
        </table>
    </div>
</body>

</html>