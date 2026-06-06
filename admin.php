<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
header("Location: login.php");
exit;
}

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$query = "SELECT * FROM users ORDER BY id DESC";
$result = pg_query($conn,$query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <style>
    body {
        margin: 0;
        background: #f4f6f9;
        font-family: Arial, Helvetica, sans-serif;
    }



    .main {
        margin-left: 220px;
        padding: 20px;
    }

    .header {
        background: white;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #3498db;
        color: white;
    }
    </style>
</head>

<body>


    <?php include "admin_menu.php"; ?>
    <div class="main">

        <div class="header">
            <h2>Registered Users</h2>
        </div>

        <table>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>

            <?php
while($row = pg_fetch_assoc($result)){
echo "<tr>";
echo "<td>".$row['id']."</td>";
echo "<td>".$row['fullname']."</td>";
echo "<td>".$row['email']."</td>";
echo "<td>".$row['role']."</td>";
echo "</tr>";
}
?>

        </table>

    </div>

</body>

</html>