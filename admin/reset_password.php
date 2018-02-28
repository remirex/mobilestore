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
        input[type=password] {
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
<?php
require_once'../function.php';
$db=connect();
if(isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['token']) and !empty($_GET['token']))
{
    //čitanje get globalnih varijabli !!!
    $email = mysqli_real_escape_string($db, $_GET['email']);
    $email = strip_tags($_GET['email']);
    $token = mysqli_real_escape_string($db, $_GET['token']);
    $token = strip_tags($_GET['token']);
    //definisanje upita !!!bitno je da name je token različit od empty i da je expire veći od trnutnog vremena !!!
    $sql = "SELECT * FROM korisnici WHERE email='$email' and token='$token' and token <> '' and istek > NOW() LIMIT 1";
    $res = mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==0)
    {
        echo "<p style='color: red'>Uneli ste pogrešan URl za validaciju passworda, pokušajte ponovo !!!!</p>";
    }
}
else
{
    echo "<p style='color: red'>Izvinite validacija je prekinuta, pokušajte ponovo !!!!</p>";
}
?>
<div style="margin: 100px auto">
    <div id="forgot_password">
        <h1 style="text-align: center">Reset your password?</h1>
        <form action="#" method="post">
            <label for="pass">New Password:
                <input type="password" name="password" id="pass" placeholder="New Password">
            </label><br><br>
            <label for="pass2">Confirm new password:
                <input type="password" name="password2" id="pass2" placeholder="Confirm new password">
            </label><br><br>
            <input type="submit" name="reset" value="Reset password">
            <h4 style="text-align: center"><a href="login.php">Back to Login page</a></h4>
        </form>
        <?php
        if(isset($_POST['reset']))
        {
            // čitenje prom !!!
            $password = mysqli_real_escape_string($db, $_POST['password']);
            $password = strip_tags($_POST['password']);
            $password2 = mysqli_real_escape_string($db, $_POST['password2']);
            $password2 = strip_tags($_POST['password2']);
            if($password == $password2)
            {
                // kriptovanje novog passworda !!!
                $password = password_hash($password,PASSWORD_BCRYPT);
                $sql = "UPDATE korisnici SET password='$password',token='' WHERE email='$email'";
                if(mysqli_query($db,$sql) or die(mysqli_error($db)))
                {
                    echo "<p style='green'>Uspešno ste resetovali vaš password</p>";
                }
            }
            else {
                echo "<p style='green'>Lozinke se ne poklapaju !!!</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
