<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GardenWise</title>
    <style>
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
            padding: 0 20px;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo {
            display: flex;
            justify-content: center;
            flex: 1;
        }
        .logo img {
            height: 90px;
            width: auto;
        }
        .menu {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 1;
        }
        .menu a {
            color: white;
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

        .header-content h1 {
            font-size: 3em;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 120px;
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

        /* Button styles */
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
        }
        .btn:hover {
            background-color: black;
            color: #28a745;
            border-color: black;
        }

        /* Toggle button styles */
        .scroll-toggle-btn {
            position: fixed;
            bottom: 30px;
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

        /* Spacing between buttons */
        .button-container {
            display: flex;
            gap: 20px;
        }
        /* Scroll toggle button */
        .scroll-toggle-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 24px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .scroll-toggle-btn:hover {
            background-color: #218838;
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
                <a href="prehome.php">Home</a>
                <a href="#">Guide</a>
                <div class="logo">
                    <img src="gard_stuffs/GW.webp" alt="GardenWise Logo">
                </div>
                <a href="#about-us">About Us</a>
                <a href="#contact">Contact</a>
                <div class="button-container">
                    <form action="test/login.php" method="post">
                        <button type="submit" class="btn" name="login">Login</button>
                    </form>
                    <form action="test/register.php" method="post">
                        <button type="submit" class="btn" name="register">Register</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="header-content">
            <h1>Welcome to GardenWise</h1>
            <p>Your ultimate guide to transforming your gardening experience.</p>
        </div>
    </header>
    <div class="content-container">
        <section id="about-us" class="about-us">
            <img src="test/gard_solo.png" alt="Gardening Image">
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
        <div class="second-video-section">
            <video autoplay muted loop>
                <source src="gard_stuffs/garden2.mp4" type="video/mp4">
            </video>
            <div class="second-video-content">
                <h1>Discover the Joy of Gardening</h1>
                <p>Explore tips, tricks, and tools to create your dream garden.</p>
            </div>
        </div>
    </div>
    <!-- Scroll toggle button -->
    <button class="scroll-toggle-btn" id="scrollToggleButton">
        &#x2193;
    </button>

    <script>
        // JavaScript to toggle the arrow direction based on scroll position
        const scrollToggleButton = document.getElementById('scrollToggleButton');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                scrollToggleButton.innerHTML = '&#x2191;'; // Change to up arrow
            } else {
                scrollToggleButton.innerHTML = '&#x2193;'; // Change to down arrow
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
    </script>
</body>
</html>
