<?php
session_start();
include_once('test/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['username'])) {
    header('Location:test/login.php');
    exit();
}

// Assign the session variables to display the correct user name
$name = $_SESSION['name'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GardenWise</title>
    <style>
        @keyframes rainbow {
            0% { color: #ffffff; }      /* White */
            50% { color: #000000; }      /* Black */
            100% { color: #ffffff; }      /* Black-to-white */
        }

        .greeny-text {
            font-weight: bold;
            font-size: 18px; /* Adjust size as needed */
            animation: rainbow 10s linear infinite; /* Adjust duration as needed */
            text-shadow: 0 0 5px rgba(0, 255, 0, 0.7), 
                         0 0 10px rgba(0, 255, 0, 0.7), 
                         0 0 15px rgba(0, 200, 0, 0.5), 
                         0 0 20px rgba(0, 150, 0, 0.3);
        }
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            scroll-behavior: smooth;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
        }
        canvas {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        header {
            position: relative;
            height: 100vh;
            overflow: hidden;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        header video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(50%);
        }
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            z-index: 10;
            backdrop-filter: blur(10px); /* Blurry effect */
            background: rgba(255, 255, 255, 0.1); /* Transparent background */
        }
        .logo {
            display: flex;
            justify-content: center;
            flex: 1;
        }
        .logo img {
            height: 90px;
            width: auto;
            animation: glow 1.5s infinite alternate;
            transition: transform 0.3s ease-in-out; /* Smooth transition for hover */
        }
        .logo img:hover {
            transform: scale(1.2); /* Enlarges the logo on hover */
        }
        @keyframes glow {
            0% {
                filter: drop-shadow(0 0 1px green);
            }
            100% {
                filter: drop-shadow(0 0 1px lime);
            }
        }
        .menu {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 1;
        }
        .menu a {
            color: black;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }
        .menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #28a745;
            border-radius: 5px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: transparent;
            color: black;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: color 0.3s;
        }

        .dropbtn::after {
            content: ' ▼';
            font-size: 12px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            color: #28a745;
        }

        .header-content h1 {
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .header-content p {
            font-size: 1.5em;
        }

        .content-container {
            padding: 20px;
            gap: 20px;
        }

        .about-us {
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            color: black;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .about-us img {
            max-width: 45%;
            height: auto;
            border-radius: 10px;
            margin-right: 20px;
        }

        .about-us .about-text {
            max-width: 55%;
        }

        .about-us h1 {
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: bold;
        }

        .about-us h2 {
            margin-top: 20px;
            font-size: 1.4em;
            color: black;
        }

        .about-us p {
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .about-us ul {
            list-style: none;
            padding: 0;
            font-size: 0.9em;
        }

        .about-us li {
            margin-bottom: 15px;
        }

        .about-us li strong {
            color: #28a745;
        }

        .second-video-section {
            position: relative;
            height: 60vh;
            overflow: hidden;
            margin-top: 40px;
        }

        .second-video-section video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .second-video-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            border: 2px solid #28a745;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            margin-top: 20px; /* Added margin to move the button below the text */
        }

        .btn:hover {
            background-color: black;
            color: #28a745;
            border-color: black;
        }
        
        .scroll-toggle-btn {
            position: fixed;
            bottom: 80px;
            right: 30px;
            background-color: #28a745;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .scroll-toggle-btn:hover {
            transform: scale(1.1);
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .theme-toggle-btn {
            position: fixed;
            bottom: -660px; /* Same bottom position for vertical alignment */
            right: 30px;  /* Adjusted to match the right side with the scroll button */
            background-color: #28a745;
            color: white;
            width: 55px;
            height: 55px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 101;
            transition: background-color 0.3s, color 0.3s;
        }

        .theme-toggle-btn:hover {
            background-color: #218838;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #333;
            color: #f4f4f4;
        }

        body.dark-mode nav {
            background: rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .menu a {
            color: white;
        }

        body.dark-mode .menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #28a745;
        }

        body.dark-mode .dropdown-content {
            background-color: #444;
        }

        body.dark-mode .dropdown-content a {
            color: white;
        }

        body.dark-mode .dropdown-content a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <video autoplay muted loop>
            <source src="gard_stuffs/garden1.mp4" type="video/mp4">
        </video>
        <nav>
            <div class="menu">
                <a href="home.php">Home</a>
                <div class="dropdown">
                    <button class="dropbtn"><b>Guide</b></button>
                    <div class="dropdown-content">
                        <a href="guides_docs/HTSG.pdf">How to start gardening?</a>
                        <a href="guides_docs/Beginner's_Guide.pdf">Beginner's Guide</a>
                        <a href="guides_docs/Gardening_Techniques.pdf">Gardening Techniques</a>
                        <a href="guides_docs/Plant_Care.pdf">Plant Care</a>
                        <a href="guides_docs/Sustainable_Gardening.pdf">Sustainable Gardening</a>
                    </div>
                </div>
                <a href="recommendation.php">Recommendation</a>
                <div class="dropdown">
                    <button class="dropbtn"><b>Community</b></button>
                    <div class="dropdown-content">
                        <a href="forums/index.php">Forums</a>
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdWInKOpLYQ6FgDxZm86Q_gCErPPWMZDKG0Yd_KT2eyjS51wg/viewform?usp=sf_link">Feedback</a>
                    </div>
                </div>
                <div class="logo">
                    <img src="gard_stuffs/GW.webp" alt="GardenWise Logo">
                </div>
                <a href="scheduler/index.php">Task Scheduling</a>
                <a href="#about-us">About Us</a>
                <a href="#contact">Contact</a>
                <!-- Light-Dark Mode Toggle Button -->
                <button id="themeToggleButton" class="theme-toggle-btn">🌙</button>
                <div class="dropdown">
                    <button class="dropbtn"><b>Profile</b></button>
                    <p class="greeny-text"><b>Welcome, <?= htmlspecialchars($name) ?></b></p>
                    <div class="dropdown-content">
                        <!-- <a href="#">My Profile</a>
                        <a href="#">Edit Profile</a>
                        <a href="#">Saved Pages</a> -->
                        <a href="test/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="header-content">
            <h1>Welcome to GardenWise</h1>
            <p>Your ultimate guide to transforming your gardening experience.</p>
        </div>
    </header>
    <canvas id="canvas"></canvas><!-- The canvas where particles will be drawn -->
    <script src="particleEffect.js"> </script><!-- JavaScript for particle effect -->
    <div class="content-container">
        <!-- About Us Section -->
        <section id="about-us" class="about-us">
            <img src="gard_stuffs/gard_home.jpg" alt="About Us">
            <div class="about-text">
                <h1>About Us</h1>
                <p>At GardenWise, our mission is to enhance your gardening journey with personalized recommendations and expert advice.</p>
                <h2>What We Do:</h2>
                <ul>
                    <li><strong>Personalized Plant Recommendations:</strong> We offer customized plant suggestions based on real-time weather data and your location.</li>
                    <li><strong>Community Engagement:</strong> Join gardening groups, participate in events, and share your gardening experiences with a supportive community.</li>
                    <li><strong>Gardening Resources:</strong> Access a comprehensive library of articles, guides, and tutorials on various gardening topics.</li>
                    <li><strong>Sustainable Practices:</strong> Promote eco-friendly gardening techniques such as water conservation and organic gardening.</li>
                    <li><strong>User-Friendly Platform:</strong> Enjoy a seamless and intuitive platform designed for easy navigation and access to resources.</li>
                </ul>
                <p><strong>Join Us:</strong> Become part of the GardenWise community today and embark on a rewarding gardening journey.</p>
            </div>
        </section>
        <footer id="contact">
            <!-- Contact section content -->
        </footer>

        <!-- Second Video Section -->
        <section class="second-video-section">
            <video autoplay muted loop>
                <source src="gard_stuffs/garden2.mp4" type="video/mp4">
            </video>
            <div class="second-video-content">
                <h1>Ready to Get Started?</h1>
                <p>Connect with us and start your gardening journey with GardenWise.</p>
                <a href="mailto:support@gardenwise.com" class="btn">Email Support</a>
            </div>
        </section>
    </div>

    <!-- Scroll toggle button -->
    <button class="scroll-toggle-btn" id="scrollToggleButton">
        ↓
    </button>

    <script>
        // JavaScript to toggle the arrow direction based on scroll position
        const scrollToggleButton = document.getElementById('scrollToggleButton');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                scrollToggleButton.innerHTML = '↑'; // Change to up arrow
            } else {
                scrollToggleButton.innerHTML = '↓'; // Change to down arrow
            }
        });

        // Scroll to top or bottom depending on the arrow direction
        scrollToggleButton.addEventListener('click', () => {
            if (window.scrollY > 200) {
                window.scrollTo({ top: 0, behavior: 'smooth' }); // Scroll to top
            } else {
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }); // Scroll to bottom
            }
        });

        // JavaScript for light-dark mode toggle
        const themeToggleButton = document.getElementById('themeToggleButton');
        const body = document.body;

        themeToggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                themeToggleButton.textContent = '☀️';
            } else {
                themeToggleButton.textContent = '🌙';
            }
        });
    </script>
</body>
</html>
