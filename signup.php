<?php
require_once("config.php");
$username = $password = $email = $confirm_password = "";
$username_error = $password_error = $email_error = $confirm_password_error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST['username']);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    if (empty((trim($_POST['password'])))) {
        $password_err = 'Password cannot be blank';
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $password_err = 'Password cannot be less than 8 characters';
    } else {
        $password = trim($_POST['password']);
    }

    if (trim($_POST[$password]) != trim($_POST['confirm password'])) {
        $password_err = 'Password cannot be blank';
    }
    // If no error faced
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            // Setting parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
            } else {
                echo "Something went wrong... Cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoFiller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    section{
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
}

section .imgbx{
    /* margin-top: 100px; */
    z-index: -1;
    position: relative;
    width: 50%;
    height: 100%;
}

section .imgbx::before{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(225deg,#e91e63, #03a9f4);
    z-index: 1;
    mix-blend-mode: screen;
}

section .imgbx img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

section .contentbx{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    height: 100%;
}

section .contentbx .formbx h2{
    color: #607d8d;
    font-weight: 600;
    font-size: 1.5em;
    text-transform: uppercase;
    margin-bottom: 20px;
    border-bottom: 4px solid #03a9f4;
    display: inline-block;
    letter-spacing: 1px;
} 

section .contentbx .formbx .inputbx span{
    font-size: 16px;
    margin-bottom: 5px;
    display: inline-block;
    color: #607db8;
    font-weight: 16px;
    letter-spacing: 1px;
}

section .contentbx .formbx .inputbx input{
    width: 100%;
    padding: 10px 20px;
    outline: none;
    font-weight: 400;
    border: 1px solid #607db8;
    font-size: 16px;
    letter-spacing: 1px;
    color: #607db8;
    background: transparent;
    border-radius: 30px;
}

section .contentbx .formbx .inputbx input[type="submit"]{
    background: #03a9f4;
    color: black;
    outline: none;
    border: none;
    font-weight: 500;
    cursor: pointer;
}

section .contentbx .formbx .inputbx input[type="submit"]:hover{
    background: #CBF7F3;
    
}

section .contentbx .formbx .check{
    /* margin-top: 10px; */
    margin-bottom: 10px;
    color: #607d8d;
    font-weight: 400;
    font-size: 14px;
}

section .contentbx .formbx .inputbx p{
    color: #607d8d;
}
section .contentbx .formbx .inputbx p a{
    color: #03a9f4;
}

section{
    background-position-y: top;
}

    svg{
    position: absolute;
}

section .contentbx .formbx{
    margin-top: 140px;
}
</style>
<body>
    <div id="main-contentbox">

        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">AutoFillers</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-box">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                        </li>
                        
                    </ul>

                </div>
            </div>
        </nav>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319">
            <path fill="#03a9f4" fill-opacity="1"
                d="M0,192L80,170.7C160,149,320,107,480,112C640,117,800,171,960,176C1120,181,1280,139,1360,117.3L1440,96L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
            </path>
        </svg>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <div>
    <section>
        <div class="imgbx">
            <img src="1.jpg" alt="">
        </div>
        <div class="contentbx">
            <div class="formbx">
                <h2>Sign Up</h2>
                <form action="" method="post">
                <div class="inputbx">
                        <span>Enter Name</span>
                        <input type="text" name="name">
                    </div>
                    <div class="inputbx">
                        <span>Username</span>
                        <input type="text" name="username">
                    </div>
                    <div class="inputbx">
                        <span>Password</span>
                        <input type="password" name="password">
                    </div>
                    <div class="inputbx">
                        <span>Confirm Password</span>
                        <input type="password" name="confirm_password">
                    </div>
                    <div class="check" >
                        <label><input type="checkbox" name="" required> I agree to terms & conditions</label>
                    </div>
                    <div class="inputbx">
                        <input type="submit" value="Sign Up" name="">
                    </div>
                    <div class="inputbx">
                        <p>Already have an account? <a href="signup.php">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>


    </div>






</body>

</html>