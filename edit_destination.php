<?php

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$id = $_GET['id'];

$query = "SELECT * FROM destinations WHERE id=$1";
$result = pg_query_params($conn,$query,array($id));

$data = pg_fetch_assoc($result);

if(isset($_POST['update'])){

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];

$update = "UPDATE destinations 
SET title=$1, description=$2, price=$3
WHERE id=$4";

pg_query_params($conn,$update,array($title,$description,$price,$id));

header("Location: admin_destinations.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Destination</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f6f9;
        margin: 0;
    }

    .form-container {
        width: 500px;
        margin: 60px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-container input,
    .form-container textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-container textarea {
        height: 100px;
        resize: none;
    }

    .update-btn {
        width: 100%;
        padding: 12px;
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .update-btn:hover {
        background: #219150;
    }
    </style>

</head>

<body>
    <?php include "admin_menu.php"; ?>

    <div class="form-container">

        <h2>Edit Destination</h2>

        <form method="POST">

            <input type="text" name="title" value="<?php echo $data['title']; ?>" placeholder="Destination Title">

            <textarea name="description" placeholder="Description"><?php echo $data['description']; ?></textarea>

            <input type="number" name="price" value="<?php echo $data['price']; ?>" placeholder="Price">

            <button class="update-btn" name="update">
                Update Destination
            </button>

        </form>

    </div>


</body>

</html>