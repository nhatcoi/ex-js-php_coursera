<?php
require_once 'Database.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

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
    echo "Profile not found or you do not have permission to edit this profile";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    $sql = "UPDATE profiles SET first_name = :first_name, last_name = :last_name, email = :email, headline = :headline, summary = :summary WHERE profile_id = :profile_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':headline' => $headline,
        ':summary' => $summary,
        ':profile_id' => $profile_id
    ]);

    header("Location: index.php");
    exit();
}
?>

<h1>Edit Profile</h1>
<form method="post">
    <p>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($profile['first_name']); ?>">
    </p>
    <p>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($profile['last_name']); ?>">
    </p>
    <p>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($profile['email']); ?>" readonly>
    </p>
    <p>
        <label for="headline">Headline</label>
        <input type="text" name="headline" id="headline" value="<?php echo htmlspecialchars($profile['headline']); ?>">
    </p>
    <p>
        <label for="summary">Summary</label>
        <textarea name="summary" id="summary"><?php echo htmlspecialchars($profile['summary']); ?></textarea>
    </p>
    <p>
        <input type="submit" value="Save">
        <a href="index.php">Cancel</a>
    </p>
</form>