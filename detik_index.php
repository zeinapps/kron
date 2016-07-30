<?php

include 'koneksi.php';
include 'simple_html_dom.php';
$html = file_get_html('http://news.detik.com/indeks');
//$ret = $html->find('ul[id=indeks-container]');

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$i = 0;

$ul = $html->find('ul[id=indeks-container]', 0);
foreach ($ul->find('a') as $li) {
    $url = $li->href;
    $title = $li->plaintext;
    $img_tumb = null;
    $sumber = 'news.detik.com';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
    $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}

$conn->close();
die;


