<?php
$conn = mysqli_connect("localhost", "root", "", "test");
session_start();
$result = $conn->query("SELECT * FROM student WHERE Id =" . $_SESSION['id']);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
//echo $result;
?>