<?php
require_once 'Database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->connect();

    // Insert the new profile
    $sql = "INSERT INTO profiles (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':headline' => $headline,
        ':summary' => $summary
    ]);

    header("Location: index.php");
    exit();
}
?>

<h1>Add New Profile</h1>
<form method="post">
    <p>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>
    </p>
    <p>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </p>
    <p>
        <label for="headline">Headline:</label>
        <input type="text" name="headline" id="headline" required>
    </p>
    <p>
        <label for="summary">Summary:</label>
        <textarea name="summary" id="summary" required></textarea>
    </p>
    <p>
        <input type="submit" value="Add">
        <a href="index.php">Cancel</a>
    </p>
</form>