<?php

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");


/* CONFIRM BOOKING */

if(isset($_GET['confirm'])){

$id = $_GET['confirm'];

pg_query($conn,"UPDATE bookings SET status='Confirmed' WHERE id=$id");

}


/* CANCEL BOOKING */

if(isset($_GET['cancel'])){

$id = $_GET['cancel'];

pg_query($conn,"UPDATE bookings SET status='Cancelled' WHERE id=$id");

}


/* GET BOOKINGS */

$query = "SELECT bookings.*, destinations.title
FROM bookings
JOIN destinations
ON bookings.destination_id = destinations.id
ORDER BY bookings.id DESC";

$result = pg_query($conn,$query);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Booking Management</title>

    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        margin: 0;
    }

    /* MAIN CONTENT (AFTER SIDEBAR) */

    .main-content {
        margin-left: 220px;
        padding: 30px;
    }

    /* PAGE TITLE */

    .page-title {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #2c3e50;
    }

    /* CARD */

    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    /* TABLE */

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    table th {
        background: #2c3e50;
        color: white;
        padding: 14px;
        font-size: 14px;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
        font-size: 14px;
    }

    /* ROW HOVER */

    table tr:hover {
        background: #f9fbfc;
    }

    /* STATUS BADGES */

    .status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .pending {
        background: #fff3cd;
        color: #856404;
    }

    .confirmed {
        background: #d4edda;
        color: #155724;
    }

    .cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    /* BUTTONS */

    .btn {
        padding: 7px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        margin: 2px;
        display: inline-block;
    }

    .confirm-btn {
        background: #27ae60;
        color: white;
    }

    .confirm-btn:hover {
        background: #219150;
    }

    .cancel-btn {
        background: #e74c3c;
        color: white;
    }

    .cancel-btn:hover {
        background: #c0392b;
    }
    </style>

</head>

<body>

    <?php include "admin_menu.php"; ?>
    <div class="main-content">

        <div class="page-title">
            Booking Management
        </div>

        <div class="card">

            <h3>Tour Booking Details</h3>

            <table>

                <tr>

                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Tour</th>
                    <th>Date</th>
                    <th>Tickets</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>


                <?php

while($row = pg_fetch_assoc($result)){

?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['full_name']; ?></td>

                    <td><?php echo $row['email']; ?></td>

                    <td><?php echo $row['phone']; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['tour_date']; ?></td>

                    <td><?php echo $row['tickets']; ?></td>

                    <td>

                        <?php

if($row['status']=="Pending"){
echo "<span class='pending'>Pending</span>";
}

elseif($row['status']=="Confirmed"){
echo "<span class='confirmed'>Confirmed</span>";
}

else{
echo "<span class='cancelled'>Cancelled</span>";
}

?>

                    </td>

                    <td>

                        <a class="btn confirm-btn" href="?confirm=<?php echo $row['id']; ?>">

                            Confirm

                        </a>

                        <a class="btn cancel-btn" href="?cancel=<?php echo $row['id']; ?>">

                            Cancel

                        </a>

                    </td>

                </tr>

                <?php

}

?>

            </table>

        </div>

    </div>

</body>

</html>