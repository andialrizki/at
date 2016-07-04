<?php  
class Mdl_page extends CI_Model {
	function getOurcompany($id='')
	{
		if (empty($id)) {
			return $this->db->where('ourcompany_status', 1)->order_by('ourcompany_sort', 'asc')->get('ourcompany')->result();
		} else {
			return $this->db->where('ourcompany_id', $id)->get('ourcompany');
		}
	}
	function getProduct($id='')
	{
		if (empty($id)) {
			return $this->db->where('product_status', 1)->order_by('product_sort', 'asc')->get('product')->result();
		} else {
			return $this->db->where('product_id', $id)->get('product');
		}
	}
	function getCategory($id='', $limit = 100)
	{
		if (empty($id)) {
			return $this->db->where('category_status', 1)->order_by('category_name', 'asc')->get('category', $limit)->result();
		} else {
			return $this->db->where('category_id', $id)->get('category');
		}
	}
	function getBrand($id='', $limit = 100)
	{
		if (empty($id)) {
			return $this->db->where('brand_status', 1)->order_by('brand_name', 'asc')->get('brand', $limit)->result();
		} else {
			return $this->db->where('brand_id', $id)->get('brand');
		}
	}
	function getBanner($id='')
	{
		if (empty($id)) {
			return $this->db->where('banner_status', 1)->order_by('banner_sort', 'asc')->get('banner')->result();
		} else {
			return $this->db->where('banner_id', $id)->get('banner');
		}
	}
	function getBannerPage($id)
	{
		return $this->db->where('banner_page', $id)->get('banner_page');
		
	}
	function getNewsCategory($id='')
	{
		if (empty($id)) {
			return $this->db->where('category_status', 1)->order_by('category_sort', 'asc')->get('news_category')->result();
		} else {
			return $this->db->where('category_id', $id)->get('news_category');
		}
	}
	function getRecipesCategory($id='')
	{
		if (empty($id)) {
			return $this->db->where('category_status', 1)->order_by('category_sort', 'asc')->get('recipes_category')->result();
		} else {
			return $this->db->where('category_id', $id)->get('recipes_category');
		}
	}
	function getNews($id='')
	{
		if (empty($id)) {
			return $this->db->join('news_category', 'category_id = news_category_id')->where('news_status', 1)->get('news')->result();
		} else {
			return $this->db->join('news_category', 'category_id = news_category_id')->where('news_id', $id)->get('news')->row();
		}
	}
	function getRecipes($id)
	{
		return $this->db->join('recipes_category', 'category_id = recipes_category_id')->where('recipes_id', $id)->get('recipes')->row();
	}
	function getProfile()
	{
		return $this->db->where('profile_id', 1)->get('profile')->row();
	}
}


?>