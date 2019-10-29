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
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 3]);
		$return_jenispaten = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 7]);
		$return_dokmerek = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', ['token' => $this->session->userdata('token'), 'id_role' => 1, 'id_haki' => 2]);
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);

		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['dokmerek'] = $return_dokmerek['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		// $this->load->model('Merek_model', 'merek');
		$getcode = $this->lapan_api_library->call('mereks/getipmancode', ['token' => $this->session->userdata('token')]);
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

		$return_pendesain = $this->lapan_api_library->call('mereks/getpendesainbyid', ['token' => $this->session->userdata('token'),'id' => $id]);
		$return_merekdraftbyid = $this->lapan_api_library->call('mereks/getmerekdraftdetail', ['token' => $this->session->userdata('token'),'id' => $id]);
		$return_patendraftdetail = $this->lapan_api_library->call('patens/getpatendraft', ['token' => $this->session->userdata('token'),'id' => $id]);

		// $return_role = $this->lapan_api_library->call('patens/getrevbyid', ['token' => $this->session->userdata('token'),'id' => $id]);
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 3]);
		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		$data['draft'] = $return_merekdraftbyid['data'][0][0];
		$data['pendesain'] = $return_pendesain['data'][0];

		$code = $data['draft']['ipman_code'];
		$return_dokumenbyipmancode = $this->lapan_api_library->call('dokumen/getdokumenbyipman', ['token' => $this->session->userdata('token'),'code' => $code]);

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

				$file_tmp = $_FILES['dokumen'.$i]['tmp_name'];
				if(!empty($_FILES['dokumen'.$i]['tmp_name']) 
				     && file_exists($_FILES['dokumen'.$i]['tmp_name'])) {
				    $data_getcontent = addslashes(file_get_contents($_FILES['dokumen'.$i]['tmp_name']));
				}
				$dokumen_base64 = base64_encode($data_getcontent);

				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$filename = $_FILES['dokumen' . $i]['name'];
					$size = $_FILES['dokumen' . $i]['size'];
					$type = $_FILES['dokumen' . $i]['type'];
					$jenisdok = $dm['id'];
				} else {
					$filename = $ipmancode . '_' . $dm['penamaan_file'];
					$size = '';
					$type = '';
					$jenisdok = $dm['id'];
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
				$md['downloadable'] = 1;
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
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$this->load->model('Merek_model', 'merek');
		$ipman = $this->input->post('ipman_code');
		$dokmerek = $this->merek->getDokumen($ipman);
		$jumlahdok = count($dokmerek);

		$post = $this->input->post();



		$data = [
			'JUDUL' => htmlspecialchars($this->input->post('judul', true)),
			'KELAS' => htmlspecialchars($this->input->post('kelas', true)),
			'UNIT_KERJA' => $this->input->post('unit_kerja'),
			'STATUS' => 19,
			'NO_HANDPHONE' => $this->input->post('no_handphone'),
			'KODE_UBAH' => $user['id'],
			'TGL_UBAH' => date('Y-m-d h:i:s'),
		];

		$this->db->where('ID', $post['id']);
		if ($this->db->update('msmerek', $data)) {
			$this->db->delete('dmerek', array('ID_MEREK' => $post['id']));
			$this->db->delete('msdokumen', array('NOMOR_PENDAFTAR' => $this->input->post('ipman_code'), 'REV' => 0, 'ROLE' => 1));

			$i = 1;
			foreach ($dokmerek as $dm) {
				$versi = $dm['REV'] + 1;
				if ($dm['SIZE']) {
					$config['file_name']          = $ipman . '_' . $dm['PENAMAAN_FILE'] . '_v' . $versi;
					$config['upload_path']          = './assets/dokumen/dokumen_merek/';
					$config['allowed_types']        = 'doc|docx|pdf';
				} else {
					$config['file_name']          = $ipman . '_' . $dm['PENAMAAN_FILE'];
					$config['upload_path']          = './assets/dokumen/dokumen_merek/';
					$config['allowed_types']        = 'doc|docx|pdf';
				}

				$this->upload->initialize($config);

				// script upload dokumen
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$this->upload->do_upload('dokumen' . $i);
					$filename[$i] = $this->upload->data('file_name');
					$size[$i] = $this->upload->data('file_size');
					$type[$i] = $this->upload->data('file_ext');
					if ($dm['SIZE']) {
						$rev[$i] = $dm['REV'] + 1;
					} else {
						$rev[$i] = $dm['REV'];
					}
					$jenisdok[$i] = $dm['ID'];
					$downloadable[$i] = $dm['DOWNLOADABLE'];
					$dateinput[$i] = $dm['TGL_INPUT'];
					$userinput[$i] = $dm['KODE_INPUT'];
					$dateubah[$i] = date('Y-m-d h:i:s');
					$userubah[$i] =  $user['id'];
				} else {
					$filename[$i] = $dm['NAME'];
					$size[$i] = $dm['SIZE'];
					$type[$i] = $dm['TYPE'];
					$rev[$i] = $dm['REV'];
					$jenisdok[$i] = $dm['ID'];
					$downloadable[$i] = $dm['DOWNLOADABLE'];
					$dateinput[$i] = $dm['TGL_INPUT'];
					$userinput[$i] = $dm['KODE_INPUT'];
					$dateubah[$i] = $dm['TGL_UBAH'];
					$userubah[$i] =  $dm['KODE_UBAH'];
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
				$kp['ID_MEREK'] = $post['id'];
				$kp['NIK'] = $kopeg['nik'];
				$this->db->insert('dmerek', $kp);
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
		$user = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$userid =  $user['id'];
		$date = date('Y-m-d h:i:s');

		$this->load->model('Merek_model', 'merek');
		$ipman = $this->input->post('ipman_code');
		$dokmerekver = $this->merek->getDokumenVer($ipman);

		$dokuver = $this->db->get_where('msjenisdokumen', array('ID_ROLE' => 2))->result_array();

		$config1['file_name']          	= $dokuver[0]['PENAMAAN_FILE'] . '_' . $this->input->post('ipman_code');
		$config1['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config1['allowed_types']        = 'doc|docx|pdf';
		$config1['overwrite']        = TRUE;

		$this->upload->initialize($config1);

		if ($dokmerekver) {
			if (!empty($_FILES['dokumen1']['name'])) {
				$this->upload->do_upload('dokumen1');
				$filename1 = $this->upload->data('file_name');
				$size1 = $this->upload->data('file_size');
				$type1 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[0]['ID'];
				$dokumen1 = array($filename1, $size1, $type1, '2', $jenisdok, $date, $userid);
			} else {
				$filename1 = $dokmerekver[0]['NAME'];
				$size1 = $dokmerekver[0]['SIZE'];
				$type1 = $dokmerekver[0]['TYPE'];
				$jenisdok = $dokmerekver[0]['ID'];
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
		$config2['overwrite']        = TRUE;


		$this->upload->initialize($config2);

		// script upload dokumen kedua
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen2']['name'])) {
				$this->upload->do_upload('dokumen2');
				$filename2 = $this->upload->data('file_name');
				$size2 = $this->upload->data('file_size');
				$type2 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[1]['ID'];
				$dokumen2 = array($filename2, $size2, $type2, '2', $jenisdok, $date, $userid);
			} else {
				$filename2 = $dokmerekver[1]['NAME'];
				$size2 = $dokmerekver[1]['SIZE'];
				$type2 = $dokmerekver[1]['TYPE'];
				$jenisdok = $dokmerekver[1]['ID'];
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
		$config3['overwrite']        = TRUE;

		$this->upload->initialize($config3);
		// script uplaod dokumen ketiga
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen3']['name'])) {
				$this->upload->do_upload('dokumen3');
				$filename3 = $this->upload->data('file_name');
				$size3 = $this->upload->data('file_size');
				$type3 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[2]['ID'];
				$dokumen3 = array($filename3, $size3, $type3, '2', $jenisdok, $date, $userid);
			} else {
				$filename3 = $dokmerekver[2]['NAME'];
				$size3 = $dokmerekver[2]['SIZE'];
				$type3 = $dokmerekver[2]['TYPE'];
				$jenisdok = $dokmerekver[2]['ID'];
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
		$config4['overwrite']        = TRUE;

		$this->upload->initialize($config4);
		// script uplaod dokumen keempat
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen4']['name'])) {
				$this->upload->do_upload('dokumen4');
				$filename4 = $this->upload->data('file_name');
				$size4 = $this->upload->data('file_size');
				$type4 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[3]['ID'];
				$dokumen4 = array($filename4, $size4, $type4, '2', $jenisdok, $date, $userid);
			} else {
				$filename4 = $dokmerekver[3]['NAME'];
				$size4 = $dokmerekver[3]['SIZE'];
				$type4 = $dokmerekver[3]['TYPE'];
				$jenisdok = $dokmerekver[3]['ID'];
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
		$config5['overwrite']        = TRUE;

		$this->upload->initialize($config5);
		// script uplaod dokumen kelima
		if ($dokmerekver) {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $this->upload->data('file_name');
				$size5 = $this->upload->data('file_size');
				$type5 = $this->upload->data('file_ext');
				$jenisdok = $dokuver[4]['ID'];
				$dokumen5 = array($filename5, $size5, $type5, '2', $jenisdok, $date, $userid);
			} else {
				$filename5 = $dokmerekver[4]['NAME'];
				$size5 = $dokmerekver[4]['SIZE'];
				$type5 = $dokmerekver[4]['TYPE'];
				$jenisdok = $dokmerekver[4]['ID'];
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
		//var_dump($dokumen);
		//die;

		$data = [
			'PEMERIKSA_MEREK' => htmlspecialchars($this->input->post('pemeriksa_merek', true)),
			'KONTAK_PEMERIKSA' => htmlspecialchars($this->input->post('kontak_pemeriksa', true)),
			'EMAIL_PEMERIKSA' => htmlspecialchars($this->input->post('email_pemeriksa', true)),
			'SERTIFIKASI' => date('Y-m-d', strtotime($this->input->post('tgl_sertifikasi'))),
			'TAHUN_PENDAFTARAN' => htmlspecialchars($this->input->post('thn_pendaftaran', true)),
			'TAHUN_GRANTED' => htmlspecialchars($this->input->post('thn_granted', true)),
			'NOMOR_PENDAFTAR' => htmlspecialchars($this->input->post('no_pendaftaran', true)),
			'STATUS' => $this->input->post('status'),
			'KETERANGAN' => $this->input->post('keterangan'),
		];
		$this->db->where('id', $this->input->post('id'));
		if ($this->db->update('msmerek', $data)) {
			if ($dokmerekver) {
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

		// $this->db->set('STATUS', 20);
		// $this->db->set('PERNAH_DIAJUKAN', 1);
		// $this->db->where('ID', $id);
		// $this->db->update('msmerek');
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
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('merek/input_pendesain', $data);
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
			$this->load->view('merek/input_pendesain', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'NIK' => htmlspecialchars($this->input->post('nik', true)),
				'NAMA' => htmlspecialchars($this->input->post('nama', true))
			];

			$this->db->insert('msnonpegawai', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pendesain baru telah ditambahkan! <a type="button" href="input" class="my-5 btn btn-success btn-sm">Tambah Merek</a></div>');
			redirect('merek/input_pendesain');
		}
	}
}
