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

$sql = "select * from listurl where sumber = 'news.detik.com' and is_tembak = '0' limit 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $url = $row["url"];
        $list_id = $row["id"];
        $img_tumb = $row["img_tumb"];
        $title = $row["title"];
    }
} else {
    $conn->close();
    echo "No data: " ;
    die();
}

        
$html = file_get_html('http:'.$url);

//$konten
$ret = $html->find('div.detail_text',0);
$konten = htmlspecialchars($ret->innertext, ENT_QUOTES);
var_dump($konten);die;
//$penulis
$ret = $html->find('div.detail_text',0);
$penulis = htmlspecialchars($ret->innertext, ENT_QUOTES);

//$waktu
$ret = $html->find('div.detail_text',0);
$waktu = htmlspecialchars($ret->innertext, ENT_QUOTES);

//$img
$ret = $html->find('div.detail_text',0);
$img = htmlspecialchars($ret->innertext, ENT_QUOTES);

//$kategori
$ret = $html->find('div.detail_text',0);
$kategori = htmlspecialchars($ret->innertext, ENT_QUOTES);



$sql = "INSERT INTO berita (url, title, konten, kategori, penulis, sumber, waktu, time, img) "
        . "VALUES ('$url', '$title','$konten', '$kategori', '$penulis', '$sumber', '$waktu', '$time', '$img')";

if ($conn->query($sql) === TRUE) {
    $sql = "UPDATE FROM listurl SET is_tembak = '1' WHERE id='$list_id'";
    $conn->query($sql);
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
die;
