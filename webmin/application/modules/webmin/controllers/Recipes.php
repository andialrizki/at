<?php 
Class Recipes extends CI_Controller {
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


			$config['upload_path'] 		= './public/images/recipes/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['recipes_image'] = $upload_data['file_name'];
			}
			$data['recipes_datetime'] = 7*3600+time();
			$data['recipes_desc_id'] = htmlspecialchars($data['recipes_desc_id']);
			$data['recipes_desc_en'] = htmlspecialchars($data['recipes_desc_en']);
			$act = false;
			if(empty($id))
				$act = $this->db->insert('recipes', $data);
			else
				$act = $this->db->update('recipes', $data, array('recipes_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/recipes');
			exit;
		}

		$news = $this->db->join('recipes_category', 'recipes_id = recipes_category_id')->get('recipes');
		$data = array(
			'data' => $news, 
			'cat' => $this->db->order_by('category_id', 'desc')->get('recipes_category'),
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('recipes/view_recipes', $data);
	}
	/* add ons */
	function remove($action, $id)
	{
		if ($action == 'category') {
			$this->db->delete('recipes_category', array('category_id' => $id));
			redirect('webmin/recipes/category');
		}
		if ($action == 'recipes') {
			$this->db->delete('recipes', array('recipes_id' => $id));
			redirect('webmin/recipes');
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
				$act = $this->db->insert('recipes_category', $data);
			else
				$act = $this->db->update('recipes_category', $data, array('category_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/recipes/category');
			exit;
		}
		$data = array('data' => $this->db->get('recipes_category'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('recipes/view_category', $data);
	}
	function getByAjax($id)
	{
		$data = $this->db->where('recipes_id', $id)->get('recipes')->row();
		$data->recipes_desc_id = htmlspecialchars_decode($data->recipes_desc_id);
		$data->recipes_desc_en = htmlspecialchars_decode($data->recipes_desc_en);
		echo json_encode($data);
	}
}