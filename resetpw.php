<?php
session_start();
require_once __DIR__ . "/../../config.php";

if (isset($_POST["send"])) {
    $email = htmlspecialchars($_POST["email"]);

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $error = "email nicht gefunden!";
    } else {
        $subject = "reset password link | Aufgaben planer";
        $message = "";
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Reset Password | Aufgaben Planer V0.3</title>
</head>

<body>
    <div class="smallContainer">
        <form method="post">
            <h3>Aufgaben Planer V0.3</h3>
            <h4>Reset Password</h4>
            <?php if (!empty($error)): ?>
                <p id="center" style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <input type="email" name="email" placeholder="email">
            <button type="submit" name="send">Send link</button>
            <a href="login.php">zuruck zum Login</a>
        </form>
    </div>
</body>

</html>