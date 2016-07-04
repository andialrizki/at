<?php 
Class Auth extends CI_Controller {
	/* admin core by Muhammad Andi Al-rizki */
	/* muhammad.andialrizki@gmail.com */
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$this->load->view('auth/view_auth');
	}
	function process()
	{
		$log = array('owner_username' => $this->input->post('uname'),
					'owner_password' => md5($this->input->post('pass')));
		
		$data = $this->db->where($log)->get('owner');
		if ($data->num_rows() > 0) {
			$this->session->set_userdata('admin_login', true);
			redirect('webmin/dashboard');
		} else {
			echo "error";
		}
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect('webmin/auth');
	}
}


 ?>