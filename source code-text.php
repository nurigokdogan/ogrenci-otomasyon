<html>
<head></head>
<body>
<?php
echo "<pre>"; print_r($_REQUEST); echo "</pre>";
switch(@ $_GET['is']){
	case 'guncelleFormu': guncelleFormu($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolum'],$_GET['cinsiyet'],$_GET['askerlik']);  break;
	case 'guncelle': guncelle($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolum'],$_GET['cinsiyet'],$_GET['askerlik']);  break;
	case 'bolumguncelleFormu': bolumguncelleFormu($_GET['bno'],$_GET['bolumadi']);  break;
	case 'bolumguncelle' : bolumguncelle($_GET['bno'],$_GET['bolumadi']);  break;
	
	case 'ekle'	: ekle(); break;
	
	case 'ogrenciSil'	: 
		ogrenciSil($_GET['no']);
		ogrenciListele(); 
		break;
	case 'bolumsil' : 
		bolumSil($_GET['bno']);
		bolumListele(); 
		break;
		
	case 'bolumEklemeFormu': bolumeklemeFormu();  break;
	case 'bolumEkle': 
		bolumEkle($_GET['bno'],$_GET['bolumadi']); 
		bolumListele(); 
		break;
	case 'ogrenciListele': ogrenciListele(); break;
	case 'bolumListele': bolumListele(); break;
	case 'bolumdekiOgrenciler':bolumdekiOgrenciler($_GET['no']); break;
	case 'ogrenciEklemeFormu': ogrenciEklemeFormu(); break;
	case 'ogrenciEkle': ogrenciEkle($_GET['no'],$_GET['ad'],$_GET['soyad'],$_GET['bolum'],$_GET['cinsiyet'],$_GET['askerlik']); 
		ogrenciListele(); 
		break;
	default: anaSayfa();//listele();
}
exit;

function ogrenciSil($no){

	$sql = "DELETE FROM ogrenciler WHERE No=$no;";
	//echo "<br/>SQL: $sql<br/>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
}

function guncelle($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik){

	$sql =	"UPDATE ogrenciler SET no='$no', ad='$ad', soyad='$soyad', bolumno='$bolumno', cinsiyet='$cinsiyet, askerlik='$askerlik'' WHERE no='$no'";
	//echo "<br/>SQL: $sql<br/>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
}
function guncelleFormu($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik){
	
	echo "
	<form action='?'  method=get>
	<h3>Ogrenci Guncelle</h3><a href='?is='>Ana sayfa</a>
	<table>
	<tr><td>No</td> <td><input name=no type=text value={$no} readonly></td></tr>
	<tr><td>Adi</td> <td><input name=ad type=text value={$ad}></td></tr>
	<tr><td>Soyadi</td> <td><input name=soyad type=text value={$soyad}></td></tr>
	<tr><td>Bolum</td> <td><input name=bolum type=text value={$bolumno}></td></tr>

	<tr><td>Askerlik Durumu</td> <td><select name=askerlik size=1 value={$askerlik}>
  	<option value=Yapti>Yaptı</option>
  	<option value=Yapmadi>Yapmadı</option>
	</select></td></tr>

	<tr><td>Cinsiyet</td> <td><select name=cinsiyet size=1 value={$cinsiyet}>
  	<option value=erkek>Erkek</option>
  	<option value=kadin>Kadın</option>
	</select></td></tr>

	<tr><td></td> <td><input name=tamam type=submit value=Olustur></td></tr>
	</table>
	<input name=is type=hidden value=guncelle>
	</form>";
}
function ogrenciEkle($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik){
	$found = 0;
	
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	$kayitKumesi = mysqli_query($baglanti, "SELECT bno FROM bolumler");
	
	
	while($satir = mysqli_fetch_assoc($kayitKumesi)){
		if( $satir['bno'] == $bolumno ){
		$found = 1;
		}
	}

	if ($found == 1){
	$sql = "INSERT INTO ogrenciler VALUE($no, $ad, $soyad,$cinsiyet, $bolumno, $askerlik);";
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
		
	}else{
	echo "<h3>Bolum Bulunamadi>
	<a href='?is='>Ana sayfa</a>";
	}

	$found = 0;
}
	
function ogrenciEklemeFormu(){
	
	echo "
	<form action='?'  method=get>
	<h3>Yeni Ogrenci</h3><a href='?is='>Ana sayfa</a>
	<table>
	<tr><td>No</td> <td><input name=no type=text></td></tr>
	<tr><td>Adi</td> <td><input name=ad type=text></td></tr>
	<tr><td>Soyadi</td> <td><input name=soyad type=text></td></tr>
	<tr><td>Bolum</td> <td><input name=bolum type=text></td></tr>
	
	
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
function bolumdekiOgrenciler($bno){
	
	echo "<h1>$bolumno Bolumdeki  listesi</h1> <a href='?is='>Ana sayfa</a>
	<table class='table table-dark'> <thead><tr> <th>No</th> <th>Adi</th> <th>Soyadi</th> <th>Cinsiyet</th> <th>Askerlik</th> </tr></thead><tbody>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	$sql = "SELECT * FROM ogrenciler WHERE bolumno=$bno;";
	$kayitKumesi = mysqli_query($baglanti, "SELECT * FROM ogrenciler WHERE bolumno=$bno;");
	//echo "$sql<br>";
	while($satir = mysqli_fetch_array($kayitKumesi)){
		print "<tr> 
			<td>{$satir[0]}</td> 
			<td>{$satir[1]}</td> 
			<td>{$satir[2]}</td> 
			<td>{$satir[3]}</td> 
			<td>{$satir[4]}</td> 
			</td></tr>";
	}
	print "</tbody></table>";
}

function bolumguncelle($bolumno, $bolumadi){

	$sql =	"UPDATE bolumler SET bno='$bolumno', bolumadi='$bolumadi' WHERE bno='$bolumno'";
	//echo "<br/>SQL: $sql<br/>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
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

	$sql = "INSERT INTO bolumler VALUE($bno, '$bolumadi');";
	//echo "<br/>SQL: $sql<br/>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
}
function bolumListele(){
	
	echo "<h1>Bolum listesi</h1> 
	<a href='?is=bolumEklemeFormu'>Yeni</a> <a href='?is='>Ana sayfa</a>
	<table class='table table-dark'> <thead><tr> <th>No</th> <th>Adi</th> <th>Ogr. Sayisi</th> <th>Sil</th> </tr></thead><tbody>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi') or exit(mysqli_error($baglanti));
	$kayitKumesi = mysqli_query($baglanti, "SELECT bolumler.bno, bolumadi, COUNT(no) FROM bolumler,ogrenciler WHERE ogrenciler.bolumno=bolumler.bno GROUP BY ogrenciler.bolumno") 
	or exit(mysqli_error($baglanti));
	while($satir = mysqli_fetch_array($kayitKumesi)){
		print "<tr> 
			<td>{$satir[0]}</td> 
			<td>{$satir[1]}</td> 
			<td>{$satir[2]}</td>
 			<td> <a href='?is=bolumsil&bno={$satir[0]}'>Sil</a>
			<td> <a href='?is=bolumguncelleFormu&bno={$satir[0]}&bolumadi={$satir[1]}'>Degistir</a>
			<td> <a href='?is=bolumdekiOgrenciler&no={$satir[0]}'>Ogrenciler</a>
			</td></tr>";
	}
	print "</tbody></table>";
}
	function bolumSil($bno){

	$sql = "DELETE FROM bolumler WHERE bno=$bno;";
	//echo "<br/>SQL: $sql<br/>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));

	$sql = "DELETE FROM ogrenciler WHERE bno=$bno;";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	if(! $baglanti)
		exit(mysqli_error($baglanti));
	$sonuc = mysqli_query($baglanti, $sql);
	if(! $sonuc)
		exit(mysqli_error($baglanti));
}
function anaSayfa(){
	echo "<a href=?is=ogrenciListele>OGRENCILER</a> <br/>
			<a href=?is=bolumListele>BOLUMLER</a>";
}
function ogrenciListele(){
echo "<h1>Ogrenci listesi</h1> 
	<a href='?is=ogrenciEklemeFormu'>Yeni</><a href='?is='>Ana sayfa</a>
	<table class='table table-dark'> <thead><tr> <th>No</th> <th>Adi</th> <th>Soyadi</th> <th>Bölüm</th>  <th>Cinsiyet</th>  <th>Askerlik</th> <th>Sil</th> <th>Degistir</th> <th>Bolumdekiler</th></tr></thead><tbody>";
	$baglanti = mysqli_connect('localhost', 'root', '', 'bilgi');
	$kayitKumesi = mysqli_query($baglanti, "SELECT * FROM ogrenciler");
	while($satir = mysqli_fetch_array($kayitKumesi)){
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
			</td></tr>";
	}
	print "</tbody></table>";
}
?>
</body>
