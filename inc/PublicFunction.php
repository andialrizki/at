<?php
function image_url($value)
{
    return SITE_URL.'public/images/'.$value;
}
function print_r_mod($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
function tipeCari($string, $tipe)
{
    if ($string == 'berita') {
        if ($tipe == 'function' || empty($tipe)) {
            return 'cariBeritaFunc';
        } else {
            return 'Berita';
        }
    } else if($string == 'harga') {
        if ($tipe == 'function' || empty($tipe)) {
            return 'cariHargaFunc';
        } else {
            return 'Harga';
        }
    } else {
        if ($tipe == 'function' || empty($tipe)) {
            return 'cariBeritaFunc';
        } else {
            return '';
        }
    }
}
/*function format tanggal INDONESIA*/
function FormatTanggal($tanggal, $format="j F Y"){
    $date=date_create($tanggal);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember','Oktober','November','Desember',
    );

    return preg_replace ($pattern, $replace, date_format($date,$format));
}

/*function format uang INDONESIA*/
function  strtonumber($number,$decimals=0) {
    return "Rp ". number_format($number, 0, ",", ".");
}

/*function format angka INDONESIA*/
function FormatNumber($number){
    return  number_format($number, 0, ",", ".");;
}

/*function remove illegal string*/
function UrlSeo($string){
    try{
        if(!is_null($string)){
            if(strlen($string)>170){
                $string=substr($string,0,170);
            }
        }
        $result=preg_replace("(\(|\~|\!|\@|\#|\$|\%|\^|\&|\*|\-|\+|\=|\{|\}|\[|\]|\||\"|\;|\:|\|\'|\<|\>|\,|\.|\?|\/|\s|\))", "-", $string);
        $result=preg_replace("(-+)", "-", $result);
        return trim(strtolower($result),"-");
    }catch (Exception $e){
    }
}
/*function untuk ProperCase (Huruf Pertama Huruf Besar)*/
function ProperCase($string){
    return ucwords(strtolower(preg_replace("(-+)", " ", $string)));
}
function UrlDeseo($string)
{
    return trim(ProperCase(str_replace('-', ' ', $string)));
}
/*function remove , (comma) pada json*/
function removeTrailingCommas($json){
    $json=preg_replace('/,\s*([\]}])/m', '$1', $json);
    return $json;
}

/*function limit kata pada suatu paragraf*/
function LimitWord($string,$limit){
    return implode(" ", array_slice(explode(" ", $string), 0, $limit));
}

/*function cek apakah ada word pada string*/
function inStr($string, $word)
{
    $pos = strpos($string, $word);
    if ($pos === false) {
        return false;
    } else {
        return true;
    }
}

/*function set alamat*/
function SetAlamat($propinsi,$kota){
    if(!empty($propinsi) && strlen($propinsi)>0){
        if(!empty($kota) && strlen($kota)>0){
            return $kota.", ".$propinsi;
        } else{
            return $propinsi;
        }
    }else{
        return "Indonesia";
    }
}

/*function check null*/
function IsNotNull($string){
    if(empty($string)){
        return;
    }
    return (strlen($string)>0?true:false);
}

/*function check url valid apa tidak*/
function IsValidURL($url){
    $regmatch="/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
    if (preg_match($regmatch, $url)) {
        return true;
    } else {
        return false;
    }
}

/*function membuat button pagging*/
function CreateButtonPagging($isNext, $isPrev, $halke, $jmldata, $limit,$optional=""){
    $xstep=1;
    try{
        /*cek jumlah data jika 0 dikembalikan (tidak ada pagging)*/
        if($jmldata==0){
            return;
        }
        $xstep=1;
        $StringBuilder="";
        $JumlahHalaman=ceil($jmldata/$limit);
        $pengurang=0;
        if(is_null($halke))$halke=1;
        $CurrentURL=$_SERVER['REQUEST_URI'];
        $url=explode("?",$CurrentURL);

        $optional="";

        $StringBuilder .="<div class='paging-holder text-center'>";
        $StringBuilder .="<ul class='pagination '>";



        $xstep=2;
        if($isPrev=="true"){
            $numpage=$halke-1;
            $StringBuilder .="<li><a href='" . $url[0] . "?page=" .  $numpage . "' data-page='" . $numpage . "' onclick='". $optional . "' title='Page " . $numpage . "'><span aria-hidden='true'>&laquo;</span></a></li>";

        }else{
            $StringBuilder.="<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span></a></li>";
        }

        $xstep=3;

        //Sebelum
        if($halke > 1){
            $mulai=$halke-2;
            $sampai=$halke-1;

            if($mulai <=0){
                $mulai=1;
            }

            for($j=$mulai;$j<=$sampai;$j++){
                //$StringBuilder .="<li><a href='" . $url[0] . "?p=" . $j . "' data-page='" . $j . "' onclick='" . $optional . "; return false;' title='Page " . $j . "'>" . $j . "</a></li>";
                $StringBuilder .="<li><a href='".$url[0]."?page=".$j."' data-page='".$j."' onclick='".$optional."' title='Page ". $j ."'>". $j ."</a></li>";
                $pengurang +=1;
            }
        }

        $xstep=4;

        if($JumlahHalaman==$halke){
            $StringBuilder.="<li class='disabled active'><a href='#'>". $halke ."</a></li>";
        }else{
            if($JumlahHalaman<5){
                for($i=1;$i<=$JumlahHalaman-$pengurang;$i++){
                    $numpage= $halke+($i-1);
                    if($i==1){
                        $StringBuilder.="<li class='disabled active'><a href='#'>". $numpage ."</a></li>";
                    }else{
                        $StringBuilder .="<li><a href='" . $url[0] . "?page=" .  $numpage . "' data-page='" . $numpage . "' onclick='". $optional . "' title='Page " . $numpage . "'>". $numpage ."</a></li>";
                    }
                }
            }else{
                for($i=1;$i<=5-$pengurang;$i++){
                    $numpage=$halke+($i-1);
                    if($i==1){
                        $StringBuilder.="<li class='disabled active'><a href='#'>". $numpage ."</a></li>";
                    }else{
                        $StringBuilder .="<li><a href='" . $url[0] . "?page=" .  $numpage . "' data-page='" . $numpage . "' onclick='". $optional . "' title='Page " . $numpage . "'>". $numpage ."</a></li>";
                    }
                }
            }
        }


        $xstep=5;
        if($isNext=="true"){
            $numpage=$halke+1;

            $StringBuilder .="<li><a href='" . $url[0] . "?page=" .  $numpage . "' data-page='" . $numpage . "' onclick='". $optional . "' title='Page " . $numpage . "'><span aria-hidden='true'>&raquo;</span></a></li>";
        }else{
            $StringBuilder.="<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span></a></li>";
        }

        $StringBuilder .="</ul>";
        $StringBuilder .="</div>";

        return $StringBuilder;
    }catch (exception $e){
        return $e->getMessage();
    }


}

?>