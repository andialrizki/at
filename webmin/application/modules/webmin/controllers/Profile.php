<?php 

Class Profile extends CI_Controller {

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
		if ($action == 'save') {
			$data = $this->input->post('post');


			$config['upload_path'] 		= './public/images/logo/';
			$config['allowed_types'] 	= 'jpg|png|gif|ico';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['profile_logo'] = $upload_data['file_name'];
			}
			if ($this->upload->do_upload('image2')){
				$upload_data = $this->upload->data();
				$data['profile_logo_footer'] = $upload_data['file_name'];
			}
			if ($this->upload->do_upload('image3')){
				$upload_data = $this->upload->data();
				$data['profile_favicon'] = $upload_data['file_name'];
			}
			$act = $this->db->update('profile', $data, array('profile_id' => 1));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/profile');
			exit;
		}
		$data = array('data' => $this->db->where('profile_id', 1)->get('profile')->row(), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('profile/view_profile', $data);
	}
}
