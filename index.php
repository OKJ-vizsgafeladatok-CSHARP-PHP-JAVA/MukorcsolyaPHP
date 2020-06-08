<?php

require 'VersenySzam.php';

function beolvas($file){
    $tomb=array();
    try {
        $f= fopen($file, 'r');
        while(!feof($f)){
            $sor= fgets($f);
            $sor= substr($sor, 0, strlen($sor)-2);
            if(strlen($sor)>3){
                $split= explode(';', $sor);
                $o=new VersenySzam(
                        $split[0], 
                        $split[1], 
                        $split[2], 
                        $split[3], 
                        $split[4]);
                $tomb[]=$o;
            }
        }
    } catch (Exception $exc) {
        die('hiba a beolvasásban. '.$file.' '.$exc);
    }
    array_shift($tomb);
    return $tomb;
}

$a=beolvas('rovidprogram.csv');
$b=beolvas('donto.csv');

$behuzas='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
echo '2. feladat: <br>';
echo $behuzas.'A rövidprogramban '.count($a).' induló volt. <br>';

//3. feladat: 
$valasz=$behuzas.'A magyar versenyző nem jutott be a kűrbe. <br>';
foreach ($b as $item) {
    if(strcasecmp($item->getOrszag(), 'HUN')==0){
        $valasz=$behuzas.'A magyar versenyző bejutott a kűrbe. <br>';
    }
}
echo '3. feladat: <br>';
echo $valasz;

//4. feladat:
function ÖsszPontszám($versenyzo,$a,$b){
    $osszPont=0.0;
    foreach ($a as $rovid) {
        if(strcasecmp($rovid->getNev(), $versenyzo)==0){
            $osszPont+=$rovid->AktOsszPont();
        }
    }
    foreach ($b as $kur) {
        if(strcasecmp($kur->getNev(), $versenyzo)==0){
            $osszPont+=$kur->AktOsszPont();
        }
    }
    return $osszPont;
}
//5. feladat
echo '5. feladat: <br>'.$behuzas.'Kérem a versenyző nevét! ';
echo $behuzas
        .'<form method="post" action="#">'
        . '<input type="text" name="nev">'
        . '<input type="submit" value="Küldés">'
       .'</form>';
if(isset($_POST['nev'])&&!empty($_POST['nev'])){
    $beker=$_POST['nev'];
    $talalat=false;
    foreach ($a as $vers) {
        if(strcasecmp($beker, $vers->getNev())==0){
            $talalat=true;
            break;
        }
    }
    if($talalat==false){
        echo $behuzas.'Ilyen nevű versenyző nem volt! ';
    }
}else{
    die();
}

//6. feladat
echo '6. feladat: <br>';
echo $behuzas.'A versenyző összpontszáma: '. ÖsszPontszám($beker, $a, $b).'<br>';

//7. feladat
echo '7. feladat: <br>';
$stat=array();
foreach ($b as $kur) {
    $stat[]=$kur->getOrszag();
}
$stat= array_count_values($stat);
foreach ($stat as $key=>$value) {
    if($value>1){
        echo $behuzas.$key.': '.$value.' versenyző<br>';
    }
}

//8. feladat
$fajlba="";
$veger=array();
foreach ($b as $kur) {
    $veger[';'.$kur->getNev().';'.$kur->getOrszag().';']= ÖsszPontszám($kur->getNev(), $a, $b);

}
arsort($veger);
$szamlalo=1;
foreach ($veger as $key => $value) {
    $fajlba.=$szamlalo.$key.';'.$value."\n";//'\n' nem működik, csak "\n"!!! :O
    $szamlalo++;
}
$myFile=fopen('vegeredmeny.txt', 'w');
fwrite($myFile, $fajlba);
