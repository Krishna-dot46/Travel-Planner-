<?php session_start();

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$query = "SELECT * FROM destinations ORDER BY id DESC";
$result = pg_query($conn,$query);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Destinations - Holiday Planners</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


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
        background: url('destination3.jpg') center/cover no-repeat;
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

    /* DESTINATION SECTION */
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 60px 20px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 35px;
    }

    .container h2 {
        grid-column: 1/-1;
        margin-bottom: 20px;
    }

    @media(max-width:1000px) {
        .container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:600px) {
        .container {
            grid-template-columns: 1fr;
        }
    }

    .tour-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        position: relative;
    }

    .tour-card:hover {
        transform: translateY(-8px);
    }

    .tour-card img {
        width: 100%;
        height: 230px;
        object-fit: cover;
    }

    .country-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #c9a24d;
        color: white;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 4px;
    }

    .tour-info {
        padding: 22px;
    }

    .tour-info h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .tour-info p {
        font-size: 14px;
        color: #777;
        line-height: 1.6;
        margin-bottom: 18px;
    }

    /* Duration + Group */

    .details {
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 12px 0;
        margin-bottom: 18px;
        font-size: 14px;
        color: #555;
    }

    /* Price + Button Row */

    .bottom-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-size: 24px;
        font-weight: 700;
    }

    .book-btn {
        background: #c9a24d;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .book-btn:hover {
        background: #b8933f;
    }

    /* Book Button */

    .book-btn {
        background: #c9a24d;
        color: white;
        border: none;
        padding: 12px 22px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    .book-btn:hover {
        background: #b8933f;
    }

    /* FOOTER */

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
    </style>

</head>

<body>

    <!-- ================= NAVBAR ================= -->

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
                    <a href="logout.php"
                        style="background: white; color: #c9a24d; padding: 8px 15px; border-radius: 25px; text-decoration: none; font-weight: 500;">Logout</a>
                </li>
                <?php } else { ?>
                <li><a href="login.php">log in</a></li>
                <?php } ?>
            </ul>
        </nav>

    </header>

    <!-- HERO -->

    <section class="hero">

        <div class="overlay"></div>

        <div class="hero-content">
            <h1>Explore Our Destinations</h1>
            <p>Discover amazing places with Holiday Planners</p>
        </div>

    </section>

    <!-- DESTINATIONS -->

    <div class="container">

        <h2 style="grid-column:1/-1;">Popular Tours</h2>

        <?php
while($row = pg_fetch_assoc($result)){
?>

        <div class="tour-card">

            <div class="country-tag">
                <?php echo $row['title']; ?>
            </div>

            <img src="uploads/<?php echo $row['image']; ?>">

            <div class="tour-info">

                <h3><?php echo $row['title']; ?></h3>

                <p><?php echo $row['description']; ?></p>

                <div class="details">
                    <span>⏱ <?php echo $row['duration']; ?></span>
                    <span>👥 <?php echo $row['group_size']; ?></span>
                </div>

                <div class="bottom-row">
                    <p class="price">₹<?php echo number_format($row['price']); ?></p>
                    <a href="booking.php?id=<?php echo $row['id']; ?>" class="book-btn">
                        BOOK NOW
                    </a>

                </div>

            </div>

        </div>

        <?php
}
?>

    </div>

    <!-- FOOTER -->

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

</body>

</html>