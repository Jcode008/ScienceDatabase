<?php
session_start();
include 'php/config.php';
if(!isset($_SESSION['id'])){
    header('Location: Login.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduScience</title>
    
    <link rel="stylesheet" href="home.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
      crossorigin="anonymous"
    />
    <style>
    /* Add styles for the upload modal */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 66.67%; 
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        margin-top: 20px;
    }

    .modal-body input, .modal-body textarea, .modal-body select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-body button {
        background: rgba(76, 68, 182, 0.808);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .modal-body button:hover {
        background: rgba(76, 68, 182, 0.6);
    }
    </style>
</head>
<body>
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


    
    
    <div class="action">
      <div class="profile" onclick="menuToggle();">
        <i class="fa fa-bars" style="font-size:24px; color:#333;"></i>
     
      </div>
    <div class="menu" style="margin-top: 20px;">
      <h3>
        <span style="display: flex; align-items: center; gap: 50px; font-size: 1.2em;">
        <?php echo $res_Fname," ",$res_Sname?> <img src="./assets/icons/default.png" style="width: 30px; height: 30px;" />
        </span>
        <span style="font-size: 0.8em; color: #666;"><?php echo $res_Subjects ?></span>
      </h3>
      <ul>
        
        <li>
        <a href="edit.php"> ✏️</a>
        <a href="edit.php"> Edit profile</a>
        </li>
        
        <li>
        <a href="#">⚙️</a>
        <a href="#">Settings </a>
        </li>

        <li>
        <a href="#" onclick="openModal()">📤</a>
        <a href="#" onclick="openModal()">Upload</a>
        </li>

        <li>
        <a href="#">❓</a>
        <a href="#">Help</a>
        </li>

       

        <li>
        <a href="logout.php">╰┈➤🚪</a>
        <a href="logout.php">Logout</a>
        </li>
        
      </ul>
    </div>
    </div>
    </div>
    <script>
    function menuToggle() {
    const toggleMenu = document.querySelector(".menu");
    const icon = document.querySelector(".profile i");
    toggleMenu.classList.toggle("active");
    icon.classList.toggle("rotate");
    
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.action')) {
        toggleMenu.classList.remove('active');
        icon.classList.remove('rotate');
      }
    });
}
    </script>


    <div class="search-container">
        <form action="/search" method="GET">
            <input type="text" class="search-bar" name="search" placeholder="What are you looking for?">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>


    <div class="subjects-container">
        <div class="subject-card physics">
            <h2>🔭⚛️</h2>
            <h2>Physics</h2>
            <p>Explore mechanics, waves, and modern physics</p>
            <a href="physics.php" class="learn-more">Get Teaching!</a>
        </div>
      
        <div class="subject-card biology">
             <h2>🧬</h2>
            <h2>Biology</h2>
            <p>Study life sciences and human anatomy</p>
            <a href="biology.php" class="learn-more">Get Teaching!</a>
        </div>
        <div class="subject-card chemistry">
            <h2>🧪</h2>
            <h2>Chemistry</h2>
            <p>Discover elements, reactions and compounds</p>
            <a href="chemistry.php" class="learn-more">Get Teaching!</a>
        </div>
        <div class="subject-card mathematics">
            <h2>➕➖✖️➗</h2>
            <h2>Mathematics</h2>
            <p>Master calculus, algebra and geometry</p>
            <a href="math.php" class="learn-more">Get Teaching!</a>
        </div>
    </div>

    <div class="recent-files">
        <h2>Your Recent Files</h2>
        <div class="files-grid">
            <div class="file-card">
                <i class="fa fa-file-pdf-o"></i>
                <p>Physics Lab Report</p>
                <span>Modified 2 days ago</span>
            </div>
            <div class="file-card">
                <i class="fa fa-file-powerpoint-o"></i>
                <p>Chemistry Slides</p>
                <span>Modified 3 days ago</span>
            </div>
            <div class="file-card">
                <i class="fa fa-file-word-o"></i>
                <p>Biology Notes</p>
                <span>Modified 5 days ago</span>
            </div>

            <div class="file-card">
                <i class="fa fa-file-word-o"></i>
                <p>Biology Notes</p>
                <span>Modified 7 days ago</span>
            </div>
        </div>
    </div>

    <div class="quick-tools">
        <h2>Quick Tools</h2>
        <div class="tools-grid">
            <a href="markschemes.php" class="tool-card">
                <i class="fa fa-check-square-o"></i>
                <h3>Mark Schemes</h3>
                <p>Access marking criteria and solutions</p>
            </a>

            <a href="specifications.php" class="tool-card">
                <i class="fa fa-file-text-o"></i>
                <h3>Specifications</h3>
                <p>View curriculum requirements</p>
            </a>

            <a href="generator.php" class="tool-card">
                <i class="fa fa-random"></i>
                <h3>Question Generator</h3>
                <p>Create practice questions</p>
            </a>
        </div>
    </div>

    <style>
    .recent-files, .quick-tools {
        padding: 20px;
        margin: 50px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .files-grid, .tools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .file-card, .tool-card {
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.2s;
    }

    .file-card:hover, .tool-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .file-card i, .tool-card i {
        font-size: 2em;
        color: rgba(76, 68, 182, 0.808);
        margin-bottom: 10px;
    }

    .file-card span {
        display: block;
        font-size: 0.8em;
        color: #666;
    }

    .tool-card {
        text-decoration: none;
        color: inherit;
    }
    </style>

    <style>
    /* Add spacing to the main sections */
    .subjects-container, .recent-files, .quick-tools {
        margin-bottom: 40px;
    }

    /* Add spacing to the footer */
    .site-footer {
        padding: 60px 0 30px;
    }

    /* Add spacing to the profile menu */
    .menu {
        padding: 20px;
    }

    /* Add spacing to the search container */
    .search-container {
        margin-bottom: 40px;
    }

    /* Add spacing to the subject cards */
    .subject-card {
        margin-bottom: 20px;
    }

    /* Add spacing to the file cards */
    .file-card {
        margin-bottom: 20px;
    }

    /* Add spacing to the tool cards */
    .tool-card {
        margin-bottom: 20px;
    }
    </style>

    <style>
    .site-footer {
        background-color: #f8f9fa;
        padding: 40px 0 20px;
        margin-top: 50px;
        color: #333;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        padding: 0 20px;
    }

    .footer-section {
        margin: 20px;
        min-width: 250px;
    }

    .footer-section h3 {
        color: rgba(76, 68, 182, 0.808);
        margin-bottom: 20px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section a:hover {
        color: rgba(76, 68, 182, 0.808);
    }

    .social-links a {
        margin-right: 15px;
        font-size: 20px;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }
    </style>

    <style>
    .subjects-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    .subject-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        width: 250px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .subject-card:hover {
        transform: translateY(-5px);
    }

    .subject-card img {
        width: 80px;
        height: 80px;
        margin-bottom: 15px;
    }

    .subject-card h2 {
        color: #333;
        margin-bottom: 10px;
    }

    .subject-card p {
        color: #666;
        font-size: 0.9em;
        margin-bottom: 15px;
    }

    .learn-more {
        display: inline-block;
        padding: 8px 20px;
        background:rgba(76, 68,182,0.808);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        transition: background 0.3s ease;
    }

    .learn-more:hover {
        background: rgba(76, 68,182,0.6);
    }
    </style>

    <style>
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
    </style>

    <style>
    /* Adjust the recent files section */
    .recent-files {
        padding: 20px;
        margin: 20px auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        max-width: 800px; /* Set a max-width */
    }

    .files-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 files per row */
        gap: 20px;
        margin-top: 15px;
    }

    .file-card {
        padding: 20px; /* Increase padding for taller cards */
        border: 1px solid #eee;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.2s;
    }

    .file-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .file-card i {
        font-size: 2em;
        color: rgba(76, 68, 182, 0.808);
        margin-bottom: 10px;
    }

    .file-card span {
        display: block;
        font-size: 0.8em;
        color: #666;
    }
    </style>

<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>📧 support@eduscience.com</p>
            <p>📞 +44 (0)123 456 789</p>
            <p>📍 123 Education Street, London, UK</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-links">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 EduScience. All rights reserved.</p>
    </div>
</footer>



<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Upload File</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form action="upload.php" method="post" enctype="multipart/form-data">
      
   
                <label for="fileName">File Name</label>
                <input type="text" id="fileName" name="fileName" required>

                <label for="fileDesc">Description</label>
                <textarea id="fileDesc" name="fileDesc" rows="4" required></textarea>

                <label for="fileSubject">Subject</label>
                <select id="fileSubject" name="fileSubject" required>
                    <option value="Physics">Physics</option>
                    <option value="Maths">Maths</option>
                    <option value="Biology">Biology</option>
                    <option value="Chemistry">Chemistry</option>
                </select>
                
                <input type="file" name="file" required>
                <button type="submit" name="submit">Upload</button>
                
            </form>
        </div>
    </div>
</div>
<script>
function openModal() {
    document.getElementById('uploadModal').style.display = 'block';
    document.getElementById('uploadModal').style.opacity = '0';
    document.getElementById('uploadModal').style.transition = 'opacity 0.3s ease';
    setTimeout(() => {
        document.getElementById('uploadModal').style.opacity = '1';
    }, 50);
}

function closeModal() {
    document.getElementById('uploadModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('uploadModal')) {
        closeModal();
    }
}
</script>

<style></style>
<script src="script.js"></script>
</html>