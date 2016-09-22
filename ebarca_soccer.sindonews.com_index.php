<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file = "param_soccer.sindonews.com.txt";
$parameter_tag = file_exists($file) ? file_get_contents($file) : 0;

if($parameter_tag == 15){
    file_put_contents($file, '0');
}else{
    file_put_contents($file, ($parameter_tag+1) );
}

$tag_asli = array(
        "299", // 0 barcelona
        "578", // 1 real-madrid
        "659", // 2 atletico-madrid
        "5064", // 3 la-liga
        "342", // 4 mu
        "330", // 5 city
        "443", // 6 chelsea
        "332", // 7 arsenal
        "300", // 8 liverpool
        "6679", // 9 premier-league
        "341", // 10 juventus
        "7639", // 11 inter-milan
        "499", // 12 ac-milan
        "719", // 13 napoli
        "657", // 14 as roma
        "3520", // 15 serie-a
    );

$my_tag = array(
        "barcelona", 
        "real-madrid", 
        "atletico-madrid", 
        "liga-spanyol", 
        "manchester-united",
        "manchester-city", 
        "chelsea", 
        "arsenal", 
        "liverpool", 
        "liga-inggris", 
        "juventus", 
        "inter-milan", 
        "ac-milan", 
        "napoli", 
        "as-roma", 
        "liga-italia", 
    );

$tag_param = $tag_asli[$parameter_tag];
$tag_input = $my_tag[$parameter_tag];

$html = file_get_html("http://soccer.sindonews.com/topic/$tag_param");
$ul = $html->find('div[class=lst-mr-sub]', 0);
foreach ($ul->find('li[class=clearfix]') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('a', 0)->plaintext);
    $img_tumb = trim($li->find('img', 0)->src);
    $sumber = 'soccer.sindonews.com';
    
    
    $sql = "select * from ebarca_listurl where url = '$url' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        $list_id = 0;
        while($row = $result->fetch_assoc()) {
            $url = $row["url"];
            $list_id = $row["id"];
            $img_tumb = $row["img_tumb"];
            $title = $row["title"];
            $sumber = $row["sumber"];
            $cur_tag = $row["tag"];
        }
        $array_tag = explode(" ", $cur_tag);
        
        if(!in_array($tag_input,$array_tag)){
            $new_tag = $cur_tag." ".$tag_input;
            $sql = "UPDATE ebarca_listurl SET is_tembak = '0', tag = '$new_tag' WHERE id='$list_id'";
            $conn->query($sql);
        }

    } else {
        $sql = "INSERT INTO ebarca_listurl (url,title,img_tumb,sumber,tag) VALUES ('$url','$title','$img_tumb','$sumber','$tag_input')";
        $conn->query($sql);
        
    }
}


$conn->close();
die;


