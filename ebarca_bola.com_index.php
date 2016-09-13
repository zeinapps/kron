<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$html = file_get_html("http://www.bola.com/tag/barcelona?type=text");
$ul = $html->find('section[id=articles-tag]', 0);
foreach ($ul->find('article') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('h4', 0)->plaintext);
    $img_tumb = trim($li->find('a img', 0)->src);
    $sumber = 'bola.com';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
    $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}


$conn->close();
die;


