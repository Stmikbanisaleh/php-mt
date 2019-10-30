<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merek extends CI_Controller
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
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'), 'golongan' => 3]);
		$return_jenispaten = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'), 'golongan' => 7]);
		$return_dokmerek = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', ['token' => $this->session->userdata('token'), 'id_role' => 1, 'id_haki' => 2]);
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);

		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['dokmerek'] = $return_dokmerek['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		// $this->load->model('Merek_model', 'merek');
		$data_getcode = array(
			'token' => $this->session->userdata('token'),
			'kode' => 'MR',
		);
		$getcode = $this->lapan_api_library->call('lib/getcode', $data_getcode);

		$pb = $getcode['data']['rows'];
		$kode = $getcode['data']['rows'][0]['kode'];
		$nourut = sprintf('%04d', $pb[0]['no_urut']);
		$ipm = $pb[0]['kode'] . '_' . $nourut;
		$ipmancode = $ipm;

		$data['ipmancode'] = $ipmancode;
		// print_r($ipmancode);exit;

		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('merek/input', $data);
		$this->load->view('templates/footer');
	}

	public function edit($id)
	{
		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $roleId = $data['user']['role_id'];
		$data['merekid'] = $id;
		// $data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);

		$return_pendesain = $this->lapan_api_library->call('mereks/getpendesainbyid', ['token' => $this->session->userdata('token'), 'id' => $id]);
		$return_merekdraftbyid = $this->lapan_api_library->call('mereks/getmerekdraftdetail', ['token' => $this->session->userdata('token'), 'id' => $id]);
		$return_patendraftdetail = $this->lapan_api_library->call('patens/getpatendraft', ['token' => $this->session->userdata('token'), 'id' => $id]);

		// $return_role = $this->lapan_api_library->call('patens/getrevbyid', ['token' => $this->session->userdata('token'),'id' => $id]);
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'), 'golongan' => 3]);
		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		$data['draft'] = $return_merekdraftbyid['data'][0][0];
		$data['pendesain'] = $return_pendesain['data'][0];

		$code = $data['draft']['ipman_code'];
		$return_dokumenbyipmancode = $this->lapan_api_library->call('dokumen/getdokumenbyipman', ['token' => $this->session->userdata('token'), 'code' => $code]);

		$data['dokumen'] = $return_dokumenbyipmancode['data'][0];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('merek/edit', $data);
		$this->load->view('templates/footer');
	}

	public function save()
	{
		$data = [
			'token' => $this->session->userdata('token'),
			'id_haki' => 2,
			'id_role' => 1,
		];
		$dokmerek = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data);

		$post = $this->input->post();

		$userid =  $this->session->userdata('user_id');
		$date = date('Y-m-d h:i:s');
		$ipmancode = $this->input->post('ipman_code');

		$data = [
			'token' => $this->session->userdata('token'),
			'judul' => htmlspecialchars($this->input->post('judul', true)),
			'unit_kerja' => $this->input->post('unit_kerja'),
			'status' => 19,
			'no_handphone' => $this->input->post('no_handphone'),
			'ipman_code' => $ipmancode,
			'kode_input' => $this->session->userdata('user_id'),
			'tgl_input' => date('Y-m-d h:i:s'),
			'kelas' => htmlspecialchars($this->input->post('kelas', true)),
		];

		$insert = $this->lapan_api_library->call('mereks/addmerek', $data);

		if ($insert) {
			$dataId = $insert['id'];

			$data = array(
				'token' => $this->session->userdata('token'),
				'kode' => 'MR',
			);
			$update = $this->lapan_api_library->call('lib/updatenourut', $data);

			$i = 1;
			$dokmerek = $dokmerek['data']['rows'];
			foreach ($dokmerek as $dm) {

				$config['file_name']          = $ipmancode . '_' . $dm['penamaan_file'];
				$config['allowed_types']        = 'doc|docx|pdf|';

				$file_tmp = $_FILES['dokumen' . $i]['tmp_name'];
				if (
					!empty($_FILES['dokumen' . $i]['tmp_name'])
					&& file_exists($_FILES['dokumen' . $i]['tmp_name'])
				) {
					$data_getcontent = file_get_contents($_FILES['dokumen' . $i]['tmp_name']);
				}
				$dokumen_base64 = base64_encode($data_getcontent);

				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$size = $_FILES['dokumen' . $i]['size'];
					$type = $_FILES['dokumen' . $i]['type'];
					$filename = $_FILES['dokumen' . $i]['name'];
					$jenisdok = $dm['id'];
					$downloadable = $dm['downloadable'];

					$ext = explode('.', $filename);
					$type = end($ext);
				} else {
					$filename = $ipmancode . '_' . $dm['penamaan_file'];
					$size = '';
					$type = '';
					$jenisdok = $dm['id'];
					$downloadable = 0;
				}
				$dokumen = array($dokumen_base64, $type, 1, $jenisdok, $date, $userid, $filename, $size);

				$md['token'] = $this->session->userdata('token');
				$md['nomor_pendaftar'] = $ipmancode;
				$md['dokumen'] = $dokumen[0];
				$md['type'] = $dokumen[1];
				$md['role'] = $dokumen[2];
				$md['jenis_dokumen'] = $dokumen[3];
				$md['tgl_input'] = $dokumen[4];
				$md['kode_input'] = $dokumen[5];
				$md['downloadable'] = $downloadable;
				$md['name'] = $dokumen[6];
				$md['size'] = $dokumen[7];

				$insert_doc = $this->lapan_api_library->call('lib/adddokumen', $md);
				$i++;
			}

			$kp = array();
			foreach ($post['pendesain'] as $kopeg) {
				$kp['token'] = $this->session->userdata('token');
				$kp['id_merek'] = $insert['id'];
				$kp['nik'] = $kopeg['nik'];

				$insert = $this->lapan_api_library->call('mereks/adddmerek', $kp);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Merek telah ditambahkan!</div>');
			redirect('merek/monitoring');
		}
	}

	public function update()
	{
		// $user = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();

		// $this->load->model('Merek_model', 'merek');
		$ipman = $this->input->post('ipman_code');
		$data_dokumen = [
			'token' => $this->session->userdata('token'),
			'code' => $ipman
		];
		$dokmerek = $this->lapan_api_library->call('dokumen/getdokumenbyipman', $data_dokumen);
		// print_r($datadokumen['data'][0][0]);exit;
		// $dokmerek = $this->merek->getDokumen($ipman);
		$jumlahdok = count($dokmerek['data'][0]);
		// print_r(json_encode($dokmerek['data'][0]));exit;
		// print_r($jumlahdok);exit;
		$post = $this->input->post();
		$data = [
			'judul' => htmlspecialchars($this->input->post('judul', true)),
			'kelas' => htmlspecialchars($this->input->post('kelas', true)),
			'unit_kerja' => $this->input->post('unit_kerja'),
			'status' => 19,
			'no_handphone' => $this->input->post('no_handphone'),
			'kode_ubah' => $this->session->userdata('user_id'),
			'tgl_ubah' => date('Y-m-d h:i:s'),
			'token' => $this->session->userdata('token'),
			'id' => $post['id']
		];

		// $this->db->where('id', $post['id']);
		$updatemerek = $this->lapan_api_library->call('merek/updatemereksave', $data);

		if ($updatemerek['status'] == 200) {
			$data2 = [
				'token' => $this->session->userdata('token'),
				'id_merek' => $post['id']
			];
			$deletedmerek = $this->lapan_api_library->call('merek/deletedmerek', $data2);
			
			$data3 = [
				'nomor_pendaftar' => $this->input->post('ipman_code'),
				'token' => $this->session->userdata('token')
			];

			$deletemsdokumen = $this->lapan_api_library->call('lib/deletedokumenbyip', $data3);
			// $deletemsdokumenb = $this->lapan_api_library->call('dokumen/deletedmerek', $data3);

			// $this->db->delete('dmerek', array('ID_MEREK' => $post['id']));
			// $this->db->delete('msdokumen', array('NOMOR_PENDAFTAR' => $this->input->post('ipman_code'), 'REV' => 0, 'ROLE' => 1));

			$i = 1;
			foreach ($dokmerek as $dm) {
				$versi = $dm['rev'] + 1;
				if ($dm['size']) {
					$config['file_name']          = $ipman . '_' . $dm['penamaan_file'] . '_v' . $versi;
					$config['upload_path']          = './assets/dokumen/dokumen_merek/';
					$config['allowed_types']        = 'doc|docx|pdf';
				} else {
					$config['file_name']          = $ipman . '_' . $dm['penamaan_file'];
					$config['upload_path']          = './assets/dokumen/dokumen_merek/';
					$config['allowed_types']        = 'doc|docx|pdf';
				}

				$this->upload->initialize($config);

				// script upload dokumen
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					// $this->upload->do_upload('dokumen' . $i);
					$filename[$i] = $_FILES['dokumen' . $i]['name'];
					$size[$i] = $_FILES['dokumen' . $i]['size'];
					$type[$i] = $_FILES['dokumen' . $i]['type'];
					if ($dm['size']) {
						$rev[$i] = $dm['rev'] + 1;
					} else {
						$rev[$i] = $dm['rev'];
					}
					$jenisdok[$i] = $dm['id'];
					$downloadable[$i] = $dm['downloadable'];
					$dateinput[$i] = $dm['tgl_input'];
					$userinput[$i] = $dm['kode_input'];
					$dateubah[$i] = date('Y-m-d h:i:s');
					$userubah[$i] = $this->session->userdata('user_id');
				} else {
					$filename[$i] = $dm['name'];
					$size[$i] = $dm['size'];
					$type[$i] = $dm['type'];
					$rev[$i] = $dm['rev'];
					$jenisdok[$i] = $dm['id'];
					$downloadable[$i] = $dm['downloadable'];
					$dateinput[$i] = $dm['tgl_input'];
					$userinput[$i] = $dm['kode_input'];
					$dateubah[$i] = $dm['tgl_ubah'];
					$userubah[$i] =  $this->session->userdata('user_id');
				}
				$dokumen[$i] = array($filename[$i], $size[$i], $type[$i], $rev[$i], '1', $jenisdok[$i], $downloadable[$i], $dateinput[$i], $userinput[$i], $dateubah[$i], $userubah[$i]);
				$i++;
			}
			switch ($jumlahdok) {
				case "1":
					$arraydokumen = array($dokumen[1]);
					break;
				case "2":
					$arraydokumen = array($dokumen[1], $dokumen[2]);
					break;
				case "3":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3]);
					break;
				case "4":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4]);
					break;
				case "5":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5]);
					break;
				case "6":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6]);
					break;
				case "7":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7]);
					break;
				case "8":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8]);
					break;
				case "9":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9]);
					break;
				case "10":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10]);
					break;
				case "11":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11]);
					break;
				case "12":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12]);
					break;
				case "13":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13]);
					break;
				case "14":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13], $dokumen[14]);
					break;
				case "15":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13], $dokumen[14], $dokumen[15]);
					break;
				case "16":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13], $dokumen[14], $dokumen[15], $dokumen[16]);
					break;
				case "17":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13], $dokumen[14], $dokumen[15], $dokumen[16], $dokumen[17]);
					break;
				case "18":
					$arraydokumen = array($dokumen[1], $dokumen[2], $dokumen[3], $dokumen[4], $dokumen[5], $dokumen[6], $dokumen[7], $dokumen[8], $dokumen[9], $dokumen[10], $dokumen[11], $dokumen[12], $dokumen[13], $dokumen[14], $dokumen[15], $dokumen[16], $dokumen[17], $dokumen[18]);
					break;
			}

			$kp = array();
			foreach ($post['pendesain'] as $kopeg) {
				$kp['id_merek'] = $post['id'];
				$kp['nik'] = $kopeg['nik'];

				$insert = $this->lapan_api_library->call('mereks/adddmerek', $kp);
				// $this->db->insert('dmerek', $kp);
			}

			$md = array();
			foreach ($arraydokumen as $dok) :
				$md['nomor_pendaftar'] = $this->input->post('ipman_code');
				$md['name'] = $dok[0];
				$md['size'] = $dok[1];
				$md['type'] = $dok[2];
				$md['rev'] = $dok[3];
				$md['role'] = $dok[4];
				$md['jenis_dokumen'] = $dok[5];
				$md['downloadable'] = $dok[6];
				$md['tgl_input'] = $dok[7];
				$md['kode_input'] = $dok[8];
				$md['tgl_ubah'] = $dok[9];
				$md['kode_ubah'] = $dok[10];
				$insertdokumen = $this->lapan_api_library->call('lib/adddokumen', $md);

				// $this->db->insert('msdokumen', $md);
			endforeach;


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Merek telah diubah!</div>');
			redirect('merek/monitoring');
		}
	}

	public function monitoring_verifikator()
	{
		// print_r($this->session->userdata());exit;
		$return_merek = $this->lapan_api_library->call('mereks/getmerek', ['token' => $this->session->userdata('token')]);
		$return_draft = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 19]);
		$return_diajukan = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 20]);
		$return_disetujui = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 21]);
		$return_ditolak = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 22]);
		$return_ditangguhkan = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 23]);
		$return_pendesain = $this->lapan_api_library->call('desain/getallpendesain', ['token' => $this->session->userdata('token')]);
		$return_nonpendesain = $this->lapan_api_library->call('desain/getallnonpendesain', ['token' => $this->session->userdata('token')]);

		$data['getMerek'] = $return_merek['data']['rows'];
		$data['getDiajukan'] = $return_diajukan['data'][0];
		$data['getDisetujui'] =  $return_disetujui['data'][0];
		$data['getDitolak'] = $return_ditolak['data'][0];
		$data['getDitangguhkan'] = $return_ditangguhkan['data'][0];
		$data['getPendesain'] = $return_pendesain['data'][0];
		$data['getPendesainNon'] = $return_nonpendesain['data'][0];

		if ($this->session->userdata('role_id') == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('merek/monitoring_ver', $data);
			$this->load->view('templates/footer');
		}
	}

	public function monitoring()
	{
		$return_draft = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 19]);

		$return_diajukan = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 20]);
		$return_disetujui = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 21]);
		$return_ditolak = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 22]);
		$return_ditangguhkan = $this->lapan_api_library->call('mereks/getmerekstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 23]);
		$return_inventor = $this->lapan_api_library->call('patens/getinventor', ['token' => $this->session->userdata('token')]);
		$return_noninventor = $this->lapan_api_library->call('patens/getnoninventor', ['token' => $this->session->userdata('token')]);
		// $return_paten = $this->lapan_api_library->call('patens/getpaten', ['token' => $this->session->userdata('token')]);

		$data['getDraft'] = $return_draft['data'][0];
		$data['getDiajukan'] = $return_diajukan['data'][0];
		$data['getDisetujui'] = $return_disetujui['data'][0];
		$data['getDitolak'] = $return_ditolak['data'][0];
		$data['getDitangguhkan'] = $return_ditangguhkan['data'][0];
		$data['getInventor'] = $return_inventor['data'][0];
		$data['getInventorNon'] = $return_noninventor['data'][0];
		// $data['data'] = $return_paten['data']['rows'];



		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('merek/monitoring', $data);
		$this->load->view('templates/footer');
	}

	public function export()
	{
		$merek = $this->lapan_api_library->call('exportexcel/getallmerek', ['token' => $this->session->userdata('token')]);
		$merek = $merek['data']['0'];

		// Load plugin PHPExcel nya
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '9ACD32')
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "JUDUL");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "UNIT KERJA");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "INVENTOR");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		// Panggil function view yang ada di merekModel untuk menampilkan semua data mereknya
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($merek as $mer) { // Lakukan looping pada variabel merek
			$peg = array($this->merek->getPendesainExport($mer['ID']));
			foreach ($peg as $pp) {
				$c = count($pp);
				switch ($c) {
					case "1":
						$arrayinventor = array($pp[0]['NAMA']);
						break;
					case "2":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA']);
						break;
					case "3":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA']);
						break;
					case "4":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA']);
						break;
					case "5":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA']);
						break;
					case "6":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA']);
						break;
					case "7":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA']);
						break;
					case "8":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA']);
						break;
					case "9":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA']);
						break;
					case "10":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA']);
						break;
					case "11":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA']);
						break;
					case "12":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA']);
						break;
					case "13":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA']);
						break;
					case "14":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA']);
						break;
					case "15":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA']);
						break;
					case "16":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA']);
						break;
					case "17":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA']);
						break;
					case "18":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA']);
						break;
					case "19":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA'], $pp[18]['NAMA']);
						break;
					case "20":
						$arrayinventor = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA'], $pp[18]['NAMA'], $pp[19]['NAMA']);
						break;
				}
				$inventor = implode(" , ", $arrayinventor);
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $mer['JUDUL']);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $mer['UNIT_KERJA']);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $mer['STATUS']);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $inventor);

				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
			}
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(60); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan merek");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="merek.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	public function verifikasi($id)
	{
		$data_rev = [
			'token' => $this->session->userdata('token'),
			'golongan' => 3
		];
		$data['unitkerja'] = $this->lapan_api_library->call('rev', $data_rev);
		$data['unitkerja'] = $data['unitkerja']['data']['rows'];

		$data_status = [
			'token' => $this->session->userdata('token'),
			'golongan' => 6
		];
		$data['status'] = $this->lapan_api_library->call('rev/', $data_status);
		$data['status'] = $data['status']['data']['rows'];

		$data['pegawai'] = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$data['pegawai'] = $data['pegawai']['data']['rows'];

		$data['nonpegawai'] = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);
		$data['nonpegawai'] = $data['nonpegawai']['data']['rows'];

		$data_merek = [
			'token' => $this->session->userdata('token'),
			'id' => $id
		];
		$data['merek'] = $this->lapan_api_library->call('mereks/getmerekbyid', $data_merek);
		$data['merek'] = $data['merek']['data']['rows'];

		$data_dokmerek = [
			'token' => $this->session->userdata('token'),
			'id_haki' => 2
		];
		$data['dokmerek'] = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data_dokmerek);
		$data['dokmerek'] = $data['dokmerek']['data']['rows'];

		$data_newdokver = [
			'token' => $this->session->userdata('token'),
			'id_haki' => 2
		];
		$data['newdokver'] = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data_newdokver);
		$data['newdokver'] = $data['newdokver']['data']['rows'];

		$data_diajukan = [
			'token' => $this->session->userdata('token'),
			'status' => 20,
			'id' => $id
		];
		$data['diajukan'] = $this->lapan_api_library->call('mereks/getmerekdiajukandetail', $data_diajukan);
		$data['diajukan'] = $data['diajukan']['data'][0][0];

		$data_pendesain = [
			'token' => $this->session->userdata('token'),
			'id' => $id
		];
		$data['pendesain'] = $this->lapan_api_library->call('mereks/getpendesainbyid', $data_pendesain);
		$data['pendesain'] = $data['pendesain']['data'][0];

		$code = $data['diajukan']['ipman_code'];
		$data_dokumen = [
			'token' => $this->session->userdata('token'),
			'code' => $code
		];
		$data['dokumen'] = $this->lapan_api_library->call('dokumen/getdokumenbyipman', $data_dokumen);
		$data['dokumen'] = $data['dokumen']['data'][0];

		$data_dokver = [
			'token' => $this->session->userdata('token'),
			'nomor_pendaftar' => $code,
			'role' => 2
		];
		$data['dokver'] = $this->lapan_api_library->call('patens/getdokumenver', $data_dokver);
		$data['dokver'] = $data['dokver']['data'][0];

		// print_r(json_encode($data['pendesain']));exit;



		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();

		// $roleId = $data['user']['role_id'];
		// $data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		// $data['unitkerja'] = $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		// $data['status'] = $this->db->get_where('msrev', array('golongan' => 6))->result_array();
		// $data['pegawai'] = $this->db->get('mspegawai')->result_array();
		// $data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();
		// $data['merek'] = $this->db->get_where('msmerek', array('ID' => $id))->row_array();
		// $data['dokmerek'] = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 2))->result_array();
		// $data['newdokver'] = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		// $this->load->model('Merek_model', 'merek');
		// $data['diajukan'] = $this->merek->getMerekDiajukanDetail($id);
		// $data['pendesain'] = $this->merek->getPendesainById($id);

		// $code = $data['diajukan']['IPMAN_CODE'];
		// $data['dokumen'] = $this->merek->getDokumen($code);
		// $data['dokver'] = $this->db->get_where('msdokumen', array('NOMOR_PENDAFTAR' => $code, 'ROLE' => 2))->result_array();

		if ($this->session->userdata('role_id') == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('merek/verifikasi', $data);
			$this->load->view('templates/footer');
		}
	}

	public function save_verifikasi()
	{
		// $user = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $return_draft = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 19]);
		// $return_diajukan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 20]);
		// $return_disetujui = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 21]);
		// $return_ditolak = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 22]);
		// $return_ditangguhkan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 23]);
		// $return_inventor = $this->lapan_api_library->call('patens/getinventor', ['token' => $this->session->userdata('token')]);
		// $return_noninventor = $this->lapan_api_library->call('patens/getnoninventor', ['token' => $this->session->userdata('token')]);

		$userid =  $this->session->userdata('user_id');
		$date = date('Y-m-d h:i:s');

		// $this->load->model('Merek_model', 'merek');
		$ipman = $this->input->post('ipman_code');
		$data_dokumen = [
			'token' => $this->session->userdata('token'),
			'code' => $ipman
		];
		$data_dokumen2 = [
			'token' => $this->session->userdata('token'),
			'id_role' => 2
		];

		// print_r($ipman);exit;
		$dokmerekver = $this->lapan_api_library->call('mereks/getdokumenver', $data_dokumen);
		// print_r($data_dokumen);exit;
		$dokuver = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data_dokumen2);
		// print_r($dokmerekver['data'][0][0]);exit;
		// $dokuver = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$config1['file_name']          	= $dokuver['data']['rows'][0]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config1['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config1['allowed_types']        = 'doc|docx|pdf';
		$config1['overwrite']        = TRUE;

		$this->upload->initialize($config1);
		// print_r(json_encode($dokmerekver));exit;
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen1']['name'])) {
				$this->upload->do_upload('dokumen1');
				$filename1 = $_FILES['dokumen1']['name'];
				$size1 = $_FILES['dokumen1']['size'];
				$type1 = $_FILES['dokumen1']['type'];
				$file_tmp = $_FILES['dokumen1']['tmp_name'];
				$data = file_get_contents($file_tmp);
				$dokumen1base64 = base64_encode($data);
				$jenisdok = $dokuver['data']['rows'][0]['id'];
				$dokumen1 = array($dokumen1base64, $filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				// print_r($dokmerekver);exit;
				$filename1 = $dokmerekver['data'][0][0]['name'];
				$size1 = $dokmerekver['data'][0][0]['size'];
				$type1 = $dokmerekver['data'][0][0]['type'];
				$jenisdok = $dokmerekver['data'][0][0]['id'];
				$dokumen1 = array('', $filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen1']['name'])) {
				// $this->upload->do_upload('dokumen1');
				$filename1 = $_FILES['dokumen1']['name'];
				$size1 = $_FILES['dokumen1']['size'];
				$type1 = $_FILES['dokumen1']['type'];
				$file_tmp = $_FILES['dokumen1']['tmp_name'];
				$data = file_get_contents($file_tmp);
				$dokumen1base64 = base64_encode($data);
				$jenisdok = $dokuver['data']['rows'][0]['id'];

				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen1 = array($dokumen1base64, $filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				$filename1 = $dokuver['data']['rows'][0]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver['data']['rows'][0]['id'];
				$dokumen1 = array('', $filename1, '', '', '2', $jenisdok, $date, $userid);
			}
		}



		$config2['file_name']          	= $dokuver['data']['rows'][1]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config2['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config2['allowed_types']        = 'doc|docx|pdf';
		$config2['overwrite']        = TRUE;

		// print_r($dokumen1);exit;
		$this->upload->initialize($config2);

		// script upload dokumen kedua
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $_FILES['dokumen2']['name'];
				$size2 = $_FILES['dokumen2']['size'];
				$type2 = $_FILES['dokumen2']['type'];
				$jenisdok = $dokuver['data']['rows'][1]['id'];
				$file_tmp2 = $_FILES['dokumen2']['tmp_name'];
				$data2 = file_get_contents($file_tmp2);
				$dokumen2base64 = base64_encode($data2);
				$dokumen2 = array($dokumen2base64, $filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				// print_r($dokmerekver['data'][0][1]['name']);exit;
				$filename2 = $dokmerekver['data'][0][1]['name'];
				$size2 = $dokmerekver['data'][0][1]['size'];
				$type2 = $dokmerekver['data'][0][1]['type'];
				$jenisdok = $dokmerekver['data'][0][1]['id'];
				$dokumen2 = array('', $filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $_FILES['dokumen2']['name'];
				$size2 = $_FILES['dokumen2']['size'];
				$type2 = $_FILES['dokumen2']['type'];
				$jenisdok = $dokuver['data']['rows'][1]['id'];
				$file_tmp2 = $_FILES['dokumen2']['tmp_name'];
				$data2 = file_get_contents($file_tmp2);
				$dokumen2base64 = base64_encode($data2);
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen2 = array($dokumen2base64, $filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				$filename2 = $dokuver['data']['rows'][1]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver['data']['rows'][1]['id'];
				$dokumen2 = array('', $filename2, '', '', '2', $jenisdok, $date, $userid);
			}
		}


		$config3['file_name']          	= $dokuver['data']['rows'][2]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config3['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config3['allowed_types']        = 'doc|docx|pdf';
		$config3['overwrite']        = TRUE;

		$this->upload->initialize($config3);
		// script uplaod dokumen ketiga
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen3']['name'])) {
				// $this->upload->do_upload('dokumen3');
				$filename3 = $_FILES['dokumen3']['name'];
				$size3 = $_FILES['dokumen3']['size'];
				$type3 = $_FILES['dokumen3']['type'];
				$jenisdok = $dokuver['data']['rows'][2]['id'];
				$file_tmp3 = $_FILES['dokumen3']['tmp_name'];
				$data3 = file_get_contents($file_tmp3);
				$dokumen3base64 = base64_encode($data3);

				$dokumen3 = array($dokumen3base64, $filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokmerekver['data'][0][2]['name'];
				$size3 = $dokmerekver['data'][0][2]['size'];
				$type3 = $dokmerekver['data'][0][2]['type'];
				$jenisdok = $dokmerekver['data'][0][2]['id'];
				$dokumen3 = array('', $filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen3']['name'])) {
				$this->upload->do_upload('dokumen3');
				$filename3 = $_FILES['dokumen3']['name'];
				$size3 = $_FILES['dokumen3']['size'];
				$type3 = $_FILES['dokumen3']['type'];
				$jenisdok = $dokuver['data']['rows'][2]['id'];
				$file_tmp3 = $_FILES['dokumen3']['tmp_name'];
				$data3 = file_get_contents($file_tmp3);
				$dokumen3base64 = base64_encode($data3);
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen3 = array($dokumen3base64, $filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokuver['data']['rows'][2]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver['data']['rows'][2]['id'];
				$dokumen3 = array('', $filename3, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$config4['file_name']          	= $dokuver['data']['rows'][3]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config4['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config4['allowed_types']        = 'doc|docx|pdf';
		$config4['overwrite']        = TRUE;

		$this->upload->initialize($config4);
		// script uplaod dokumen keempat
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen4']['name'])) {
				$this->upload->do_upload('dokumen4');
				$filename4 = $this->upload->data('file_name');
				$size4 = $_FILES['dokumen4']['size'];
				$type4 = $_FILES['dokumen4']['type'];
				$jenisdok = $dokuver['data']['rows'][3]['id'];
				$file_tmp4 = $_FILES['dokumen4']['tmp_name'];
				$data4 = file_get_contents($file_tmp4);
				$dokumen4base64 = base64_encode($data4);
				$dokumen4 = array($dokumen4base64, $filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokmerekver['data'][0][3]['name'];
				$size4 = $dokmerekver['data'][0][3]['size'];
				$type4 = $dokmerekver['data'][0][3]['type'];
				$jenisdok = $dokmerekver['data'][0][3]['id'];
				$dokumen4 = array('', $filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen4']['name'])) {
				$filename4 = $_FILES['dokumen4']['name'];
				$size4 = $_FILES['dokumen4']['size'];
				$type4 = $_FILES['dokumen4']['type'];
				$jenisdok = $dokuver['data']['rows'][3]['id'];
				$file_tmp4 = $_FILES['dokumen4']['tmp_name'];
				$data4 = file_get_contents($file_tmp4);
				$dokumen4base64 = base64_encode($data4);
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen4 = array($dokumen4base64, $filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokuver['data']['rows'][3]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver['data']['rows'][3]['id'];
				$dokumen4 = array('', $filename4, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$config5['file_name']          	= $dokuver['data']['rows'][4]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config5['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config5['allowed_types']        = 'doc|docx|pdf';
		$config5['overwrite']        = TRUE;

		$this->upload->initialize($config5);
		// script uplaod dokumen kelima
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $_FILES['dokumen5']['name'];
				$size5 = $_FILES['dokumen5']['size'];
				$type5 = $_FILES['dokumen5']['type'];
				$jenisdok = $dokuver['data']['rows'][4]['id'];
				$file_tmp5 = $_FILES['dokumen5']['tmp_name'];
				$data5 = file_get_contents($file_tmp5);
				$dokumen5base64 = base64_encode($data5);
				$dokumen5 = array($dokumen5base64, $filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokmerekver['data'][0][4]['name'];
				$size5 = $dokmerekver['data'][0][4]['size'];
				$type5 = $dokmerekver['data'][0][4]['type'];
				$jenisdok = $dokmerekver['data'][0][4]['id'];
				$dokumen5 = array('', $filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen5']['name'])) {
				$filename5 = $_FILES['dokumen5']['name'];
				$size5 = $_FILES['dokumen5']['size'];
				$type5 = $_FILES['dokumen5']['type'];
				$jenisdok = $dokuver['data']['rows'][4]['id'];
				$file_tmp5 = $_FILES['dokumen5']['tmp_name'];
				$data5 = file_get_contents($file_tmp5);
				$dokumen5base64 = base64_encode($data5);
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen5 = array($dokumen5base64, $filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokuver['data']['rows'][4]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver['data']['rows'][4]['id'];
				$dokumen5 = array('', $filename5, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$dokumen = array($dokumen1, $dokumen2, $dokumen3, $dokumen4, $dokumen5);
		// print_r($dokumen1);exit;
		//var_dump($dokumen);
		//die;

		$data = [
			'pemeriksa_merek' => htmlspecialchars($this->input->post('pemeriksa_merek', true)),
			'kontak_pemeriksa' => htmlspecialchars($this->input->post('kontak_pemeriksa', true)),
			'email_pemeriksa' => htmlspecialchars($this->input->post('email_pemeriksa', true)),
			'sertifikasi' => date('Y-m-d', strtotime($this->input->post('tgl_sertifikasi'))),
			'tahun_pendaftaran' => htmlspecialchars($this->input->post('thn_pendaftaran', true)),
			'tahun_granted' => htmlspecialchars($this->input->post('thn_granted', true)),
			'nomor_pendaftar' => htmlspecialchars($this->input->post('no_pendaftaran', true)),
			'status' => $this->input->post('status'),
			'keterangan' => $this->input->post('keterangan'),
			'id' =>  $this->input->post('id'),
			'token' => $this->session->userdata('token')
		];
		// print_r($data);exit;
		// $this->db->where('id', $this->input->post('id'));
		$updateverifikasi = $this->lapan_api_library->call('mereks/updateverifikasisave', $data);
		// print_r($updateverifikasi['status']);exit;
		if ($updateverifikasi['status'] == 200) {
			if ($dokmerekver) {
				$delete = [
					'code' => $this->input->post('ipman_code'),
					'role' => 2,
					'token' => $this->session->userdata('token')
				];

				$deletedokumen = $this->lapan_api_library->call('dokumen/deletedokumenbynomorpendaftar', $delete);
				// print_r($deletedokumen);exit;
				// $this->db->delete('msdokumen', array('nomor_pendaftar' => $this->input->post('ipman_code'), 'role' => 2));
				// print_r(json_encode($dokumen));exit;
				foreach ($dokumen as $dok) :
					if (!empty($dok)) {
						// print_r($dok);exit;
						$md['nomor_pendaftar'] = $this->input->post('ipman_code');
						$md['dokumen'] = $dok[0];
						$md['name'] = $dok[1];
						$md['size'] = $dok[2];
						$md['type'] = $dok[3];
						$md['role'] = 2;
						$md['jenis_dokumen'] = $dok[4];
						$md['tgl_input'] = $dok[5];
						$md['kode_input'] = $dok[6];
						$md['downloadable'] = 1;
						$md['token'] = $this->session->userdata('token');

						// print_r($md);exit;
						$insertdokumen = $this->lapan_api_library->call('lib/adddokumen', $md);
						// print_r($insertdokumen);exit;

						// $this->db->insert('msdokumen', $md);
					}
				endforeach;
			} else {

				foreach ($dokumen as $dok) :
					if (!empty($dok)) {
						$md['nomor_pendaftar'] = $this->input->post('ipman_code');
						$md['gambar'] = $dok[0];
						$md['name'] = $dok[1];
						$md['size'] = $dok[2];
						$md['type'] = $dok[3];
						$md['role'] = 2;
						$md['jenis_dokumen'] = $dok[4];
						$md['tgl_input'] = $dok[5];
						$md['kode_input'] = $dok[6];

						$insertdokumen = $this->lapan_api_library->call('lib/adddokumen', $md);

						// $this->db->insert('msdokumen', $md);
					}
				endforeach;
			}
		}
		redirect('merek/monitoring_verifikator');
	}

	public function ajukan($id)
	{
		$data = [
			'token' => $this->session->userdata('token'),
			'id' => $id,
			'status' => 20,
			'pernah_diajukan' => 1
		];
		$return = $this->lapan_api_library->call('mereks/ajukan', $data);
		redirect('merek/monitoring');
	}

	public function hapusdraft($id)
	{
		$data = [
			'token' => $this->session->userdata('token'),
			'id' => $id,
		];
		$dokmerek = $this->lapan_api_library->call('mereks/deletedraft', $data);
		redirect('merek/monitoring');
	}

	public function input_pendesain()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('merek/input_pendesain');
		$this->load->view('templates/footer');
	}

	public function save_pendesain()
	{
		$data = [
			'nik' => htmlspecialchars($this->input->post('nik', true)),
			'nama' => htmlspecialchars($this->input->post('nama', true)),
			'token' => $this->session->userdata('token'),
		];
		$insertpendesain = $this->lapan_api_library->call('nonpegawai/insertpendesain', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pendesain baru telah ditambahkan! <a type="button" href="input" class="my-5 btn btn-success btn-sm">Tambah Merek</a></div>');
		redirect('merek/input_pendesain');
	}
}
