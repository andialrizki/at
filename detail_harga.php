<?php 
	require_once "inc/config.php";
	require_once "inc/ubig.php";

	$ubig = new \UBIG\MainSDK($ubig_option);	
	$IsError = true;
	// Ambil Data Detail Ke API
	$ApiResult = $ubig->GetPriceDetail(array("_id" => $_REQUEST['id'], 'cache' => true));
	//print_r_mod($ApiResult);
	if ($ApiResult["IsError"] == "false") {
	    $IsError = false;

	    /* buat variable penampung data */
	    $IklanID = $_REQUEST["id"];
	    $NamaIklan = $ApiResult["n"];
	    $HargaIklan = strtonumber($ApiResult["hrg"]);
	    $TanggalIklan = FormatTanggal($ApiResult["t_psg"]);
	    $LokasiIklan = setAlamat($ApiResult['n_kot'], $ApiResult['n_prop']);
	    $KondisiIklan = ($ApiResult["kon"] == 1 ? "Bekas" : "Baru");
	    $SumberIklan = $ApiResult["n_smbr"];
	    $DeskIklan = (is_array($ApiResult["desk"]) ? "" : $ApiResult["desk"]);
	    $SeoKatIklan = $ApiResult["seo_kat"];
	    $NamaKatIklan = $ApiResult["n_kat"];
	    $SeoSubKatIklan = $ApiResult["seo_skat"];
	    $NamaSubKatIklan = $ApiResult["n_skat"];
	    $SeoJenisIklan = $ApiResult["seo_jns"];
	    $IDPemasangIklan = $ApiResult["i_pmsg"];
	    $PemasangNama = ProperCase($ApiResult["n_pmsg"]);
	    $PemasangID = ProperCase($ApiResult["i_pmsg"]);

	    $Gambar1 = $Gambar2 = $Gambar3 = false;
	    if (!is_null($ApiResult["gs1"])) {
	        $Gambar1 = ($ApiResult["gs1"] == 'default.png' ? "/img/" . $ApiResult["gs1"] : $ApiResult["gs1"]);
	    }
	    if (!is_array($ApiResult["gs2"])) {
	        $Gambar2 = $ApiResult["gs2"];
	    }
	    if (!is_array($ApiResult["gs3"])) {
	        $Gambar3 = $ApiResult["gs3"];
	    }
	}
$Similiar=$ubig->GetPriceSimiliar([
    "kywd"=>LimitWord($NamaIklan, 3),
    "sort"=>"t_psg:desc",
    "bhs"=>"ind",
    "limit"=>"8",
    "cache" => true
]);
$ListSimiliar = ($Similiar["pagging"]["Count"] > 1 ? $Similiar["lstdt"]["DtIklan"] : array($Similiar["lstdt"]["DtIklan"])); 
//print_r_mod($Similiar);
?>
<?php include "header.php" ?>
<div class="container body_wrapper">
	<div class="row">
		<div class="col-sm-7">
			<h4 class="news-title font-22 no-padd-marg-left"><?php echo $NamaIklan ?></h4>
			<br>
			<br>
			<div class="slider">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
				  	<?php if($Gambar1): ?>
				    	<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				  	<?php endif ?>
				  	<?php if($Gambar2): ?>
				    	<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				  	<?php endif ?>
				  	<?php if($Gambar3): ?>
				    	<li data-target="#carousel-example-generic" data-slide-to="2"></li>
				  	<?php endif ?>
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">
				  	<?php if($Gambar1): ?>
					    <div class="item active">
					      <img src="<?php echo $Gambar1 ?>" alt="..." class="img-responsive" style="max-height:400px; width:100%">
					    </div>
				  	<?php endif ?>
				  	<?php if($Gambar2): ?>
					    <div class="item">
					      <img src="<?php echo $Gambar2 ?>" alt="..." class="img-responsive" style="max-height:400px; width:100%">
					    </div>
				  	<?php endif ?>
				  	<?php if($Gambar3): ?>
					    <div class="item">
					      <img src="<?php echo $Gambar3 ?>" alt="..." class="img-responsive" style="max-height:400px; width:100%">
					    </div>
				  	<?php endif ?>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
			<br>
			<p class="news-detail">
				<?php echo strip_tags($DeskIklan) ?>
			</p>
		</div>
		<div class="col-sm-5">
			<h4 class="title">
				Informasi Iklan & Penjual
			</h4>
			<div class="row">
				<div class="col-xs-12">
					<table>
						<tr>
							<td style="width:150px;"><p class="font-14">Harga:</p></td>
							<td><span class="txt-orange font-22"><?php echo $HargaIklan ?></span></td>
						</tr>

						<tr>
							<td><p class="font-14">Kondisi:</p></td>
							<td><p class="font-14"><?php echo $KondisiIklan ?></p></td>
						</tr>
						<tr>
							<td><p class="font-14">Tanggal Pasang:</p></td>
							<td><p class="font-14"><?php echo $TanggalIklan ?></p></td>
						</tr>
						<tr>
							<td><p class="font-14">Lokasi:</p></td>
							<td><p class="font-14"><?php echo $LokasiIklan ?></p></td>
						</tr>
						<tr>
							<td><p class="font-14">Pemasang:</p></td>
							<td><p class="font-14"><?php echo $PemasangNama ?></p></td>
						</tr>
					</table>
					<p>
						<a href="<?php echo $ApiResult['url'] ?>" target="_blank">
							<button class="btn btn-no-radius btn-sm btn-orange btn-block">Beli di <?php echo $SumberIklan ?></button>
						</a>
					</p>
					<p>
						Share ke : 
						<button class="btn btn-info btn-sm btn-no-radius box"><i class="fa fa-twitter"></i></button> 
						<button class="btn btn-primary btn-sm btn-no-radius box"><i class="fa fa-facebook"></i></button> 
						<button class="btn btn-danger btn-sm btn-no-radius box"><i class="fa fa-google-plus"></i></button> 
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<h4 class="title">
			Iklan Terkait
		</h4>
	</div>
	<div class="row">
		<div class="col-sm-12 no-padd-marg">
			<div class="similar-property-container">
			<?php if($Similiar['isError'] == false && $Similiar['isError'] != 1){ ?>
				<div id="similar-property-carousel" class="owl-carousel">
					<?php foreach ($ListSimiliar as $d): ?>
		        <div class="item">
		        	<a href="<?php echo SITE_URL.'pricedetail/'.UrlSeo($d["n"]) ?>-<?php echo $d["_id"] ?>.html" target="_blank">
			        	<div class="photo-container">
	                <img src="<?php echo $d['gs1'] ?>"  alt="" class="img-responsive" />
	              </div>
	              <div class="info-listing">
	                <div class="listing-type listing-sell">
			        			<?php echo $d['n'] ?>
	                </div>
	                <div class="listing-location">
	                	<?php echo $d['n_kot'] .', '.$d['n_prop'] ?>
	                </div>
	                <div class="price-info">
	                	<?php echo strtonumber($d['hrg']) ?>
	                </div>
	              </div>
              </a>
		        </div>
					<?php endforeach ?>
	      </div>
    	<?php }else{ ?>
    		<p>Tidak ada iklan terkait.</p>
    	<?php } ?>
    	</div>
		</div>
	</div>
</div>

<?php include "footer_script.php"; ?>
<?php include "footer.php"; ?>