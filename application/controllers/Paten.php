<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paten extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email')) {
			redirect('auth');
		}
		$this->load->helper(array('form', 'url'));
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
		$data['unitkerja'] = $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		$data['jenispaten'] = $this->db->get_where('msrev', array('golongan' => 7))->result_array();
		$data['dokpaten'] = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 1, 'ID_ROLE' => 1))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/input', $data);
		$this->load->view('templates/footer');
	}

	public function edit($id)
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['patenid'] = $id;

		$data['paten'] = $this->db->get_where('mspaten', array('ID' => $id))->row_array();
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['unitkerja'] = $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		$data['jenispaten'] = $this->db->get_where('msrev', array('golongan' => 7))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();

		$this->load->model('Paten_model', 'paten');
		$data['draft'] = $this->paten->getPatenDraftDetail($id);
		$data['inventor'] = $this->paten->getInventorById($id);
		$code = $data['draft']['IPMAN_CODE'];

		$data['dokumen'] = $this->paten->getDokumen($code);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/edit', $data);
		$this->load->view('templates/footer');
	}

	public function save()
	{
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$dokpaten = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 1, 'ID_ROLE' => 1))->result_array();

		$this->load->model('Paten_model', 'paten');
		$pb = $this->paten->getCodePb();
		$ps = $this->paten->getCodePs();

		$jenispaten = $this->input->post('jenis_paten');

		switch ($jenispaten) {
			case "24":
				$ipmancode = $pb;
				$kode = 'PB';
				break;

			case "25":
				$ipmancode = $ps;
				$kode = 'PS';
				break;
		}

		$post = $this->input->post();

		$date = date('Y-m-d h:i:s');
		$userid =  $user['id'];



		//Upload Dokumen Asbstrak
		$configab['file_name']          =  $ipmancode . '_abstrak';
		$configab['upload_path']          = './assets/dokumen/dokumen_paten/';
		$configab['allowed_types']        = 'txt';
		$configab['overwrite']        = TRUE;

		$this->upload->initialize($configab);

		if ($this->upload->do_upload('abstrak')) {
			$filename = $this->upload->data('file_name');
			$fileabstrak = $filename;
		} else {
			$this->session->set_flashdata('message_errorabs', '<div class="alert alert-danger my-5" role="alert">
            File Abstrak belum terunggah!</div>');
			redirect('paten/input');
		}

		//Upload Foto paten yang ingin ditampilkan
		$cgambar['file_name']          =  $ipmancode . 'gambar_paten_';
		$cgambar['upload_path']          = './assets/dokumen/dokumen_paten/';
		$cgambar['allowed_types']        = 'jpg|jpeg';
		$cgambar['overwrite']        = TRUE;

		$this->upload->initialize($cgambar);

		if ($this->upload->do_upload('gambar')) {
			$filename = $this->upload->data('file_name');
			$gambarpaten = $filename;
		} else {
			$this->session->set_flashdata('message_errorgam', '<div class="alert alert-danger my-5" role="alert">
            Gambar belum terunggah!</div>');
			redirect('paten/input');
		}

		$data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
			'ABSTRAK' => $fileabstrak,
			'GAMBAR' => $gambarpaten,
			'UNIT_KERJA' => $this->input->post('unit_kerja'),
			'BIDANG_INVENSI' => htmlspecialchars($this->input->post('bidang_invensi', true)),
			'JENIS_PATEN' => $this->input->post('jenis_paten'),
			'STATUS' => 19,
			'NO_HANDPHONE' => $this->input->post('no_handphone'),
			'IPMAN_CODE' => $ipmancode,
			'KODE_INPUT' => $user['id'],
			'TGL_INPUT' => date('Y-m-d h:i:s'),
		];

		if ($this->db->insert('mspaten', $data)) {
			$dataId = $this->db->insert_id();
			$this->db->query("UPDATE msipmancode SET NO_URUT = NO_URUT + 1 WHERE KODE='" . $kode . "'");

			$i = 1;
			foreach ($dokpaten as $dp) {

				$config['file_name']          = $ipmancode . '_' . $dp['PENAMAAN_FILE'];
				$config['upload_path']          = './assets/dokumen/dokumen_paten/';
				$config['allowed_types']        = 'doc|docx|pdf';
				$config['overwrite']        = TRUE;

				$this->upload->initialize($config);

				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$this->upload->do_upload('dokumen' . $i);
					$size = $this->upload->data('file_size');
					$type = $this->upload->data('file_ext');
					$filename = $this->upload->data('file_name');
					$jenisdok = $dp['ID'];
					$downloadable = $dp['DOWNLOADABLE'];
				} else {
					$filename = $ipmancode . '_' . $dp['PENAMAAN_FILE'];
					$size = '';
					$type = '';
					$jenisdok = $dp['ID'];
					$downloadable = 0;
				}
				$dokumen = array($filename, $size, $type, 1, $jenisdok, $downloadable, $date, $userid);
				$md['NOMOR_PENDAFTAR'] = $ipmancode;
				$md['NAME'] = $dokumen[0];
				$md['SIZE'] = $dokumen[1];
				$md['TYPE'] = $dokumen[2];
				$md['ROLE'] = $dokumen[3];
				$md['JENIS_DOKUMEN'] = $dokumen[4];
				$md['DOWNLOADABLE'] = $dokumen[5];
				$md['TGL_INPUT'] = $dokumen[6];
				$md['KODE_INPUT'] = $dokumen[7];

				$this->db->insert('msdokumen', $md);
				$i++;
			}

			$kp = array();
			foreach ($post['inventor'] as $kopeg) {
				$kp['ID_PATEN'] = $dataId;
				$kp['NIK'] = $kopeg['nik'];
				$this->db->insert('dpaten', $kp);
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Paten telah ditambahkan!</div>');
			redirect('paten/monitoring');
		}
	}

	public function update()
	{
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$this->load->model('Paten_model', 'paten');
		$ipman = $this->input->post('ipman_code');
		$dokpaten = $this->paten->getDokumen($ipman);
		$jumlahdok = count($dokpaten);

		$post = $this->input->post();



		//Upload Dokumen Asbstrak
		$configab['file_name']          = $ipman . '_abstrak';
		$configab['upload_path']          = './assets/dokumen/dokumen_paten/';
		$configab['allowed_types']        = 'txt';
		$configab['overwrite']        = TRUE;

		$this->upload->initialize($configab);

		if ($this->upload->do_upload('abstrak')) {
			$fileabstrak = $this->upload->data('file_name');
		} else {
			$fileabstrak = '';
		}

		$configgam['file_name']          = $ipman . '_gambar_paten';
		$configgam['upload_path']          = './assets/dokumen/dokumen_paten/';
		$configgam['allowed_types']        = 'jpg|png';
		$configgam['overwrite']        = TRUE;

		$this->upload->initialize($configgam);

		if ($this->upload->do_upload('gambar')) {
			$gambarpaten = $this->upload->data('file_name');
		} else {
			$gambarpaten = '';
		}

		$data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
			'ABSTRAK' => $fileabstrak,
			'GAMBAR' => $gambarpaten,
			'BIDANG_INVENSI' => htmlspecialchars($this->input->post('bidang_invensi', true)),
			'UNIT_KERJA' => $this->input->post('unit_kerja'),
			'STATUS' => 19,
			'NO_HANDPHONE' => $this->input->post('no_handphone'),
			'IPMAN_CODE' => $this->input->post('ipman_code'),
			'KODE_UBAH' => $user['id'],
			'TGL_UBAH' => date('Y-m-d h:i:s'),
		];

		$this->db->where('ID', $post['id']);
		if ($this->db->update('mspaten', $data)) {
			$this->db->delete('dpaten', array('ID_PATEN' => $post['id']));
			$this->db->delete('msdokumen', array('NOMOR_PENDAFTAR' => $this->input->post('ipman_code'), 'REV' => 0, 'ROLE' => 1));

			$i = 1;
			foreach ($dokpaten as $dp) {
				$versi = $dp['REV'] + 1;
				if ($dp['SIZE']) {
					$config['file_name']          =  $ipman . '_' .  $dp['PENAMAAN_FILE'] . '_v' . $versi;
					$config['upload_path']          = './assets/dokumen/dokumen_paten/';
					$config['allowed_types']        = 'doc|docx|pdf';
				} else {
					$config['file_name']          = $ipman . '_' . $dp['PENAMAAN_FILE'];
					$config['upload_path']          = './assets/dokumen/dokumen_paten/';
					$config['allowed_types']        = 'doc|docx|pdf';
				}

				$this->upload->initialize($config);

				// script upload dokumen
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$this->upload->do_upload('dokumen' . $i);
					$filename[$i] = $this->upload->data('file_name');
					$size[$i] = $this->upload->data('file_size');
					$type[$i] = $this->upload->data('file_ext');
					if ($dp['SIZE']) {
						$rev[$i] = $dp['REV'] + 1;
					} else {
						$rev[$i] = $dp['REV'];
					}
					$jenisdok[$i] = $dp['ID'];
					$downloadable[$i] = $dp['DOWNLOADABLE'];
					$dateinput[$i] = $dp['TGL_INPUT'];
					$userinput[$i] = $dp['KODE_INPUT'];
					$dateubah[$i] = date('Y-m-d h:i:s');
					$userubah[$i] =  $user['id'];
				} else {
					$filename[$i] = $dp['NAME'];
					$size[$i] = $dp['SIZE'];
					$type[$i] = $dp['TYPE'];
					$rev[$i] = $dp['REV'];
					$jenisdok[$i] = $dp['ID'];
					$downloadable[$i] = $dp['DOWNLOADABLE'];
					$dateinput[$i] = $dp['TGL_INPUT'];
					$userinput[$i] = $dp['KODE_INPUT'];
					$dateubah[$i] = $dp['TGL_UBAH'];
					$userubah[$i] =  $dp['KODE_UBAH'];
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

			$md = array();
			foreach ($arraydokumen as $dok) :
				$md['NOMOR_PENDAFTAR'] = $this->input->post('ipman_code');
				$md['NAME'] = $dok[0];
				$md['SIZE'] = $dok[1];
				$md['TYPE'] = $dok[2];
				$md['REV'] = $dok[3];
				$md['ROLE'] = $dok[4];
				$md['JENIS_DOKUMEN'] = $dok[5];
				$md['DOWNLOADABLE'] = $dok[6];
				$md['TGL_INPUT'] = $dok[7];
				$md['KODE_INPUT'] = $dok[8];
				$md['TGL_UBAH'] = $dok[9];
				$md['KODE_UBAH'] = $dok[10];
				$this->db->insert('msdokumen', $md);
			endforeach;

			$kp = array();
			foreach ($post['inventor'] as $kopeg) {
				$kp['ID_PATEN'] = $post['id'];
				$kp['NIK'] = $kopeg['nik'];
				$this->db->insert('dpaten', $kp);
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Paten telah diubah!</div>');
			redirect('paten/monitoring');
		}
	}


	public function monitoring()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$this->load->model('User_model', 'user');
		$data['getUser'] = $this->user->getUserRole();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Paten_model', 'paten');
		$data['getPaten'] = $this->db->get('mspaten')->result_array();
		$data['getDraft'] = $this->paten->getPatenDraft();
		$data['getDiajukan'] = $this->paten->getPatenDiajukan();
		$data['getDisetujui'] = $this->paten->getPatenDisetujui();
		$data['getDitolak'] = $this->paten->getPatenDitolak();
		$data['getDitangguhkan'] = $this->paten->getPatenDitangguhkan();
		$data['getInventor'] = $this->paten->getInventor();
		$data['getInventorNon'] = $this->paten->getInventorNon();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/monitoring', $data);
		$this->load->view('templates/footer');
	}

	public function export()
	{
		$this->load->model('Paten_model', 'paten');
		$paten = $this->paten->getExportDiajukan();

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
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "FILLING DATE");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "STATUS");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "INVENTOR");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		// Panggil function view yang ada di patenModel untuk menampilkan semua data patennya
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($paten as $pat) { // Lakukan looping pada variabel paten
			$peg = array($this->paten->getInventorExport($pat['ID']));
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
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $pat['JUDUL']);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $pat['UNIT_KERJA']);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, date('d-m-Y', strtotime($pat['FILLING'])));
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $pat['STATUS']);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $inventor);

				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
			}
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Paten");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Paten.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	public function draftdetail($id)
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$this->load->model('User_model', 'user');
		$data['getUser'] = $this->user->getUserRole();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Paten_model', 'paten');
		$data['getDraftDetail'] = $this->paten->getPatenDraftDetail($id);
		$data['kodepeg'] = $this->db->get_where('dpaten', array('ID_PATEN' => $id))->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/draft_detail', $data);
		$this->load->view('templates/footer');
	}

	public function monitoring_verifikator()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$this->load->model('User_model', 'user');
		$data['getUser'] = $this->user->getUserRole();

		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Paten_model', 'paten');
		$data['getPaten'] = $this->db->get('mspaten')->result_array();
		$data['getDiajukan'] = $this->paten->getPatenDiajukan();
		$data['getDisetujui'] = $this->paten->getPatenDisetujui();
		$data['getDitolak'] = $this->paten->getPatenDitolak();
		$data['getDitangguhkan'] = $this->paten->getPatenDitangguhkan();
		$data['getInventor'] = $this->paten->getInventor();
		$data['getInventorNon'] = $this->paten->getInventorNon();

		if ($roleId == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('paten/monitoring_ver', $data);
			$this->load->view('templates/footer');
		}
	}

	public function verifikasi($id)
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['unitkerja'] = $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		$data['status'] = $this->db->get_where('msrev', array('golongan' => 6))->result_array();
		$data['tindaklanjut'] = $this->db->get_where('msrev', array('golongan' => 12))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();
		$data['paten'] = $this->db->get_where('mspaten', array('ID' => $id))->row_array();
		$data['dokpaten'] = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 1))->result_array();
		$data['newdokver'] = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$this->load->model('Paten_model', 'paten');
		$data['diajukan'] = $this->paten->getPatenDiajukanDetail($id);
		$data['inventor'] = $this->paten->getInventorById($id);

		$code = $data['diajukan']['IPMAN_CODE'];
		$data['dokumen'] = $this->paten->getDokumen($code);
		$data['dokver'] = $this->db->get_where('msdokumen', array('NOMOR_PENDAFTAR' => $code, 'ROLE' => 2))->result_array();

		if ($roleId == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('paten/verifikasi', $data);
			$this->load->view('templates/footer');
		}
	}

	public function save_verifikasi()
	{


		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$userid =  $user['id'];
		$date = date('Y-m-d h:i:s');

		$this->load->model('Paten_model', 'paten');
		$ipman = $this->input->post('ipman_code');
		$dokpatenver = $this->paten->getDokumenVer($ipman);

		$dokuver = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$config1['file_name']          	= $dokuver[0]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config1['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config1['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config1);

		if ($dokpatenver) {
			if (!empty($_FILES['dokumen1']['name'])) {
				$this->upload->do_upload('dokumen1');
				$filename1 = $this->upload->data('file_name');
				$size1 = $this->upload->data('file_size');
				$type1 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[0]['ID'];
				$dokumen1 = array($filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				$filename1 = $dokpatenver[0]['NAME'];
				$size1 = $dokpatenver[0]['SIZE'];
				$type1 = $dokpatenver[0]['TYPE'];
				$jenisdok = $dokpatenver[0]['ID'];
				$dokumen1 = array($filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen1']['name'])) {
				$this->upload->do_upload('dokumen1');
				$filename1 = $this->upload->data('file_name');
				$size1 = $this->upload->data('file_size');
				$type1 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[0]['ID'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen1 = array($filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				$filename1 = $dokuver[0]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver[0]['ID'];
				$dokumen1 = array($filename1, '', '', '2', $jenisdok, $date, $userid);
			}
		}



		$config2['file_name']          	= $dokuver[1]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config2['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config2['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config2);

		// script upload dokumen kedua
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $this->upload->data('file_name');
				$size2 = $this->upload->data('file_size');
				$type2 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[1]['ID'];
				$dokumen2 = array($filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				$filename2 = $dokpatenver[1]['NAME'];
				$size2 = $dokpatenver[1]['SIZE'];
				$type2 = $dokpatenver[1]['TYPE'];
				$jenisdok = $dokpatenver[1]['ID'];
				$dokumen2 = array($filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $this->upload->data('file_name');
				$size2 = $this->upload->data('file_size');
				$type2 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[1]['ID'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen2 = array($filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				$filename2 = $dokuver[1]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver[1]['ID'];
				$dokumen2 = array($filename2, '', '', '2', $jenisdok, $date, $userid);
			}
		}


		$config3['file_name']          	= $dokuver[2]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config3['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config3['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config3);
		// script uplaod dokumen ketiga
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen3']['name'])) {
				$this->upload->do_upload('dokumen3');
				$filename3 = $this->upload->data('file_name');
				$size3 = $this->upload->data('file_size');
				$type3 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[2]['ID'];
				$dokumen3 = array($filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokpatenver[2]['NAME'];
				$size3 = $dokpatenver[2]['SIZE'];
				$type3 = $dokpatenver[2]['TYPE'];
				$jenisdok = $dokpatenver[2]['ID'];
				$dokumen3 = array($filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen3']['name'])) {
				$this->upload->do_upload('dokumen3');
				$filename3 = $this->upload->data('file_name');
				$size3 = $this->upload->data('file_size');
				$type3 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[2]['ID'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen3 = array($filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokuver[2]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver[2]['ID'];
				$dokumen3 = array($filename3, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$config4['file_name']          	= $dokuver[3]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config4['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config4['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config4);
		// script uplaod dokumen keempat
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen4']['name'])) {
				$this->upload->do_upload('dokumen4');
				$filename4 = $this->upload->data('file_name');
				$size4 = $this->upload->data('file_size');
				$type4 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[3]['ID'];
				$dokumen4 = array($filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokpatenver[3]['NAME'];
				$size4 = $dokpatenver[3]['SIZE'];
				$type4 = $dokpatenver[3]['TYPE'];
				$jenisdok = $dokpatenver[3]['ID'];
				$dokumen4 = array($filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen4']['name'])) {
				$this->upload->do_upload('dokumen4');
				$filename4 = $this->upload->data('file_name');
				$size4 = $this->upload->data('file_size');
				$type4 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[3]['ID'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen4 = array($filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokuver[3]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver[3]['ID'];
				$dokumen4 = array($filename4, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$config5['file_name']          	= $dokuver[4]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config5['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config5['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config5);
		// script uplaod dokumen kelima
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $this->upload->data('file_name');
				$size5 = $this->upload->data('file_size');
				$type5 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[4]['ID'];
				$dokumen5 = array($filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokpatenver[4]['NAME'];
				$size5 = $dokpatenver[4]['SIZE'];
				$type5 = $dokpatenver[4]['TYPE'];
				$jenisdok = $dokpatenver[4]['ID'];
				$dokumen5 = array($filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $this->upload->data('file_name');
				$size5 = $this->upload->data('file_size');
				$type5 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[4]['ID'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen5 = array($filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokuver[4]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
				$jenisdok = $dokuver[4]['ID'];
				$dokumen5 = array($filename5, '', '', '2', $jenisdok, $date, $userid);
			}
		}

		$dokumen = array($dokumen1, $dokumen2, $dokumen3, $dokumen4, $dokumen5);

		$data = [
			'NOMOR_PERMOHONAN' => $this->input->post('no_permohonan'),
			'PEMERIKSA_PATEN' => htmlspecialchars($this->input->post('pemeriksa_paten', true)),
			'KONTAK_PEMERIKSA' => htmlspecialchars($this->input->post('kontak_pemeriksa', true)),
			'EMAIL_PEMERIKSA' => htmlspecialchars($this->input->post('email_pemeriksa', true)),
			'SERTIFIKASI' => date('Y-m-d', strtotime($this->input->post('tgl_sertifikasi'))),
			'FILLING' => date('Y-m-d', strtotime($this->input->post('filling_date'))),
			'FORMALITAS' => date('Y-m-d', strtotime($this->input->post('tgl_persyaratan'))),
			'PUBLISH' => date('Y-m-d', strtotime($this->input->post('tgl_publikasi'))),
			'PEMBAYARAN' => date('Y-m-d', strtotime($this->input->post('tgl_pembayaran'))),
			'PEMBERIAN' => date('Y-m-d', strtotime($this->input->post('tgl_pemberian'))),
			'NOMOR_PATEN' => $this->input->post('no_paten'),
			'TAHUN_GRANTED' => $this->input->post('thn_granted'),
			'STATUS' => $this->input->post('status'),
			'TINDAK_LANJUT' => $this->input->post('tindak_lanjut'),
			'KETERANGAN' => htmlspecialchars($this->input->post('keterangan', true)),
		];


		$this->db->where('id', $this->input->post('id'));
		if ($this->db->update('mspaten', $data)) {
			if ($dokpatenver) {
				$this->db->delete('msdokumen', array('NOMOR_PENDAFTAR' => $this->input->post('ipman_code'), 'ROLE' => 2));

				foreach ($dokumen as $dok) :
					if (!empty($dok)) {
						$md['NOMOR_PENDAFTAR'] = $this->input->post('ipman_code');
						$md['NAME'] = $dok[0];
						$md['SIZE'] = $dok[1];
						$md['TYPE'] = $dok[2];
						$md['ROLE'] = 2;
						$md['JENIS_DOKUMEN'] = $dok[4];
						$md['TGL_INPUT'] = $dok[5];
						$md['KODE_INPUT'] = $dok[6];

						$this->db->insert('msdokumen', $md);
					}
				endforeach;
			} else {

				foreach ($dokumen as $dok) :
					if (!empty($dok)) {
						$md['NOMOR_PENDAFTAR'] = $this->input->post('ipman_code');
						$md['NAME'] = $dok[0];
						$md['SIZE'] = $dok[1];
						$md['TYPE'] = $dok[2];
						$md['ROLE'] = 2;
						$md['JENIS_DOKUMEN'] = $dok[4];
						$md['TGL_INPUT'] = $dok[5];
						$md['KODE_INPUT'] = $dok[6];

						$this->db->insert('msdokumen', $md);
					}
				endforeach;
			}
		}
		redirect('paten/monitoring_verifikator');
	}

	public function ajukan($id)
	{
		$this->db->set('STATUS', 20);
		$this->db->set('PERNAH_DIAJUKAN', 1);
		$this->db->where('ID', $id);
		$this->db->update('mspaten');
		redirect('paten/monitoring');
	}

	public function hapusdraft($id)
	{
		$this->db->trans_begin();

		$this->db->query('DELETE FROM mspaten WHERE ID=' . $id);
		$this->db->query('DELETE FROM dpaten WHERE ID_PATEN=' . $id);
		$this->db->query('DELETE FROM msdokumen WHERE NOMOR_PENDAFTAR=' . $id);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			redirect('paten/monitoring');
		}
	}

	function reload_paten($id = '')
	{
		$jenis_paten = $this->input->post('jenis_paten');
		if ($id != '') {
			$jenis_paten = $id;
		}

		$this->load->model('Paten_model', 'paten');
		$ipman = $this->paten->getIpmancode($jenis_paten);

		echo json_encode($ipman);
	}

	public function timeline()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/timeline', $data);
		$this->load->view('templates/footer');
	}

	public function input_inventor()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/input_inventor', $data);
		$this->load->view('templates/footer');
	}

	public function save_inventor()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nik', 'NIK', 'required|is_unique[msnonpegawai.NIK]|numeric');
		$this->form_validation->set_rules('nama', 'nama', 'required');

		if ($this->form_validation->run($this) == false) {
			$data['user'] = $this->db->get_where('msuser', ['email' =>
			$this->session->userdata('email')])->row_array();
			$roleId = $data['user']['role_id'];
			$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('paten/input_inventor', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'NIK' => htmlspecialchars($this->input->post('nik', true)),
				'NAMA' => htmlspecialchars($this->input->post('nama', true))
			];

			$this->db->insert('msnonpegawai', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Inventor Baru telah ditambahkan! <a type="button" href="input" class="my-5 btn btn-success btn-sm">Tambah Paten</a></div>');
			redirect('paten/input_inventor');
		}
	}
}
