<?php
session_start();
require_once __DIR__ . "/../../config.php";

/* $hash = password_hash("1234", PASSWORD_DEFAULT);
$create = $conn->prepare("INSERT INTO users (user_name, password_hash) VALUES ('ibisacam', '$hash')");
$create->execute(); */

if (isset($_POST["login"])) {
    $uname = htmlspecialchars($_POST["username"]);
    $pword = htmlspecialchars($_POST["password"]);

    $hash = password_hash($pword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pword, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $uname;
            header("Location: index.php");
            exit;
        } else {
            $error = "Falsches Passwort!";
        }
    } else {
        $error = "Benutzer nicht gefunden!";
    }
    $stmt->close();

}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Login | Aufgaben Planer V0.4</title>
</head>

<body>
    <div class="smallContainer">
        <form method="post">
            <h3>Aufgaben Planer V0.4</h3>
            <h4>User Login</h4>
            <?php if (!empty($error)): ?>
                <p id="center" style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <button type="submit" name="login">login</button>
            <div class="links">
                <a href="resetpw.php">Passwort vergessen?</a>
                <a href="signup.php">Konto erstellen</a>
            </div>
        </form>
    </div>
</body>

</html>