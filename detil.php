<?php
include 'koneksi.php';


$time = time();
$title = '';
$konten = '';
$kategori = '';
$penulis = '';
$sumber = '';
$waktu = '';
$img = '';
$img_tumb = '';
$url = '';
$list_id = '';

include 'simple_html_dom.php';
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "select * from listurl where is_tembak = '0' ORDER BY RAND() limit 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $url = $row["url"];
        $list_id = $row["id"];
        $img_tumb = $row["img_tumb"];
        $title = $row["title"];
        $sumber = $row["sumber"];
    }
    $sql = "UPDATE listurl SET is_tembak = '1' WHERE id='$list_id'";
    $conn->query($sql);
    
} else {
    $conn->close();
    echo "No data: " ;
    die();
}

if($sumber == 'cnnindonesia.com'){
    include 'cnnindonesia_detil.php';
}else if($sumber == 'news.detik.com'){
    include 'detik_detil.php';
}else if($sumber == 'kompas.com'){
    include 'kompas_detil.php';
}