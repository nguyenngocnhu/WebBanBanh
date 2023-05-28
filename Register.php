<?php

@include'config.php';
if(isset($_POST['submit'])){
    $filter_name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $name =mysqli_real_escape_string($conn,$filter_name);
    $filter_email=filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $email =mysqli_real_escape_string($conn,$filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $message[] = 'user already exist!';
     }else{
        if($pass != $cpass){
           $message[] = 'confirm password not matched!';
        }else{
           mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
           $message[] = 'registered successfully!';
           header('location:login.php');
        }
     }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

         <div class="form">
              <form action="" method="post">
        <div class="my-form bg-dark">
            <h1>Register Form</h1>
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
                <div class="mb-3 mt-4">
                    <label for="exampleInputPassword1" class="form-label">RPassword</label>
                    <input type="password" name="cpass" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" name="submit" class="btn btn-light mt-3">Register</button>
            </form>
            <p class="mt-4">Have u a account?? <a class="nav-link text-white"href="Login.php">Login now</a></p>
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
            max-height: 55vh;
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