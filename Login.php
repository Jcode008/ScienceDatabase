<?php
 session_start();

    if(isset($_SESSION['id'])){
        header('Location: home.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                include 'php/config.php';
                if(isset($_POST['submit'])){
                   $email = mysqli_real_escape_string($con, $_POST['email']);
                   $password = mysqli_real_escape_string($con, $_POST['password']);

                   $result = mysqli_query($con, "SELECT * FROM accounts WHERE Email = '$email' AND password = '$password'") or die("Error Connecting to Database");
                    $row = mysqli_fetch_array($result);

                    if(is_array($row) && !empty($row)){
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['Username'] = $row['Username'];
                        
                        $_SESSION['id'] = $row['id'];
                    }
                    else{
                        echo "<div class='message' style='text-align: center; background: #f9eded; padding:15px 0px; border:0cqb solid #699053; border-radius:5px; margin-bottom: 10px; color: red;'>
                        <p>Invalid Username or Password</p>
                        </div> <br>";
                        echo "<a href= 'Login.php'><button class='btn'>Go Back</button></a>";
                    }

                    if(isset($_SESSION['id'])){
                        header('Location: home.php');
                        exit();
                    }
                }else {

                
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required >
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="login" required>
                </div>

                <div class="links">
                    Don't have an account?<a href="register.php"> Sign up</a>
                </div>
                   
            </form>
        </div>
        <?php } ?>
    </div>
    
</body>
</html></html>