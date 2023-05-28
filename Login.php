<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


    if (mysqli_num_rows($select_users) > 0) {

        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'admin') {

            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');

        } elseif ($row['user_type'] == 'user') {

            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');

        } else {
            $message[] = 'no user found!';
        }

    } else {
        $message[] = 'incorrect email or password!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/styles.css">

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>


    <form action="" method="post">
        <div class="my-form bg-dark">
            <h1>Login Form</h1>
            <form>
                <div class="mb-3 mt-4">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3 mt-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" name="submit" class="btn btn-light mt-3">LOGIN</button>
            </form>
            <p class="mt-4">Not a member? <a href="Register.php">Signup now</a></p>
        </div>
    </form>


    <style>
         body{
        background-image: url('https://hainh2k3.com/wp-content/uploads/2018/11/Random-Pure-CSS-Parallax-Stars.gif');
        background-repeat: no-repeat;
        background-size: cover;
    }
        .my-form {
            padding: 2em;
            color: #fff;
            max-width: 55vh;
            max-height: 65vh;
            margin: auto;
            margin-top: 100px;
            
        }

        h1 {
            font-weight: bold;
            text-align: center;
            font-size: 2.5em;
        }

        .form-control {
            background-color: inherit;
            color: #fff;
            border: none;
            border-bottom: 1px solid #fff;
            border-radius: 0;
            padding-left: 0;
        }

        .form-control:focus {
            background-color: inherit;
            color: #fff;
            box-shadow: none;
            border-color: #fff;
        }

        .btn {
            border-radius: 0;
            width: 100%;
            font-weight: bold;
        }

        .my-form p {
            color: gray;
            text-align: center;
        }

        .my-form p a {
            color: #e1e1e1;
            text-decoration: none;
        }

        .my-form p a:hover {
            color: #fff;
        }
    </style>

</body>

</html>