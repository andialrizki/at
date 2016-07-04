<?php 
require_once "inc/config.php";
require_once "inc/ubig.php";

// $ubig_option declate on config.php
$ubig = new \UBIG\MainSDK($ubig_option);


if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = 'index';
}
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}
if (isset($_GET['limit'])) {
	$limit = $_GET['limit'];
} else {
	$limit = 10;
}




switch ($id) {
	case 'index':
		$News = $ubig->GetNews(array(
		    "seo_kat"=>"olahraga-sports",
		    "sort" => "t_psg:desc",
		    "limit" => $limit,
		    "page" => $page,
		    "cache" => true,
		));
			if ($News["IsError"] == "false"){
				$ListBerita = ($News["pagging"]["Count"] > 1 ? $News["lstdt"]["DtBerita"] : array($News["lstdt"]["DtBerita"])); 
				foreach ($ListBerita as $brt){
					echo '<div class="row news-item">
								<div class="col-xs-4">
									<div class="pdt-card-img">
										<img alt="'.$brt['jdl'].'" data-original="'.(is_array($brt["gs"])? "/img/default.png" : $brt["gs"]).'" class="lazy img-rounded img-responsive">
									</div>
								</div>
								<div class="col-xs-8">
									<a href="'.SITE_URL.'baca/'.UrlSeo($brt["jdl"]).'-'.$brt["_id"].'.html">
										<p class="news-title">'.$brt['jdl'].'</p>
									</a>
									<p class="news-time">'.$brt["n_smbr"].', '.FormatTanggal($brt["t_psg"]).'</p>
									<p class="news-detail">
										'.LimitWord($brt["rksn"], 20).'
									</p>
								</div>
							</div>';
				}
			}
		break;
	case 'harga-promo':
			$Harga=$ubig->GetPricePromo([
			    //'kywd' => 'samsung',
			    "seo_kat"=>"otomotif-dan-sepeda",
			    "sort" => "t_psg:desc",
			    "cache" => true,
			    "limit" => 8,
			    "page" => $page,
			]);
			if ($Harga["IsError"] == "false"){ 
			echo '<ul class="hargaList">';
				$ListHarga = ($Harga["pagging"]["Count"] > 1 ? $Harga["lstdt"]["DtIklanPromo"] : array($Harga["lstdt"]["DtIklanPromo"])); 
				foreach ($ListHarga as $hrg){
					echo '<li class="row jual-item">
						<div class="col-xs-4 no-padd-marg-left">
							<div class="barangPromo-img">
								<img data-original="'. ($hrg["gs1"] =="default.png"? "/img/default.png" : $hrg["gs1"]) .'" class="lazy img-rounded img-responsive">
							</div>
						</div>
						<div class="col-xs-8 no-padd-marg-left">
							<a href="'. SITE_URL.'harga/'.UrlSeo($hrg["n"]) .'-'. $hrg["_id"] .'.html">
								<p class="news-title">'. $hrg["n"] .'</p>
							</a>
							<p><del style="font-size:10px">'.strtonumber($hrg["hrg_nrml"]).'</del> <span class="price">'.strtonumber($hrg["hrg_dskn"]).'</span></p>
							<a href="">
								<button class="btn btn-orange btn-xs"><i class="fa fa-exchange"></i> Bandingkan</button> 
							</a>
						</div>
					</li>';
				} 
				echo '</ul>';
			} 
		break;
	case 'headline-index':
		$Headline = $ubig->GetNewsHeadline(array(
		    //"seo_kat"=>"olahraga-sports",
		    // "seo_skat"=>"sepak-bola-football",
		    "sort" => "t_psg:desc",
		    "limit" => 10,
		    "page" => 1,
		    "cache" => true
		));
			if ($Headline["IsError"] == "false"){

				echo '<ul class="headline-list" id="headline-slider">';
				$ListHeadline = ($Headline["pagging"]["Count"] > 1 ? $Headline["lstdt"]["DtBeritaHeadline"] : array($Headline["lstdt"]["DtBeritaHeadline"])); 
				foreach ($ListHeadline as $head){
					echo '<li class="row jual-item">
						<a href="'. SITE_URL.'baca/'.UrlSeo($head["jdl"]) .'-'. $head["_id"] .'.html">
							<p class="news-title" style="font-weight:normal!important">'.$head["jdl"] .'</p>
						</a>
					</li>';
				}

				echo '</ul>';
			}
		break;
	case 'get-provinsi':
		# code...
		break;
	case 'get-kota':
		if (isset($_GET['prov'])) {
			$prov = $_GET['prov'];
		} else {
			$prov = '';
		}
		$id_prov = explode('-', $prov);
		$kota=$ubig->GetKota([
			"i_prop" => $id_prov[1],
	    "ngr"=>"id",
	    "cache"=>true
	  ]);
	  if ($kota["IsError"] == "false"){
				$ListKota = ($kota["pagging"]["Count"] > 1 ? $kota["lstdt"]["DtIntKota"] : array($Headline["lstdt"]["DtIntKota"])); 
				$data = array();
				foreach ($ListKota as $d) {
					//$kot = explode(',', $d['kywd']);
					$data[] = array(
						//'kota' => $kot[0].'-'.$d['_id'],
						'n' => $d['n']);
				}
				echo json_encode($data);
			}
		break;
	default:
		# code...
		break;
}



?>