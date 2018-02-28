<?php
require_once("../function.php");
session_start();
if($_SESSION['status'] != "admin")
{
    echo "<span style='color:red'><h3>Nemate pristup ovoj stranici!!!</h3></span>";
    echo "<a href='../index.php'>Back to home page</a>";
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../style.css" rel="stylesheet" type="text/css">
	<link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style>
	#proizvodi {
        background-color: orange;
        padding: 5px;
        border-radius: 4px;
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
                    <li><a href="pocetna.php"><b>home</b></a></li>
                    <li><a href="update.php"><b>update proizvoda</b></a></li>
                    <li><a href="login.php?odjava"><b>Logout</b></a></li>
                </ul>
            </nav><!-- end nav -->
            <div id="baner">
                <a href="#"><img src="../images/mobile_banner.jpg" alt="baner"></a>
            </div>
            <div id="contain" style="padding:10px">
                <div id="proizvodi">
                    <h2 style="color:white"><b>Ubacivanje novih proizvoda:</b></h2>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <p><b>Model:</b></p><input type="text" id="model" name="model" placeholder="Unesite ime modela"><br>
                        <p><b>Proizvođač:</b></p>
                        <select id="id_proizvodjaca" name="id_proizvodjaca">
                            <option value="1">Alcatel</option>
                            <option value="2">Sony</option>
                            <option value="3">Samsung</option>
                            <option value="4">Iphone</option>
                            <option value="5">Huawei</option>
                            <option value="6">htc</option>
                        </select><br>
                        <p><b>Sistem:</b></p><input type="text" id="sistem" name="sistem" placeholder="Sistem"><br>
                        <p><b>Ekran:</b></p><input type="text" id="ekran" name="ekran" placeholder="Ekran"><br>
                        <p><b>Memorija:</b></p><input type="text" id="memorija" name="memorija" placeholder="Memorija"><br>
                        <p><b>Kamera:</b></p><input type="text" id="kamera" name="kamera" placeholder="Kamera"><br>
                        <p><b>Cena:</b></p><input type="text" id="cena" name="cena"><br><br>
                        <p><b>Slika:</b></p><input type="file" id="slika" name="slika"><br><br>
                        <input type="submit" value="Ubaci proizvod">
                    </form>
                </div>
                <?php
                $db = connect();
                if(!$db){
                    echo "Greška prilikom konekcije!!!";
                    exit();
                }
                
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $model = $_POST['model'];
                    $id_proizvodjaca = $_POST['id_proizvodjaca'];
                    $sistem = $_POST['sistem'];
                    $ekran = $_POST['ekran'];
                    $memorija = $_POST['memorija'];
                    $kamera = $_POST['kamera'];
                    $cena = $_POST['cena'];
                    $slika = $_FILES['slika']['name'];
                    //proveravamo da li je slika setovana !!!!
                    if(!empty($slika)){
                        //podešavamo da slika nakon upload-a ima ime koje mi definišemo !!!!
                        $slika = time().".".pathinfo($slika,PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES['slika']['tmp_name'],"../images/".$slika);
                    }
                    if(!empty($model)){
                        $sql = "INSERT INTO telefoni (model,id_proizvodjaca,sistem,ekran,memorija,kamera,cena,slika)
                        VALUES ('$model',$id_proizvodjaca,'$sistem','$ekran','$memorija','$kamera','$cena','$slika')";
                        mysqli_query($db,$sql);
                        if(mysqli_error($db)) echo mysqli_error($db);
                        header("Location:pocetna.php");
                    }
                    else echo "<span style='color:red'><h3>Niste uneli neophodne podatke!!!</h3></span>";
                }
                ?>
            </div><!-- end contain -->
            <footer id="footer">
                <p><b>Copyright &copy; by haker87 2017</b></p>
            </footer>
        </div><!-- end big_wrapper-->
    </body>
</html>
