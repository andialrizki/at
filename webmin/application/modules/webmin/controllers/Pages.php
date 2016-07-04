<?php 
Class Pages extends CI_Controller {
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


			$config['upload_path'] 		= './public/images/pages/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['pages_image'] = $upload_data['file_name'];
			}
			$data['pages_desc_en'] = htmlspecialchars($data['pages_desc_en']);
			$data['pages_desc_id'] = htmlspecialchars($data['pages_desc_id']);
			$act = false;
			if(empty($id))
				$act = $this->db->insert('pages', $data);
			else
				$act = $this->db->update('pages', $data, array('pages_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/pages');
			exit;
		}
		$data = array('data' => $this->db->order_by('pages_id', 'desc')->get('pages'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('pages/view_pages', $data);
	}
	function getByAjax($id)
	{
		$data = $this->db->where('pages_id', $id)->get('pages')->row();
		$data->pages_desc_en = htmlspecialchars_decode($data->pages_desc_en);
		$data->pages_desc_id = htmlspecialchars_decode($data->pages_desc_id);
		echo json_encode($data);
	}
}


 ?>