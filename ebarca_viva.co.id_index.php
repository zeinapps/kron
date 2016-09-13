<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$html = file_get_html("http://www.viva.co.id/tag/barcelona");
$ul = $html->find('ul[class=indexlist]', 0);
foreach ($ul->find('li') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('a div[class=title]', 0)->plaintext);
    $img_tumb = trim($li->find('a div[class=thumbcontainer] img', 0)->src);
    $sumber = 'viva.co.id';
    //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
    $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
    $conn->query($sql);
}


$conn->close();
die;


