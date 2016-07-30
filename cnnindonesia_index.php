<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

for ($i = 1; $i <= 2; $i++) {
    $html = file_get_html("http://cnnindonesia.com/indeks?page=$i");
    $ul = $html->find('ul[class=list_indeks]', 0);
    foreach ($ul->find('li') as $li) {
        //           echo $li->find('a',0);
        $url = trim($li->find('a', 0)->href);
        $title = trim($li->find('h3', 0)->plaintext);
        $img_tumb = trim($li->find('a img', 0)->src);
        $sumber = 'cnnindonesia.com';
        //            var_dump($url.' '.$title.' '.$img_tumb.' '.$sumber.' ');die;
        $sql = "INSERT INTO listurl (url,title,img_tumb,sumber) VALUES ('$url','$title','$img_tumb','$sumber')";
        $conn->query($sql);
    }
}


$conn->close();
die;


