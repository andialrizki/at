<?php 

	function filemanager_location()
	{
		// $fc = explode('/', FCPATH);
		// $me = $fc[sizeof($fc)-2];
		return base_url().'private/plugins/fman/index.html';
	}
	function brand_url($value='')
	{
		return base_url('public/images/brand').'/'.$value;
	}
	function prodimg_url($value='')
	{
		return base_url('public/images/product').'/'.$value;
	}
	function logo_url($value='')
	{
		return base_url('public/images/logo').'/'.$value;
	}
	function newsimg_url($value='')
	{
		return base_url('public/images/news').'/'.$value;
	}
	function recipesimg_url($value='')
	{
		return base_url('public/images/recipes').'/'.$value;
	}
	function banner_url($value='')
	{
		return base_url('public/images/banner').'/'.$value;
	}
	function ourcompany_url($value='')
	{
		return base_url('public/images/ourcompany').'/'.$value;
	}
	function pagesimg_url($value='')
	{
		return base_url('public/images/pages').'/'.$value;
	}
	function private_url($value='')
	{
		return base_url('private').'/'.$value;
	}
	function public_url($value='')
	{
		return base_url('public').'/'.$value;
	}
	function webmin_url($value='')
	{
		return site_url('webmin').'/'.$value;
	}
	function checkStatus($value='')
	{
		return ($value==1?'Active': 'Nonactive');
	}
	function dangerAlert()
	{
		$data = '<div class="alert alert-danger alert-dismissable">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.
                    '<h4><i class="icon fa fa-ban"></i> Error!</h4>'.
                    'Operation cannot complete, please try again or contact administator.'.
                  '</div>';
        return $data;
	}
	function successAlert()
	{
		$data = '<div class="alert alert-success alert-dismissable">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.
                    '<h4>	<i class="icon fa fa-check"></i> Success!</h4>'.
                    'Current operation was successfully execution.'.
                  '</div>';
        return $data;
	}
	function showAlert($value='')
	{
		if ($value == 'success') {
			return successAlert();
		} else if ($value == 'danger') {
			return dangerAlert();
		} else {
			return '';
		}
	}
	function seo_url($value='')
	{
		return url_title($value, 'dash', TRUE);
	}
 ?>