<?php
// Check if the username is provided
if (isset($_GET['user'])) {
    $username = $_GET['user'];
} else {
    $username = "User"; // Fallback if no username provided
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Submitted</title>
    <link rel="stylesheet" href="style_form.css">
    <link rel="icon" type="image/x-icon" href="icon2.png">
</head>

<body>
    <div class="container">
        <!-- App Header (optional) -->
        <div class="app_header">
            <h1>Qbee</h1>
            <p class="tagline">Anon vibes, real talk.</p>
        </div>

        <div class="form_area">
            <p class="title">Thank you!</p>
            <p>Your anonymous DM to <span><?php echo htmlspecialchars($username); ?></span> has been successfully sent.
            </p>

            <!-- Link to go back or submit another question -->
            <p><a class="link" href="ask.php?user=<?php echo urlencode($username); ?>">Send another question</a></p>
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
        <span></span>
        <span></span>
    </div>
</body>

</html>