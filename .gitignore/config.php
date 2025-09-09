<?php
$servername = "localhost";
$username = "sijajhit_aufgabe";
$password = "LAWhajadida19((";
$dbname = "sijajhit_aufgabenplaner";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
