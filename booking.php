<?php session_start();

$destination="";

if(isset($_GET['destination'])){
$destination=$_GET['destination'];
}

?>
<?php

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$id = 0;

if(isset($_GET['id'])){
$id = $_GET['id'];
}
$query = "SELECT * FROM destinations WHERE id=$1";
$result = pg_query_params($conn,$query,array($id));

$tour = pg_fetch_assoc($result);

if(!$tour){
    echo "Invalid Tour ID";
    exit;
}

/* CHECK BOOKING STATUS */

$user_email = "";

$booking_status = "";

$user_email = $_POST['email'] ?? $_GET['email'] ?? "";

if(isset($_GET['email'])){
    $user_email = $_GET['email'];
}

if($user_email != ""){

$check = "SELECT status FROM bookings 
WHERE destination_id=$1 AND email=$2 
ORDER BY id DESC LIMIT 1";

$res = pg_query_params($conn,$check,array($id,$user_email));

if(pg_num_rows($res) > 0){

$data = pg_fetch_assoc($res);

$booking_status = $data['status'];

}

}



/* BOOKING SUBMIT */

if(isset($_POST['book_tour'])){

$destination_id = $_POST['destination_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['tour_date'];
$tickets = $_POST['tickets'];
$message = $_POST['message'];

// Validation
$errors = array();

// Validate phone number (10 digits)
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    $errors[] = "Phone number must be exactly 10 digits";
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address";
}

// Validate tour date (not in the past)
$today = date('Y-m-d');
if (strtotime($date) < strtotime($today)) {
    $errors[] = "Tour date cannot be in the past";
}

// If there are errors, display them
if (!empty($errors)) {
    echo "<script>\nalert('Booking Error: " . implode('\n', $errors) . "');\n</script>";
} else {
    // If validation passes, insert the booking
    $insert = "INSERT INTO bookings
(destination_id,full_name,email,phone,tour_date,tickets,message,status)
VALUES ($1,$2,$3,$4,$5,$6,$7,'Pending')";

    pg_query_params($conn,$insert,
    array($destination_id,$name,$email,$phone,$date,$tickets,$message));

    echo "<script>
alert('Booking Sent! Waiting for Admin Confirmation');
window.location='booking.php?id=$destination_id&email=$email';
</script>";
}

}

?>

<!DOCTYPE html>
<html>

<head>

    <title><?php echo $tour['title']; ?> - Tour Details</title>

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
        background: url('bookpage.jpg') center/cover no-repeat;
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

    /* LAYOUT */

    .container {
        width: 1200px;
        margin: auto;
        display: flex;
        gap: 30px;
        padding: 50px 0;
    }

    /* LEFT SIDE */

    .left {
        width: 70%;
    }

    /* RIGHT SIDE */

    .right {
        width: 30%;
    }

    /* CARD */

    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    /* IMAGE */

    .main-img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* FEATURES */

    .features {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }

    /* PRICE BADGE */

    .price {
        position: absolute;
        top: -20px;
        right: 20px;
        background: #c9a24d;
        color: white;
        padding: 15px;
        border-radius: 50%;
        font-weight: bold;
    }

    /* BOOK FORM */

    .form input,
    .form textarea,
    .form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form button {
        background: #c9a24d;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
    }

    /* BENEFITS */

    .benefits li {
        margin-bottom: 8px;
    }

    /* CONTACT */

    .contact {
        background: #333;
        color: white;
        padding: 20px;
        border-radius: 8px;
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
                        <a href="logout.php" style="background: white; color: #c9a24d; padding: 8px 15px; border-radius: 25px; text-decoration: none; font-weight: 500;">Logout</a>
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
            <h1>Book your Tour</h1>
            <p>Discover amazing places with Holiday Planners</p>
        </div>

    </section>

    <div class="container">

        <!-- LEFT CONTENT -->

        <div class="left">

            <div class="card" style="position:relative;">

                <?php
                $final_price = $tour['price'];

                if($tour['discount'] > 0){
                    $final_price = $tour['price'] - ($tour['price'] * $tour['discount'] / 100);
                }
                ?>

                <div class="price">
                    ₹<?php echo $final_price; ?>
                </div>

                <?php if($tour['discount'] > 0){ ?>
                <p style="color:red;">
                    <del>₹<?php echo $tour['price']; ?></del>
                    (<?php echo $tour['discount']; ?>% OFF)
                </p>
                <?php } ?>

                <h2><?php echo $tour['title']; ?></h2>

                <p style="color:#c9a24d;font-weight:600;">
                    <?php echo $tour['tour_type']; ?> Tour
                </p>

                <img class="main-img"
                    src="uploads/<?php echo !empty($tour['image']) ? $tour['image'] : 'default.jpg'; ?>">
                <div class="features">

                    <div>
                        <b>Duration</b><br>
                        <?php echo $tour['duration']; ?>
                    </div>

                    <div>
                        <b>Group Size</b><br>
                        <?php echo $tour['group_size']; ?>
                    </div>

                    <div>
                        <b>Tour Type</b><br>
                        <?php echo $tour['tour_type']; ?>
                    </div>

                </div>

                <h3>Tour Description</h3>

                <p>
                    <?php echo $tour['description']; ?>
                </p>

            </div>

        </div>

        <!-- RIGHT SIDEBAR -->

        <div class="right">

            <div class="card">

                <h3>Book This Tour</h3>

                <?php if($booking_status == "Pending"){ ?>

                <button style="background:orange;color:white;padding:12px;width:100%;border:none;">
                    Booking Pending
                </button>

                <?php } elseif($booking_status == "Confirmed"){ ?>

                <button style="background:green;color:white;padding:12px;width:100%;border:none;">
                    Booking Confirmed
                </button>

                <?php } else { ?>

                <form method="POST" class="form">

                    <input type="hidden" name="destination_id" value="<?php echo $tour['id']; ?>">

                    <input type="text" name="name" placeholder="Full Name" required>

                    <input type="email" name="email" placeholder="Email" required>

                    <input type="text" name="phone" placeholder="Phone Number (10 digits)" pattern="[0-9]{10}" required>

                    <label>Tour Date</label>

                    <input type="date" name="tour_date" min="<?php echo date('Y-m-d'); ?>" required>

                    <label>Tickets</label>

                    <select name="tickets">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>

                    <textarea name="message" placeholder="Message"></textarea>

                    <button name="book_tour">Book Now</button>

                </form>

                <?php } ?>

            </div>


        </div>

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