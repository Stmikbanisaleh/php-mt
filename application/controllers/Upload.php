<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		  $this->load->helper(array('form', 'url'));
	}
 
	public function index(){
		$data['user'] = $this->db->get_where('msuser', ['email' =>
			$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['unitkerja']= $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['dokumen'] = $this->db->get('msdokumen')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('upload');
		$this->load->view('templates/footer');
	}
 
	public function aksi_upload(){

		$config['upload_path']          = './assets/img/upload/';
		$config['allowed_types']        = 'doc|docx|xls|xlsx|pdf|gif|jpg|png';
		//$config['file_name']        = 'berkas';
		//$config['max_size']             = 100;
		//$config['max_width']            = 1024;
		//$config['max_height']           = 768;
 
		$this->load->library('upload', $config);
 
		for ($i=1; $i <=3 ; $i++) { 
      if(!empty($_FILES['berkas'.$i]['name'])){
          if(!$this->upload->do_upload('berkas'.$i))
              echo "error";
          else
					$data = array('upload_data' => $this->upload->data());
					$this->load->view('upload_sukses', $data);
      }
    }

    $data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
		];
		$this->db->insert('mspaten', $data);
	}
	
}