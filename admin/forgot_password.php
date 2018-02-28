<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <style>
        #forgot_password {
            background-color: lightgray;
            margin: auto;
            color: gray;
            width: 450px;
            padding: 25px;
            border-radius: 5px;
        }
        input[type=email] {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
        }
        input[type=submit]{
            padding: 5px;
            border-radius: 5px;
            background-color: orange;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div style="margin: 100px auto">
    <div id="forgot_password">
        <h1 style="text-align: center">Forgot your password?</h1>
        <form action="#" method="post">
            <label for="email">
                <input type="email" name="email" id="email" placeholder="Email">
            </label><br><br>
            <input type="submit" name="send" value="Apply">
        </form>
        <h4 style="text-align: center"><a href="login.php">Back to Login page</a></h4>
        <?php
        require_once('../function.php');
        $db = connect();
        if(isset($_POST['send']))
        {
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $email = strip_tags($_POST['email']);
            $sql = "SELECT * FROM korisnici WHERE email='$email'";
            $res = mysqli_query($db, $sql);
            if(mysqli_num_rows($res)==1)
            {
                //definisanje tokena !!!
                $str="qwertzuioplkjhgfdsayxcvbnm1234567890";
                $str=str_shuffle($str);
                $str=md5(substr($str,0,20));
                //definisanje upita za update tokena !!!
                $url = "http://localhost/mobilestores/admin/reset_password.php?token=$str&email=$email";
                $sql="UPDATE korisnici SET token='$str',istek=DATE_ADD(NOW(),INTERVAL 5 MINUTE ) WHERE email='$email'";
                mysqli_query($db,$sql);
                echo "Proverite svoj email <b>$email</b>, kako bi mogli da nastavite sa resetovanjem password-a !!";
            }
            else echo "<p style='color: red;'>Ne postoji korisnik sa ovom email adresom !!!</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
