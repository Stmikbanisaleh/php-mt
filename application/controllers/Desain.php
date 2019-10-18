<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desain extends CI_Controller
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
		$data['unitkerja'] = $this->db->get_where('msrev', array('GOLONGAN' => 3))->result_array();
		$data['dokdesain'] = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 4, 'ID_ROLE' => 1))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();

		$this->load->model('Desain_model', 'desain');
		$data['ipmancode'] = $this->desain->getIpmancode();


		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('desain/input', $data);
		$this->load->view('templates/footer');
	}

	public function edit($id)
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['desainid'] = $id;

		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['unitkerja'] = $this->db->get_where('msrev', array('golongan' => 3))->result_array();
		$data['pegawai'] = $this->db->get('mspegawai')->result_array();
		$data['nonpegawai'] = $this->db->get('msnonpegawai')->result_array();

		$this->load->model('Desain_model', 'desain');
		$data['draft'] = $this->desain->getdesainDraftDetail($id);
		$data['pendesain'] = $this->desain->getPendesainById($id);
		$code = $data['draft']['IPMAN_CODE'];

		$data['dokumen'] = $this->desain->getDokumen($code);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('desain/edit', $data);
		$this->load->view('templates/footer');
	}

	public function save()
	{

		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$dokdesain = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 4, 'ID_ROLE' => 1))->result_array();

		$post = $this->input->post();

		$userid =  $user['id'];
		$date = date('Y-m-d h:i:s');
		$ipmancode = $this->input->post('ipman_code');



		$data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
			'UNIT_KERJA' => $this->input->post('unit_kerja'),
			'STATUS' => 19,
			'NO_HANDPHONE' => $this->input->post('no_handphone'),
			'IPMAN_CODE' => $this->input->post('ipman_code'),
			'KODE_INPUT' => $user['id'],
			'TGL_INPUT' => date('Y-m-d h:i:s'),
		];
		if ($this->db->insert('msdesainindustri', $data)) {
			$dataId = $this->db->insert_id();
			$this->db->query("UPDATE msipmancode SET NO_URUT = NO_URUT + 1 WHERE KODE= 'DI' ");

			$i = 1;
			foreach ($dokdesain as $dd) {

				$config['file_name']          = $ipmancode . '_' . $dd['PENAMAAN_FILE'];
				$config['upload_path']          = './assets/dokumen/dokumen_desainindustri';
				$config['allowed_types']        = 'doc|docx|pdf';
				$config['overwrite']        = TRUE;

				$this->upload->initialize($config);

				// script uplaod dokumen pertama
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$this->upload->do_upload('dokumen' . $i);
					$filename = $this->upload->data('file_name');
					$size = $this->upload->data('file_size');
					$type = $this->upload->data('file_ext');
					$jenisdok = $dd['ID'];
				} else {
					$filename =  $ipmancode . '_' . $dd['PENAMAAN_FILE'];
					$size = '';
					$type = '';
					$jenisdok = $dd['ID'];
				}
				$dokumen = array($filename, $size, $type, '1', $jenisdok, $date, $userid);

				$md['NOMOR_PENDAFTAR'] = $this->input->post('ipman_code');
				$md['NAME'] = $dokumen[0];
				$md['SIZE'] = $dokumen[1];
				$md['TYPE'] = $dokumen[2];
				$md['ROLE'] = $dokumen[3];
				$md['JENIS_DOKUMEN'] = $dokumen[4];
				$md['TGL_INPUT'] = $dokumen[5];
				$md['KODE_INPUT'] = $dokumen[6];

				$this->db->insert('msdokumen', $md);
				$i++;
			}

			$kp = array();
			foreach ($post['pendesain'] as $kopeg) {
				$kp['ID_DESAIN_INDUSTRI'] = $dataId;
				$kp['NIK'] = $kopeg['nik'];
				$this->db->insert('ddesainindustri', $kp);
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
							Desain Industri telah ditambahkan!</div>');
			redirect('desain/monitoring');
		}
	}

	public function update()
	{
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$this->load->model('Desain_model', 'desain');
		$ipman = $this->input->post('ipman_code');
		$dokdesain = $this->desain->getDokumen($ipman);
		$jumlahdok = count($dokdesain);

		$post = $this->input->post();



		$data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
			'UNIT_KERJA' => $this->input->post('unit_kerja'),
			'STATUS' => 19,
			'NO_HANDPHONE' => $this->input->post('no_handphone'),
			'KODE_UBAH' => $user['id'],
			'TGL_UBAH' => date('Y-m-d h:i:s'),
		];

		$this->db->where('ID', $post['id']);
		if ($this->db->update('msdesainindustri', $data)) {
			$this->db->delete('ddesainindustri', array('ID_DESAIN_INDUSTRI' => $post['id']));
			$this->db->delete('msdokumen', array('NOMOR_PENDAFTAR' => $this->input->post('ipman_code'), 'REV' => 0, 'ROLE' => 1));


			$i = 1;
			foreach ($dokdesain as $dd) {
				$versi = $dd['REV'] + 1;
				if ($dd['SIZE']) {
					$config['file_name']          = $ipman . '_' . $dd['PENAMAAN_FILE'] . '_v' . $versi;
					$config['upload_path']          = './assets/dokumen/dokumen_desainindustri/';
					$config['allowed_types']        = 'doc|docx|pdf';
				} else {
					$config['file_name']          = $ipman . '_' . $dd['PENAMAAN_FILE'];
					$config['upload_path']          = './assets/dokumen/dokumen_desainindustri/';
					$config['allowed_types']        = 'doc|docx|pdf';
				}

				$this->upload->initialize($config);

				// script upload dokumen
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$this->upload->do_upload('dokumen' . $i);
					$filename[$i] = $this->upload->data('file_name');
					$size[$i] = $this->upload->data('file_size');
					$type[$i] = $this->upload->data('file_ext');
					if ($dd['SIZE']) {
						$rev[$i] = $dd['REV'] + 1;
					} else {
						$rev[$i] = $dd['REV'];
					}
					$jenisdok[$i] = $dd['ID'];
					$downloadable[$i] = $dd['DOWNLOADABLE'];
					$dateinput[$i] = $dd['TGL_INPUT'];
					$userinput[$i] = $dd['KODE_INPUT'];
					$dateubah[$i] = date('Y-m-d h:i:s');
					$userubah[$i] =  $user['id'];
				} else {
					$filename[$i] = $dd['NAME'];
					$size[$i] = $dd['SIZE'];
					$type[$i] = $dd['TYPE'];
					$rev[$i] = $dd['REV'];
					$jenisdok[$i] = $dd['ID'];
					$downloadable[$i] = $dd['DOWNLOADABLE'];
					$dateinput[$i] = $dd['TGL_INPUT'];
					$userinput[$i] = $dd['KODE_INPUT'];
					$dateubah[$i] = $dd['TGL_UBAH'];
					$userubah[$i] =  $dd['KODE_UBAH'];
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
			foreach ($post['pendesain'] as $kopeg) {
				$kp['ID_DESAIN_INDUSTRI'] = $post['id'];
				$kp['NIK'] = $kopeg['nik'];
				$this->db->insert('ddesainindustri', $kp);
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Desain Industri telah diubah!</div>');
			redirect('desain/monitoring');
		}
	}

	public function monitoring()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Desain_model', 'desain');
		$data['getDesain'] = $this->db->get('msdesainindustri')->result_array();
		$data['getDraft'] = $this->desain->getDesainDraft();
		$data['getDiajukan'] = $this->desain->getDesainDiajukan();
		$data['getDisetujui'] = $this->desain->getDesainDisetujui();
		$data['getDitolak'] = $this->desain->getDesainDitolak();
		$data['getDitangguhkan'] = $this->desain->getDesainDitangguhkan();
		$data['getPendesain'] = $this->desain->getPendesain();
		$data['getPendesainNon'] = $this->desain->getPendesainNon();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('desain/monitoring', $data);
		$this->load->view('templates/footer');
	}

	public function monitoring_verifikator()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		$data['unitkerja'] = $this->db->get_where('msrev', array('GOLONGAN' => 3))->result_array();

		$this->load->model('Desain_model', 'desain');
		$data['getDesain'] = $this->db->get('msdesainindustri')->result_array();
		$data['getDiajukan'] = $this->desain->getDesainDiajukan();
		$data['getDisetujui'] = $this->desain->getDesainDisetujui();
		$data['getDitolak'] = $this->desain->getDesainDitolak();
		$data['getDitangguhkan'] = $this->desain->getDesainDitangguhkan();
		$data['getPendesain'] = $this->desain->getPendesain();
		$data['getPendesainNon'] = $this->desain->getPendesainNon();

		if ($roleId == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('desain/monitoring_ver', $data);
			$this->load->view('templates/footer');
		}
	}

	public function export()
	{
		$this->load->model('desain_model', 'desain');
		$desain = $this->desain->getExportDiajukan();

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
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "PENDESAIN");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		// Panggil function view yang ada di desainModel untuk menampilkan semua data desainnya
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($desain as $pend) { // Lakukan looping pada variabel desain
			$peg = array($this->desain->getPendesainExport($pend['ID']));
			foreach ($peg as $pp) {
				$c = count($pp);
				switch ($c) {
					case "1":
						$arraypendesain = array($pp[0]['NAMA']);
						break;
					case "2":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA']);
						break;
					case "3":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA']);
						break;
					case "4":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA']);
						break;
					case "5":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA']);
						break;
					case "6":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA']);
						break;
					case "7":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA']);
						break;
					case "8":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA']);
						break;
					case "9":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA']);
						break;
					case "10":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA']);
						break;
					case "11":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA']);
						break;
					case "12":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA']);
						break;
					case "13":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA']);
						break;
					case "14":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA']);
						break;
					case "15":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA']);
						break;
					case "16":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA']);
						break;
					case "17":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA']);
						break;
					case "18":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA']);
						break;
					case "19":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA'], $pp[18]['NAMA']);
						break;
					case "20":
						$arraypendesain = array($pp[0]['NAMA'], $pp[1]['NAMA'], $pp[2]['NAMA'], $pp[3]['NAMA'], $pp[4]['NAMA'], $pp[5]['NAMA'], $pp[6]['NAMA'], $pp[7]['NAMA'], $pp[8]['NAMA'], $pp[9]['NAMA'], $pp[10]['NAMA'], $pp[11]['NAMA'], $pp[12]['NAMA'], $pp[13]['NAMA'], $pp[14]['NAMA'], $pp[15]['NAMA'], $pp[16]['NAMA'], $pp[17]['NAMA'], $pp[18]['NAMA'], $pp[19]['NAMA']);
						break;
				}
				$pendesain = implode(" , ", $arraypendesain);
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $pend['JUDUL']);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $pend['UNIT_KERJA']);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $pend['STATUS']);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $pendesain);

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
		$excel->getActiveSheet(0)->setTitle("Laporan Desain Industri");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="desain.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
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
		$data['dokdesain'] = $this->db->get_where('msjenisdokumen', array('ID_HAKI' => 4))->result_array();
		$data['newdokver'] = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$this->load->model('Desain_model', 'desain');
		$data['diajukan'] = $this->desain->getDesainDiajukanDetail($id);
		$data['pendesain'] = $this->desain->getPendesainById($id);

		$code = $data['diajukan']['IPMAN_CODE'];
		$data['dokumen'] = $this->desain->getDokumen($code);
		$data['dokver'] = $this->db->get_where('msdokumen', array('NOMOR_PENDAFTAR' => $code, 'ROLE' => 2))->result_array();


		if ($roleId == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('desain/verifikasi', $data);
			$this->load->view('templates/footer');
		}
	}

	public function save_verifikasi()
	{
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$userid =  $user['id'];
		$date = date('Y-m-d h:i:s');

		$this->load->model('Desain_model', 'desain');
		$ipman = $this->input->post('ipman_code');
		$dokdesainver = $this->desain->getDokumenVer($ipman);

		$dokuver = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$config1['file_name']          	= $dokuver[0]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config1['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config1['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config1);

		if ($dokdesainver) {
			if (!empty($_FILES['dokumen1']['name'])) {
				$this->upload->do_upload('dokumen1');
				$filename1 = $this->upload->data('file_name');
				$size1 = $this->upload->data('file_size');
				$type1 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[0]['ID'];
				$dokumen1 = array($filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				$filename1 = $dokdesainver[0]['NAME'];
				$size1 = $dokdesainver[0]['SIZE'];
				$type1 = $dokdesainver[0]['TYPE'];
				$jenisdok = $dokdesainver[0]['ID'];
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
		if ($dokdesainver) {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $this->upload->data('file_name');
				$size2 = $this->upload->data('file_size');
				$type2 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[1]['ID'];
				$dokumen2 = array($filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				$filename2 = $dokdesainver[1]['NAME'];
				$size2 = $dokdesainver[1]['SIZE'];
				$type2 = $dokdesainver[1]['TYPE'];
				$jenisdok = $dokdesainver[1]['ID'];
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
		if ($dokdesainver) {
			if (!empty($_FILES['dokumen3']['name'])) {
				$this->upload->do_upload('dokumen3');
				$filename3 = $this->upload->data('file_name');
				$size3 = $this->upload->data('file_size');
				$type3 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[2]['ID'];
				$dokumen3 = array($filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokdesainver[2]['NAME'];
				$size3 = $dokdesainver[2]['SIZE'];
				$type3 = $dokdesainver[2]['TYPE'];
				$jenisdok = $dokdesainver[2]['ID'];
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
		if ($dokdesainver) {
			if (!empty($_FILES['dokumen4']['name'])) {
				$this->upload->do_upload('dokumen4');
				$filename4 = $this->upload->data('file_name');
				$size4 = $this->upload->data('file_size');
				$type4 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[3]['ID'];
				$dokumen4 = array($filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokdesainver[3]['NAME'];
				$size4 = $dokdesainver[3]['SIZE'];
				$type4 = $dokdesainver[3]['TYPE'];
				$jenisdok = $dokdesainver[3]['ID'];
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
		if ($dokdesainver) {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $this->upload->data('file_name');
				$size5 = $this->upload->data('file_size');
				$type5 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[4]['ID'];
				$dokumen5 = array($filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokdesainver[4]['NAME'];
				$size5 = $dokdesainver[4]['SIZE'];
				$type5 = $dokdesainver[4]['TYPE'];
				$jenisdok = $dokdesainver[4]['ID'];
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
			'PEMERIKSA_DESAIN' => htmlspecialchars($this->input->post('pemeriksa_desain', true)),
			'KONTAK_PEMERIKSA' => htmlspecialchars($this->input->post('kontak_pemeriksa', true)),
			'EMAIL_PEMERIKSA' => htmlspecialchars($this->input->post('email_pemeriksa', true)),
			'SERTIFIKASI' => date('Y-m-d', strtotime($this->input->post('tgl_sertifikasi'))),
			'NOMOR_PENDAFTAR' => $this->input->post('no_pendaftaran'),
			'TAHUN_PENDAFTAR' => $this->input->post('thn_pendaftaran'),
			'TAHUN_GRANTED' => $this->input->post('thn_granted'),
			'NOMOR_DESAIN' => $this->input->post('no_desain'),
			'STATUS' => $this->input->post('status'),
			'KETERANGAN' => $this->input->post('keterangan'),
		];

		$this->db->where('id', $this->input->post('id'));
		if ($this->db->update('msdesainindustri', $data)) {
			if ($dokdesainver) {
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
		redirect('desain/monitoring_verifikator');
	}

	public function ajukan($id)
	{
		$this->db->set('STATUS', 20);
		$this->db->set('PERNAH_DIAJUKAN', 1);
		$this->db->where('ID', $id);
		$this->db->update('msdesainindustri');
		redirect('desain/monitoring');
	}

	public function hapusdraft($id)
	{
		$this->db->trans_begin();

		$this->db->query('DELETE FROM msdesainindustri WHERE ID=' . $id);
		$this->db->query('DELETE FROM ddesainindustri WHERE ID_DESAIN_INDUSTRI=' . $id);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			redirect('desain/monitoring');
		}
	}

	public function input_pendesain()
	{
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('desain/input_pendesain', $data);
		$this->load->view('templates/footer');
	}

	public function save_pendesain()
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
			$this->load->view('desain/input_pendesain', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'NIK' => htmlspecialchars($this->input->post('nik', true)),
				'NAMA' => htmlspecialchars($this->input->post('nama', true))
			];

			$this->db->insert('msnonpegawai', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pendesain baru telah ditambahkan! <a type="button" href="input" class="my-5 btn btn-success btn-sm">Tambah Desain Industri</a></div>');
			redirect('desain/input_pendesain');
		}
	}
}
