<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
        
        <?php 
        
            include 'php/config.php';
            if(isset($_POST['submit'])){
                $FirstName = $_POST['FirstName'];
                $SurName = $_POST['SurName'];
                $email = $_POST['Email'];
                $subjects = implode(',', $_POST['subject']); // Convert array to comma-separated string
                $password = $_POST['password'];
               
                //verify if the email already exists

                $verify_query = mysqli_query($con, "SELECT Email FROM accounts WHERE Email = '$email'");
                if(mysqli_num_rows($verify_query) != 0){
                    echo "<div class='message' style='text-align: center; background: #f9eded; padding:15px 0px; border:0cqb solid #699053; border-radius:5px; margin-bottom: 10px; color: red;'>
                    <p>Email already exists, please try another one!</p>
                    </div> <br>";
                    echo "<a href= 'javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                }else{
                    mysqli_query($con, "INSERT INTO accounts (FirstName,SurName, Email, subjects, Password) VALUES ('$FirstName','$SurName', '$email', '$subjects', '$password')" ) or die("Error Occured");
                    
                    echo "<div class='message'>
                    <p>Account created successfully!</p>
                    </div> <br>";
                    echo "<a href= 'Login.php'><button class='btn'>Login Now!</button></a>";
                    exit();
                }
                    
            } else{
        
        ?> 
            <header>Create Account</header>
            <form action="" method="post">
                
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="Email" id="Email"autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="FirstName">First Name</label>
                    <input type="text" name="FirstName" id="FirstName" autocomplete="off" >
                </div>

                <div class="field input">
                    <label for="SurName">Last Name</label>
                    <input type="text" name="SurName" id="SurName" autocomplete="off" >
                </div>
                <div class="field select">
                    <label for="subject">What Subjects Do You Teach?:</label>
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
                </div>
                <style>
                .field.select {
                    position: relative;
                }

                .multi-select {
                    appearance: none;
                    cursor: pointer;
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    background: #fff;
                }

                .multi-select option {
                    padding: 10px;
                    transition: background-color 0.2s;
                }

                .multi-select option:hover {
                    background-color: #f0f0f0;
                }

                .multi-select option:checked {
                    background-color: #4CAF50;
                    color: white;
                }

                .help-text {
                    display: block;
                    font-size: 12px;
                    color: #666;
                    margin-top: 5px;
                }
                .multi-select {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    min-height: 120px;
                }
                .multi-select option {
                    padding: 8px;
                    margin: 2px;
                    background-color: #f8f8f8;
                    border-radius: 2px;
                }
                .multi-select option:checked {
                    background-color: #e3e8ff;
                    color: #333;
                }
                </style>
                <small class="help-text">Hold Ctrl (Windows) or Command (Mac) to select multiple subjects</small>
              

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Create Account" required>
                </div>

                <div class="links">
                    Already a member? <a href="Login.php" > Sign in here!</a>
                </div>
                   
            </form>
        </div>
        <?php } ?>
    </div>
    
</body>
</html></html>