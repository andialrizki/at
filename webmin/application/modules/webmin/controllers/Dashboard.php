<?php 
Class Dashboard extends CI_Controller {

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
		//redirect('webmin/profile');
		$data = array(
			'prod' => $this->db->get('product')->num_rows(),
			'oc' => $this->db->get('ourcompany')->num_rows(),
			'pages' => $this->db->get('pages')->num_rows(),
			'banner' => $this->db->get('banner')->num_rows(),
			'news' => $this->db->get('news')->num_rows(),
			'recipes' => $this->db->get('recipes')->num_rows() );
		$this->load->view('dashboard/view_dashboard', $data);
	}
}