<?php 
Class Ourcompany extends CI_Controller {

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


			$config['upload_path'] 		= './public/images/ourcompany/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['ourcompany_image'] = $upload_data['file_name'];
			}
			$data['ourcompany_desc_en'] = htmlspecialchars($data['ourcompany_desc_en']);
			$data['ourcompany_desc_id'] = htmlspecialchars($data['ourcompany_desc_id']);
			$act = false;
			if(empty($id))
				$act = $this->db->insert('ourcompany', $data);
			else
				$act = $this->db->update('ourcompany', $data, array('ourcompany_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/ourcompany');
			exit;
		}
		$data = array('data' => $this->db->order_by('ourcompany_id', 'desc')->get('ourcompany'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('ourcompany/view_ourcompany', $data);
	}
	function getByAjax($id)
	{
		$data = $this->db->where('ourcompany_id', $id)->get('ourcompany')->row();
		$data->ourcompany_desc_en = htmlspecialchars_decode($data->ourcompany_desc_en);
		$data->ourcompany_desc_id = htmlspecialchars_decode($data->ourcompany_desc_id);
		echo json_encode($data);
	}
}


 ?>