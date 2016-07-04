<?php 
Class Product extends CI_Controller {

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
		$data = array(
			'data' => $this->db->order_by('product_id', 'desc')->get('product'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('product/view_product_dashboard', $data);
	}
	function add()
	{
		$action = $this->input->get('action');
		if ($action == 'save') {
			$data = $this->input->post('post');
			$cat = $this->input->post('prodcat');
			$brand = $this->input->post('prodbrand');

			$config['upload_path'] 		= './public/images/product/';
			$config['allowed_types'] 	= 'jpg|png|psd|zip|pdf|rar';
			$config['max_size']			= '10000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['product_image'] = $upload_data['file_name'];
			}
			sleep(0.1);
			if ($this->upload->do_upload('brochure')){
				$upload_data = $this->upload->data();
				$data['product_brochure'] = $upload_data['file_name'];
			}

			$data['product_description_en'] = htmlspecialchars($data['product_description_en']);
			$data['product_description_id'] = htmlspecialchars($data['product_description_id']);
			$this->db->insert('product', $data);
			$insert_id = $this->db->insert_id();
			# ============================================
			for ($i=0; $i < sizeof($cat); $i++) { 
				$catdata = array(
					'prodcat_product_id' => $insert_id, 
					'prodcat_category_id' => $cat[$i]);
				$this->db->insert('product_category', $catdata);
				sleep(0.1);
			}
			# ============================================
			for ($i=0; $i < sizeof($brand); $i++) { 
				$branddata = array(
					'prodbrand_product_id' => $insert_id, 
					'prodbrand_brand_id' => $brand[$i]);
				$this->db->insert('product_brand', $branddata);
				sleep(0.1);
			}
			$this->session->set_flashdata('alert', 'success');
			redirect('webmin/product');
			exit;
		}

		$data = array( 
			'cat' => $this->mpage->getCategory(),
			'data' => $this->db->get('product'), 
			'brand' => $this->mpage->getBrand(),
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('product/view_product_add', $data);
	}
	function edit($id)
	{
		$action = $this->input->get('action');
		if ($action == 'save') {
			$data = $this->input->post('post');
			$cat = $this->input->post('prodcat');
			$brand = $this->input->post('prodbrand');

			$config['upload_path'] 		= './public/images/product/';
			$config['allowed_types'] 	= 'jpg|png|psd|zip|pdf|rar';
			$config['max_size']			= '10000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['product_image'] = $upload_data['file_name'];
			}
			sleep(0.1);
			if ($this->upload->do_upload('brochure')){
				$upload_data = $this->upload->data();
				$data['product_brochure'] = $upload_data['file_name'];
			}

			$data['product_description_en'] = htmlspecialchars($data['product_description_en']);
			$data['product_description_id'] = htmlspecialchars($data['product_description_id']);
			$this->db->update('product', $data, array('product_id'=>$id));
			# ============================================
			$this->db->delete('product_category', array('prodcat_product_id'=>$id));
			for ($i=0; $i < sizeof($cat); $i++) { 
				$catdata = array(
					'prodcat_product_id' => $id, 
					'prodcat_category_id' => $cat[$i]);
				$this->db->insert('product_category', $catdata);
				sleep(0.1);
			}
			# ============================================
			$this->db->delete('product_brand', array('prodbrand_product_id'=>$id));
			for ($i=0; $i < sizeof($brand); $i++) { 
				$branddata = array(
					'prodbrand_product_id' => $id, 
					'prodbrand_brand_id' => $brand[$i]);
				$this->db->insert('product_brand', $branddata);
				sleep(0.1);
			}
			$this->session->set_flashdata('alert', 'success');
			redirect('webmin/product');
			exit;
		}

		$data = array(
			'cat' => $this->mpage->getCategory(),
			'brand' => $this->mpage->getBrand(),
			'data' => $this->db->where('product_id', $id)->get('product')->row(), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('product/view_product_edit', $data);
	}
	/* add ons */
	function remove($action, $id)
	{
		if ($action == 'category') {
			$this->db->delete('category', array('category_id' => $id));
			redirect('webmin/product/category');
		}
		if ($action == 'brand') {
			$this->db->delete('brand', array('brand_id' => $id));
			redirect('webmin/product/brand');
		}
		if ($action == 'product') {
			$this->db->delete('product_image', array('image_product_id' => $id));
			$this->db->delete('product', array('product_id' => $id));
			redirect('webmin/product');
		}
		if ($action == 'image') {
			$dua = explode('-', $id);
			$this->db->delete('product_image', array('image_id' => $dua[1]));
			redirect('webmin/product/image/'.$dua[0]);
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
				$act = $this->db->insert('category', $data);
			else
				$act = $this->db->update('category', $data, array('category_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/product/category');
			exit;
		}
		$data = array('data' => $this->db->order_by('category_id', 'desc')->get('category'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('product/view_category', $data);
	}
	function brand()
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');


			$config['upload_path'] 		= './public/images/brand/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['brand_image'] = $upload_data['file_name'];
			}

			$act = false;
			if(empty($id))
				$act = $this->db->insert('brand', $data);
			else
				$act = $this->db->update('brand', $data, array('brand_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/product/brand');
			exit;
		}
		$data = array('data' => $this->db->order_by('brand_id', 'desc')->get('brand'), 
			'alert' => $this->session->flashdata('alert'));
		$this->load->view('product/view_brand', $data);
	}
	function image($product_id)
	{
		$action = $this->input->get('action');
		$id = $this->input->get('id');
		if ($action == 'save') {
			$data = $this->input->post('post');
			$data['image_product_id'] = $product_id;

			$config['upload_path'] 		= './public/images/product/';
			$config['allowed_types'] 	= 'jpg|png|gif';
			$config['max_size']			= '2000';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')){
				$upload_data = $this->upload->data();
				$data['image_file'] = $upload_data['file_name'];
			}

			$act = false;
			if(empty($id))
				$act = $this->db->insert('product_image', $data);
			else
				$act = $this->db->update('product_image', $data, array('image_id' => $id));
			if($act)
				$this->session->set_flashdata('alert', 'success');
			else
				$this->session->set_flashdata('alert', 'danger');
			redirect('webmin/product/image/'.$product_id);
			exit;
		}
		$data = array('data' => $this->db->where('image_product_id', $product_id)->order_by('image_id', 'desc')->get('product_image'), 
			'alert' => $this->session->flashdata('alert'),
			'prod' => $this->db->where('product_id', $product_id)->get('product')->row()
			);
		$this->load->view('product/view_product_image', $data);
	}
}