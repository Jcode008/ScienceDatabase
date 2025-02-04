<?php
$host = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ProductivityApp1"; 

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch files
$sql = "SELECT * FROM files ORDER BY FileName DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
</head>
<body>
    <h2>Uploaded Files</h2>
    <table border="1">
        <tr>
            <th>File Name</th>
            <th>Author</th>
            <th>Subject</th>
            <th>File Type</th>
            <th>View</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["FileName"]; ?></td>
                <td><?php echo strtoupper($row["Author"]); ?></td>
                <td><?php echo strtoupper($row["Subject"]); ?></td>
                <td><?php echo strtoupper($row["FileType"]); ?></td>
                <td><a href="<?php echo $row["FilePath"]; ?>" target="_blank">Open</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
