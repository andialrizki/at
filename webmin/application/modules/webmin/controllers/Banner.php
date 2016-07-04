<?php 

Class Banner extends CI_Controller {
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


			$config['upload_path'] 		= './public/images/banner/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['banner_image'] = $upload_data['file_name'];
			}

			$act = false;
			if(empty($id))
				$act = $this->db->insert('banner', $data);
			else
				$act = $this->db->update('banner', $data, array('banner_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/banner');
			exit;
		}
		$data = array('data' => $this->db->order_by('banner_id', 'desc')->get('banner'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('banner/view_banner', $data);
	}
	function page()
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');


			$config['upload_path'] 		= './public/images/banner/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['banner_image'] = $upload_data['file_name'];
			}

			$act = false;
			if(empty($id))
				$act = $this->db->insert('banner_page', $data);
			else
				$act = $this->db->update('banner_page', $data, array('banner_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/banner/page');
			exit;
		}
		$data = array('data' => $this->db->order_by('banner_id', 'desc')->get('banner_page'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('banner/view_banner_page', $data);
	}
	function remove($id)
	{
		$this->db->delete('banner', array('banner_id' => $id));
		redirect('webmin/banner');
	}
	function remove_bp($id)
	{
		$this->db->delete('banner_page', array('banner_id' => $id));
		redirect('webmin/banner/page');
	}
}
