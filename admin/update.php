<?php
require_once("../function.php");
session_start();
if($_SESSION['status'] != "admin")
{
    echo "<span style='color:red'><h3>Nemate pristup ovoj stranici!!!</h3></span>";
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
            <h2 style="color:white"><b>Update postojećih proizvoda:</b></h2>
            <form action="#" method="post">
                <h2>Izaberi proizvod</h2>
                <select name="idProizvoda">
                    <?php
                    $db = connect();
                    $sql = "SELECT id,model FROM telefoni WHERE obrisan=0";
                    $res = mysqli_query($db,$sql);
                    while($row = mysqli_fetch_object($res))
                    {
                        ?>
                        <option value="<?=$row->id?>"><?=$row->model?></option>
                    <?php
                    }
                    ?>
                </select><br><br>
                <input type="submit" name="izaberi" value="Izaberi proizvod">
            </form>
            <hr>
            <?php
            $id = '';
            $model = '';
            $id_proizvodjaca = '';
            $sistem ='';
            $ekran ='';
            $memorija = '';
            $kamera = '';
            $cena = '';
            if(isset($_POST['izaberi']))
            {
                $id = $_POST['idProizvoda'];
                $sql = "SELECT * FROM telefoni WHERE id=$id";
                $res = mysqli_query($db, $sql);
                $row = mysqli_fetch_object($res);
                $id = $row->id;
                $model = $row->model;
                $sistem = $row->sistem;
                $ekran = $row->ekran;
                $memorija = $row->memorija;
                $kamera = $row->kamera;
                $cena = $row->cena;
                $slika = $row->slika;
                $id_proizvodjaca = $row->id_proizvodjaca;
            }
            ?>
            <form action="#" method="post" enctype="multipart/form-data">
                <p><b>ID Proizvoda:</b></p><input name="idProizvod" id="id_proizvoda" value="<?=$id?>"><br>
                <p><b>Model:</b></p><input type="text" id="model" name="model" value="<?=$model?>"><br>
                <p><b>Proizvođač:</b></p>
                <select id="id_proizvodjaca" name="id_proizvodjaca">
                    <option value="<?=$id_proizvodjaca?>"><?=$row->model?></option>
                    <option value="1">Alcatel</option>
                    <option value="2">Sony</option>
                    <option value="3">Samsung</option>
                    <option value="4">Iphone</option>
                    <option value="5">Huawei</option>
                    <option value="6">htc</option>
                </select><br>
                <p><b>Sistem:</b></p><input type="text" id="sistem" name="sistem" value="<?=$sistem?>"><br>
                <p><b>Ekran:</b></p><input type="text" id="ekran" name="ekran" value="<?=$ekran?>"><br>
                <p><b>Memorija:</b></p><input type="text" id="memorija" name="memorija" value="<?=$memorija?>"><br>
                <p><b>Kamera:</b></p><input type="text" id="kamera" name="kamera" value="<?=$kamera?>"><br>
                <p><b>Cena:</b></p><input type="text" id="cena" name="cena" value="<?=$cena?>"><br><br>
                <p><b>Slika:</b></p><input type="file" id="slika" name="slika"><br><br>
                <img src="../images/<?=$row->slika?>" height="100px" alt="nema slike"><br><br>
                <input type="submit" value="Update" name="update">
            </form>
            <h2>Delete proizvoda</h2>
            <form method="post" action="#">
                <input type="hidden" name="id" value="<?=$row->id?>">
                <input type="submit" value="Delete" name="delete">
            </form>
        </div>
        <?php

        if(!$db){
            echo "Greška prilikom konekcije!!!";
            exit();
        }

        if(isset($_POST['update'])){
            $id = $_POST['idProizvod'];
            $model = $_POST['model'];
            $id_proizvodjaca = $_POST['id_proizvodjaca'];
            $sistem = $_POST['sistem'];
            $ekran = $_POST['ekran'];
            $memorija = $_POST['memorija'];
            $kamera = $_POST['kamera'];
            $cena = $_POST['cena'];
            $slika = $_FILES['slika']['name'];
            //proveravamo da li je slika setovana !!!!
            if(isset($slika) and !empty($slika)){
                //podešavamo da slika nakon upload-a ima ime koje mi definišemo !!!!
                $slika = time().".".pathinfo($slika,PATHINFO_EXTENSION);
                $sql = "UPDATE telefoni SET slika='$slika' WHERE id=$id";
                mysqli_query($db, $sql);
                move_uploaded_file($_FILES['slika']['tmp_name'], "../images/".$slika);
            }
            $sql = "UPDATE telefoni SET model='$model',id_proizvodjaca='$id_proizvodjaca',sistem='$sistem',ekran='$ekran', memorija='$memorija', kamera='$kamera', cena='$cena'  WHERE id=$id";
            mysqli_query($db,$sql);
            if(mysqli_error($db)) echo mysqli_error($db);
            header("Location:update.php");
        }

        if(isset($_POST['delete']))
        {
            $id = $_POST['id'];
            $sql = "UPDATE telefoni SET obrisan=1 WHERE id=$id";
            mysqli_query($db,$sql);
        }
        ?>
    </div><!-- end contain -->
    <footer id="footer">
        <p><b>Copyright &copy; by haker87 2017</b></p>
    </footer>
</div><!-- end big_wrapper-->
</body>
</html>
