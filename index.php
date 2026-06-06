<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Private Holidays - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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


    <!-- ================= HERO ================= -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Enjoy The Travel With</h1>
            <h2>Holiday Planners</h2>
            <p>Explore amazing destinations around the world</p>

            <!--<div class="search-bar">
                <input type="text" placeholder="Where to?">
                <input type="date">
                <select>
                    <option>Tour Type</option>
                    <option>Adventure</option>
                    <option>Family</option>
                </select>
                <button>Find Now</button>-->
        </div>
        </div>
    </section>

    <!-- ================= VACATION IDEAS ================= -->
    <section class="ideas">
        <h1>Choose The Destination</h1>
        <h3>Just Right For Your Vacation </h3>
        <div class="idea-container">
            <a href="destination.php" class="idea-card-link">
                <div class="idea-card">
                    <img src="jaipur.jpg">
                    <div class="idea-title"> jaipur </div>
                </div>
            </a>
            <a href="destination.php" class="idea-card-link">
                <div class="idea-card">
                    <img src="beach.jpg">
                    <div class="idea-title">kerala</div>
                </div>
            </a>
            <a href="destination.php" class="idea-card-link">
                <div class="idea-card">
                    <img src="city.jpg">
                    <div class="idea-title">kashmir </div>
                </div>
            </a>
        </div>
    </section>

    <!-- ================= RECENT LOCATIONS ================= -->
    <section class="locations">

        <h2 style="text-align: center;"><i class="fa fa-align-center" aria-hidden="true"> Trending, Best Selling Tours
                And Fun Destinations</i>
        </h2>


        <div class="location-grid">

            <!-- CARD 1 -->
            <!--<div class="location-card">

                <span class="discount">20% OFF</span>

                <img src="kerla.jpg">

                <div class="location-content">
                    <h3>Thalie 5</h3>
                    <p>Luxury villa in Mauritius with beach access.</p>

                    <a href="booking.php?id=1">
                        <button class="book-btn">BOOK NOW</button>
                    </a>

                </div>
        </div>

-->
            <!-- CARD 2 -->
            <!-- <div class="location-card">

                <span class="discount">15% OFF</span>

                <img src="kashmir.jpg">

                <div class="location-content">
                    <h3>Montage Kapalua</h3>
                    <p>Beautiful ocean view private resort.</p>
                    <a href="booking.php?id=2">
                        <button class="book-btn">BOOK NOW</button>
                    </a>

                </div>
            </div>
-->

            <!-- CARD 3 -->
            <!--            <div class="location-card">

                <span class="discount">30% OFF</span>

                <img src="jaipur.jpg">

                <div class="location-content">
                    <h3>Varanasi</h3>
                    <p>Experience spiritual beauty and culture.</p>

                    <a href="booking.php?id=3">
                        <button class="book-btn">BOOK NOW</button>
                    </a>

                </div>
            </div>
-->

            <?php
$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$query = "SELECT * FROM destinations WHERE show_home = true ORDER BY id DESC LIMIT 3";
$result = pg_query($conn,$query);

while($row = pg_fetch_assoc($result)){
?>
            <div class="location-card">

                <?php if($row['discount'] > 0){ ?>
                <span class="discount"><?php echo $row['discount']; ?>% OFF</span>
                <?php } ?>

                <img src="uploads/<?php echo $row['image']; ?>">

                <div class="location-content">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo substr($row['description'],0,70); ?>...</p>

                    <a href="booking.php?id=<?php echo $row['id']; ?>">
                        <button class="book-btn">BOOK NOW</button>
                    </a>
                </div>
            </div>
            <?php } ?>

        </div>
    </section>

    <!-- ================= WHY DIFFERENT ================= -->
    <section class="why">
        <h2>Why we are different</h2>
        <div class="why-container">
            <div class="why-box">
                <div class="icon">✈</div>
                <h3>Tailor-Made Packages</h3>
                <p>Customized trips designed for your perfect holiday.</p>
            </div>

            <div class="why-box">
                <div class="icon">📅</div>
                <h3>Best Experience</h3>
                <p>Premium services and unforgettable memories.</p>
            </div>

            <div class="why-box">
                <div class="icon">💎</div>
                <h3>Exquisite Service</h3>
                <p>We guide you from booking to trip completion.</p>
            </div>
        </div>
    </section>

    <!-- ================= CONTACT ================= -->
    <!-- <section class="contact">
        <div class="contact-overlay"></div>
        <div class="contact-box">
            <h2>Send us a message</h2>
            <input type="text" placeholder="Your Name">
            <input type="email" placeholder="Email">
            <textarea placeholder="Message"></textarea>
            <button>SEND</button>
        </div>
        </section>
-->
    <!-- ================= FOOTER ================= -->
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