<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$time = time();
$tgl = date('d',$time);
$bln = date('m',$time);
$thn = date('Y',$time);
$q = "tanggal=$tgl&bulan=$bln&tahun=$thn";
    $html = file_get_html("http://indeks.kompas.com/?".$q);
    $ul = $html->find('div[class=kcm-main-list]', 0);
    foreach ($ul->find('li') as $li) {
                   //echo $li->find('a',0);die;
        $url = trim($li->find('a', 0)->href);
        $title = trim($li->find('a', 0)->plaintext);
        $img_tumb = null;
        $sumber = 'kompas.com';
        //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
        $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
        $conn->query($sql);
    }



$conn->close();
die;


