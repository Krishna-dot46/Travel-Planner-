<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #f5f5f5;
    }

    /* NAVBAR */
    .navbar {
        position: absolute;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 100px;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(8px);
        z-index: 1000;
    }

    /* ===== LOGO SECTION ===== */

    .logo-box {
        display: flex;
        align-items: center;
    }

    .logo-box img {
        height: 50px;
        /* Bigger logo */
        width: auto;
        margin-right: 15px;
    }

    .brand-text h2 {
        color: white;
        font-size: 26px;
        font-weight: 700;
        margin: 0;
    }

    .brand-text p {
        color: #ddd;
        font-size: 12px;
        margin: 0;
        letter-spacing: 1px;
    }

    /* ===== NAVIGATION LINKS ===== */

    .navbar ul {
        list-style: none;
        display: flex;
        align-items: center;
    }

    .navbar ul li {
        margin-left: 35px;
    }

    .navbar ul li a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        font-size: 15px;
        position: relative;
        transition: 0.3s;
    }

    /* Underline Hover Animation */

    .navbar ul li a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 0%;
        height: 2px;
        background: #00c6ff;
        transition: 0.3s;
    }

    .navbar ul li a:hover::after {
        width: 100%;
    }

    /* ===== LOGIN BUTTON STYLE ===== */

    .navbar ul li:last-child a {
        background: white;
        color: black;
        padding: 8px 20px;
        border-radius: 25px;
        transition: 0.3s;
    }

    .navbar ul li:last-child a:hover {
        background: #00c6ff;
        color: white;
    }

    /* HERO */
    .hero {
        height: 100vh;
        background: url('about bg.jpg') center/cover no-repeat;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }

    .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero h1 {
        font-size: 50px;
    }

    /* ABOUT SECTION */
    .about-section {
        padding: 30px 10%;
        text-align: center;
    }

    .about-section h2 {
        font-size: 35px;
        margin-bottom: 20px;
    }

    .about-section p {
        max-width: 800px;
        margin: auto;
        line-height: 2.0;
        color: #555;
    }

    /* CONTACT SECTION */
    .contact {
        background: #fff;
        padding: 60px 10%;
        display: flex;
        justify-content: center;
    }

    .contact-box {
        width: 400px;
        padding: 30px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .contact-box input,
    .contact-box textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .contact-box button {
        background: red;
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
    }

    .success {
        text-align: center;
        color: green;
        margin-bottom: 10px;
    }

    /* FOOTER */
    .footer {
        background: rgba(0, 0, 0, 0.6) url('footerbg.jpg') center/cover no-repeat;
        color: #ccc;
        padding: 60px 10%;
        position: relative;
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 200px;
    }

    /* COLUMN */
    .footer-col {
        flex: 1;
        min-width: 250px;
    }

    .footer h2 {
        color: #fff;
        margin-bottom: 15px;
    }

    .footer p {
        font-size: 14px;
        line-height: 1.6;
    }

    /* NEWSLETTER */
    .newsletter {
        margin-top: 15px;
        display: flex;
    }

    .newsletter input {
        flex: 1;
        padding: 10px;
        border: none;
        outline: none;
    }

    .newsletter button {
        background: #c9a24d;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    .success-msg {
        color: #4CAF50;
        font-size: 14px;
        margin-top: 8px;
    }

    /* NAVIGATION */
    .footer ul {
        list-style: none;
    }

    .footer ul li {
        margin: 8px 0;
    }

    .footer ul li a {
        text-decoration: none;
        color: #ccc;
        transition: 0.3s;
    }

    .footer ul li a:hover {
        color: #c9a24d;
    }

    /* CONTACT INFO */
    .contact-info p {
        margin: 10px 0;
    }

    /* SOCIAL */
    .social-icons {
        margin-top: 10px;
    }

    .social-icons i {
        margin-right: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    .social-icons i:hover {
        color: #c9a24d;
    }

    /* BOTTOM BAR */
    .footer-bottom {
        border-top: 1px solid #333;
        margin-top: 40px;
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        font-size: 14px;
    }

    .footer-bottom a {
        color: #ccc;
        text-decoration: none;
        margin-left: 15px;
    }

    .footer-bottom a:hover {
        color: #c9a24d;
    }

    /* RESPONSIVE */
    @media(max-width:768px) {
        .footer-container {
            flex-direction: column;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 10px;
        }
    }

    /* Responsive */
    @media(max-width:768px) {
        .navbar {
            padding: 20px;
        }

        .navbar ul li {
            margin-left: 15px;
        }

        .hero h1 {
            font-size: 35px;
        }
    }

    .features {
        display: flex;
        justify-content: center;
        gap: 30px;
        padding: 30px 10%;
        background: #f8f8f8;
    }

    .feature-box {
        background: #fff;
        padding: 25px;
        text-align: center;
        width: 220px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-box i {
        font-size: 30px;
        color: #cea245;
    }

    /* ABOUT CONTENT */
    .about-content {
        display: flex;
        padding: 20px 15%;
        gap: 30px;
    }

    .about-content img {
        width: 300px;
        margin: 20px;
    }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo-box">
            <img src="—Pngtree—tropical travel logo with airplane_23751439.png" alt="Logo">
            <div class="brand-text">
                <h2>Holiday Planners</h2>
            </div>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About us </a></li>
            <li><a href="destination.php">Destination</a></li>
            <li><a href="contectpage.php">Contact</a></li>
            
            <?php if(isset($_SESSION['user_id'])){ ?>
                <li style="display: flex; align-items: center; gap: 15px;">
                    <span style="color: white;">Hello, <?php echo $_SESSION['user_name']; ?></span>
                    <a href="logout.php" style="background: white; color: #c9a24d; padding: 8px 15px; border-radius: 25px; text-decoration: none; font-weight: 500;">Logout</a>
                </li>
            <?php } else { ?>
                <li><a href="login.php">log in</a></li>
            <?php } ?>
        </ul>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>About Our Website</h1>
            <p>Learn more about what we do</p>
        </div>
    </section>

    <!-- ABOUT CONTENT -->
    <section class="about-section">
        <h2>Who We Are</h2>
        <p>
            We are a creative and professional team dedicated to building modern,
            responsive, and user-friendly websites. Our goal is to provide the best
            digital solutions and enhance online experiences for our clients.
        </p>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <div class="feature-box">
            <i class="fa fa-bus"></i>
            <h1>🚙</h1>
            <h3>Private Transport</h3>
            <p>Comfortable and secure travel service.</p>
        </div>

        <div class="feature-box">
            <i class="fa fa-globe"></i>
            <h1>🌍</h1>
            <h3>Diverse Destinations</h3>
            <p>Explore beautiful places around the world.</p>
        </div>

        <div class="feature-box">
            <i class="fa fa-hotel"></i>
            <h1>🏨</h1>
            <h3>Great Hotels</h3>
            <p>Luxury stay experience guaranteed.</p>
        </div>

        <div class="feature-box">
            <i class="fa fa-clock"></i>
            <h1>⏱️</h1>
            <h3>Fast Booking</h3>
            <p>Quick and easy reservation system.</p>
        </div>
    </section>

    <!-- ABOUT CONTENT -->
    <section class="about-content">
        <div class="left">
            <h2>Plan Your Trip With Us</h2>
            <p>
                Far far away, behind the word mountains, far from the countries Vokalia.
                We provide best holiday packages and amazing experiences.
            </p>
        </div>

        <div class="right">
            <img src="img1.jpg">
        </div>
    </section>




    <!-- CONTACT FORM -->

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">

            <!-- Column 1 -->
            <div class="footer-col">
                <h2>Holiday Planners</h2>
                <p>
                    Holiday Planners sit amet consectetur adipisicing elit.
                    Perferendis sapiente tenetur officiis explicabo fugit.
                </p>


            </div>

            <!-- Column 2 -->
            <div class="footer-col">
                <h2>Navigation</h2>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Destination</a></li>
                    <li><a href="#">Tour</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="footer-col contact-info">
                <h2>Need Help ?</h2>
                <p><strong>Call Us:</strong><br> +123 456 7890</p>
                <p><strong>Email:</strong><br> holidayplanners@gmail.com</p>
                <p><strong>Location:</strong><br> Main Street, Victoria 8007</p>

                <div class="social-icons">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-twitter"></i>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <div>
                Copyright © <?php echo date("Y"); ?> Geek Code Lab. All Rights Reserved.
            </div>
            <div>
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms of Use</a> |
                <a href="#">Cookie Policy</a>
            </div>
        </div>

    </footer>
    <!-- SIMPLE JS -->
    <script>
    console.log("About page loaded successfully!");
    </script>

</body>

</html>