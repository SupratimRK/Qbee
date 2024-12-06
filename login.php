<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'qbee');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Invalid credentials!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qbee Login</title>
    <link rel="stylesheet" href="style_form.css">
    <link rel="icon" type="image/x-icon" href="icon2.png">
</head>
<body>
    <div class="container">
        <!-- App Name and Tagline -->
        <div class="app_header">
            <h1>Qbee</h1>
            <p class="tagline">Anon vibes, real talk.</p>
        </div>
        
        <div class="form_area">
            <p class="title">LOGIN</p>
            <form action="" method="POST">
                <div class="form_group">
                    <label class="sub_title" for="username">Username</label>
                    <input placeholder="Enter your username" class="form_style" id="username" type="text" name="username" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" type="password" name="password" required>
                </div>
                <div>
                    <button class="btn" type="submit">LOGIN</button>
                    <p>Don't have an account? <a class="link" href="signup.php">Sign up here!</a></p>
                </div>
            </form>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</body>
</html>

