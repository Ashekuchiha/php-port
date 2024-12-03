<?php
include('../includes/db.php');
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}

// Handle message deletion
if (isset($_GET['delete']) && isset($_SESSION['loggedin'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM messages WHERE id = $id");
    header("Location: home.php");
    exit();
}

// Fetch messages from the database
$sql = "SELECT id, name, message, created_at FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Home</title>
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="contact.php">What you think</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <a href="home.php?logout=true">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <section>
        <h1>Welcome to My Portfolio!</h1>
        <img src="../images/myphoto.jpg" alt="My Image" style="width:200px; border-radius:50%;">

        <h2>What People Say</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                echo "<small>Posted on: " . $row['created_at'] . "</small>";
                
                // Display delete button if logged in
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo "<form method='GET' action='home.php' style='display:inline;'>
                            <input type='hidden' name='delete' value='{$row['id']}'>
                            <button type='submit'>Delete</button>
                          </form>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No messages yet!</p>";
        }
        ?>
    </section>
</body>
</html>
