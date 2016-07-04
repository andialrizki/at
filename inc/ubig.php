<?php
/**
 * Ubig SDK
 *
 * @copyright  2016 PT Universal Big Data
 * @version    Release Candidate 1.0
 * @link       http://sdk.ubig.co.id
 */

namespace UBIG;
use phpFastCache\CacheManager;
require_once dirname(__FILE__) . '/plugin/phpfastcache/autoload.php';

class MainSDK{
    private $option;
    private $AccessKeyPrice=false;
    private $AccessKeyNews=false;
    private $debug=false;
    private $ROOT;
    public static $ApiURL = array(
        //'api_price'  => 'http://demoapi.ubig.co.id/api/price.asmx/',
        'api_price'  => 'http://idapiv2.ubig.co.id/api/price.asmx/',
        'api_news'   => 'http://idapinewsv2.ubig.co.id/api/news.asmx/'
    );

    function __construct($config) {
        $this->ROOT=$_SERVER['DOCUMENT_ROOT'];
        $this->option=$config ;
        $this->debug=(is_bool($this->option["debug"])?false:$this->option["debug"]);
        // Setup File Path on your config files
        if(!is_dir($this->ROOT."/cache/")){
            mkdir($this->ROOT."/cache/", 0777, true);
            chmod($this->ROOT."/cache/", 0777);
        }
        $cacheconf = array(
            "storage"   =>  "sqlite",
            "path" => $this->ROOT."/cache/"
        );

        CacheManager::setup($cacheconf);
        $this->AccessKeyPrice=$this->GetAccessKeyPrice();
        $this->AccessKeyNews=$this->GetAccessKeyNews();

    }

