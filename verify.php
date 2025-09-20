<?php
require 'db.php';
$token = $_GET['token'] ?? '';
$stmt = $pdo->prepare('SELECT id FROM users WHERE verification_token=? AND verified=0');
$stmt->execute([$token]);
if ($user = $stmt->fetch()) {
    $upd = $pdo->prepare('UPDATE users SET verified=1, verification_token=NULL WHERE id=?');
    $upd->execute([$user['id']]);
    echo "Your account is verified! <a href='login.php'>Login now</a>";
} else {
    echo "Invalid or already-used token.";
}
?>