<?php
session_start();
require_once("function.php");
require_once"class_Kupovina.php";
if(isset($_GET['logout']))
{
    unset($_SESSION['gost_id']);
    unset($_SESSION['gost_ime']);
    unset($_SESSION['gost_korime']);
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
    <style>
        .korpa{
            padding: 50px;
            width: 880px;
        }
        .korpa table{
            border-collapse: collapse;
            width: 880px;
        }
        .korpa th{
            background-color: lightgray;
        }
        .korpa td{
            padding: 5px;
            text-align: center;
        }
        #buy{
            display: inline-block;
            text-decoration: none;
            background-color: green;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        #delete{
            display: inline-block;
            text-decoration: none;
            background-color: red;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        #shoping{
            display: inline-block;
            text-decoration: none;
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
            <a href="#"><img src="images/logo.png" alt="logo"></a>
        </div>
        <div id="slogan">
            <p><b>Mobile world</b></p>
        </div>
    </header><!-- end header -->
    <nav id="nav">
        <ul>
            <li><a href="index.php"><b>home</b></a></li>
            <?php
            if(!isset($_SESSION['gost_id']))
                echo "<li><a href='admin/login.php'><b>prijava na sistem</b></a></li>";
            else echo "<li><a href='index.php?logout'>".$_SESSION['gost_ime']." (Logout)</a></li>";
            ?>
            <?php
            if(isset($_SESSION['gost_id']))
            {
                $db=connect();
                $proizvodi=0;//postavljamo količinu naručenih proizvoda na 0 !!!
                $sql="SELECT kolicina FROM korpa WHERE idkupca=".$_SESSION['gost_id']."";
                $res=mysqli_query($db,$sql);
                if(mysqli_num_rows($res)==0){
                    echo "<li><a href='korpa.php'><b>korpa&nbsp;(".$proizvodi.")</b></a></li>";
                }
                else{
                    while($row=mysqli_fetch_object($res))  $proizvodi+=$row->kolicina;
                    echo "<li><a href='korpa.php'><b>korpa&nbsp;(".$proizvodi.")</b></a></li>";
                }
            }
            else echo "<li><a href='korpa.php'><b>korpa</b></a></li>";
            ?>
        </ul>
    </nav><!-- end nav -->
    <div id="baner">
        <a href="#"><img src="images/mobile_banner.jpg" alt="baner"></a>
    </div>
    <div id="contain">
        <?php
        if(!isset($_SESSION['gost_id']))
        {
            ?>
            <div class="korpa">
                <h3>Ukoliko želite da nastavite sa kupovinom, molimo vas prijavite se na sistem</h3>
                <a href="admin/login.php" id="shoping"><b>Login</b></a>
            </div>
        <?php
        }
        else{
            ?>
           <div class="korpa">
               <h2>Naručeni proizvodi:</h2>
               <?php
               $db=connect();
               //brisanje iz korpe !!!
               if(isset($_GET['idbrisanja']))
               {
                   $idbrisanja=$_GET['idbrisanja'];
                   $sql="DELETE FROM korpa WHERE id=".$idbrisanja;
                   mysqli_query($db,$sql);
                   //header('location:korpa.php');
               }
               //kupovina !!!
               if(isset($_GET['idkupovine']))
               {
                   $idkupovine=$_GET['idkupovine'];
                   $sql="UPDATE korpa SET kupljen='1' WHERE id=$idkupovine";
                   $res=mysqli_query($db,$sql);
                   $sql="SELECT * FROM korpa WHERE kupljen='1'";
                   $res=mysqli_query($db,$sql);
                   $row=mysqli_fetch_object($res);
                   $text="";
                   $text.="ID proizvoda : ".$row->idproizvoda."\r\n";
                   $text.="Kupac: ".$_SESSION['gost_ime']."\r\n";
                   $text.="Količina: ".$row->kolicina."\r\n";
                   $text.="Model: ".$row->model."\r\n";
                   $text.="________________________________\r\n";
                   $obj=new Kupovina($text);
                   $obj->upisKupovine();
                   header('location:korpa.php');
               }
               $sql="SELECT telefoni.model,telefoni.cena,telefoni.slika, korpa.*  FROM korpa INNER JOIN telefoni ON telefoni.id=korpa.idproizvoda WHERE korpa.idkupca=".$_SESSION['gost_id']." AND korpa.kupljen=0 ORDER BY id DESC";
               $res=mysqli_query($db,$sql);
               if(mysqli_num_rows($res)==0)
                   echo "Nemate nijedan naručen proizvod u korpi, <a href='index.php' id='shoping'>Nastavite kupovinu</a>";
               else{
                   ?>
                    <table>
                        <tr>
                            <th>ID_pr:</th>
                            <th>Slika</th>
                            <th>Model</th>
                            <th>Količina</th>
                            <th>Ukupno</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $ukupno=0;//postavljamo ukupnu cenu na 0 !!!!
                        $proizvodi=0;//postavljamo količinu naručenih proizvoda na 0 !!!
                        while($row=mysqli_fetch_object($res))
                        {
                            $cena=$row->kolicina * $row->cena;
                            $ukupno+=$cena;
                            $proizvodi+=$row->kolicina;
                            ?>
                            <tr>
                                <td><?=$row->idproizvoda?></td>
                                <td><img src="images/<?=$row->slika?>" alt="nema slike" width="50" height="50"></td>
                                <td><b><?=$row->model?></b></td>
                                <td><b><?=$row->kolicina?></b></td>
                                <td><b><?php echo $cena ?>&nbsp;&euro;</b></td>
                                <td><a href="korpa.php?idkupovine=<?=$row->id?>" id="buy">BUY</a>|<a href="korpa.php?idbrisanja=<?=$row->id?>" id="delete">Delete&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo $proizvodi;?></th>
                            <th><?php echo $ukupno;?>&nbsp;&euro;</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><a href="index.php" id="shoping">Nastavite kupovinu</a> </td>
                        </tr>
                    </table>
               <?php
               }
               ?>
               <h2>Kupljeni proizvodi:</h2>
               <?php
               $sql="SELECT telefoni.model,telefoni.cena,telefoni.slika, korpa.*  FROM korpa INNER JOIN telefoni ON telefoni.id=korpa.idproizvoda WHERE korpa.idkupca=".$_SESSION['gost_id']." AND korpa.kupljen=1 ORDER BY id DESC";
               $res=mysqli_query($db,$sql);
               if(mysqli_num_rows($res)==0)
                   echo "Nemate nijedan kupljen proizvod u korpi";
               else{
                   ?>
                   <table>
                       <tr>
                           <th>ID_pr:</th>
                           <th>Slika</th>
                           <th>Model</th>
                           <th>Količina</th>
                           <th>Ukupno</th>
                       </tr>
                       <?php
                       $ukupno=0;//postavljamo ukupnu cenu na 0 !!!!
                       $proizvodi=0;//postavljamo količinu naručenih proizvoda na 0 !!!
                       while($row=mysqli_fetch_object($res))
                       {
                           $cena=$row->kolicina * $row->cena;
                           $ukupno+=$cena;
                           $proizvodi+=$row->kolicina;
                           ?>
                           <tr>
                               <td><?=$row->idproizvoda?></td>
                               <td><img src="images/<?=$row->slika?>" alt="nema slike" width="50" height="50"></td>
                               <td><b><?=$row->model?></b></td>
                               <td><b><?=$row->kolicina?></b></td>
                               <td><b><?php echo $cena ?>&nbsp;&euro;</b></td>
                           </tr>
                           <?php
                       }
                       ?>
                       <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th><?php echo $proizvodi;?></th>
                           <th><?php echo $ukupno;?>&nbsp;&euro;</th>
                       </tr>
                   </table>
                   <?php
               }
               ?>
           </div>
        <?php
        }
        ?>
    </div><!-- end contain -->
    <footer id="footer">
        <p><b>Copyright &copy; by haker87 2017</b></p>
    </footer>
</div><!-- end big_wrapper-->
</body>
</html>