    function GetPrice($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamHarga1 = isset($param['hrg_start']) ? $param['hrg_start'] : null;
        $sParamHarga2 = isset($param['hrg_end']) ? $param['hrg_end'] : null;
        $sParamKondisi = isset($param['kond']) ? $param['kond'] : null;
        $sParamIDProvinsi = isset($param['i_prop']) ? $param['i_prop'] : null;
        $sParamIDKota = isset($param['i_kot']) ? $param['i_kot'] : null;
        $sParamIDSumber= isset($param['i_smbr']) ? $param['i_smbr'] : null;
        $sParamTgl1 = isset($param['t_psg_start']) ? $param['t_psg_start'] : null;
        $sParamTgl2 = isset($param['t_psg_end']) ? $param['t_psg_end'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPrice(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
         $ApiURL='Iklan_Search?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&hrg_start='.$sParamHarga1.
            '&hrg_end='.$sParamHarga2.
            '&kond='.$sParamKondisi.
            '&i_prop='.$sParamIDProvinsi.
            '&i_kot='.$sParamIDKota.
            '&i_smbr='.$sParamIDSumber.
            '&t_psg_start='.$sParamTgl1.
            '&t_psg_end='.$sParamTgl2.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage.
            '&Atribut='.$sAttribute.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPriceDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetPriceDetail(), parameter _id belum diisi",true);
        $ApiURL='Iklan_Detail?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&_id='.$sParamID.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("PriceDtl-".$sParamID)){
                return $this->CacheGet("PriceDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("PriceDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetPriceSimiliar($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='Iklan_Similiar?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPriceByUser($param=array()){
        $sParamIdUser = isset($param['i_pmsg']) ? $param['i_pmsg'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamIdUser))$this->ThrowError("Tidak bisa menjalankan function GetPriceSimiliar(), parameter i_pmsg belum diisi.!",true);
        $ApiURL='Iklan_Pemasang?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&i_pmsg='.$sParamIdUser.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPriceUserDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceUserDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetPriceUserDetail(), parameter _id belum diisi.!",true);
        $ApiURL='Pemasang_Detail?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&_id='.$sParamID;
        if($isCache){
            if($this->CacheExist("UsrDtl-".$sParamID)){
                return $this->CacheGet("UsrDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("UsrDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetPriceByCategory($param=array()){
        $sListKategori = isset($param['listkategori']) ? $param['listkategori'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceByCategory(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sListKategori))$this->ThrowError("Tidak bisa menjalankan function GetPriceByCategory(), parameter listkategori belum diisi.!",true);
        $ApiURL='Iklan_ShowByKategori?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&LstKat='.$sListKategori.
            '&Limit='.$sParamLimit.
            '&Atribut='.$sAttribute;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPriceByID($param=array()){
        $sListID = isset($param['listid']) ? $param['listid'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPriceSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sListID))$this->ThrowError("Tidak bisa menjalankan function GetPriceByID(), parameter listid belum diisi.!",true);
        $ApiURL='Iklan_Compare?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_sts='.$this->option["SiteIDPrice"].
            '&_id='.$sListID.
            '&Sort='.$sParamSort;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPricePromo($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamHarga1 = isset($param['hrg_start']) ? $param['hrg_start'] : null;
        $sParamHarga2 = isset($param['hrg_end']) ? $param['hrg_end'] : null;
        $sParamKondisi = isset($param['kond']) ? $param['kond'] : null;
        $sParamIDProvinsi = isset($param['i_prop']) ? $param['i_prop'] : null;
        $sParamIDKota = isset($param['i_kot']) ? $param['i_kot'] : null;
        $sParamIDSumber= isset($param['i_smbr']) ? $param['i_smbr'] : null;
        $sParamTgl1 = isset($param['t_psg_start']) ? $param['t_psg_start'] : null;
        $sParamTgl2 = isset($param['t_psg_end']) ? $param['t_psg_end'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        $sListJenis = isset($param['listjenis']) ? $param['listjenis'] : null;
        $sParamCicilanBulan = isset($param['cicilan']) ? $param['cicilan'] : null;
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPricePromo(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='IklanPromo_Search?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&kywd='.$sParamKeyword.
            '&hrg_start='.$sParamHarga1.
            '&hrg_end='.$sParamHarga2.
            '&kond='.$sParamKondisi.
            '&i_prop='.$sParamIDProvinsi.
            '&i_kot='.$sParamIDKota.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&i_smbr='.$sParamIDSumber.
            '&t_psg_start='.$sParamTgl1.
            '&t_psg_end='.$sParamTgl2.
            '&ls_jns='.$sListJenis.
            '&dskn_start='.$sParamHarga1.
            '&dskn_end='.$sParamHarga2.
            '&ccl='.$sParamCicilanBulan.
            '&atrbt='.$sAttribute.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPricePromoDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPricePromoDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetPricePromoDetail(), parameter _id belum diisi.!",true);
        $ApiURL='IklanPromo_Detail?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&_id='.$sParamID.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("PricePrmoDtl-".$sParamID)){
                return $this->CacheGet("PricePrmoDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("PricePrmoDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetPricePromoSimiliar($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPricePromoSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='IklanPromo_Similiar?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetPricePromoByUser($param=array()){
        $sParamIdUser = isset($param['i_pmsg']) ? $param['i_pmsg'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetPricePromoByUser(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamIdUser))$this->ThrowError("Tidak bisa menjalankan function GetPricePromoByUser(), parameter i_pmsg belum diisi.!",true);
        $ApiURL='IklanPromo_Pemasang?AccessKey_App='. $this->AccessKeyPrice .
            '&Ngr='.$this->option["SiteCountryPrice"].
            '&i_pmsg='.$sParamIdUser.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage;
        $ApiResult=$this->CallApiPrice($ApiURL);
        return $ApiResult;
    }
    function GetCategoryPrice($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetCategoryPrice(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='Kategori_ShowAllActive?AccessKey_App='. $this->AccessKeyPrice .
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstCat")){
                return $this->CacheGet("LstCat");
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstCat", $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetCategorySubPrice($param=array()){
        $sIdCategory = isset($param['i_kat']) ? $param['i_kat'] : null;
        $sSeoCategory = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetCategorySubPrice(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sIdCategory) && is_null($sSeoCategory))$this->ThrowError("Tidak bisa menjalankan function GetCategorySubPrice(), parameter i_kat atau seo_kat belum diisi.!",true);
        $ApiURL='KategoriSub_ShowAllActive?AccessKey_App='. $this->AccessKeyPrice .
            '&i_kat='.$sIdCategory.
            '&seo_kat='.$sSeoCategory.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstSub-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory))){
                return $this->CacheGet("LstSub-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory));
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstSub-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory), $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetCategoryTypePrice($param=array()){
        $sIdSubCategory = isset($param['i_skat']) ? $param['i_skat'] : null;
        $sSeoSubCategory = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetCategoryTypePrice(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sIdSubCategory) && is_null($sSeoSubCategory))$this->ThrowError("Tidak bisa menjalankan function GetCategoryTypePrice(), parameter i_skat atau seo_skat belum diisi.!",true);
        $ApiURL='KategoriJenis_ShowAllActive?AccessKey_App='. $this->AccessKeyPrice .
            '&i_skat='.$sIdSubCategory.
            '&seo_skat='.$sSeoSubCategory.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstType-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory))){
                return $this->CacheGet("LstType-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory));
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstType-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory), $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }
    function GetSourcePrice($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamNegara = isset($param['ngr']) ? $param['ngr'] : "id";
        if($this->AccessKeyPrice==false)$this->ThrowError("Tidak bisa menjalankan function GetSourcePrice(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);

        $ApiURL='Situs_ShowSumberData?AccessKey_App='.$this->AccessKeyPrice.
            '&i_sts='.$this->option["SiteIDPrice"].
            '&Ngr='.$sParamNegara;
        if($isCache){
            if($this->CacheExist("LstSource")){
                return $this->CacheGet("LstSource");
            }else{
                $ApiResult=$this->CallApiPrice($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstSource", $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiPrice($ApiURL);
        }
        return $ApiResult;
    }

    /*News MainApp*/
    function GetNews($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSeoSubJenis = isset($param['seo_sjns']) ? $param['seo_sjns'] : null;
        $sParamIDProvinsi = isset($param['i_prop']) ? $param['i_prop'] : null;
        $sParamIDKota = isset($param['i_kot']) ? $param['i_kot'] : null;
        $sParamIDSumber= isset($param['i_smbr']) ? $param['i_smbr'] : null;
        $sParamTgl1 = isset($param['t_psg_start']) ? $param['t_psg_start'] : null;
        $sParamTgl2 = isset($param['t_psg_end']) ? $param['t_psg_end'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='Berita_Search?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&seo_sjns='.$sParamSeoSubJenis.
            '&i_prop='.$sParamIDProvinsi.
            '&i_kot='.$sParamIDKota.
            '&i_smbr='.$sParamIDSumber.
            '&t_psg_start='.$sParamTgl1.
            '&t_psg_end='.$sParamTgl2.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage.
            '&Atribut='.$sAttribute.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetNewsDetail(), parameter _id belum diisi.!",true);
        $ApiURL='Berita_Detail?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&_id='.$sParamID.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("NewsDtl-".$sParamID)){
                return $this->CacheGet("NewsDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("NewsDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetNewsSimiliar($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSeoSubJenis = isset($param['seo_sjns']) ? $param['seo_sjns'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='Berita_Similiar?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&Bhs='.$sParamBahasa.
            '&i_sts='.$this->option["SiteIDNews"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&seo_sjns='.$sParamSeoSubJenis.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsByUser($param=array()){
        $sParamIdUser = isset($param['i_pmsg']) ? $param['i_pmsg'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsByUser(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamIdUser))$this->ThrowError("Tidak bisa menjalankan function GetNewsByUser(), parameter i_pmsg belum diisi.!",true);
        $ApiURL='Berita_Pemasang?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&i_pmsg='.$sParamIdUser.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsUserDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsUserDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetNewsUserDetail(), parameter _id belum diisi.!",true);
        $ApiURL='Pemasang_Detail?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&_id='.$sParamID;
        if($isCache){
            if($this->CacheExist("UsrNDtl-".$sParamID)){
                return $this->CacheGet("UsrNDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("UsrNDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetNewsByCategory($param=array()){
        $sListKategori = isset($param['listkategori']) ? $param['listkategori'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsByCategory(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sListKategori))$this->ThrowError("Tidak bisa menjalankan function GetNewsByCategory(), parameter listkategori belum diisi.!",true);
        $ApiURL='Berita_ShowByKategori?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&LstKat='.$sListKategori.
            '&Limit='.$sParamLimit;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsById($param=array()){
        $sListID = isset($param['listid']) ? $param['listid'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsById(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sListID))$this->ThrowError("Tidak bisa menjalankan function GetNewsById(), parameter listid belum diisi.!",true);
        $ApiURL='Berita_ShowById?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_sts='.$this->option["SiteIDNews"].
            '&Bhs='.$sParamBahasa.
            '&_id='.$sListID;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsHeadline($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSeoSubJenis = isset($param['seo_sjns']) ? $param['seo_sjns'] : null;
        $sParamIDProvinsi = isset($param['i_prop']) ? $param['i_prop'] : null;
        $sParamIDKota = isset($param['i_kot']) ? $param['i_kot'] : null;
        $sParamIDSumber= isset($param['i_smbr']) ? $param['i_smbr'] : null;
        $sParamTgl1 = isset($param['t_psg_start']) ? $param['t_psg_start'] : null;
        $sParamTgl2 = isset($param['t_psg_end']) ? $param['t_psg_end'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        $sAttribute = isset($param['atribut']) ? $param['atribut'] : null;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadline(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='BeritaHeadline_Search?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&seo_sjns='.$sParamSeoSubJenis.
            '&i_prop='.$sParamIDProvinsi.
            '&i_kot='.$sParamIDKota.
            '&i_smbr='.$sParamIDSumber.
            '&t_psg_start='.$sParamTgl1.
            '&t_psg_end='.$sParamTgl2.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage.
            '&Atribut='.$sAttribute.
            '&Bhs='.$sParamBahasa;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsHeadlineDetail($param=array()){
        $sParamID = isset($param['_id']) ? $param['_id'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadlineDetail(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamID))$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadlineDetail(), parameter _id belum diisi.!",true);
        $ApiURL='BeritaHeadline_Detail?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&_id='.$sParamID.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("NewsHeadDtl-".$sParamID)){
                return $this->CacheGet("NewsHeadDtl-".$sParamID);
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("NewsHeadDtl-".$sParamID, $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetNewsHeadlineSimiliar($param=array()){
        $sParamKeyword = isset($param['kywd']) ? $param['kywd'] : null;
        $sParamSeoKategori = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $sParamSeoSubKategori = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $sParamSeoJenis = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $sParamSeoSubJenis = isset($param['seo_sjns']) ? $param['seo_sjns'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadlineSimiliar(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='BeritaHeadline_Similiar?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&Bhs='.$sParamBahasa.
            '&kywd='.$sParamKeyword.
            '&seo_kat='.$sParamSeoKategori.
            '&seo_skat='.$sParamSeoSubKategori.
            '&seo_jns='.$sParamSeoJenis.
            '&seo_sjns='.$sParamSeoSubJenis.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetNewsHeadlineByUser($param=array()){
        $sParamIdUser = isset($param['i_pmsg']) ? $param['i_pmsg'] : null;
        $sParamSort = isset($param['sort']) ? $param['sort'] : null;
        $sParamLimit = isset($param['limit']) ? $param['limit'] : 10;
        $sParamPage = isset($param['page']) ? $param['page'] : 1;
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadlineByUser(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamIdUser))$this->ThrowError("Tidak bisa menjalankan function GetNewsHeadlineByUser(), parameter i_pmsg belum diisi.!",true);
        $ApiURL='BeritaHeadline_Pemasang?AccessKey_App='. $this->AccessKeyNews .
            '&Ngr='.$this->option["SiteCountryNews"].
            '&i_pmsg='.$sParamIdUser.
            '&Sort='.$sParamSort.
            '&Limit='.$sParamLimit.
            '&Page='.$sParamPage;
        $ApiResult=$this->CallApiNews($ApiURL);
        return $ApiResult;
    }
    function GetCategoryNews($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetCategoryNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        $ApiURL='Kategori_ShowAllActive?AccessKey_App='. $this->AccessKeyNews .
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstCatNws")){
                return $this->CacheGet("LstCatNws");
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstCatNws", $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetCategorySubNews($param=array()){
        $sIdCategory = isset($param['i_kat']) ? $param['i_kat'] : null;
        $sSeoCategory = isset($param['seo_kat']) ? $param['seo_kat'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetCategorySubNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sIdCategory) && is_null($sSeoCategory))$this->ThrowError("Tidak bisa menjalankan function GetCategorySubNews(), parameter i_kat atau seo_kat belum diisi.!",true);
        $ApiURL='KategoriSub_ShowAllActive?AccessKey_App='. $this->AccessKeyNews .
            '&i_kat='.$sIdCategory.
            '&seo_kat='.$sSeoCategory.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstSubNws-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory))){
                return $this->CacheGet("LstSubNws-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory));
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstSubNws-".(is_null($sIdCategory)?$sSeoCategory:$sIdCategory), $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetCategoryTypeNews($param=array()){
        $sIdSubCategory = isset($param['i_skat']) ? $param['i_skat'] : null;
        $sSeoSubCategory = isset($param['seo_skat']) ? $param['seo_skat'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetCategoryTypeNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sIdSubCategory) && is_null($sSeoSubCategory))$this->ThrowError("Tidak bisa menjalankan function GetCategoryNews(), parameter i_skat atau seo_skat belum diisi.!",true);
        $ApiURL='KategoriJenis_ShowAllActive?AccessKey_App='. $this->AccessKeyNews .
            '&i_skat='.$sIdSubCategory.
            '&seo_skat='.$sSeoSubCategory.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstTypeNws-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory))){
                return $this->CacheGet("LstTypeNws-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory));
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstTypeNws-".(is_null($sIdSubCategory)?$sSeoSubCategory:$sIdSubCategory), $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetCategorySubTypeNews($param=array()){
        $sIdSubJnsCategory = isset($param['i_jns']) ? $param['i_jns'] : null;
        $sSeoSubJnsCategory = isset($param['seo_jns']) ? $param['seo_jns'] : null;
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamBahasa = isset($param['bhs']) ? $param['bhs'] : "ind";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetCategorySubTypeNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sIdSubJnsCategory) && is_null($sSeoSubJnsCategory))$this->ThrowError("Tidak bisa menjalankan function GetCategorySubTypeNews(), parameter i_jns atau seo_jns belum diisi.!",true);
        $ApiURL='KategoriSubJenis_ShowAllActive?AccessKey_App='. $this->AccessKeyNews .
            '&i_jns='.$sIdSubJnsCategory.
            '&seo_jns='.$sSeoSubJnsCategory.
            '&Bhs='.$sParamBahasa;
        if($isCache){
            if($this->CacheExist("LstSubTypeNws-".(is_null($sIdSubJnsCategory)?$sSeoSubJnsCategory:$sIdSubJnsCategory))){
                return $this->CacheGet("LstSubTypeNws-".(is_null($sIdSubJnsCategory)?$sSeoSubJnsCategory:$sIdSubJnsCategory));
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstSubTypeNws-".(is_null($sIdSubJnsCategory)?$sSeoSubJnsCategory:$sIdSubJnsCategory), $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }
    function GetSourceNews($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamNegara = isset($param['ngr']) ? $param['ngr'] : "id";
        if($this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetSourceNews(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);

        $ApiURL='SumberData_ShowAllActive?AccessKey_App='.$this->AccessKeyNews.
            '&i_sts='.$this->option["SiteIDNews"].
            '&Ngr='.$sParamNegara;
        if($isCache){
            if($this->CacheExist("LstSourceNws")){
                return $this->CacheGet("LstSourceNws");
            }else{
                $ApiResult=$this->CallApiNews($ApiURL);
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstSourceNws", $ApiResult);
                }
            }
        }else{
            $ApiResult=$this->CallApiNews($ApiURL);
        }
        return $ApiResult;
    }

    /*Global Data*/
    function GetProvinsi($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamNegara = isset($param['ngr']) ? $param['ngr'] : "id";
        if($this->AccessKeyPrice==false && $this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetProvinsi(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);

        $TypeApp=1; //1=price 2=news
        if($this->AccessKeyPrice==false)$TypeApp=2;

        $ApiURL='IntPropinsi_ShowAllActive?AccessKey_App='. ($TypeApp==1?$this->AccessKeyPrice:$this->AccessKeyNews) .
            '&ngr='.$sParamNegara;
        if($isCache){
            if($this->CacheExist("LstProv")){
                return $this->CacheGet("LstProv");
            }else{
                $ApiResult=($TypeApp==1?$this->CallApiPrice($ApiURL):$this->CallApiNews($ApiURL));
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstProv", $ApiResult);
                }
            }
        }else{
            $ApiResult=($TypeApp==1?$this->CallApiPrice($ApiURL):$this->CallApiNews($ApiURL));
        }
        return $ApiResult;
    }
    function GetKota($param=array()){
        $isCache = isset($param['cache']) ? $param['cache'] : true;
        $sParamNegara = isset($param['ngr']) ? $param['ngr'] : "id";
        $sParamIDProvinsi = isset($param['i_prop']) ? $param['i_prop'] : null;
        if($this->AccessKeyPrice==false && $this->AccessKeyNews==false)$this->ThrowError("Tidak bisa menjalankan function GetKota(), AccessKey tidak valid, silahkan periksa parameter AppKey dan AppScreet.!!",true);
        if(is_null($sParamIDProvinsi))$this->ThrowError("Tidak bisa menjalankan function GetProvinsi(), missing parameter i_prop",true);

        $TypeApp=1; //1=price 2=news
        if($this->AccessKeyPrice==false)$TypeApp=2;

        $ApiURL='IntKota_ShowAllActive?AccessKey='. ($TypeApp==1?$this->AccessKeyPrice:$this->AccessKeyNews) .
            '&ngr='.$sParamNegara.
            '&i_prop='.$sParamIDProvinsi;
        if($isCache){
            if($this->CacheExist("LstKota-".$sParamIDProvinsi)){
                return $this->CacheGet("LstKota-".$sParamIDProvinsi);
            }else{
                $ApiResult=($TypeApp==1?$this->CallApiPrice($ApiURL):$this->CallApiNews($ApiURL));
                if($ApiResult["IsError"]=="false"){
                    $this->CacheSet("LstKota-".$sParamIDProvinsi, $ApiResult);
                }
            }
        }else{
            $ApiResult=($TypeApp==1?$this->CallApiPrice($ApiURL):$this->CallApiNews($ApiURL));
        }
        return $ApiResult;
    }


//    /*Ubig Main APP*/
    function GetAccessKeyPrice(){
        if($this->CacheExist("AccessKeyPrice")){
            if($this->CacheGet("AccessKeyPrice")==false){
                $this->AccessKeyPrice=$this->UBIGAppLogin("price");
                $this->CacheSet("AccessKeyPrice", $this->AccessKeyPrice);
                return $this->AccessKeyPrice;
            }else{
                return $this->CacheGet("AccessKeyPrice");
            }
        }else{
            $this->AccessKeyPrice=$this->UBIGAppLogin("price");
            $this->CacheSet("AccessKeyPrice", $this->AccessKeyPrice);
            return $this->AccessKeyPrice;
        }
    }
    function GetAccessKeyNews(){
        if($this->CacheExist("AccessKeyNews")){
            if($this->CacheGet("AccessKeyNews")==false){
                $this->AccessKeyNews=$this->UBIGAppLogin("news");
                $this->CacheSet("AccessKeyNews", $this->AccessKeyNews);
                return $this->AccessKeyNews;
            }else{
                return $this->CacheGet("AccessKeyNews");
            }
        }else{
            $this->AccessKeyNews=$this->UBIGAppLogin("news");
            $this->CacheSet("AccessKeyNews", $this->AccessKeyNews);
            return $this->AccessKeyNews;
        }
    }
    function UBIGAppLogin($type){
        switch ($type){
            case "price":
                $apiresult=$this->CallApiPrice("App_Login?AppKey=" . $this->option["AppKeyPrice"] . "&AppSecret=" . $this->option["AppScreetPrice"]);
//                var_dump($apiresult);
                if($apiresult["IsError"]=="false"){
                    return $apiresult["AccessKey"];
                }else{
                    $this->ThrowError($apiresult["ErrMessage"]." App_Login Price Failed");
                    return false;
                }
            break;
            case "news":
                $apiresult=$this->CallApiNews("App_Login?AppKey=" . $this->option["AppKeyNews"] . "&AppSecret=" . $this->option["AppScreetNews"]);
//                var_dump($apiresult);
                if($apiresult["IsError"]=="false"){
                    return $apiresult["AccessKey"];
                }else{
                    $this->ThrowError($apiresult["ErrMessage"]." App_Login News Failed");
                    return false;
                }
            break;
        }
    }
    function CallApiPrice($uri) {
        $PriceApiURL = self::$ApiURL["api_price"];

        PostCallApiPrice:
        try {
            $accessws = str_replace(' ', '%20', $PriceApiURL . $uri);
            error_log($accessws);
            $ch = curl_init($accessws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);

            if (substr($data, 0, 5) != "<?xml") {
                return $this->CreateErrorAPI(true, "An error occurred retrieval API data. Api Url.");
            }

            $xstep        = 2; //Konversi XML ke JSON
            $json_convert = (json_encode(simplexml_load_string($data), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS));
            $Array         = json_decode($json_convert, true);

//            return $xml_snippet;
            //error_log($json_convert);

            if($Array["IsError"]=="true"){
                if($Array["Status"]=="106"){
                    $this->AccessKeyPrice=$this->UBIGAppLogin("price");
                    error_log($this->UBIGAppLogin("price"));
                    error_log("kesini");
                    $uri = preg_replace("/AccessKey=([^\&]*)\&/", "AccessKey=" . $this->AccessKeyPrice . "&", $uri);
                    $uri = preg_replace("/AccessKey_App=([^\&]*)\&/", "AccessKey_App=" . $this->AccessKeyPrice . "&", $uri);
                    $uri = preg_replace("/AccessKey_Memb=([^\&]*)\&/", "AccessKey_Memb=" . $this->AccessKeyPrice . "&", $uri);
                    goto PostCallApiPrice;
                }
                return $this->CreateErrorAPI(true, $Array["ErrMessage"], $Array["Status"]);
            }else{
                return ($Array);
            }

        }
        catch (Exception $e) {
            return $this->CreateErrorAPI(true, "Error CallApiPrice. Step : " . $xstep . ". " . $e->getMessage());
        }
    }
    function CallApiNews($uri) {
        $ApiURL = self::$ApiURL["api_news"];
        PostCallApiNews:
        try {
            $accessws = str_replace(' ', '%20', $ApiURL . $uri);
            error_log($accessws);
            $ch = curl_init($accessws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);

            if (substr($data, 0, 5) != "<?xml") {
                return $this->CreateErrorAPI(true, "An error occurred retrieval API data. Api Url.");
            }

            $xstep        = 2; //Konversi XML ke JSON
            $json_convert = (json_encode(simplexml_load_string($data), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS));
            $Array         = json_decode($json_convert, true);

//            return $xml_snippet;
            //error_log($json_convert);

            if($Array["IsError"]=="true"){
                if($Array["Status"]=="106"){
                    $this->AccessKeyNews=$this->UBIGAppLogin("news");
                    $uri = preg_replace("/AccessKey=([^\&]*)\&/", "AccessKey=" . $this->AccessKeyNews . "&", $uri);
                    $uri = preg_replace("/AccessKey_App=([^\&]*)\&/", "AccessKey_App=" . $this->AccessKeyNews . "&", $uri);
                    $uri = preg_replace("/AccessKey_Memb=([^\&]*)\&/", "AccessKey_Memb=" . $this->AccessKeyNews . "&", $uri);
                    goto PostCallApiNews;
                }
                return $this->CreateErrorAPI(true, $Array["ErrMessage"], $Array["Status"]);
            }else{
                return ($Array);
            }

        }
        catch (Exception $e) {
            return $this->CreateErrorAPI(true, "Error CallApiNews. Step : " . $xstep . ". " . $e->getMessage());
        }
    }
    function CreateErrorAPI($IsError, $ErrMessage, $Code = NULL) {
        $return = '
            <Message xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/">
              <IsError>' . $IsError . '</IsError>
              <ErrMessage>' . $ErrMessage . '</ErrMessage>';
        if ($Code) {
            $return .= '
              <Status>' . $Code . '</Status>';
        }
        $return .= '
            </Message>
         ';

        $xml_snippet  = simplexml_load_string($return);
        $json_convert = (json_encode($xml_snippet, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS));
        return (json_decode($json_convert,true));
    }

    /*Error*/
    function ThrowError($message,$stop=false){
        $logfile=dirname(__FILE__)."/logs.txt";
        $logtext="[".date("D d/M/Y h:i:s")."] ".$message;
        $myfile = file_put_contents($logfile, $logtext.PHP_EOL , FILE_APPEND);
//        echo $this->AccessKeyPrice;
//        if(($this->AccessKeyPrice==false && $this->AccessKeyNews==false)){
//            echo "Please check config, its missing some parameter".$this->AccessKeyNews."<br>";
//            echo "Please check config, its missing some parameter".$this->AccessKeyPrice;
//            exit();
//        }
        if($stop){
            echo $message;
            exit();
        }
    }

    /*Cache*/
    function CacheSet($key,$value,$time=0){
        return CacheManager::set($key, $value, 600);
    }
    function CacheGet($key){
        return CacheManager::get($key);
    }
    function CacheExist($key){
        $CachedString = CacheManager::get($key);
        return (is_null($CachedString)?false:true);
    }
}