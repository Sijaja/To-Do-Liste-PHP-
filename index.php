<?php
session_start();

require_once __DIR__ . "/../../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST["add"])) {
    $text = htmlspecialchars($_POST["text"]);
    $category = $_POST["category"];
    $priority = $_POST["priority"];

    $stmt = $conn->prepare("INSERT INTO tasks (text, category, priority, done, user_id) VALUES (?, ?, ?, 0, ?)");
    $stmt->bind_param("sssi", $text, $category, $priority, $user_id);
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

$stmt2 = $conn->prepare('SELECT user_name FROM users WHERE id = ?');
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$users = $stmt2->get_result();
$row = $users->fetch_assoc();
$username = $row['user_name'];

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

function matchesFilter($task, $filter)
{
    if ($filter === 'all')
        return true;
    if ($filter === 'done')
        return $task['done'];
    if ($filter === 'open')
        return !$task['done'];
    return $task['category'] === $filter || $task['priority'] === $filter;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Aufgaben Planer V0.4</title>
</head>

<body>
    <div class="sideBanner">
        <div class="photo">
            <form method="post">
                <img src="./img/ap_profile.png" height="100" width="100" id="profilePic">
            </form>
        </div>
        <div class="divText">
            <h5><?= htmlspecialchars($username) ?></h5>
        </div>
        <form method="post">
            <div>
                <button id="side" name="profile">Profile</button>
                <button id="side" name="settings">Settings</button>
                <button id="side" name="about">about</button>
                <button id="side" name="logout">sign out</button>
            </div>
        </form>
    </div>
    <div class="container">
        <form method="post">
            <h3>Aufgaben Planer V0.4</h3>
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
                                        <button name="done" id="tableButton" value="<?= $task['id'] ?>">Erledigt</button>
                                    <?php endif; ?>
                                    <button name="delete" id="tableButton" value="<?= $task['id'] ?>">Löschen</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">noch keine Aufgaben!</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>

</html>