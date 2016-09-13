<?php 

//include 'koneksi.php';
//
//$time = time();
//$title = '';
//$konten = '';
//$kategori = '';
//$penulis = '';
//$sumber = '';
//$waktu = '';
//$img = '';
//$img_tumb = '';
//$url = '';
//$list_id = '';
//
//include 'simple_html_dom.php';
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//$sql = "select * from listurl where sumber = 'cnnindonesia.com' and is_tembak = '0' limit 1";
//$result = $conn->query($sql);
//
//if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//        $url = $row["url"];
//        $list_id = $row["id"];
//        $img_tumb = 'http:'.$row["img_tumb"];
//        $title = $row["title"];
//        $sumber = $row["sumber"];
//    }
//} else {
//    $conn->close();
//    echo "No data: " ;
//    die();
//}

$html = file_get_html($url);
//echo $html;die;
//$konten
$ret = $html->find('article[class=article-detail]',0);

//$penulis
$div_penulis = $ret->find('div[class=author] b',1);
$penulis = trim(mysql_escape_string($div_penulis->plaintext));

//$div_konten = $ret->find('div[id=detail]',0);
if($div_konten = $ret->find('span[itemprop=description]',0)){
//    $element = $div_konten->find('div[class=baca-juga]',0);
//    $element->outertext='';
}

$konten = trim(mysql_escape_string($div_konten->outertext));
if(!$konten){
	die;
}
//$waktu
$div_waktu = $ret->find('div[class=date]',0);
$waktu = trim(mysql_escape_string($div_waktu->plaintext));

//$img
$div_img = $ret->find('div[class=thumbcontainer] img',0);
$img = trim(mysql_escape_string($div_img->src));

// img_tumb
if(!$img_tumb){
    $img_tumb = str_replace('/big/', '/original/', $img);
}

//$kategori

$kategori = 'kategori';



$sql = "INSERT INTO ebarca_berita (url, title, konten, kategori, penulis, sumber, waktu, time, img , img_tumb) "
        . "VALUES ('$url', '$title','$konten', '$kategori', '$penulis', '$sumber', '$waktu', '$time', '$img', '$img_tumb')";

if ($conn->query($sql) === TRUE) {
    $sql = "UPDATE ebarca_listurl SET is_sukses = '1' WHERE id='$list_id'";
    $conn->query($sql);
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
die;
