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

$img_tumb = 'http:'.$img_tumb;
$html = file_get_html($url);
//echo $html;die;
//$konten
$ret = $html->find('div[class=content_detail]',0);

//$penulis
$div_penulis = $ret->find('div[class=author]',0);
$penulis = trim(mysql_escape_string($div_penulis->plaintext));

//$div_konten = $ret->find('div[id=detail]',0);
if($div_konten = $ret->find('div[id=detail]',0)){
    $element = $div_konten->find('table',0);
    $element->outertext='';
}

$konten = trim(mysql_escape_string($div_konten->outertext));

//$waktu
$div_waktu = $ret->find('div[class=date]',0);
$waktu = trim(mysql_escape_string($div_waktu->plaintext));

//$img
$div_img = $ret->find('div[class=pic_artikel] img',0);
$img = trim(mysql_escape_string('http:'.$div_img->src));

// img_tumb
if(!$img_tumb){
    $img_tumb = $img.'?w=200&q=90';
}

//$kategori
$div_kategori = $ret->find('div[class=breadcrumb] a',1);
$kategori = trim(mysql_escape_string($div_kategori->plaintext));



$sql = "INSERT INTO berita (url, title, konten, kategori, penulis, sumber, waktu, time, img , img_tumb) "
        . "VALUES ('$url', '$title','$konten', '$kategori', '$penulis', '$sumber', '$waktu', '$time', '$img', '$img_tumb')";

if ($conn->query($sql) === TRUE) {
    $sql = "UPDATE listurl SET is_tembak = '1' WHERE id='$list_id'";
    $conn->query($sql);
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
die;
