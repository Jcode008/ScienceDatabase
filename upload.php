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
            $query = mysqli_query($con, "SELECT * FROM accounts WHERE Id = '$id'");
            
            if($result = mysqli_fetch_assoc($query)){
                $res_Fname = $result['FirstName'];
                $res_Sname = $result['SurName'];
                $res_Email = $result['Email'];
                $res_Subjects = $result['subjects'];
                $res_id = $result['Id'];
                
                
            }
        }
    ?>




<?php
// Database connection
$host = "localhost";
$username = "root"; // Change this if needed
$password = ""; // Change this if needed
$dbname = "productivityapp1"; // Change to your database name
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
            $stmt = $conn->prepare("INSERT INTO files (FileName , FileType, FilePath, fileDesc, Author, Subject) VALUES (?, ?, ?,?,?,?)");
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