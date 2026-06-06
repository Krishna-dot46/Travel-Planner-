<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Private Holidays - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
    /* HERO */
    .hero {
        height: 100vh;
        background: url('contect.jpg') center/cover no-repeat;
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

    /* ===========================
CONTACT TOP
=========================== */

    .contact-section {
        padding: 60px 60px;
    }

    .contact-top {
        display: flex;
        gap: 40px;
        margin-bottom: 60px;
    }

    .contact-form {
        width: 50%;
        background: white;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border-radius: 6px;
    }

    .contact-form input,
    .contact-form textarea,
    .contact-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .contact-form button {
        background: #caa553;
        border: none;
        padding: 12px 25px;
        color: white;
        cursor: pointer;
    }

    .contact-form button:hover {
        background: #b8903f;
    }

    .success {
        background: #d4edda;
        padding: 10px;
        margin-bottom: 15px;
        color: green;
    }

    .error {
        background: #f8d7da;
        padding: 10px;
        margin-bottom: 15px;
        color: red;
    }

    .contact-info {
        width: 35%;
        display: flex;
        flex-direction: column;
        gap: 25px;
        padding: 0 50px;
    }

    .info-box {
        background: white;
        padding: 60px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .info-box h3 {
        margin-bottom: 10px;
    }

    /* ===========================
BOTTOM SECTION
=========================== */

    .contact-bottom {
        display: flex;
        gap: 40px;
    }

    .office-details {
        width: 35%;
    }

    .office {
        background: white;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .map {
        width: 100%;
    }

    .map iframe {
        width: 100%;
        height: 400px;
        border-radius: 8px;
    }
    </style>
</head>

<body>
    <!--=================NAVBAR=================-->
    <header class="navbar">
        <div class="logo-box">
            <img src="—Pngtree—tropical travel logo with airplane_23751439.png" alt="Logo">
            <div class="brand-text">
                <h2>Holiday Planners</h2>
            </div>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About us</a></li>
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
    </header>

    <!--========================hero section===============-->
    <!-- HERO -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Contact Us</h1>
        </div>
    </section>


    <!-- ================= CONTACT ================= -->
    <section class="contact-section">
        <div class="container">

            <div class="contact-top">

                <!-- FORM -->
                <div class="contact-form">

                    <?php
include 'db.php';

$success_msg = "";
$error_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    // Get form values
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);

    // Validation
    if(empty($name) || empty($email) || empty($phone) || empty($service) || empty($message)){
        $error_msg = "Please fill all fields!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_msg = "Please enter a valid email address!";
    }
    else{

        // Secure Query
        $query = "INSERT INTO feedback(name,email,phone,service,message,submitted_at)
                  VALUES($1,$2,$3,$4,$5,NOW())";

        $result = pg_query_params($conn,$query,array(
            $name,
            $email,
            $phone,
            $service,
            $message
        ));

        if($result){
            $success_msg = "Thank you! Your message has been sent successfully.";
        }
        else{
            $error_msg = "Database error. Please try again.";
        }
    }
}
?>


                    <?php if($success_msg): ?>
                    <div class="success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>

                    <?php if($error_msg): ?>
                    <div class="error"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <form method="POST">

                        <input type="text" name="name" placeholder="Full Name" required>

                        <input type="email" name="email" placeholder="Email Address" required>

                        <input type="text" name="phone" placeholder="Phone Number" required>

                        <select name="service" required>
                            <option value="">Select Service</option>
                            <option value="Tour Booking">Tour Booking</option>
                            <option value="Hotel Booking">Hotel Booking</option>
                            <option value="Travel Guide">Travel Guide</option>
                        </select>

                        <textarea name="message" rows="5" placeholder="Message" required></textarea>

                        <button type="submit" name="submit">Send Message</button>

                    </form>

                </div>

                <!-- RIGHT INFO -->
                <div class="contact-info">

                    <div class="info-box">
                        <h3>Why Book With Us?</h3>
                        <p>✔ Best Price Guarantee</p>
                        <p>✔ 24/7 Customer Support</p>
                        <p>✔ Free Travel Insurance</p>
                    </div>

                    <div class="info-box">
                        <h3>Get a Question?</h3>
                        <p>Email: holidayplanners@gmail.com</p>
                        <p>Phone: +123 456 7890</p>
                    </div>

                </div>
            </div>

            <!-- BOTTOM SECTION -->
            <div class="contact-bottom">

                <div class="office-details">

                    <div class="office">
                        <h3>India Office</h3>
                        <p>54, Beside Shopping Mall, Gujarat</p>
                        <p>+123 456 7890</p>
                    </div>

                    <div class="office">
                        <h3>USA Office</h3>
                        <p>888 S Greenville, TX 75081</p>
                        <p>+123 456 7890</p>
                    </div>

                </div>

                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=YOUR_REAL_CODE_HERE" width="100%" height="400"
                        style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

            </div>

        </div>
    </section>

    <!--=================FOOTER=================-->
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
</body>

</html>