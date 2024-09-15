<?php
require_once 'Database.php';
session_start();

if (!isset($_GET['profile_id'])) {
    echo "Profile ID is missing";
    exit();
}

$profile_id = $_GET['profile_id'];

// Create a new instance of the Database class
$database = new Database();
$conn = $database->connect();

// Fetch the profile details
$sql = "SELECT first_name, last_name, email, headline, summary FROM profiles WHERE profile_id = :profile_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':profile_id' => $profile_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    echo "Profile not found";
    exit();
}
?>

<h1>Profile Information</h1>
<p><strong>First Name:</strong> <?php echo htmlspecialchars($profile['first_name']); ?></p>
<p><strong>Last Name:</strong> <?php echo htmlspecialchars($profile['last_name']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
<p><strong>Headline:</strong> <?php echo htmlspecialchars($profile['headline']); ?></p>
<p><strong>Summary:</strong> <?php echo htmlspecialchars($profile['summary']); ?></p>

<p><a href="index.php">Back to Home</a></p>