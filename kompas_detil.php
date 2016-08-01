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

$html = file_get_html($url);
//echo $html;die;
//$konten

$detail_content = $html->find('div[class=kcm-read]',0);
$date = $detail_content->find('div[class=kcm-date]',0);

$stringdate = explode('<br>',$date);

//$penulis
if(isset($stringdate[1])){
	$waktu = trim(mysql_escape_string(strip_tags($stringdate[1])));
	$penulis = trim(mysql_escape_string(strip_tags($stringdate[0])));
}else{
	$waktu = trim(mysql_escape_string(strip_tags($stringdate[0])));
	$penulis = '';
}
//$waktu

//$img
$img = null;
$img_tumb = null;
if($div_img = $detail_content->find('div[class=photo] img',0)){
	$img = trim(mysql_escape_string($div_img->src));
	$img_tumb = str_replace('/data/','/thumb/data/',$img).'?&x=200&v=200';
}


$div_konten = $detail_content->find('div[class=kcm-read-text]',0);
if($element = $div_konten->find('strong')){
	foreach($element as $e){
		$e->outertext='';
	}
}
$konten = trim(mysql_escape_string($div_konten->outertext));

//$kategori ok
$div_kategori = $detail_content->find('ul[class=kcm-breadcrumb] a',0);
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
