<?php
require_once("../function.php");
if(isset($_GET['odjava']))
{
    session_start();
    unset($_SESSION['status']);
    session_destroy();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="../jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="main.js"></script>
    <style>
        .login, .regist {
            float: left;
            width: 475px;
            border-radius: 4px;
            padding: 5px;
            margin-bottom: 100px;
        }
        input[type=text], input[type=email], input[type=password]{
            padding: 5px 10px;
            border-radius: 5px;
        }
        input[type=button], input[type=submit]{
            background-color: orange;
            border: none;
            color: #000;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="big_wrapper">
    <header id="header">
        <div id="logo">
            <a href="../index.php"><img src="../images/logo.png" alt="logo"></a>
        </div>
        <div id="slogan">
            <p><b>Mobile world</b></p>
        </div>
    </header><!-- end header -->
    <nav id="nav">
        <ul>
            <li><a href="../index.php"><b>home</b></a></li>
        </ul>
    </nav><!-- end nav -->
    <div id="baner">
        <a href="#"><img src="../images/mobile_banner.jpg" alt="baner"></a>
    </div>
    <div id="contain" style="padding:5px">
        <div class="login">
            <h2>Login</h2>
            <?php
            $db=connect();
            if(!$db) echo 'Greška';
            //else echo 'Uspešno';
            $password='';
            $err=$err2='';
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //echo 'Provera';
                $email=$_POST['email'];
                $password=$_POST['password'];
                // test_input()
                if(!empty($password))
                {
                    if(!preg_match("/^[a-zA-Z0-9@#$%&^]*$/",$password))
                        $err='Nedozvoljen karakter';
                    else{
                        $sql="SELECT * FROM korisnici WHERE email='$email'";
                        $res=mysqli_query($db,$sql);
                        if(mysqli_num_rows($res)==1)
                        {
                            $row=mysqli_fetch_object($res);
                            if(password_verify($password,$row->password))
                            {
                                session_start();
                                if($row->status=='gost')
                                {
                                    $_SESSION['gost_id']=$row->id;
                                    $_SESSION['gost_ime']=$row->first_name;
                                    $_SESSION['gost_status']=$row->status;
                                    header('location:../index.php');
                                }
                                else{
                                    $_SESSION['status']=$row->status;
                                    header('location:pocetna.php');
                                }
                            }
                        }
                        else{
                            $err2='Ne postoji korisnik sa ovim podacima';
                        }
                    }
                }
                else{
                    $err='Obavezno polje!!!';
                }
            }
            ?>
            <form action="#" method="post">
                <span style="color: red"><?php echo $err2; ?></span><br>
                <label for="mail">Email:</label><br>
                <input type="email" id="mail" name="email" placeholder="Unesite email" required><br>
                <label for="pass">Password:</label><br>
                <input type="password" id="pass" name="password" placeholder="Unesite password"><br>
                <span style="color: red"><?php echo $err; ?></span><br>
                <input type="submit" name="login"  value="Login">
            </form>
            <br>
            <a href="forgot_password.php">Forgot your password?</a>

        </div>
        <div class="regist">
            <h2>Registration</h2>
            <span id="info"></span>
            <form action="#" method="post">
                <label for="fname">First Name:</label><br>
                <input type="text" id="fname" name="first_name" placeholder="First Name" required><br>
                <span id="fname_req"></span><br>
                <label for="lname">Last Name:</label><br>
                <input type="text" id="lname" name="last_name" placeholder="Last Name" required><br>
                <span id="lname_req"></span><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="Email" required>&nbsp;<span id="exist"></span><br>
                <span id="email_req"></span><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Password" required>&nbsp;<span id="p1"></span><br>
                <span id="pass_req"></span><br>
                <label for="password2">Repeat Password:</label><br>
                <input type="password" id="password2" name="password2" placeholder="Repeat Password" required>&nbsp;<span id="p2"></span><br>
                <span id="pass2_req"></span><br><br>
                <input type="button" id="regist" value="Regist" disabled>
            </form>
        </div>
    </div><!-- end contain -->
    <footer id="footer">
        <p><b>Copyright &copy; by haker87 2017</b></p>
    </footer>
</div><!-- end big_wrapper-->
</body>
</html>
