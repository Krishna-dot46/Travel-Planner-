<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

/* DATABASE CONNECTION */
$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

if(!$conn){
    die("Database connection failed");
}

/* SIGNUP LOGIC */
if(isset($_POST['signup'])){

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validation
$errors = array();

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address";
}

// Password validation
if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}
if (!preg_match('/[A-Z]/', $password)) {
    $errors[] = "Password must contain at least one uppercase letter";
}
if (!preg_match('/[a-z]/', $password)) {
    $errors[] = "Password must contain at least one lowercase letter";
}
if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]/', $password)) {
    $errors[] = "Password must contain at least one special character (!@#$%^&* etc)";
}

if (!empty($errors)) {
    $error = implode("<br>", $errors);
} else {
    // Check if email already exists
    $check = "SELECT * FROM users WHERE email=$1";
    $check_result = pg_query_params($conn, $check, array($email));
    
    if (pg_num_rows($check_result) > 0) {
        $error = "Email already exists!";
    } else {
        // Hash password and insert
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(fullname,email,password,role) VALUES($1,$2,$3,'user')";
        $result = pg_query_params($conn, $query, array($fullname, $email, $hashed_password));

        if ($result) {
            $msg = "Registration Successful. Please Login.";
        } else {
            $error = "Registration Failed!";
        }
    }
}

}

/* LOGIN LOGIC */
if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email=$1";
$result = pg_query_params($conn,$query,array($email));

if(pg_num_rows($result)==1){

$user = pg_fetch_assoc($result);

if(password_verify($password,$user['password'])){

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['fullname'];
$_SESSION['role'] = $user['role'];

/* ADMIN LOGIN */
if($user['role'] == 'admin'){

$_SESSION['admin'] = $email;
header("Location: admin.php");
exit;

}

/* NORMAL USER LOGIN */
else{

header("Location: index.php");
exit;

}

}else{
$error = "Wrong Password!";
}

}else{
$error = "Email not found!";
}

}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login & Signup</title>

    <style>
    body {
        font-family: Arial;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        background: white;
        padding: 40px;
        width: 350px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #4facfe;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background: #3a8de0;
    }

    .link {
        color: blue;
        cursor: pointer;
        margin-top: 10px;
        display: block;
    }

    .error {
        color: red;
    }

    .success {
        color: green;
    }
    </style>

</head>

<body>

    <div class="container">

        <h2 id="formTitle">Login</h2>

        <?php
if(isset($error)){ echo "<p class='error'>$error</p>"; }
if(isset($msg)){ echo "<p class='success'>$msg</p>"; }
?>

        <!-- LOGIN FORM -->

        <form method="POST" id="loginForm">

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login">Login</button>

            <span class="link" onclick="showSignup()">Create Account</span>

        </form>

        <!-- SIGNUP FORM -->

        <form method="POST" id="signupForm" style="display:none;">

            <input type="text" name="fullname" placeholder="Full Name" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password (Min 6 chars, uppercase, lowercase, special char)" required>

            <small style="color: #666; display: block; margin-bottom: 10px;">
                Password must contain: uppercase, lowercase, special character (!@#$%^&*), and at least 6 characters
            </small>

            <button type="submit" name="signup">Sign Up</button>

            <span class="link" onclick="showLogin()">Already have account?</span>

        </form>

    </div>

    <script>
    function showSignup() {
        document.getElementById("loginForm").style.display = "none";
        document.getElementById("signupForm").style.display = "block";
        document.getElementById("formTitle").innerText = "Sign Up";
    }

    function showLogin() {
        document.getElementById("signupForm").style.display = "none";
        document.getElementById("loginForm").style.display = "block";
        document.getElementById("formTitle").innerText = "Login";
    }
    </script>

</body>

</html>