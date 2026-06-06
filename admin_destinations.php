<?php
$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$query = "SELECT * FROM destinations ORDER BY id DESC";
$result = pg_query($conn,$query);
?>



<div class="main-content">

    <h1>Manage Destinations</h1>
    <?php include "admin_menu.php"; ?>

    <table>

        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php while($row = pg_fetch_assoc($result)){ ?>

        <tr>

            <td><?php echo $row['id']; ?></td>

            <td>
                <img src="uploads/<?php echo $row['image']; ?>" class="dest-img">
            </td>

            <td><?php echo $row['title']; ?></td>

            <td>₹<?php echo $row['price']; ?></td>

            <td>

                <a class="edit-btn" href="edit_destination.php?id=<?php echo $row['id']; ?>">Edit</a>

                <a class="delete-btn" href="delete_destination.php?id=<?php echo $row['id']; ?>"
                    onclick="return confirm('Delete this destination?')">
                    Delete
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<style>
/* MAIN CONTENT */

.main-content {
    margin-left: 240px;
    padding: 40px;
    font-family: Arial, Helvetica, sans-serif;
}

/* TITLE */

.main-content h1 {
    margin-bottom: 25px;
}

/* TABLE */

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table th {
    background: #34495e;
    color: white;
    padding: 12px;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

table tr:hover {
    background: #f2f2f2;
}

/* IMAGE */

.dest-img {
    width: 80px;
    border-radius: 6px;
}

/* BUTTONS */

.edit-btn {
    background: #3498db;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
    margin-right: 5px;
}

.delete-btn {
    background: #e74c3c;
    color: white;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
}

.edit-btn:hover {
    background: #2980b9;
}

.delete-btn:hover {
    background: #c0392b;
}
</style>