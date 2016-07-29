<?php 

include 'koneksi.php';
include 'simple_html_dom.php';
$html = file_get_html('http://news.detik.com/indeks');
//$ret = $html->find('ul[id=indeks-container]');

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$i = 0;
foreach($html->find('ul[id=indeks-container]') as $ul) 
{
       foreach($ul->find('a') as $li) 
       {
//           var_dump($li->plaintext);die;
           $sql = "INSERT INTO listurl (url,title,sumber) VALUES ('$li->href','$li->plaintext','news.detik.com')";
           $conn->query($sql);
           echo $i++.'<br>';
       }
}
$conn->close();
die;


