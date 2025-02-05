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

// Debugging: Output the query being executed
$query = "SELECT * FROM accounts WHERE id='$id'";


// Fetch user data for the form
$query_result = mysqli_query($con, $query);

if (mysqli_num_rows($query_result) > 0) {
    $row = mysqli_fetch_assoc($query_result);
 
    $res_Email = $row['Email'];
    $res_Fname = $row['FirstName'];

    $res_Sname =    $row['SurName'];
    $res_Subjects = $row['Subjects'];

    // Check if the form was submitted
    if (isset($_POST['submit'])) {
        
        $email = $_POST['Email'];
        $Fname = $_POST['FirstName'];
        $Sname = $_POST['SurName'];
        $subjects = implode(',', $_POST['subject']); // Convert array to comma-separated string

        // Update the user data
        $update_query = "UPDATE accounts SET  Email='$email', FirstName='$Fname', SurName='$Sname', Subjects='$subjects' WHERE Id='$id'";
      
        //reload the page 
        
        if (mysqli_query($con, $update_query)) 
            echo "<div class='message'>User data updated successfully.</div>";

           
           
        } else {
            echo "<div class='message'>Error updating user data: " . mysqli_error($con) . "</div>";
        }
        
       
        
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Change Profile</title>
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
                <label for="FirstName">First Name</label>
                <input type="text" name="FirstName" id="FirstName" value="<?php echo htmlspecialchars($res_Fname); ?>" autocomplete="off" required>
            </div>
            <div class="field input">
                <label for="SurName">Last Name</label>
                <input type="text" name="SurName" id="SurName" value="<?php echo htmlspecialchars($res_Sname); ?>" autocomplete="off" required>
            </div>
            <div class="field input">
                <label for="email">Email</label>
                <input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($res_Email); ?>" autocomplete="off" required>
            </div>

            <div class="field select">
                    <label for="subject">Subjects:</label>
                    <div id="selectedSubjects" style="margin-top: 10px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; min-height: 25px;"></div>
                    <select name="subject[]" id="subject" multiple class="multi-select">
                        <option value="Biology">Biology</option>
                        <option value="Chemistry">Chemistry</option>
                        <option value="Physics">Physics</option>
                        <option value="Maths">Maths</option> 
                    </select>
                   
                    <script>
                        const select = document.getElementById('subject');
                        select.size = 1;
                        
                        select.addEventListener('blur', function() {
                            this.size = 1;
                        });
                        select.addEventListener('change', function() {
                            const selected = Array.from(this.selectedOptions).map(opt => opt.text);
                            document.getElementById('selectedSubjects').textContent = selected.join(', ');
                        });
                    </script>

          

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Update">
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
} else {
    echo "<div class='message'>User data not found.</div>";
}
?>



