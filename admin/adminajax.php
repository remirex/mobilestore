<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 16.6.2017
 * Time: 11:29
 */
require_once('../function.php');
$db=connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
$funkcija=$_GET['funkcija'];
if($funkcija=='email')
{
    $email=$_POST['email'];
    $email=testInput($email);
    $sql="SELECT * FROM korisnici WHERE email='$email'";
    $res=mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==1)
        echo "postoji";
    else echo "nepostoji";
}
if($funkcija=='regist')
{
    // čitanje promenljivih koje su nam došle GET metodom !!!
    $first_name=mysqli_real_escape_string($db, $_POST['first_name']);
    $first_name = strip_tags($_POST['first_name']);
    $last_name=$_POST['last_name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    // provera preko funkcije test_input() !!!
    $first_name=testInput($first_name);
    $last_name=testInput($last_name);
    $email=testInput($email);
    $password=testInput($password);
    // enkripcija password-a
    $hash=password_hash($password,PASSWORD_BCRYPT);
    // definisanje upita !!
    $sql="INSERT INTO korisnici(first_name,last_name,email,password,token) VALUES ('$first_name','$last_name','$email','$hash','')";
    if(mysqli_query($db,$sql) or die(mysqli_error($db)))
    {
        echo "<font color='green'>Uspešna registracija</font>";
    }
    else{
        echo  "<font color='red'>Neuspešna registracija</font>";
    }
}
