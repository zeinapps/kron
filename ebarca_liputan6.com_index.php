<?php

include 'koneksi.php';
include 'simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file = "param_liputan6.com.txt";
$parameter_tag = file_exists($file) ? file_get_contents($file) : 0;

if($parameter_tag == 15){
    file_put_contents($file, '0');
}else{
    file_put_contents($file, ($parameter_tag+1) );
}

$tag_asli = array(
        "barcelona", // 0 barcelona
        "real-madrid", // 1 real-madrid
        "atletico-madrid", // 2 atletico-madrid
        "liga-spanyol", // 3 la-liga
        "manchester-united", // 4 mu
        "manchester-city", // 5 city
        "chelsea", // 6 chelsea
        "arsenal", // 7 arsenal
        "liverpool", // 8 liverpool
        "liga-inggris", // 9 premier-league
        "juventus", // 10 juventus
        "inter-milan", // 11 inter-milan
        "ac-milan", // 12 ac-milan
        "napoli", // 13 napoli
        "as-roma", // 14 as roma
        "liga-italia", // 15 serie-a
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

$html = file_get_html("http://www.liputan6.com/tag/$tag_param?type=text");
$ul = $html->find('div[class=topics--articles]', 0);
$property = 'data-src';
if(!$ul){
    $ul = $html->find('div[class=articles--iridescent-list]', 0);
    $property = "src";
}
foreach ($ul->find('article') as $li) {
    //           echo $li->find('a',0);
    $url = trim($li->find('a', 0)->href);
    $title = trim($li->find('header h4 a', 0)->plaintext);
    $figure = $li->find('figure picture', 0);
    
    $img_tumb = trim($figure->find('img', 0)->$property);
    $sumber = 'liputan6.com';
    
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


