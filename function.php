<?php
function connect()
{
    $db = @ mysqli_connect('localhost','root','remirexklds89','mobile_store');
    if(!$db) return false;
    mysqli_query($db,"SET NAMES UTF8");
    return $db;
}
function prikaziProizvodjace($db)
{
    $sql="SELECT * FROM proizvodjaci";
    $res=mysqli_query($db,$sql);
    while($row=mysqli_fetch_object($res))
    {
        echo "<li><a href='index.php?naziv=$row->naziv'><b>$row->naziv</b></a></li>";
    }
}
function testInput($data)
{
    $data=trim($data);
    $data=stripcslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
?>