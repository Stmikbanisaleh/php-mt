<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email')) {
			redirect('auth');
		}
		$this->load->library('upload');
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
	}

	public function input()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['jenispembayaran'] = $this->db->get_where('msrev', array('GOLONGAN' => 13))->result_array();

		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Pembayaran_model', 'bayar');
		$data['pembayaran'] = $this->bayar->getPembayaran();

		if ($roleId == 15 or $roleId == 17) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('pembayaran/input', $data);
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		}
	}

	public function save()
	{
		$config['file_name']          = 'bukti_pembayaran';
		$config['upload_path']          = './assets/pembayaran';
		$config['allowed_types']        = 'doc|docx|xls|xlsx|pdf|gif|jpg|png';

		$this->upload->initialize($config);

		if (!empty($_FILES['bukti_pembayaran']['name'])) {
			$this->upload->do_upload('bukti_pembayaran');
			$name = $this->upload->data('raw_name');
			$ext = $this->upload->data('file_ext');
			$filename = $name . '_' . $this->input->post('no_paten') . $ext;
		} else {
			$filename = 'error';
		}

		$data = [
			'NOMOR_PENDAFTAR' => htmlspecialchars($this->input->post('no_paten', true)),
			'TGL_INPUT' => date('Y-m-d h:i:s'),
			'JENIS_PEMBAYARAN' => htmlspecialchars($this->input->post('jenis_pembayaran', true)),
			'BUKTI_PEMBAYARAN' => $filename,
			'PEMBAYARAN' => htmlspecialchars($this->input->post('dibayar', true))
		];

		$this->db->insert('trpembayaran', $data);
		$this->db->insert('trpembayaran_backup', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pembayaran telah ditambahkan!</div>');
		redirect('pembayaran/monitoring');
	}

	private function _uploadFile()
	{
		$config['upload_path']          = './assets/pembayaran';
		$config['allowed_types']        = 'pdf|jpg|png';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('bukti_pembayaran')) {
			return $this->upload->data("file_name");
		}

		return 'error';
	}

	public function monitoring()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Pembayaran_model', 'bayar');
		$data['pembayaran'] = $this->bayar->getPembayaran();

		if ($roleId == 15 or $roleId == 17) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('pembayaran/monitoring', $data);
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		}
	}

	function reload_paten($id = '')
	{
		$nopaten = $this->input->post('no_paten');
		if ($id != '') {
			$no_paten = $id;
		}

		$this->load->model('Pembayaran_model', 'bayar');
		$detail = $this->bayar->getDetail($nopaten);

		$results = array('header' => $detail);

		echo json_encode($results);
	}
}
