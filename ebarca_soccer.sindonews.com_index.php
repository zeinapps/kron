<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$html = file_get_html("http://soccer.sindonews.com/topic/299/barcelona");
$ul = $html->find('div[class=lst-mr-sub]', 0);
foreach ($ul->find('li[class=clearfix]') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('a', 0)->plaintext);
    $img_tumb = trim($li->find('img', 0)->src);
    $sumber = 'soccer.sindonews.com';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
    $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}


$conn->close();
die;


