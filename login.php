<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "4659802";
$dbname = "sijajhit_aufgabenplaner";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
            header("Location: index_V0.2.php");
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
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Login | Aufgaben Planer V0.2</title>
</head>

<body>
    <div class="smallContainer">
        <form method="post">
            <h3>Aufgaben Planer V0.2</h3>
            <h4>User Login</h4>
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <button type="submit" name="login">login</button>
        </form>
    </div>
</body>

</html>