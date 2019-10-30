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
		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $roleId = $data['user']['role_id'];
		// $data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 3]);
		$return_jenispembayaran = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 4]);
		$return_dokhakcipta = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', ['token' => $this->session->userdata('token'), 'id_role' => 1, 'id_haki' => 3]);
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);
		
		$data['jenispembayaran'] = $return_jenispembayaran['data']['rows'];

		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $roleId = $data['user']['role_id'];
		$return_role = $this->lapan_api_library->call('rev/getrevbyid', ['token' => $this->session->userdata('token'),'id' => $this->session->userdata('role_id')]);
		$return_pembayaran = $this->lapan_api_library->call('pembayaran/getpembayaran', ['token' => $this->session->userdata('token')]);

		// print_r($return_pembayaran);exit;
		// $data['role'] = $return_role['data']['rows'][0];

		// $this->load->model('Pembayaran_model', 'bayar');
		$data['pembayaran'] = $return_pembayaran['data'][0];

		if ($this->session->userdata('role_id') == 15 or $this->session->userdata('role_id')== 17) {
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
			'nomor_pendaftar' => htmlspecialchars($this->input->post('no_paten', true)),
			'tgl_input' => date('Y-m-d h:i:s'),
			'jenis_pembayaran' => htmlspecialchars($this->input->post('jenis_pembayaran', true)),
			'bukti_pembayaran' => $filename,
			'pembayaran' => htmlspecialchars($this->input->post('dibayar', true)),
			'token' => $this->session->userdata('token'),
		];

		$insert = $this->lapan_api_library->call('pembayaran/addpembayaran',$data);

		// $this->db->insert('trpembayaran', $data);
		// $this->db->insert('trpembayaran_backup', $data);

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
		$return_pembayaran = $this->lapan_api_library->call('pembayaran/getpembayaran', ['token' => $this->session->userdata('token')]);
		$data['pembayaran'] = $return_pembayaran['data'][0];

		// print_r($data);exit;
		if ($this->session->userdata('role_id') == 15 or $this->session->userdata('role_id') == 17) {
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
			$nopaten = $id;
		}
		$data = [
			'nomor_paten' => $nopaten,
			'token' => $this->session->userdata('token')
		];
		$detail = $this->lapan_api_library->call('pembayaran/getdetail',$data);
		// print_r(json_encode($detail['data'][0][0]));exit;
		$detail = $detail['data'][0][0];
		// $this->load->model('Pembayaran_model', 'bayar');
		// $detail = $this->bayar->getDetail($nopaten);

		$results = array('header' => $detail);

		echo json_encode($results);
	}
}
