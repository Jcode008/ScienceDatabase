<head>
<link rel="stylesheet" href="home.css">

<link rel="stylesheet" href="home.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
      crossorigin="anonymous"
    /> 

</head>


<?php
$host ="br48chr14wfe42z7yirg-mysql.services.clever-cloud.com";
$username="uydxtwygd2yzb0ng";
$password="lM36mTZWw85XKpSLnpr6";   
$database="br48chr14wfe42z7yirg";  


$conn = mysqli_connect("$host", "$username", "$password", "$database", "3306");



// Check if search term is provided
if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%"; // Add wildcards for partial matching

    // SQL query to search FileName first, then Description, then Author
    $sql = "SELECT *, 
                CASE 
                    WHEN FileName LIKE ? THEN 1 
                    WHEN FileDesc LIKE ? THEN 2 
                    WHEN Author LIKE ? THEN 3 
                    ELSE 4 
                END AS priority
            FROM files
            WHERE FileName LIKE ? OR FileDesc LIKE ? OR Author LIKE ?
            ORDER BY priority, FileName ASC";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results
    if ($result->num_rows > 0) {
        ?>

        <div class="search-container">
        <form action="test.php" method="GET">
            <input type="text" class="search-bar" name="search" placeholder="What are you looking for?">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

        <a href="home.php" style="position: fixed; top: 20px; right: 20px; padding: 10px 20px; background-color: rgba(76, 68, 182, 0.808); color: white; text-decoration: none; border-radius: 5px; transition: all 0.3s ease;">
            <i class="fa fa-home"></i> Home
        </a>
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
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #e4e9f7;
                color: #333;
                margin: 0;
                padding: 0;
            }

            .search-container {
        margin-bottom: 40px;
    }

    .search-container {
        width: 100%;
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .search-container form {
        width: 60%;
        display: flex;
        gap: 10px;
    }

    .search-bar {
        width: 100%;
        padding: 12px 20px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 25px;
        outline: none;
    }

    .search-container button {
        padding: 12px 20px;
        background: rgba(76, 68,182,0.808);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
    }

    .search-container button:hover {
        background: rgba(76, 68,182,0.6);
    }

            .files-container {
                display: flex;
                justify-content: center;
                padding: 20px;
                flex-grow: 1;
                margin-top: 50px;
                margin-right:50px:
            }

            .file-box {
                background: white;
                border-radius: 10px;
                padding: 20px;
                width: 90%;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                text-align: center;
                margin-top: 20px;
            }

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
        <?php
    } else {
        echo "No results found.";
    }

    $stmt->close();
}

$conn->close();
?>
