<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$html = file_get_html("http://www.liputan6.com/tag/barcelona?type=text");
$ul = $html->find('div[class=topics--articles]', 0);
foreach ($ul->find('article') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('header h4 a', 0)->plaintext);
    $figure = $li->find('figure picture', 0);
    $property = 'data-src';
    $img_tumb = trim($figure->find('img', 0)->$property);
    $sumber = 'liputan6.com';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
    $sql = "INSERT INTO ebarca_listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}


$conn->close();
die;


