<?php
require_once 'Database.php';
session_start();



if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
} else {
    $user_id = $_SESSION['user_id'];
}

// Create a new instance of the Database class
$database = new Database();
$conn = $database->connect();

// Fetch all profiles
$sql = "SELECT profile_id, first_name, last_name, headline, email FROM profiles WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$profiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>46ebe2a5</title>
</head>
<body>
<h1> 46ebe2a5 Chuck Severance's Resume Registry</h1>

<?php
if (isset($_SESSION['email'])) {
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo '<p><a href="login.php">Login</a></p>';
}
?>

<table border="1">
    <tbody>
    <tr>
        <th>Name</th>
        <th>Headline</th>
        <?php
        if (isset($_SESSION['email'])) {
            echo '<th>Action</th>';
        }
        ?>

    </tr>
    <?php
    if (count($profiles) > 0) {
        foreach ($profiles as $profile) {
            echo "<tr>";
            echo "<td><a href='view.php?profile_id=" . htmlspecialchars($profile['profile_id']) . "'>" . htmlspecialchars($profile['first_name']) . " " . htmlspecialchars($profile['last_name']) . "</a></td>";
            echo "<td>" . htmlspecialchars($profile['headline']) . "</td>";
            echo "<td>";
            if (isset($_SESSION['email'])) {
                echo "<a href='edit.php?profile_id=" . htmlspecialchars($profile['profile_id']) . "'>Edit</a> ";
                echo "<a href='delete.php?profile_id=" . htmlspecialchars($profile['profile_id']) . "'>Delete</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No profiles found</td></tr>";
    }
    ?>
    </tbody>
</table>

<?php
if (isset($_SESSION['email'])) {
    echo '<p><a href="add.php">Add New Entry</a></p>';
}
?>

<p>
    <b>Note:</b> Your implementation should retain data across multiple
    logout/login sessions. This sample implementation clears all its
    data periodically - which you should not do in your implementation.
</p>

</body>