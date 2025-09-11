<?php
session_start();

require_once __DIR__ . "/../../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    $last = date("Y-m-d");
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("UPDATE users SET `last_log` = ? WHERE id = ?");
    $stmt->bind_param("si", $last, $user_id);
    $stmt->execute();
    $stmt->close();
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
    $conn->query("INSERT INTO deleted (text, category, priority, done, user_id) SELECT text, category, priority, done, user_id FROM tasks where id = $id");
    $conn->query("DELETE FROM tasks WHERE id = $id");
}

if (isset($_POST["restore"])) {
    $id = intval($_POST["restore"]);
    $conn->query("INSERT INTO tasks (text, category, priority, done, user_id) SELECT text, category, priority, done, user_id FROM deleted where id = $id");
    $conn->query("DELETE FROM deleted WHERE id = $id");
}

if (isset($_POST["bigdelete"])) {
    $id = intval($_POST["bigdelete"]);
    $conn->query("DELETE FROM deleted WHERE id = $id");
}

$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';

$stmt2 = $conn->prepare('SELECT user_name, since, last_log FROM users WHERE id = ?');
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$users = $stmt2->get_result();
$row = $users->fetch_assoc();
$username = $row['user_name'];
$since = $row['since'];
$last = $row['last_log'];

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

$stmt = $conn->prepare("SELECT * FROM deleted WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$deleted = [];
while ($row = $result->fetch_assoc()) {
    $deleted[] = $row;
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

function matchesFilterArchiv($delete, $filter)
{
    if ($filter === 'all')
        return true;
    if ($filter === 'done')
        return $delete['done'];
    if ($filter === 'open')
        return !$delete['done'];
    return $delete['category'] === $filter || $delete['priority'] === $filter;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Aufgaben Planer V0.4</title>
</head>

<body>
    <div class="topBanner">
        <div class="divText">
            <div class="photo">
                <img src="./img/ap_profile.png" height="100" width="100" id="profilePic">
            </div>
            <div class="infos">
                <h5><?= htmlspecialchars($username) ?></h5>
                <h6>Mitglied seit: <?= htmlspecialchars($since) ?><br>
                    Letzter Login: <?= htmlspecialchars($last) ?></h6>
            </div>
        </div>
        <div class="buttons">

            <div id="top">
                <button id="profile" name="profile">Archiv</button>
                <button id="side" name="settings">Settings</button>
                <button id="side" name="about">about</button>
                <form method="post" style="display:inline;">
                    <button id="side" name="logout">abmelden</button>
                </form>
            </div>
        </div>
    </div>
    <div id="tasks" class="container">
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
    <div id="profileview" class="container">
        <h3>gelöschte Aufgaben</h3>
        <table>
            <tr>
                <th>Aufgabe</th>
                <th>Kategorie</th>
                <th>Priorität</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>

            <?php if (count($deleted) > 0): ?>
                <?php foreach ($deleted as $delete): ?>
                    <?php if (matchesFilterArchiv($delete, $filter)): ?>
                        <tr class="<?= $task['done'] ? 'done' : '' ?>">
                            <td><?= htmlspecialchars($delete['text']) ?></td>
                            <td><?= htmlspecialchars($delete['category']) ?></td>
                            <td><?= htmlspecialchars($delete['priority']) ?></td>
                            <td><?= $delete['done'] ? 'Erledigt' : 'Offen' ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <?php if (!$delete['done']): ?>
                                        <button name="restore" id="tableButton" value="<?= $delete['id'] ?>">Restore</button>
                                    <?php endif; ?>
                                    <button name="bigdelete" id="tableButton" value="<?= $delete['id'] ?>">Löschen</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#profileview").hide();
        $("#profile").on("click", function () {
            $("#tasks").toggle();
            $("#profileview").toggle();
        });
    </script>
</body>

</html>