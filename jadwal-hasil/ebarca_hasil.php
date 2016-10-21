<?php
ini_set('max_execution_time', 300); 

$alltim = array(
    'barcelona' => array(
        'kode' => '2017',
        'tag' => 'barcelona',
        'tim' => 'Barcelona',
    ),
    'real-madrid' => array(
        'kode' => '2016',
        'tag' => 'real-madrid',
        'tim' => 'Real Madrid',
    ),
    'atletico-madrid' => array(
        'kode' => '2020',
        'tag' => 'atletico-madrid',
        'tim' => 'Atlético Madrid',
    ),
    
    'juventus' => array(
        'kode' => '1242',
        'tag' => 'juventus',
        'tim' => 'Juventus',
    ),
    'milan' => array(
        'kode' => '1240',
        'tag' => 'milan',
        'tim' => 'Milan',
    ),
    'internazionale' => array(
        'kode' => '1244',
        'tag' => 'internazionale',
        'tim' => 'Internazionale',
    ),
    'napoli' => array(
        'kode' => '1270',
        'tag' => 'napoli',
        'tim' => 'Napoli',
    ),
    'roma' => array(
        'kode' => '1241',
        'tag' => 'roma',
        'tim' => 'Roma',
    ),
    
    'arsenal-fc' => array(
        'kode' => '660',
        'tag' => 'arsenal-fc',
        'tim' => 'Arsenal FC',
    ),
    'chelsea-fc' => array(
        'kode' => '661',
        'tag' => 'chelsea-fc',
        'tim' => 'Chelsea FC',
    ),
    'liverpool-fc' => array(
        'kode' => '663',
        'tag' => 'liverpool-fc',
        'tim' => 'Liverpool FC',
    ),
    'manchester-city-fc' => array(
        'kode' => '676',
        'tag' => 'manchester-city-fc',
        'tim' => 'Manchester City FC',
    ),
    'manchester-united-fc' => array(
        'kode' => '662',
        'tag' => 'manchester-united-fc',
        'tim' => 'Manchester United FC',
    ),
);

$BLN = array(
	'Januari' => '01',
	'Februari' => '02',
	'Maret' => '03',
	'April' => '04',
	'Mei' => '05',
	'Juni' => '06',
	'Juli' => '07',
	'Agustus' => '08',
	'September' => '09',
	'Oktober' => '10',
	'November' => '11',
	'Desember' => '12',
);

include '../koneksi.php';
include '../simple_html_dom.php';

$conn = new mysqli($servername, $username, $password, $dbname);

foreach ($alltim as $value) {
    
$tim = $value['tim'];
$tag = $value['tag'];
$kode = $value['kode'];
$url = "http://www.goal.com/id-ID/results/team/$tag/$kode";
$musim = 2016;
	




$html = file_get_html($url);

foreach ($html->find('table[class=match-table]') as $li) {
 
	$tgl = trim($li->find('thead', 0)->plaintext);
	$T = explode(" ",$tgl);

	$tanggal = $T[1];
	$bulan = $T[2];
	$tahun = $T[3];

	$time = strtotime($tahun."-".$BLN[$bulan]."-".$tanggal);
        
        $jam = trim($li->find('td[class=status]', 0)->plaintext);
	$waktu = $tgl." ".$jam;
        
        $div_home = $li->find('div[class=home] span',0);
        $tim_home = trim(($div_home->plaintext));
        
        $div_away = $li->find('div[class=away] span',0);
        $tim_away = trim(($div_away->plaintext));
        
        $div_vs = $li->find('td[class=vs]',0);
        $skor = trim($div_vs->plaintext); 
        
        $skor = explode("-",$skor);
        
        
        if($tim_home == $tim){
            $is_kandang = 1;
            $div_img = $li->find('div[class=home] img',0);
            $url_img_tim = $div_img->src;
            
            $div_img_lawan = $li->find('div[class=away] img',0);
            $url_img_lawan = $div_img_lawan->src;
            $lawan = $tim_away;
            
            $skor_tim = trim($skor[0]);
            $skor_lawan =  trim($skor[1]);
        }else{
            $is_kandang = 0;
            $div_img = $li->find('div[class=away] img',0);
            $url_img_tim = $div_img->src;
            
            $div_img_lawan = $li->find('div[class=home] img',0);
            $url_img_lawan = $div_img_lawan->src;
            $lawan = $tim_home;
            
            $skor_tim = trim($skor[1]);
            $skor_lawan =  trim($skor[0]);
        }
         
        $sql = "select * from ebarca_jadwal where time = '$time' AND tag = '$tag' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql = "UPDATE ebarca_jadwal SET skor_tim = '$skor_tim',skor_lawan = '$skor_lawan',waktu = '$waktu' WHERE time='$time' AND tag = '$tag'";
        }else{
            $sql = "INSERT INTO ebarca_jadwal (tag,is_kandang,waktu,musim,lawan,url_img_tim,url_img_lawan,time,skor_tim,skor_lawan) "
                    . "VALUES ('$tag','$is_kandang','$waktu','$musim','$lawan','$url_img_tim','$url_img_lawan','$time','$skor_tim','$skor_lawan')";
        }
        
        $conn->query($sql);
    
}
}

$conn->close();
die;


