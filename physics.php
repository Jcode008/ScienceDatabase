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
    <title>Physics Calculator</title>
    <link rel="stylesheet" href="style.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
      crossorigin="anonymous"
    />
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e4e9f7;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .search-container { 
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: center;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .search-container input {
        width: 60%;
        padding: 12px 20px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 25px;
        outline: none;
    }

    .files-container {
        display: flex;
        justify-content: center;
        padding: 20px;
        flex-grow: 1;
    }

    .file-box {
        background: white;
        border-radius: 10px;
        padding: 20px;
        width: 90%;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        text-align: center;
    }

    .file-box a {
        display: block;
        padding: 10px;
        margin: 10px 0;
        background: rgba(76, 68, 182, 0.808);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .file-box a:hover {
        background: rgba(76, 68, 182, 0.6);
    }

    .filter-sidebar {
        background: white;
        border-radius: 10px;
        padding: 20px;
        width: 250px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        left: -300px;
        height: 100%;
        overflow-y: auto;
        transition: left 0.3s ease;
    }

    .filter-sidebar h3, .filter-sidebar h4 {
        color: rgba(76, 68, 182, 0.808);
    }

    .filter-sidebar label {
        color: #666;
    }

    .filter-sidebar input[type="checkbox"] {
        margin-right: 10px;
    }

    .filter-section {
        margin-bottom: 20px;
    }

    .container {
        display: flex;
        justify-content: space-between;
        padding: 20px;
    }

    .hamburger {
        font-size: 24px;
        cursor: pointer;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000;
    }

    .filter-sidebar.active {
        left: 0;
    }


    /* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

th {
    background-color: rgba(76, 68, 182, 0.9);
    color: #ffffff;
    text-align: left;
    font-weight: 500;
    padding: 12px;
    letter-spacing: 0.5px;
}

td {
    padding: 12px;
    border-bottom: 1px solid rgba(0,0,0,.05);
    color: #666;
}

tr {
    transition: all 0.3s ease;
}

tr:hover {
    background-color: rgba(76, 68, 182, 0.05);
    
}

tr:last-child td {
    border-bottom: none;
}

td a {
    background-color: rgba(76, 68, 182, 0.8);
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.85em;
    transition: all 0.3s ease;
}

td a:hover {
    background-color: rgba(76, 68, 182, 1);
    
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

@media screen and (max-width: 768px) {
    table {
        font-size: 0.8em;
    }
    
    td, th {
        padding: 8px;
    }
    
    td a {
        padding: 4px 8px;
    }
}
    </style>
</head>
<body>
    <div class="hamburger" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </div>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search files...">
    </div>

    <a href="home.php" style="position: fixed; top: 20px; right: 20px; padding: 10px 20px; background-color: rgba(76, 68, 182, 0.808); color: white; text-decoration: none; border-radius: 5px; transition: all 0.3s ease;">
        <i class="fa fa-home"></i> Home
    </a>
    <div class="container">
        <div class="filter-sidebar" id="filterSidebar">
            <h3>Filters</h3>
          
            <div class="filter-section">
                <h4>Year</h4>
                <input type="checkbox" id="2023" name="year" value="2023">
                <label for="2023">2023</label><br>
                <input type="checkbox" id="2022" name="year" value="2022">
                <label for="2022">2022</label><br>
                <input type="checkbox" id="2021" name="year" value="2021">
                <label for="2021">2021</label>
            </div>
            <div class="filter-section">
                <h4>Topic</h4>
                <input type="checkbox" id="mechanics" name="topic" value="Mechanics">
                <label for="mechanics">Mechanics</label><br>
                <input type="checkbox" id="waves" name="topic" value="Waves">
                <label for="waves">Waves</label><br>
                <input type="checkbox" id="electricity" name="topic" value="Electricity">
                <label for="electricity">Electricity</label>
            </div>
            <div class="filter-section">
                <h4>File Type</h4>
                <input type="checkbox" id="pdf" name="fileType" value="pdf">
                <label for="pdf">PDF</label><br>
                <input type="checkbox" id="docx" name="fileType" value="docx">
                <label for="docx">Document</label><br>
                <input type="checkbox" id="pptx" name="fileType" value="pptx">
                <label for="pptx">PowerPoint</label>
            </div>
        </div>
        <div class="files-container">
            <div class="file-box">
            <table border="1">
        <tr>
            <th>File Name</th>
            <th>Author</th>
            
            <th>Subject</th>
            <th>File Type</th>
            <th>Description</th>
            <th>View</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["FileName"]; ?></td>
                <td><?php echo strtoupper($row["Author"]); ?></td>
                <td><?php echo strtoupper($row["Subject"]); ?></td>
                <td><?php echo strtoupper($row["FileType"]); ?></td>
                <td><?php echo $row["FileDesc"]; ?></td>
                <td><a href="<?php echo $row["FilePath"]; ?>" target="_blank">Open</a></td>
            </tr>
        <?php } ?>
    </table>
            </div>
        </div>
    </div>
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('filterSidebar');
        sidebar.classList.toggle('active');
    }
    </script>
</body>
</html>