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
//$sql = "select * from listurl where sumber = 'news.detik.com' and is_tembak = '0' limit 1";
//$result = $conn->query($sql);
//
//if ($result->num_rows > 0) {
//    // output data of each row
//    while($row = $result->fetch_assoc()) {
//        $url = $row["url"];
//        $list_id = $row["id"];
//        $img_tumb = $row["img_tumb"];
//        $title = $row["title"];
//        $sumber = $row["sumber"];
//    }
//} else {
//    $conn->close();
//    echo "No data: " ;
//    die();
//}

$url = 'http:'.$url;
$html = file_get_html($url);
//echo $html;die;
//$konten

$detail_content = $html->find('div[class=detail_content]',0);
$ret = $html->find('article',0);
$jdl = $ret->find('div[class=jdl]',0);

//$penulis
$div_penulis = $jdl->find('div[class=author]',0);
$penulis = trim(mysql_escape_string($div_penulis->plaintext));

$div_konten = $ret->find('div[class=detail_text]',0);

$konten = trim(mysql_escape_string($div_konten->outertext));
if(!$konten){
	die;
}
//$waktu
$div_waktu = $jdl->find('div[class=date]',0);
$waktu = trim(mysql_escape_string($div_waktu->plaintext));

//$img
$div_img = $ret->find('div[class=pic_artikel] img',0);
$img = trim(mysql_escape_string($div_img->src));

// img_tumb
if(!$img_tumb){
    $img_tumb = $img.'&w=200&q=90';
}

//$kategori
$div_kategori = $detail_content->find('div[class=breadcrumb] a',1);
$kategori = trim(mysql_escape_string($div_kategori->plaintext));



$sql = "INSERT INTO berita (url, title, konten, kategori, penulis, sumber, waktu, time, img , img_tumb) "
        . "VALUES ('$url', '$title','$konten', '$kategori', '$penulis', '$sumber', '$waktu', '$time', '$img', '$img_tumb')";

if ($conn->query($sql) === TRUE) {
    $sql = "UPDATE listurl SET is_sukses = '1' WHERE id='$list_id'";
    $conn->query($sql);
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
die;
