<?php
session_start();
require 'php/config.php';

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: Login.php');
    exit(); // stop further execution if the user is not logged in
}

$id = $_SESSION['id'];

// Ensure the ID is properly sanitized (make sure it's an integer)
$id = intval($id); // Convert to an integer to avoid any issues

// Fetch user data for the form
$query = "SELECT * FROM accounts WHERE id='$id'";
$query_result = mysqli_query($con, $query);

if (mysqli_num_rows($query_result) > 0) {
    $row = mysqli_fetch_assoc($query_result);

    $res_Email = $row['Email'];
    $res_Fname = $row['FirstName'];
    $res_Sname = $row['SurName'];
    $res_Subjects = $row['Subjects'];
    $res_Password = $row['Password']; // Fetch the original password

    // Check if the form was submitted
    if (isset($_POST['submit'])) {
        $prevPW = $_POST['PrevPassword'];
        $newpassword = $_POST['Password'];
        $confirmPw = $_POST['ConfirmPassword'];

        // Verify the previous password
        if ($prevPW === $res_Password) {
            // Check if the new password and confirm password match
            if ($newpassword === $confirmPw) {
                // Update the user data
                $update_query = "UPDATE accounts SET Password='$newpassword' WHERE id='$id'";
                if (mysqli_query($con, $update_query)) {
                    echo "<div class='message'>User data updated successfully.</div>";
                } else {
                    echo "<div class='message'>Error updating user data.</div>";
                }
            } else {
                echo "<div class='message'>New password and confirm password do not match.</div>";
            }
        } else {
            echo "<div class='message'>Previous password is incorrect.</div>";
        }
    }
} else {
    echo "<div class='message'>User data not found.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Password</title>
</head>
<body>

<div class="nav">
    <div class="logo">
        <p><a href="home.php">Logo</a></p>
    </div>
    <div class="right-links">
        <a href="logout.php"><button class="btn">Log Out</button></a>
    </div>
</div>

<div class="container">
    <div class="box form-box">
        <header>Edit Account</header>
        <form action="" method="post">
            <div class="field input">
                <label for="PrevPassword">Enter Previous Password</label>
                <input type="text" name="PrevPassword" id="PrevPassword" value="" autocomplete="off" required>
            </div>
            <div class="field input">
                <label for="Password">Enter New Password</label>
                <input type="text" name="Password" id="Password" value="" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="ConfirmPassword">Confirm Password</label>
                <input type="text" name="ConfirmPassword" id="ConfirmPassword" value="" autocomplete="off" required>
            </div>
            
          

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Update">
            </div>
        </form>
    </div>
</div>
</body>
</html>
