<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 19.6.2017
 * Time: 12:03
 */
class Kupovina
{
    public $text;
    public function __construct($text)
    {
        $this->text=$text;
    }
    public function upisKupovine()
    {
        $ime_datoteke="kupovina/".date("d.m.Y",time()).".txt";
        $upis=date("d.m.Y H:i:s",time())." :\r\n".$this->text;
        $f=fopen($ime_datoteke,"a");
        fwrite($f,$upis);
        fclose($f);
    }
}