<?php
// require Facebook PHP SDK
// see: https://developers.facebook.com/docs/php/gettingstarted/
require_once("facebook-php-sdk/src/facebook.php");
include '../koneksi.php';
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
$config = array();
$config['appId'] = '1803352489909972';
$config['secret'] = '1fa8447cda638abe2b7e7361807ca82c';
$config['fileUpload'] = false; // optional
 
$fb = new Facebook($config);
 
$params = array();

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "select * from berita where is_fb_post = '0' ORDER BY ID DESC limit 1";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $time = $row['time'] + (3600*7);
        $tgl = date("d-M-Y", $time);
        $jam = date("H:i:s", $time);
        switch(date("l", $time))
        {
            case 'Monday':$nmh="Senin";break; 
            case 'Tuesday':$nmh="Selasa";break; 
            case 'Wednesday':$nmh="Rabu";break; 
            case 'Thursday':$nmh="Kamis";break; 
            case 'Friday':$nmh="Jum'at";break; 
            case 'Saturday':$nmh="Sabtu";break; 
            case 'Sunday':$nmh="Minggu";break; 
        }
        $waktu = $nmh.", "."$tgl $jam";
        
        $params = array(
            "access_token" => "EAAZAoI7iQ3tQBAHM737P95Il0xtve6UJmU3mCSNUKBz7D1C1zKZBsPZAmzL9LPbGACZBYb6Ayly490gLwqoTMa8uln3wK8nCb4yZBfeFj4bkM0qZBNcNZAI9LZC7eNYhRLzyLtZA2X4LoTfNXUHBiMBTFdoMpCHZCa2jTs2xaVG6F1mQZDZD", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
            "message" => "Berita Baru ". $waktu,
            "link" => "http://7ready.com/". $row['time']. "/detil/" .str_replace('/', '-', $row['title']) ,
            "picture" => $row["img"],
            "name" => $row["title"],
            "caption" => "www.7ready.com",
            "description" => substr(strip_tags($row['konten']), 0,300 ).' ...'
        );
    }
    $sql = "UPDATE berita SET is_fb_post = '1' WHERE id='$id'";
    $conn->query($sql);
    
} else {
    $conn->close();
    echo "No data: " ;
    die();
} 
 

// define your POST parameters (replace with your own values)

 
// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
  $ret = $fb->api('/1782379721974017/feed', 'POST', $params);
  
} catch(Exception $e) {
  echo 'Bug post FB : '.$e->getMessage();
}
?>