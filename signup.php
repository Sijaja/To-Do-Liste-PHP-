<?php
session_start();
require_once __DIR__ . "/../../config.php";

if (isset($_POST["signup"])) {
    $uname = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $pword = htmlspecialchars($_POST["password"]);

    $check = $conn->prepare("SELECT id FROM users WHERE user_name = ?");
    $check->bind_param("s", $uname);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Benutzername bereits vergeben!";
    } else {
        $hash = password_hash($pword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (user_name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uname, $email, $hash);

        if ($stmt->execute()) {
            $success = "Konto erfolgreich erstellt! <a href='login.php'>Zum Login</a>";
        } else {
            $error = "Fehler beim Erstellen des Kontos!";
        }
        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Signup | Aufgaben Planer V0.3</title>
</head>

<body>
    <div class="smallContainer">
        <form method="post">
            <h3>Aufgaben Planer V0.3</h3>
            <h4>neue Konto erstellen</h4>
            <?php if (!empty($error)): ?>
                <p id="center" style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p id="center" style="color:green;"><?= $success ?></p>
            <?php endif; ?>
            <input type="text" name="username" placeholder="username" required>
            <input type="email" name="email" placeholder="example@email.com">
            <input type="password" name="password" placeholder="password" required>
            <button type="submit" name="signup">Signup</button>
            <a href="login.php">Konto vorhanden? zum Login</a>
        </form>
    </div>
</body>

</html>