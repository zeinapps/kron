<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$html = file_get_html("http://bola.okezone.com/topic/30418");

$ul = $html->find('ul[class=list-berita]', 0);
foreach ($ul->find('li[class=col-md-4]') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('a', 1)->plaintext);
    $property = 'data-original';
    $img_tumb = trim($li->find('div[class=thumb-news]', 0)->$property);
    $sumber = 'bola.okezone.com';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
     $sql = "INSERT INTO ebarca_listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}


$conn->close();
die;


