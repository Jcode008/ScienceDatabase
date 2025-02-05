<?php
session_start();
include 'php/config.php';
if(!isset($_SESSION['id'])){
    header('Location: Login.php');
}
?>

<?php
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $query = mysqli_query($con, "SELECT * FROM accounts WHERE id = '$id'");
            
            if($result = mysqli_fetch_assoc($query)){
                $res_Fname = $result['FirstName'];
                $res_Sname = $result['SurName'];
                $res_Email = $result['Email'];
                $res_Subjects = $result['Subjects'];
                $res_id = $result['id'];
                
                
            }
        }
    ?>




<?php
// Database connection
$host ="br48chr14wfe42z7yirg-mysql.services.clever-cloud.com";
$username="uydxtwygd2yzb0ng";
$password="lM36mTZWw85XKpSLnpr6";   
$database="br48chr14wfe42z7yirg";  


$con = mysqli_connect("$host", "$username", "$password", "$database", "3306");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// File upload handling
if (isset($_POST['submit'])) {
    $uploadDir = "uploads/"; // Folder to store files
    $fileName = $_POST['fileName']. "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $fileDescription = $_POST['fileDesc'];
    $auther = $res_Fname . " " . $res_Sname;
    $subject = $_POST['fileSubject'];
    // Allowed file types
    $allowedTypes = ["docx", "pptx", "pdf"];

    if (in_array($fileType, $allowedTypes)) {
        // Move file to the upload folder
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
            // Insert file details into database
            $stmt = $con->prepare("INSERT INTO files (FileName , FileType, FilePath, FileDesc, Author, Subject) VALUES (?, ?, ?,?,?,?)");
            $stmt->bind_param("ssssss", $fileName, $fileType, $filePath, $fileDescription, $auther, $subject); 
            
            if ($stmt->execute()) {
                echo "File uploaded successfully! <a href='$filePath' target='_blank'>View File</a>  <a href='home.php'>Back</a>";
            } else {
                echo "Database error: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only .docx, .pptx, and .pdf are allowed.";
    }
}
?>