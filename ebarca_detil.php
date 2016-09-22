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
$tag = '';

include 'simple_html_dom.php';
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "select * from ebarca_listurl where is_tembak = '0' ORDER BY id DESC limit 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $url = $row["url"];
        $list_id = $row["id"];
        $img_tumb = $row["img_tumb"];
        $title = $row["title"];
        $sumber = $row["sumber"];
        $tag = $row["tag"];
    }
        
    $sql = "UPDATE ebarca_listurl SET is_tembak = '1' WHERE id='$list_id'";
    $conn->query($sql);
    
} else {
    $conn->close();
    echo "ebarca No data: " ;
    die();
}


$sql = "select * from ebarca_berita where url = '$url' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
        
$sql = "UPDATE ebarca_berita SET tag = '$tag' WHERE url='$url'";
$conn->query($sql);
$conn->close();
die();

} 
echo $url;
if($sumber == 'bola.com'){
    include 'ebarca_bola.com_detil.php';
}else if($sumber == 'bola.okezone.com'){
    include 'ebarca_bola.okezone.com_detil.php';
}else if($sumber == 'soccer.sindonews.com'){
    include 'ebarca_soccer.sindonews.com_detil.php';
}else if($sumber == 'viva.co.id'){
    include 'ebarca_viva.co.id_detil.php';
}else if($sumber == 'liputan6.com'){
    include 'ebarca_liputan6.com_detil.php';
}