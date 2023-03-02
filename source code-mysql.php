/*---------------------------------------------------------------------
Program:	aksis2.php
Konusu:		BMG dersi text dosyası ile aksis hazırlama
Programcı:	Nuri Gökdoğan, nurigokdogan@ogr.iu.edu.tr
Numara:		1306170084
Dili:		PHP 7
Tarih:		19.12.2018
Kurum:		İstanbul Üniversitesi
----------------------------------------------------------------------*/
<html>
<head></head>
<body>
<?php
echo "<pre>"; print_r($_REQUEST); echo "</pre>";
switch(@ $_GET['is']){
	
	case 'ogrenciEklemeFormu': ogrenciEklemeFormu(); break;
	case 'ogrenciEkle': ogrenciEkle($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolumno'],$_GET['cinsiyet'],$_GET['askerlik']); anaSayfa(); break;
	case 'ogrenciSil'	: ogrenciSil($_GET['no']);ogrenciListele(); break;
	case 'guncelleFormu': guncelleFormu($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolum'],$_GET['cinsiyet'],$_GET['askerlik']);  break;
	case 'guncelle': guncelle($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolum'],$_GET['cinsiyet'],$_GET['askerlik']);  break;
	case 'ekle'	: ekle(); break;
	case 'ogrenciListele': ogrenciListele(); break;
	case 'bolumEklemeFormu': bolumeklemeFormu();  break;
	case 'bolumEkle': bolumEkle($_GET['bno'],$_GET['bolumadi']); bolumListele(); break;
	case 'bolumsil' : bolumSil($_GET['bno']);bolumListele(); break;
	case 'bolumguncelleFormu': bolumguncelleFormu($_GET['bno'],$_GET['bolumadi']);  break;
	case 'bolumguncelle' : bolumguncelle($_GET['bno'],$_GET['bolumadi']);  break;
	case 'bolumListele': bolumListele(); break;
	case 'bolumdekiOgrenciler':bolumdekiOgrenciler($_GET['no']); break;
		default: anaSayfa();//listele();
}
exit;

	function anaSayfa(){
	echo "<a href=?is=ogrenciListele>OGRENCILER</a> <br/>
			<a href=?is=bolumListele>BOLUMLER</a>";
}
	
	function ogrenciEklemeFormu(){
	
	echo "
	<form action='?'  method=get>
	<h3>Yeni Ogrenci</h3><a href='?is='>Ana sayfa</a>
	<table>
	<tr><td>No</td> <td><input name=no type=text></td></tr>
	<tr><td>Adi</td> <td><input name=ad type=text></td></tr>
	<tr><td>Soyadi</td> <td><input name=soyad type=text></td></tr>
	<tr><td>BolumNo</td> <td><input name=bolumno type=text></td></tr>
	
	
	<tr><td>Askerlik Durumu</td> <td><select name=askerlik size=1>
  	<option value=Yapti>Yaptı</option>
  	<option value=Yapmadi>Yapmadı</option>
	</select></td></tr>

	<tr><td>Cinsiyet</td> <td><select name=cinsiyet size=1>
  	<option value=erkek>Erkek</option>
  	<option value=Kadin>Kadın</option>
	</select></td></tr>

	<tr><td></td> <td><input name=tamam type=submit value=Olustur></td></tr>
	</table>
	<input name=is type=hidden value=ogrenciEkle>
	</form>";
	}

	function ogrenciEkle($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik){
$dosya_adi = "ogrenci.txt"; 

$deger1 = $_GET['no'];
$deger2=$_GET['ad'];
$deger3=$_GET['soyad'];
$deger4=$_GET['bolumno'];
$deger5=$_GET['cinsiyet'];
$deger6=$_GET['askerlik'];

$yazilacak_deger = "$deger1,$deger2,$deger3,$deger4,$deger5,$deger6\n"; 


if ($yazilacak_deger) {  
	if (!file_exists($dosya_adi)){  
touch($dosya_adi); 
chmod($dosya_adi,0666); 
} 
$dosyaya_baglanti = fopen($dosya_adi,"a+"); 

if (!fwrite($dosyaya_baglanti,$yazilacak_deger)){ 
echo "Dosyaya yazılamadı."; 
exit; 
}  

echo "Kayit gerceklesti. Kaydi goruntule >> <a href='ogrenci.txt'>ogrenci.txt</a>"; 
} else { 
echo "Kayit basarili degil."; 
	}
	
}
function ogrenciSil($no){
$okunan=file('ogrenci.txt');
	$k=0;
	foreach($okunan as $sira => $satir){
		$data=explode('|',$satir);
$no=substr($satir,0,strpos($satir,'|'));
		$k++;
	}
	
	if($_GET['no']){
	$indis = array_search($_GET['no'], $no);
			if($indis>=0){
			unset($okunan[$indis]);
			$ac = fopen('ogrenci.txt','w+');
	foreach($okunan as  $satir){
	fwrite($ac,$satir);
				}
				fclose($ac);
			}
		}
}
function guncelle($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik){
	if($GET['Submit']){ 
$open = fopen("ogrenci.txt","w+"); 
$text = $GET['update']; 
fwrite($open, $text); 
fclose($open); 
echo "File updated.<br />";  
echo "File:<br />"; 
$file = file("ogrenci.txt"); 
foreach($file as $text) { 
echo $text."<br />"; 
} 
}else{ 
$file = file("ogrenci.txt"); 
echo "<form action=\"".$PHP_SELF."\" method=\"get\">"; 
echo "<textarea Name=\"update\" cols=\"50\" rows=\"10\">"; 
foreach($file as $text) { 
echo $text; 
}  
echo "</textarea>"; 
echo "<input name=\"Submit\" type=\"submit\" value=\"Update\" />\n 
</form>"; 
	}
}


function ogrenciListele(){
echo "<h1>Ogrenci listesi</h1> 
	<a href='?is=ogrenciEklemeFormu'>Yeni</><a href='?is='>Ana sayfa</a>
	<table class='table table-dark'> <thead><tr> <th>No</th> <th>Adi</th> <th>Soyadi</th> <th>Bölüm</th>  <th>Cinsiyet</th>  <th>Askerlik</th> <th>Sil</th> <th>Degistir</th> <th>Bolumdekiler</th></tr></thead><tbody>";
	$oku = fopen("ogrenci.txt","r"); //okunacak yol ve metod belirttik
while(!feof($oku)){ //feof metodu ile dosya sonu gelene kadar while’ı devam ettirdik
$okunan = fgets($oku); //fgets ile satır okuduk ve $satir değişkeninin içine attık.
$satir=explode(" ",$okunan);		
		print "<tr> 
			<td>{$satir[0]}</td> 
			<td>{$satir[1]}</td> 
			<td>{$satir[2]}</td> 
			<td>{$satir[3]}</td>
			<td>{$satir[4]}</td>
			<td>{$satir[5]}</td>
			<td> <a href='?is=ogrenciSil&no={$satir[0]}'>Sil</a>
			<td> <a href='?is=guncelleFormu&no={$satir[0]}&ad={$satir[1]}&soyad={$satir[2]}&bolum={$satir[3]}&cinsiyet={$satir[5]}&askerlik={$satir[4]}'>Degistir</a>
			<td> <a href='?is=bolumdekiOgrenciler&no={$satir[3]}'>Bolumdekiler</a> </td> 
			</td></tr>";}
	   print "</tbody></table>";
}

function bolumEklemeFormu(){
	echo 
	"<form action='?'  method=get>
	<h3>YeniBolum  </h3><a href='?is='>Ana sayfa</a>
	<table>
	<tr><td>No</td> <td><input name=bno type=text></td></tr>
	<tr><td>Adi</td> <td><input name=bolumadi type=text></td></tr>
	<tr><td></td> <td><input name=tamam type=submit value=Olustur></td></tr>
	</table>
	<input name=is type=hidden value=bolumEkle>
	</form>";
}

function bolumEkle($bno, $bolumadi){
	
	$dosya_adi = "bolum.txt"; 

$deger1 = $_GET['bno'];
$deger2=$_GET['bolumadi'];

$yazilacak_deger = "$deger1,$deger2\n"; 


if ($yazilacak_deger) {  
	if (!file_exists($dosya_adi)){  
touch($dosya_adi); 
chmod($dosya_adi,0666); 
} 
$dosyaya_baglanti = fopen($dosya_adi,"a+"); 

if (!fwrite($dosyaya_baglanti,$yazilacak_deger)){ 
echo "Dosyaya yazılamadı."; 
exit; 
}  

echo "Kayit gerceklesti. Kaydi goruntule >> <a href='bolum.txt'>bolum.txt</a>"; 
} else { 
echo "Kayit basarili degil."; 
	}
	
}

function bolumListele(){
	
	echo "<h1>Bolum listesi</h1> 
	<a href='?is=bolumEklemeFormu'>Yeni</a> <a href='?is='>Ana sayfa</a>
	<table class='table table-dark'> <thead><tr> <th>No</th> <th>Adi</th>  <th>Sil</th> </tr></thead><tbody>";
	$oku = fopen("bolum.txt","r"); //okunacak yol ve metod belirttik
while(!feof($oku)){ //feof metodu ile dosya sonu gelene kadar while’ı devam ettirdik
$okunan = fgets($oku); //fgets ile satır okuduk ve $satir değişkeninin içine attık.
$satir=explode(" ",$okunan);
print "<tr> 
			<td>{$satir[0]}</td> 
			<td>{$satir[1]}</td> 
 			<td> <a href='?is=bolumsil&bno={$satir[0]}'>Sil</a>
			<td> <a href='?is=bolumguncelleFormu&bno={$satir[0]}&bolumadi={$satir[1]}'>Degistir</a>
			<td> <a href='?is=bolumdekiOgrenciler&no={$satir[0]}'>Ogrenciler</a>
			</td></tr>";
	}
	print "</tbody></table>";
}
function bolumSil($bno){
$okunan=file('bolum.txt');
	$k=0;
	foreach($okunan as $sira => $satir){
		$data=explode('|',$satir);
$no=substr($satir,0,strpos($satir,'|'));
		$k++;
	}
	
	if($_GET['no']){
	$indis = array_search($_GET['no'], $no);
			if($indis>=0){
			unset($okunan[$indis]);
			$ac = fopen('bolum.txt','w+');
	foreach($okunan as  $satir){
	fwrite($ac,$satir);
				}
				fclose($ac);
			}
		}
}

function bolumguncelleFormu($bolumno, $bolumadi){
	
	echo "
	<form action='?'  method=get>
	<h3>Bolum Guncelle</h3><a href='?is='>Ana sayfa</a>
	<table>
	<tr><td>No</td> <td><input name=bno type=text value={$bno} readonly></td></tr>
	<tr><td>Adi</td> <td><input name=bolumadi type=text value={$bolumadi}></td></tr>
	<tr><td></td> <td><input name=tamam type=submit value=Olustur></td></tr>
	</table>
	<input name=is type=hidden value=bolumguncelle>
	</form>";
}
function bolumguncelle($bolumno, $bolumadi){
if($GET['Submit']){ 
$open = fopen("bolum.txt","w+"); 
$text = $GET['update']; 
fwrite($open, $text); 
fclose($open); 
echo "File updated.<br />";  
echo "File:<br />"; 
$file = file("bolum.txt"); 
foreach($file as $text) { 
echo $text."<br />"; 
} 
}else{ 
$file = file("bolum.txt"); 
echo "<form action=\"".$PHP_SELF."\" method=\"get\">"; 
echo "<textarea Name=\"update\" cols=\"50\" rows=\"10\">"; 
foreach($file as $text) { 
echo $text; 
}  
echo "</textarea>"; 
echo "<input name=\"Submit\" type=\"submit\" value=\"Update\" />\n 
</form>"; 
	}
}

	?>
</body>