<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'qbee');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if the username already exists
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username is already taken!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Signup successful!";
                header('Location: login.php');
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qbee Signup</title>
    <link rel="stylesheet" href="style_form.css">
    <link rel="icon" type="image/x-icon" href="icon2.png">
</head>

<body>

    <!--  -->

    <!--  -->
    <div class="container">
        <!-- App Name and Tagline -->
        <div class="app_header">
            <h1>Qbee</h1>
            <!--  -->
            <p class="tagline">Anon vibes, real talk.</p>
            <!--  -->
        </div>

        <div class="form_area">
            <p class="title">SIGN UP</p>
            <form action="" method="POST">
                <div class="form_group">
                    <label class="sub_title" for="username">Username</label>
                    <input placeholder="Enter your username" class="form_style" id="username" type="text"
                        name="username" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" type="password"
                        name="password" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="confirm_password">Confirm Password</label>
                    <input placeholder="Re-type your password" id="confirm_password" class="form_style" type="password"
                        name="confirm_password" required>
                </div>
                <div>
                    <button class="btn" type="submit">SIGN UP</button>
                    <p>Already have an account? <a class="link" href="login.php">Login here!</a></p>
                </div>
            </form>
            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
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