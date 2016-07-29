<?php 

include 'koneksi.php';
include 'simple_html_dom.php';
$html = file_get_html('http://merdeka.com/indeks-berita');
//$ret = $html->find('ul[id=indeks-container]');

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$i = 0;
foreach($html->find('ul[class=mdk-idn-nd-centlist]') as $ul) 
{
       foreach($ul->find('a') as $li) 
       {
//           var_dump($li->plaintext);die;
           
           if(strpos($li->href, 'foto/') != 1){
               $sql = "INSERT INTO listurl (url,title,sumber) VALUES ('$li->href','$li->plaintext','merdeka.com')";
                $conn->query($sql);
           }
           
       }
}
$conn->close();
die;


