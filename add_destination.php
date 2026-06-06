<?php
$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

if(isset($_POST['add_destination'])){

$title=$_POST['title'];
$description=$_POST['description'];
$price=$_POST['price'];
$duration=$_POST['duration'];
$group_size=$_POST['group_size'];
$tour_type = isset($_POST['tour_type']) ? $_POST['tour_type'] : '';$image=$_FILES['image']['name'];
$tmp=$_FILES['image']['tmp_name'];

$folder="uploads/";

if(!file_exists($folder)){
mkdir($folder,0777,true);
}

move_uploaded_file($tmp,$folder.$image);

$discount = $_POST['discount'];
$show_home = $_POST['show_home'];

$query="INSERT INTO destinations(title,description,price,duration,group_size,image,discount,show_home,tour_type)
VALUES('$title','$description','$price','$duration','$group_size','$image','$discount','$show_home','$tour_type')";

pg_query($conn,$query);

echo "Destination Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Destination</title>

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fb;
    }

    /* FORM CONTAINER */

    .form-box {
        width: 600px;
        margin: 60px auto;
        background: white;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* TITLE */

    .form-box h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
    }

    /* INPUTS */

    input,
    textarea,
    select {
        width: 100%;
        padding: 12px;
        margin: 10px 0 18px 0;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.3s;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #c9a24d;
        outline: none;
    }

    /* LABEL */

    label {
        font-size: 14px;
        font-weight: 500;
    }

    /* BUTTON */

    button {
        background: #c9a24d;
        color: white;
        padding: 12px;
        border: none;
        width: 100%;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #b8933f;
    }

    /* SUCCESS MESSAGE */

    .success {
        background: #eaf7ea;
        color: green;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
    }
    </style>

</head>

<body>
    <?php include "admin_menu.php"; ?>

    <div class="form-box">

        <h2>Add Tour Destination</h2>

        <?php if(isset($_POST['add_destination'])){ ?>
        <div class="success">Destination Added Successfully ✅</div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Tour Title</label>
            <input type="text" name="title" placeholder="Enter Tour Title" required>

            <label>Description</label>
            <textarea name="description" placeholder="Enter Description"></textarea>

            <label>Tour Type</label>
            <select name="tour_type" required>
                <option value="">Select Tour Type</option>
                <option>Adventure</option>
                <option>Beach</option>
                <option>Hill Station</option>
                <option>Cultural</option>
                <option>Family</option>
                <option>Honeymoon</option>
            </select>

            <label>Duration</label>
            <input type="text" name="duration" placeholder="e.g. 5 Days / 4 Nights">

            <label>Group Size</label>
            <input type="text" name="group_size" placeholder="e.g. 2-10 People">

            <label>Price (₹)</label>
            <input type="number" name="price" placeholder="Enter Price">

            <label>Discount (%)</label>
            <input type="number" name="discount" placeholder="Enter Discount">

            <label>Show on Home Page</label>
            <select name="show_home">
                <option value="true">Yes</option>
                <option value="false">No</option>
            </select>

            <label>Upload Image</label>
            <input type="file" name="image">

            <button type="submit" name="add_destination">
                Add Destination
            </button>

        </form>

    </div>

</body>

</html>