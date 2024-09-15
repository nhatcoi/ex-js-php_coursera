<!--login.php will present the user the login screen with an email address and password to get the user to log in.
If there is an error, redirect the user back to the login page with a message. If the login is successful, redirect the
user back to index.php after setting up the session. In this assignment, you will need to store the user's hashed password
in the users table as described below.-->


<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli('localhost:3306', 'root', '', 'jsphp');
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user['user_id']; // Set user_id in session
        header("Location: index.php");
        return;
    } else {
        echo "Login failed";
    }
}
?>


<form action="login.php" method="post">
    <h1>Please Log In</h1>
    <p>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </p>
</form>
