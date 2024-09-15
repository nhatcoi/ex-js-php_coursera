<?php
require_once 'Database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $profile_id = $_POST['profile_id'];

    // Create a new instance of the Database class
    $database = new Database();
    $conn = $database->connect();

    // Delete the profile
    $sql = "DELETE FROM profiles WHERE profile_id = :profile_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':profile_id' => $profile_id,
        ':user_id' => $_SESSION['user_id']
    ]);

    header("Location: index.php");
    exit();
}

// Fetch the profile to be deleted
if (!isset($_GET['profile_id'])) {
    header("Location: index.php");
    exit();
}

$profile_id = $_GET['profile_id'];

// Create a new instance of the Database class
$database = new Database();
$conn = $database->connect();

$sql = "SELECT profile_id, first_name, last_name FROM profiles WHERE profile_id = :profile_id AND user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':profile_id' => $profile_id,
    ':user_id' => $_SESSION['user_id']
]);
$profile = $stmt->fetch();

if ($profile === false) {
    header("Location: index.php");
    exit();
}
?>

<h1>Delete Profile</h1>
<p>Are you sure you want to delete the profile of <?php echo htmlspecialchars($profile['first_name']) . " " . htmlspecialchars($profile['last_name']); ?>?</p>

<form method="post">
    <input type="hidden" name="profile_id" value="<?php echo htmlspecialchars($profile['profile_id']); ?>">
    <input type="submit" name="delete" value="Delete">
    <a href="index.php">Cancel</a>
</form>