<?php
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $message = $_POST['message'];

    // Prevent SQL injection
    $name = $conn->real_escape_string($name);
    $message = $conn->real_escape_string($message);

    // Insert message into the database
    $sql = "INSERT INTO messages (name, message) VALUES ('$name', '$message')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Message sent successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Contact</title>
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>
    <section>
        <h1>Say something about me.</h1>
        <form action="contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send</button>
        </form>
        <?php
        if (isset($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </section>
</body>
</html>
