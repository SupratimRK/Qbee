<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'qbee');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the username is provided
if (isset($_GET['user'])) {
    $username = $_GET['user'];

    // Fetch user ID based on the username
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Question was submitted
            $question_text = $_POST['question'];

            // Insert question into the database
            $sql = "INSERT INTO questions (user_id, question_text) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('is', $user_id, $question_text);

            if ($stmt->execute()) {
                // Redirect to the confirmation page with the username in the URL
                header("Location: confirmation.php?user=$username");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    } else {
        // User not found
        echo "Invalid user.";
    }
} else {
    // No user provided in the URL
    echo "No user specified.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question</title>
    <link rel="stylesheet" href="style_form.css">
</head>

<body>
    <div class="container">
        <!-- App Header (optional) -->
        <div class="app_header">
            <h1>Qbee</h1>
            <p class="tagline">Anon vibes, real talk.</p>
        </div>

        <div class="form_area">
            <!-- Dynamic title with username -->
            <p class="title">Hit me up with an anonymous DM<br>~<span><?php echo htmlspecialchars($username); ?></span></p>
            <form method="POST">
                <div class="form_group">
                    <!-- Large input area for the question -->
                    <textarea name="question" class="form_style large_textarea" placeholder="Your anonymous question..." required></textarea>
                </div>
                <div>
                    <button class="btn" type="submit">Send!</button>
                </div>
            </form>

            <!-- Option to generate your own link -->
            <p>Want to receive anonymous messages? <a class="link" href="signup.php">Get your own Messages</a></p>
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
    </div>
</body>

</html>
