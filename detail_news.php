<?php 

require_once "inc/config.php";
require_once "inc/ubig.php";

$ubig = new \UBIG\MainSDK($ubig_option);

$IsError = true;
// Ambil Data Detail Ke API
$ApiResult = $ubig->GetNewsDetail(array("_id" => $_REQUEST['id']));
if ($ApiResult["IsError"] == "false") {
    $IsError = false;

    /* buat variable penampung data */ 
    $BeritaID=$_REQUEST["id"];
    $JudulBerita=$ApiResult["jdl"];
    $TanggalBerita=FormatTanggal($ApiResult["t_psg"]);
    $LokasiBerita="";
    $SumberBerita=$ApiResult["n_smbr"];
    $DeskBerita=preg_replace("/<\/?div[^>]*\>/i", "",(is_array($ApiResult["dsk"])?"":$ApiResult["dsk"]));
    $SeoKatBerita=$ApiResult["seo_kat"];
    $NamaKatBerita=$ApiResult["n_kat"];
    $SeoSubKatBerita=$ApiResult["seo_skat"];
    $NamaSubKatBerita=$ApiResult["n_skat"];
    $SeoJenisBerita=$ApiResult["seo_jns"];

    if(!is_null($ApiResult["gs"])){
        $Gambar1=$ApiResult["gs"];
    }
    if(!is_null($ApiResult["gs2"])){
        $Gambar2=$ApiResult["gs2"];
    }
    if(!is_null($ApiResult["gs3"])){
        $Gambar3=$ApiResult["gs3"];
    }
}

 ?>
<?php include "header.php" ?>
<div class="container body_wrapper">
	<div class="row">
		<div class="col-sm-7">
			<h3 class="news-title"><?php echo $JudulBerita ?></h3>
			<p class="news-time">Sumber: <?php echo $SumberBerita ?>, <?php echo $TanggalBerita ?></p>
			<p>
				 <?php
	          /* cek gambar ada apa tidak. jika iya tambah elemen */
	          if (isset($Gambar1)) {
	              echo '<img src="' . $Gambar1 . '" class="img-responsive">';
	          }
	          if (isset($Gambar2)) {
	              echo '<img src="' . $Gambar2 . '" class="img-responsive">';
	          }
	          if (isset($Gambar3)) {
	              echo '<img src="' . $Gambar3 . '" class="img-responsive">';
	          }
          ?>
			</p>
			<p class="news-detail">
				<?php echo $DeskBerita ?>
			</p>
		</div>
		<div class="col-sm-5">
			<h4 class="title">
				Berita Terkait
			</h4>
			<div class="barangHome">
				<?php
			    /* variable penampung keyword dari nama iklan dan dibatasi 3 kata */
			    $keyword = LimitWord($JudulBerita, 2);
			    $ApiResult=$ubig->GetNewsSimiliar(array(
			        "kywd"=>$keyword,
			        "sort"=>"t_psg:desc",
			        "limit"=>"5",
			    ));
			    if($ApiResult["IsError"]=="false"){
			      $Similliar=(count($ApiResult["lstdt"])>1?$ApiResult["lstdt"]["DtBerita"]:array($ApiResult["lstdt"]["DtBerita"])); 
						foreach ($Similliar as $item){ ?>
							<div class="row jual-item">
								<div class="col-xs-4">
									<img src="<?= (is_array($item["gs"])? "/img/default.png" : $item["gs"]) ?>" class="img-rounded img-responsive">
								</div>
								<div class="col-xs-8">
									<a href="<?php echo SITE_URL.'readnews/' ?><?php echo UrlSeo($item["jdl"]) ?>-<?php echo $item["_id"] ?>.html">
										<p class="news-title"><?= $item["jdl"] ?></p>
									</a>
								</div>
							</div>
						<?php } ?>
					<?php } else echo $ApiResult['ErrMessage']; ?>
			</div>
		</div>
	</div>
</div>

<?php include "footer_script.php"; ?>
<?php include "footer.php"; ?>