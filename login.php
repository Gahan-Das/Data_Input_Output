<?php
// session_start();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Dummy credentials for demo:
//     $valid_user = 'admin';
//     $valid_pass = '12345';

//     $user = $_POST['username'] ?? '';
//     $pass = $_POST['password'] ?? '';

//     if ($user === $valid_user && $pass === $valid_pass) {
//         $_SESSION['logged_in'] = true;
//         header('Location: index.php'); // go to protected page
//         exit;
//     } else {
//         $error = "Invalid credentials!";
//     }
// }

session_start();
require 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($action === 'signup') {
        if ($username === '' || $password === '') {
            $error = "Both fields are required.";
        } else {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = "Username already exists.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?,?)');
                $ins->execute([$username, $hash]);
                $error = "Signup successful! Please log in.";
            }
        }
    } elseif ($action === 'login') {
        $stmt = $pdo->prepare('SELECT id,password_hash,verified FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['verified']) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $user['id'];
                header('Location: index.php');
                exit;
            } else {
                $error = "Please verify your email before logging in.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
    <div class="Login">
        <h2 id='H2'>Please Login</h2>
        <?php if (!empty($error))
            echo "<p style='color:red;'>$error</p>"; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="action" value="login">Login</button>
            <!-- <button type="submit" name="action" value="signup">Signup</button> -->
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </form>
    </div>
</body>

</html>