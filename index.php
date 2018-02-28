<?php
session_start();
require_once("function.php");
if(isset($_GET['logout']))
{
    unset($_SESSION['gost_id']);
    unset($_SESSION['gost_ime']);
    unset($_SESSION['gost_status']);
    session_destroy();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">
	<link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="main.js"></script>
    <style>
        input[type=number]{
            width: 40px;
        }
        button{
            background-color: green;
            border: none;
            color: #fff;
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
                    <a href="#"><img src="images/logo.png" alt="logo"></a>
                </div>
                <div id="slogan">
                    <p><b>Mobile world</b></p>
                </div>
            </header><!-- end header -->
            <nav id="nav">
                <!-- nije pokrenuta sesija gosta i admina-->
                <?php
                if(!isset($_SESSION['gost_id']) and $_SESSION['status'] != 'admin')
                {
                    echo "<ul>";
                    echo "<li><a href='index.php'><b>home</b></a></li>";
                    echo "<li><a href='admin/login.php'><b>prijava na sistem</b></a></li>";
                    echo "<li><a href='korpa.php'><b>korpa</b></a></li>";
                    echo "</ul>";
                }
                if(isset($_SESSION['gost_id']))
                {
                    echo "<ul>";
                    echo "<li><a href='index.php'><b>home</b></a></li>";
                    echo "<li><a href='index.php?logout'>".$_SESSION['gost_ime']."(Logout)</a></li>";
                    $db=connect();
                    $proizvodi=0;//postavljamo količinu naručenih proizvoda na 0 !!!
                    $sql="SELECT kolicina FROM korpa WHERE idkupca=".$_SESSION['gost_id']."";
                    $res=mysqli_query($db,$sql);
                    if(mysqli_num_rows($res)==0){
                        echo "<li><a href='korpa.php'><b>korpa&nbsp;(".$proizvodi.")</b></a></li>";
                    }
                    else{
                        $row=mysqli_fetch_object($res);
                            $proizvodi+=$row->kolicina;
                        echo "<li><a href='korpa.php'><b>korpa&nbsp;(".$proizvodi.")</b></a></li>";
                    }
                    echo "</ul>";
                }
                if($_SESSION['status'] == 'admin')
                {
                    echo "<ul>";
                    echo "<li><a href='admin/pocetna.php'><b>Admin Page</b></a></li>";
                    echo "</ul>";
                }
                ?>
            </nav><!-- end nav -->
            <div id="baner">
                <a href="#"><img src="images/mobile_banner.jpg" alt="baner"></a>
            </div>
            <div id="contain">
                <div id="leftbox">
                    <article id="category">
                        <ul>
                            <li><a href="index.php"><b>svi modeli</b></a></li>
                            <?php
                            $db=connect();
                            prikaziProizvodjace($db);
                            mysqli_close($db);
                            ?>
                            <!--
                            <li><a href="index.php?proizvodjac=sony"><b>Sony</b></a></li>
                            <li><a href="index.php?proizvodjac=alcatel"><b>Alcatel</b></a></li>
                            <li><a href="index.php?proizvodjac=huawei"><b>Huawei</b></a></li>
                            <li><a href="index.php?proizvodjac=iphone"><b>Iphone</b></a></li>
                            <li><a href="index.php?proizvodjac=samsung"><b>Samsung</b></a></li>
                            <li><a href="index.php?proizvodjac=htc"><b>htc</b></a></li>
                            <li><a href="#"><b>Tesla</b></a></li>
                            <li><a href="#"><b>Nokia</b></a></li>
                            <li><a href="#"><b>Colpad</b></a></li>
                            -->
                        </ul>
                    </article>
                </div><!-- end leftbox -->
                <div id="rightbox">
				<?php
				$db = connect();
                if(isset($_POST['add']))
                {
                    $idproizvoda=$_POST['idproizvoda'];
                    $kolicina=$_POST['kolicina'];
                    $model=$_POST['model'];
                    $sql="INSERT INTO korpa (idkupca,idproizvoda,kolicina,model) VALUES ('".$_SESSION['gost_id']."','$idproizvoda','$kolicina','$model')";
                    mysqli_query($db,$sql);
                    header('location:index.php');
                }
                    //generisanje upita!!!
                    $sql = "SELECT * FROM telefoni WHERE obrisan=0";
                    if(isset($_GET['naziv'])) $sql = "SELECT telefoni.*,proizvodjaci.naziv FROM telefoni INNER JOIN proizvodjaci ON telefoni.id_proizvodjaca=proizvodjaci.id WHERE naziv='".$_GET['naziv']."'";
                    //odgovor na postavljeni upit!!!
                    $res = mysqli_query($db,$sql);
                    //obrada odgovora !!!
                    while($row = mysqli_fetch_object($res)){
                    ?>
                    <article class="models">
                        <header>
                            <h2><b><?=$row->model?></b></h2>
                        </header>
                        <div class="image-info">
						<img src="images/<?=$row->slika?>" alt="slika1">
						</div>
                        <div class="specmobile">
							<table>
							<tr>
								<td><?=$row->sistem?></td>
								<td><i class="fa fa-android" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td><?=$row->ekran?></td>
								<td><i class="fa fa-mobile" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td><?=$row->memorija?></td>
								<td><i class="fa fa-microchip" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td><?=$row->kamera?></td>
								<td><i class="fa fa-camera" aria-hidden="true"></i></td>
							</tr>
                               <form action="#" method="post">
                                   <tr>
                                       <td>Količina:</td>
                                       <td><input type="number" id="kolicina" name="kolicina" value="1">
                                           <input type="hidden" name="idproizvoda" value="<?=$row->id?>">
                                           <input type="hidden" name="model" value="<?=$row->model?>"
                                       </td>
                                   </tr>
                                   <tr>
                                      <td>
                                          <?php
                                          if(isset($_SESSION['gost_id']))
                                            echo "<button name='add'>Add&nbsp;<i class='fa fa-shopping-cart' aria-hidden='true'></i></button>";
                                          ?>
                                      </td>
                                   </tr>
                               </form>
							</table>
						</div>
						<div class="cena-mob">
							<p><b>Cena: <?=$row->cena?> <i class="fa fa-eur" aria-hidden="true"></i></b></p>
						</div>
                    </article>
                    <?php
                    }
                    ?>
                    <?php

                    ?>
                   <!-- za potrebe dinamike !!!
                     <article class="models">
                        <header>
                            <h2><b>Samsung Galaxy J6</b></h2>
                        </header>
                        <div class="image-info">
						<img src="images/slika1.jpg" alt="slika1">
						</div>
                        <div class="specmobile">
							<table>
							<tr>
								<td>Sistem</td>
								<td><i class="fa fa-android" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td>Ekran</td>
								<td><i class="fa fa-mobile" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td>Memorija</td>
								<td><i class="fa fa-microchip" aria-hidden="true"></i></td>
							</tr>
							<tr>
								<td>Kamera</td>
								<td><i class="fa fa-camera" aria-hidden="true"></i></td>
							</tr>
							</table>
						</div>
						<div class="cena-mob">
							<p><b>Cena: 200 <i class="fa fa-eur" aria-hidden="true"></i></b></p>
						</div>
                    </article>-->
					
                    
                </div><!-- end rightbox -->
            </div><!-- end contain -->
            <footer id="footer">
                <p><b>Copyright &copy; by haker87 2017</b></p>
            </footer>
        </div><!-- end big_wrapper-->
    </body>
</html>
