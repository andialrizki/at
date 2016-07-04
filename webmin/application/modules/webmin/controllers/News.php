<?php 
Class News extends CI_Controller {

	/* admin core by Muhammad Andi Al-rizki */
	/* muhammad.andialrizki@gmail.com */

	function __construct()
	{
		parent::__construct();
		if (!$this->session->admin_login) {
			redirect('webmin/auth');
		}
	}
	function index()
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');


			$config['upload_path'] 		= './public/images/news/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['news_image'] = $upload_data['file_name'];
			}

			$data['news_desc_id'] = htmlspecialchars($data['news_desc_id']);
			$data['news_desc_en'] = htmlspecialchars($data['news_desc_en']);
			$data['news_datetime'] = 7*3600+time();
			$act = false;
			if(empty($id))
				$act = $this->db->insert('news', $data);
			else
				$act = $this->db->update('news', $data, array('news_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/news');
			exit;
		}

		$news = $this->db->join('news_category', 'category_id = news_category_id')->get('news');
		$data = array(
			'data' => $news, 
			'cat' => $this->db->get('news_category'),
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('news/view_news', $data);
	}
	/* add ons */
	function remove($action, $id)
	{
		if ($action == 'category') {
			$this->db->delete('news_category', array('category_id' => $id));
			redirect('webmin/news/category');
		}
		if ($action == 'news') {
			$this->db->delete('news', array('news_id' => $id));
			redirect('webmin/news');
		}
	}
	function category()
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');

			$act = false;
			if(empty($id))
				$act = $this->db->insert('news_category', $data);
			else
				$act = $this->db->update('news_category', $data, array('category_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/news/category');
			exit;
		}
		$data = array('data' => $this->db->order_by('category_id', 'desc')->get('news_category'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('news/view_category', $data);
	}
	function getByAjax($id)
	{
		$data = $this->db->where('news_id', $id)->get('news')->row();
		$data->news_desc_id = htmlspecialchars_decode($data->news_desc_id);
		$data->news_desc_en = htmlspecialchars_decode($data->news_desc_en);
		echo json_encode($data);
	}
}