<?php
// require 'db.php';
// $error = $success = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $username = trim($_POST['username']);
//     $email = trim($_POST['email']);
//     $password = trim($_POST['password']);
//     $token = bin2hex(random_bytes(32));
//     $hash = password_hash($password, PASSWORD_DEFAULT);

//     // Insert user
//     $stmt = $pdo->prepare('INSERT INTO users (username,email,password_hash,verification_token) VALUES (?,?,?,?)');
//     $stmt->execute([$username, $email, $hash, $token]);
//     // Send email
//     $link = "http://yourdomain.com/verify.php?token=$token";
//     mail($email, "Verify your account", "Click the link: $link");
//     $success = "Check your email to verify your account!";
// }
require 'db.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        $error = "Please fill in all fields.";
    } else {
        // Check duplicate username or email
        $check = $pdo->prepare('SELECT id FROM users WHERE username=? OR email=?');
        $check->execute([$username, $email]);
        if ($check->fetch()) {
            $error = "That username or email is already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare(
                'INSERT INTO users (username,email,password_hash,verification_token) VALUES (?,?,?,?)'
            );
            $stmt->execute([$username, $email, $hash, $token]);

            // Send the verification email
            $link = "http://localhost/Tutorial/verify.php?token=$token";
            $subject = "Verify your account";
            $message = "Click this link to verify your account:\n$link";
            $headers = "From: no-reply@yourdomain.com\r\n";

            if (mail($email, $subject, $message, $headers)) {
                $success = "Signup successful! Check your email to verify your account.";
            } else {
                $error = "Account created, but failed to send verification email.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="Login">
        <h2>Sign up</h2>
        <form method="post">
            <input name="username" required placeholder="Username"><br>
            <input name="email" required placeholder="Email"><br>
            <input name="password" required placeholder="Password" type="password"><br>
            <button>Sign up</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
    <p style="color:red"><?= $error ?></p>
    <p style="color:green"><?= $success ?></p>
</body>

</html>