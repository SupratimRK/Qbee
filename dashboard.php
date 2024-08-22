<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'qbee');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch all questions for the logged-in user
$sql = "SELECT question_text, question_date FROM questions WHERE user_id = ? ORDER BY question_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Function to format the date
function formatDate($date) {
    return date('h:i A d F, Y', strtotime($date));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qbee Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <h3>Your <span class="app-header">Qbee</span> Inbox</h3>

        <div class="message-section">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='message-card'>";
                    echo "<p class='message-title'>Your Qbee</p>";
                    echo "<p class='message-body'>" . htmlspecialchars($row['question_text']) . "</p>";
                    echo "<small class='message-date'>Asked on:<br> " . formatDate($row['question_date']) . "</small>";
                    echo "<button class='screenshot-btn' onclick='takeScreenshot(this)'>Screenshot</button>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-questions'>You haven't received any questions yet.<br>Share the link below to start receiving questions.</p>";
            }
            ?>
        </div>

        <div class="link-area">
            <input type="text" id="share-link" value="https://<?php echo $_SERVER['HTTP_HOST']; ?>/Qbee-t/ask.php?user=<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
            <button class="share-btn" onclick="shareLink()">Share</button>
            <button class="copy-btn" onclick="copyLink()">Copy</button>
        </div>

        <div class="logout-area">
            <button class="logout-btn" onclick="confirmLogout()">Logout</button>
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
    </div>

    <script>
        function copyLink() {
            const copyText = document.getElementById("share-link");
            copyText.select();
            document.execCommand("copy");
            alert("Link copied: " + copyText.value);
        }

        function shareLink() {
            const shareText = document.getElementById("share-link").value;
            if (navigator.share) {
                navigator.share({
                    title: 'Share your Qbee link!',
                    text: 'Hit me up with an anonymous DM!',
                    url: shareText
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(err => console.error(err));
            } else {
                alert("Sharing not supported on this browser, please copy the link manually.");
            }
        }

        function takeScreenshot(button) {
            const card = button.closest('.message-card');
            html2canvas(card).then(canvas => {
                const link = document.createElement('a');
                link.href = canvas.toDataURL();
                link.download = 'screenshot.png';
                link.click();
            });
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <!-- Online Source -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Local Source -->
    <!-- <script src="script.js"></script> -->
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>

