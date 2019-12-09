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
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 3]);
		$return_jenispaten = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 7]);
		$return_dokpaten = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', ['token' => $this->session->userdata('token'), 'id_role' => 1, 'id_haki' => 1]);
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);

		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['jenispaten'] = $return_jenispaten['data']['rows'];
		$data['dokpaten'] = $return_dokpaten['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('paten/input', $data);
		$this->load->view('templates/footer');
	}

	public function edit($id)
	{
		$return_pegawai = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
		$return_nonpegawai = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);

		$data_inventor = [
						'token' => $this->session->userdata('token'),
						'id' => $id
					];
		$return_inventor = $this->lapan_api_library->call('patens/getinventorbyid', $data_inventor);
		$return_patenbyid = $this->lapan_api_library->call('patens/getpatenbyid', ['token' => $this->session->userdata('token'),'id' => $id]);

		$return_patendraftdetail = $this->lapan_api_library->call('patens/getpatendraft', ['token' => $this->session->userdata('token'),'id' => $id]);
		$return_unitkerja = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 3]);
		$return_jenispaten = $this->lapan_api_library->call('rev/', ['token' => $this->session->userdata('token'),'golongan' => 7]);

		$data['patenid'] = $id;
		$data['paten'] = $return_patenbyid['data']['rows'][0];
		$data['unitkerja'] = $return_unitkerja['data']['rows'];
		$data['jenispaten'] = $return_jenispaten['data']['rows'];
		$data['pegawai'] = $return_pegawai['data']['rows'];
		$data['nonpegawai'] = $return_nonpegawai['data']['rows'];

		$data['draft'] = $return_patendraftdetail['data'][0][0];
		$data['inventor'] = $return_inventor['data'][0];

		$code = $data['draft']['ipman_code'];
		$return_dokumenbyipmancode = $this->lapan_api_library->call('dokumen/getdokumenbyipman', ['token' => $this->session->userdata('token'),'code' => $code]);
		$data['dokumen'] = $return_dokumenbyipmancode['data'][0];



		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('paten/edit', $data);
		$this->load->view('templates/footer');
	}

	public function save()
	{
		$dokpaten = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', ['token' => $this->session->userdata('token'), 'id_role' => 1, 'id_haki' => 1]);
		$jenispaten = $this->input->post('jenis_paten');
		$userid =  $this->session->userdata('user_id');
		$date = date('Y-m-d h:i:s');
		switch ($jenispaten) {
			case "24":
				$getpb = $this->lapan_api_library->call('lib/getcodepb', ['token' => $this->session->userdata('token')]);
				$pb = $getpb['data']['rows'];
				$kode = $getpb['data']['rows'][0]['kode'];
				$nourut = sprintf('%04d', $pb[0]['no_urut']);
				$ipm = $pb[0]['kode'] . '_' . $nourut;
				$ipmancode = $ipm;

			case "25":
				$getpb = $this->lapan_api_library->call('lib/getcodeps', ['token' => $this->session->userdata('token')]);
				$pb = $getpb['data']['rows'];
				$kode = $getpb['data']['rows'][0]['kode'];
				$nourut = sprintf('%04d', $pb[0]['no_urut']);
				$ipm = $pb[0]['kode'] . '_' . $nourut;
				$ipmancode = $ipm;
		}
		$post = $this->input->post();

		$configab['file_name'] =  $ipmancode . '_abstrak';
		$name = $_FILES["abstrak"]["name"];
		$ext = explode('.', $name);
		$ext = end($ext);

		$upload_abstrak = $this->upload->initialize($configab);
		if (!empty($_FILES['abstrak']['tmp_name'])) {
			$name_abstrak = $configab['file_name'].".".$ext;
			$file_tmp = $_FILES['abstrak']['tmp_name'];
			$data = file_get_contents($file_tmp);
			$abstrak_base64 = base64_encode($data);
		} else {
			$this->session->set_flashdata('message_errorabs', '<div class="alert alert-danger my-5" role="alert">
            File Abstrak belum terunggah!</div>');
		}

		$cgambar['file_name']  =  $ipmancode . '_gambar_paten';
		$name = $_FILES["gambar"]["name"];
		$ext = explode('.', $name);
		$ext = end($ext);

		$upload_gambar = $this->upload->initialize($cgambar);
		if (!empty($_FILES['gambar']['tmp_name'])) {
			$name_gambar = $cgambar['file_name'].".".$ext;
			$file_tmp = $_FILES['gambar']['tmp_name'];
			$data = file_get_contents($file_tmp);
			$gambar_base64 = base64_encode($data);
		} else {
			$this->session->set_flashdata('message_errorgam', '<div class="alert alert-danger my-5" role="alert">
            Gambar belum terunggah!</div>');
			redirect('paten/input');
		}
		$data = [
			'token' => $this->session->userdata('token'),
			'judul' => htmlspecialchars($this->input->post('judul', true)),
			'unit_kerja' => $this->input->post('unit_kerja'),
			'jenis_paten' => $this->input->post('jenis_paten'),
			'bidang_invensi' => htmlspecialchars($this->input->post('bidang_invensi', true)),
			'status' => 19,
			'no_handphone' => $this->input->post('no_handphone'),
			'ipman_code' => $ipmancode,
			'kode_input' => $this->session->userdata('user_id'),
			'gambar' => $gambar_base64,
			'abstrak' => $abstrak_base64,
			'abstrak_name' => $name_abstrak,
			'gambar_name' => $name_gambar,
		];

		$insert = $this->lapan_api_library->call('patens/addpaten', $data);

		if ($insert) {
			$data = array(
				'token' => $this->session->userdata('token'),
				'kode' => $kode,
			);
			$update = $this->lapan_api_library->call('lib/updatenourut', $data);
			$i = 1;
			$dokpaten = $dokpaten['data']['rows'];
			
			foreach ($dokpaten as $dp) {
				$config['file_name']          = $ipmancode . '_' . $dp['penamaan_file'];
				$config['allowed_types']        = 'doc|docx|pdf|';

				$file_tmp = $_FILES['dokumen'.$i]['tmp_name'];
				if(!empty($_FILES['dokumen'.$i]['tmp_name']) 
				     && file_exists($_FILES['dokumen'.$i]['tmp_name'])) {
				    $data_getcontent = file_get_contents($_FILES['dokumen'.$i]['tmp_name']);
				}
				$dokumen_base64 = base64_encode($data_getcontent);

				if (!empty($_FILES['dokumen' . $i]['name'])) {
					$size = $_FILES['dokumen' . $i]['size'];
					$type = $_FILES['dokumen' . $i]['type'];
					$filename = $_FILES['dokumen' . $i]['name'];
					$jenisdok = $dp['id'];
					$downloadable = $dp['downloadable'];

					$ext = explode('.', $filename);
					$type = end($ext);

				} else {
					$filename = $ipmancode . '_' . $dp['penamaan_file'];
					$size = '';
					$type = '';
					$jenisdok = $dp['id'];
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
			$id_paten = $insert['id'];
			foreach ($post['inventor'] as $kopeg) {
				$kp['id_paten'] = $id_paten;
				$kp['nik'] = $kopeg['nik'];
				$kp['token'] = $this->session->userdata('token');
				$insert = $this->lapan_api_library->call('dpatens/adddpaten', $kp);

			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Paten telah ditambahkan!</div>');
			redirect('paten/monitoring');
		}
	}

	public function update()
	{
		$userid =  $this->session->userdata('user_id');
		$date = date('Y-m-d h:i:s');
		$ipman = $this->input->post('ipman_code');

		$data_dokumen = [
                    'token' => $this->session->userdata('token'),
                    'code' => $ipman
				];
				
        $dokpaten = $this->lapan_api_library->call('dokumen/getdokumenbyipman', $data_dokumen);
		$dokpaten = $dokpaten['data'][0];

		$jumlahdok = count($dokpaten);
		$post = $this->input->post();
			// print_r($post);exit;
		//Upload Dokumen Asbstrak
		$configab['file_name']          = $ipman . '_abstrak';
		$configab['upload_path']          = './assets/dokumen/dokumen_paten/';
		$configab['allowed_types']        = 'txt';
		$configab['overwrite']        = TRUE;

		$this->upload->initialize($configab);

		if (!empty($_FILES['abstrak']['name'])) {
			$fileabstrak = $ipman . '_abstrak';
			$file_tmp = $_FILES['abstrak']['tmp_name'];
			$data = file_get_contents($file_tmp);
			$file_base64 = base64_encode($data);
		} else {
			$fileabstrak = $post['abstrak_lama'];
			$file_base64 = null;
		}

		$configgam['file_name']          = $ipman . '_gambar_paten';
		$configgam['upload_path']          = './assets/dokumen/dokumen_paten/';
		$configgam['allowed_types']        = 'jpg|png';
		$configgam['overwrite']        = TRUE;

		$this->upload->initialize($configgam);

		if (!empty($_FILES['gambar']['tmp_name'])) {
			$ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
			$gambarpaten =  $ipman.'_gambar_paten.'.$ext;
			$file_tmp = $_FILES['gambar']['tmp_name'];
			$data = file_get_contents($file_tmp);
			$gambar_base64 = base64_encode($data);
		} else {
			$gambarpaten = $post['gambar_lama'];
			$gambar_base64 =null;
		}
			$data = [
				'token' => $this->session->userdata('token'),
				'judul' => htmlspecialchars($this->input->post('judul', true)),
				'abstrak' => $file_base64,
				'gambar' => $gambar_base64,
				'bidang_invensi' => htmlspecialchars($this->input->post('bidang_invensi', true)),
				'unit_kerja' => $this->input->post('unit_kerja'),
				'status' => 19,
				'no_handphone' => $this->input->post('no_handphone'),
				'ipman_code' => $this->input->post('ipman_code'),
				'kode_ubah' => $this->session->userdata('user_id'),
				'tgl_ubah' => date('Y-m-d h:i:s'),
				'abstrak_name' => $fileabstrak,
				'gambar_name' => $gambarpaten,
				'id' => $post['id']
			];
		$array_date['abstrak_gambar'] = $data;
		$update_paten = $this->lapan_api_library->call('patens/updatepatensave', $data);
		if ($update_paten) {

			$datad = [
				'id' => $post['id'],
				'token' => $this->session->userdata('token')
			];

			$deletedpaten = $this->lapan_api_library->call('patens/deletedpatenbyip', $datad);

			$data3 = [
				'nomor_pendaftar' => $this->input->post('ipman_code'),
				'token' => $this->session->userdata('token')
			];
			$deletemsdokumen = $this->lapan_api_library->call('lib/deletedokumenbyip', $data3);

			$i = 1;

			foreach ($dokpaten as $dp) {
				$versi = $dp['rev'] + 1;
				if ($dp['size']) {
					$config['file_name']          =  $ipman . '_' .  $dp['penamaan_file'] . '_v' . $versi;
				} else {
					$config['file_name']          = $ipman . '_' . $dp['penamaan_file'];
				}
				$this->upload->initialize($config);
				// script upload dokumen
				if (!empty($_FILES['dokumen' . $i]['name'])) {
					// $this->upload->do_upload('dokumen' . $i);
					$filename[$i] =$config['file_name'].'pdf';
					// $size[$i] = $_FILES['dokumen' . $i]['size'];
					$size[$i] = $_FILES['dokumen' . $i]['size'];
					$type[$i] = $_FILES['dokumen' . $i]['type'];
					$file_tmp = $_FILES['dokumen' . $i]['tmp_name'];
					$data_base64 = file_get_contents($file_tmp);
					$dokumenx[$i] = base64_encode($data_base64);
					if ($dp['size']) {
						$rev[$i] = $dp['rev'] + 1;
					} else {
						$rev[$i] = $dp['rev'];
					}
					$jenisdok[$i] = $dp['id'];
					$downloadable[$i] = $dp['downloadable'];
					$dateinput[$i] = $dp['createdAt'];
					$userinput[$i] = $dp['kode_input'];
					$dateubah[$i] = date('Y-m-d h:i:s');
					$userubah[$i] =  $this->session->userdata('user_id');
				} else {
					$filename[$i] = $dp['name'];
					$size[$i] = $dp['size'];
					$type[$i] = 'application/pdf';
					$rev[$i] = $dp['rev'];
					$jenisdok[$i] = $dp['id'];
					$downloadable[$i] = $dp['downloadable'];
					$dateinput[$i] = $dp['tgl_input'];
					$userinput[$i] = $dp['kode_input'];
					$dateubah[$i] = $dp['updatedAt'];
					$userubah[$i] =  $dp['kode_ubah'];
					$dokumenx[$i] = null;
				}
				$dokumen[$i] = array($dokumenx[$i], $filename[$i], $size[$i] , $type[$i], $rev[$i], '1', $jenisdok[$i], $downloadable[$i], $dateinput[$i], $userinput[$i], $dateubah[$i], $userubah[$i]);
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
				$md['nomor_pendaftar'] = $this->input->post('ipman_code');
				$md['dokumen'] = $dok[0];
				$md['name'] = $dok[1];
				$md['size'] = $dok[2];
				$md['type'] = $dok[3];
				$md['rev'] = $dok[4];
				$md['role'] = $dok[5];
				$md['jenis_dokumen'] = $dok[6];
				$md['downloadable'] = $dok[7];
				$md['tgl_input'] = $dok[8];
				$md['kode_input'] = $dok[9];
				$md['tgl_ubah'] = $dok[10];
				$md['kode_ubah'] = $dok[11];
				$md['token'] = $this->session->userdata('token');
				$insert_doc = $this->lapan_api_library->call('lib/adddokumen', $md);
			endforeach;

			$kp = array();
			foreach ($post['inventor'] as $kopeg) {
				$kp['token'] = $this->session->userdata('token');
				$kp['id_paten'] = $post['id'];
				$kp['nik'] = $kopeg['nik'];
				$insert = $this->lapan_api_library->call('patens/adddpaten', $kp);		
			}

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Paten telah diubah!</div>');
			redirect('paten/monitoring');
		}
	}


	public function monitoring()
	{
		$return_draft = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 19]);
		// print_r(json_encode($return_draft));EXIT;
		$return_diajukan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 20]);
		$return_disetujui = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 21]);
		$return_ditolak = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 22]);
		$return_ditangguhkan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 23]);

		// print_r(json_encode($return_ditangguhkan));exit;
		$return_inventor = $this->lapan_api_library->call('patens/getinventor', ['token' => $this->session->userdata('token')]);
		$return_noninventor = $this->lapan_api_library->call('patens/getnoninventor', ['token' => $this->session->userdata('token')]);
		$return_paten = $this->lapan_api_library->call('patens/getpaten', ['token' => $this->session->userdata('token')]);

		$data['getDraft'] = $return_draft['data'][0];
		$data['getDiajukan'] = $return_diajukan['data'][0];
		$data['getDisetujui'] = $return_disetujui['data'][0];
		$data['getDitolak'] = $return_ditolak['data'][0];
		$data['getDitangguhkan'] = $return_ditangguhkan['data'][0];
		// print_r(json_encode($data['getDitangguhkan']));exit;
		$data['getInventor'] = $return_inventor['data'][0];
		$data['getInventorNon'] = $return_noninventor['data'][0];
		$data['data'] = $return_paten['data']['rows'];

		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('paten/monitoring', $data);
		$this->load->view('templates/footer');
	}

	public function export()
	{
		// $this->load->model('Paten_model', 'paten');
		// $paten = $this->paten->getExportDiajukan();
		$paten = $this->lapan_api_library->call('exportexcel/getallpaten', ['token' => $this->session->userdata('token')]);
		$paten = $paten['data']['0'];

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
			$peg = array($this->paten->getInventorExport($pat['id']));
			foreach ($peg as $pp) {
				$c = count($pp);
				switch ($c) {
					case "1":
						$arrayinventor = array($pp[0]['nama']);
						break;
					case "2":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama']);
						break;
					case "3":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama']);
						break;
					case "4":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama']);
						break;
					case "5":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama']);
						break;
					case "6":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama']);
						break;
					case "7":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama']);
						break;
					case "8":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama']);
						break;
					case "9":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama']);
						break;
					case "10":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama']);
						break;
					case "11":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama']);
						break;
					case "12":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama']);
						break;
					case "13":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama']);
						break;
					case "14":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama']);
						break;
					case "15":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama']);
						break;
					case "16":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama'], $pp[15]['nama']);
						break;
					case "17":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama'], $pp[15]['nama'], $pp[16]['nama']);
						break;
					case "18":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama'], $pp[15]['nama'], $pp[16]['nama'], $pp[17]['nama']);
						break;
					case "19":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama'], $pp[15]['nama'], $pp[16]['nama'], $pp[17]['nama'], $pp[18]['nama']);
						break;
					case "20":
						$arrayinventor = array($pp[0]['nama'], $pp[1]['nama'], $pp[2]['nama'], $pp[3]['nama'], $pp[4]['nama'], $pp[5]['nama'], $pp[6]['nama'], $pp[7]['nama'], $pp[8]['nama'], $pp[9]['nama'], $pp[10]['nama'], $pp[11]['nama'], $pp[12]['nama'], $pp[13]['nama'], $pp[14]['nama'], $pp[15]['nama'], $pp[16]['nama'], $pp[17]['nama'], $pp[18]['nama'], $pp[19]['nama']);
						break;
				}
				$inventor = implode(" , ", $arrayinventor);
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $pat['judul']);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $pat['unit_kerja']);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, date('d-m-Y', strtotime($pat['filling'])));
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $pat['status']);
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
		$return_draft = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 19]);
		$return_diajukan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 20]);
		$return_disetujui = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 21]);
		$return_ditolak = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 22]);
		$return_ditangguhkan = $this->lapan_api_library->call('patens/getpatenstatus', ['token' => $this->session->userdata('token'), 'userId' => $this->session->userdata('user_id'), 'role_id' => $this->session->userdata('role_id'), 'status' => 23]);
		$return_inventor = $this->lapan_api_library->call('patens/getinventor', ['token' => $this->session->userdata('token')]);
		$return_noninventor = $this->lapan_api_library->call('patens/getnoninventor', ['token' => $this->session->userdata('token')]);
		$data['getPaten'] = $return_draft['data'][0];
		$data['getDiajukan'] = $return_diajukan['data'][0];
		$data['getDisetujui'] = $return_disetujui['data'][0];
		$data['getDitolak'] = $return_ditolak['data'][0];
		$data['getDitangguhkan'] =  $return_ditangguhkan['data'][0];
		$data['getInventor'] = $return_inventor['data'][0];
		$data['getInventorNon'] = $return_noninventor['data'][0];

		if ($this->session->userdata('role_id') == 18) {
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

        $data_tindaklanjut = [
                    'token' => $this->session->userdata('token'),
                    'golongan' => 12
                ];
        $data['tindaklanjut'] = $this->lapan_api_library->call('rev/', $data_tindaklanjut);
        $data['tindaklanjut'] = $data['tindaklanjut']['data']['rows'];

        $data['pegawai'] = $this->lapan_api_library->call('pegawai', ['token' => $this->session->userdata('token')]);
        $data['pegawai'] = $data['pegawai']['data']['rows'];

        $data['nonpegawai'] = $this->lapan_api_library->call('nonpegawai', ['token' => $this->session->userdata('token')]);
        $data['nonpegawai'] = $data['nonpegawai']['data']['rows'];

        $data_paten = [
                    'token' => $this->session->userdata('token'),
                    'id' => $id
                ];
        $data['paten'] = $this->lapan_api_library->call('patens/getpatenbyid', $data_paten);
        $data['paten'] = $data['paten']['data']['rows'];

        $data_dokpaten = [
                    'token' => $this->session->userdata('token'),
                    'id_haki' => 1
                ];
        $data['dokpaten'] = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data_dokpaten);
        $data['dokpaten'] = $data['dokpaten']['data']['rows'];

        $data_newdokver = [
                    'token' => $this->session->userdata('token'),
                    'id_haki' => 2
                ];
        $data['newdokver'] = $this->lapan_api_library->call('jenisdokumen/getjenisdokumen', $data_newdokver);
        $data['newdokver'] = $data['newdokver']['data']['rows'];

        $data_diajukan = [
                    'token' => $this->session->userdata('token'),
                    'id' => $id
                ];
        $data['diajukan'] = $this->lapan_api_library->call('patens/getpatendiajukandetail', $data_diajukan);
        $data['diajukan'] = $data['diajukan']['data'][0][0];



        $data_inventor = [
                    'token' => $this->session->userdata('token'),
                    'id' => $id
                ];
        $data['inventor'] = $this->lapan_api_library->call('patens/getinventorbyid', $data_inventor);
        $data['inventor'] = $data['inventor']['data'][0];


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

		if ($this->session->userdata('role_id') == 18) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header');
			$this->load->view('templates/side_menu');
			$this->load->view('paten/verifikasi', $data);
			$this->load->view('templates/footer');
		}
	}

	public function save_verifikasi()
	{
		$userid =  $this->session->userdata('user_id');
		$date = date('Y-m-d h:i:s');

		$ipman = $this->input->post('ipman_code');

		$data_dokpatenver = [
                    'token' => $this->session->userdata('token'),
                    'nomor_pendaftar' => $ipman,
                    'role' => 1
                ];
        $dokpatenver = $this->lapan_api_library->call('patens/getdokumenver', $data_dokpatenver);
        $dokpatenver = $dokpatenver['data'][0];

		$data_dokuver = [
                    'token' => $this->session->userdata('token'),
                    'id_role' => 2
                ];
        $dokuver = $this->lapan_api_library->call('jenisdokumen/getnewdokver', $data_dokuver);
        $dokuver = $dokuver;

		$config1['file_name']          	= $dokuver['data']['rows'][0]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		// $config1['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config1['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config1);

		if ($dokpatenver) {
			if (!empty($_FILES['dokumen1']['name'])) {
				$filename1 = $filename5 = $_FILES['dokumen1']['name'];
				$size1 = $filename5 = $_FILES['dokumen1']['size'];
				$type1 = $filename5 = $_FILES['dokumen1']['type'];
				$file_tmp1 = $_FILES['dokumen1']['tmp_name'];
				$data1 = file_get_contents($file_tmp1);
				$dokumen1base64 = base64_encode($data1);
				$jenisdok1 = $dokuver['data']['rows'][0]['id'];
				$dokumen1 = array($dokumen1base64, $filename1, $size1, $type1, '2', $jenisdok1, $date, $userid);
			} else {
				$filename1 = $dokpatenver[0]['name'];
				$size1 = $dokpatenver[0]['size'];
				$type1 = $dokpatenver[0]['type'];
				$jenisdok1 = $dokpatenver[0]['id'];
				$dokumen1 = array('',$filename1, $size1, $type1, '2', $jenisdok1, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen1']['name'])) {
				$filename1 = $_FILES['dokumen1']['name'];
				$size1 = $_FILES['dokumen1']['size'];
				$type1 = $_FILES['dokumen1']['type'];
				$file_tmp1 = $_FILES['dokumen1']['tmp_name'];
				$data1 = file_get_contents($file_tmp1);
				$dokumen1base64 = base64_encode($data1);
				$jenisdok1 = $dokuver['data']['rows'][0]['id'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen1 = array($dokumen1base64, $filename1, $size1, $type1, '2', $jenisdok1, $date, $userid);
			} else {
				$filename1 = $dokuver['data']['rows'][0]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok1 = $dokuver['data']['rows'][0]['id'];
				$dokumen1 = array('',$filename1, '', '', '2', $jenisdok1, $date, $userid);
			}
		}

		$config2['file_name']          	= $dokuver['data']['rows'][1]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		// $config2['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config2['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config2);

		// script upload dokumen kedua
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen2']['name'])) {
				$filename2 = $_FILES['dokumen2']['name'];
				$size2 = $_FILES['dokumen2']['size'];
				$type2 = $_FILES['dokumen2']['type'];
				$file_tmp2 = $_FILES['dokumen2']['tmp_name'];
				$data2 = file_get_contents($file_tmp2);
				$dokumen2base64 = base64_encode($data2);
				$jenisdok2 = $dokuver['data']['rows'][0]['id'];
				$dokumen2 = array($dokumen2base64, $filename2, $size2, $type2, '2', $jenisdok2, $date, $userid);
			} else {
				$filename2 = $dokpatenver[1]['name'];
				$size2 = $dokpatenver[1]['size'];
				$type2 = $dokpatenver[1]['type'];
				$jenisdok2 = $dokpatenver[1]['id'];
				$dokumen2 = array('',$filename2, $size2, $type2, '2', $jenisdok2, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen2']['name'])) {
				$filename2 = $_FILES['dokumen2']['name'];
				$size2 = $_FILES['dokumen2']['size'];
				$type2 = $_FILES['dokumen2']['type'];
				$file_tmp2 = $_FILES['dokumen2']['tmp_name'];
				$data2 = file_get_contents($file_tmp2);
				$dokumen2base64 = base64_encode($data2);
				$jenisdok2 = $dokuver['data']['rows'][0]['id'];
				$dokumen2 = array($dokumen2base64, $filename2, $size2, $type2, '2', $jenisdok2, $date, $userid);
			} else {
				$filename2 = $dokuver['data']['rows'][1]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok2 = $dokuver['data']['rows'][1]['id'];
				$dokumen2 = array('',$filename2, '', '', '2', $jenisdok2, $date, $userid);
			}
		}


		$config3['file_name']          	= $dokuver['data']['rows'][2]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		$config3['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config3['allowed_types']        = 'doc|docx|pdf';

		

		$this->upload->initialize($config3);
		// script uplaod dokumen ketiga
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen3']['name'])) {
				$filename3 = $_FILES['dokumen3']['name'];
				$size3 = $_FILES['dokumen3']['size'];
				$type3 = $_FILES['dokumen3']['type'];
				$file_tmp3 = $_FILES['dokumen3']['tmp_name'];
				$data3 = file_get_contents($file_tmp3);
				$dokumen3base64 = base64_encode($data3);
				$jenisdok3 = $dokuver['data']['rows'][0]['id'];
				$dokumen3 = array($dokumen3base64, $filename3, $size3, $type3, '2', $jenisdok3, $date, $userid);
			} else {
				$filename3 = $dokpatenver[2]['name'];
				$size3 = $dokpatenver[2]['size'];
				$type3 = $dokpatenver[2]['type'];
				$jenisdok3 = $dokpatenver[2]['id'];
				$dokumen3 = array('',$filename3, $size3, $type3, '2', $jenisdok3, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen3']['name'])) {
				$filename3 = $_FILES['dokumen3']['name'];
				$size3 = $_FILES['dokumen3']['size'];
				$type3 = $_FILES['dokumen3']['type'];
				$file_tmp3 = $_FILES['dokumen3']['tmp_name'];
				$data3 = file_get_contents($file_tmp3);
				$dokumen3base64 = base64_encode($data3);
				$jenisdok3 = $dokuver['data']['rows'][0]['id'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen3 = array($dokumen3base64, $filename3, $size3, $type3, '2', $jenisdok3, $date, $userid);
			} else {
				$filename3 = $dokuver['data']['rows'][2]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok3 = $dokuver['data']['rows'][2]['id'];
				$dokumen3 = array('',$filename3, '', '', '2', $jenisdok3, $date, $userid);
			}
		}

		$config4['file_name']          	= $dokuver['data']['rows'][3]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		// $config4['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config4['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config4);
		// script uplaod dokumen keempat
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen4']['name'])) {
				$filename4 = $_FILES['dokumen4']['name'];
				$size4 = $_FILES['dokumen4']['size'];
				$type4 = $_FILES['dokumen4']['type'];
				$file_tmp4 = $_FILES['dokumen4']['tmp_name'];
				$data4 = file_get_contents($file_tmp4);
				$dokumen4base64 = base64_encode($data4);
				$jenisdok4 = $dokuver['data']['rows'][0]['id'];
				$dokumen4 = array($dokumen4base64,$filename4, $size4, $type4, '2', $jenisdok4, $date, $userid);
			} else {
				$filename4 = $dokpatenver[3]['name'];
				$size4 = $dokpatenver[3]['size'];
				$type4 = $dokpatenver[3]['type'];
				$jenisdok4 = $dokpatenver[3]['id'];
				$dokumen4 = array('',$filename4, $size4, $type4, '2', $jenisdok4, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen4']['name'])) {
				$filename4 = $_FILES['dokumen4']['name'];
				$size4 = $_FILES['dokumen4']['size'];
				$type4 = $_FILES['dokumen4']['type'];
				$file_tmp4 = $_FILES['dokumen4']['tmp_name'];
				$data4 = file_get_contents($file_tmp4);
				$dokumen4base64 = base64_encode($data4);
				$jenisdok4 = $dokuver['data']['rows'][0]['id'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen4 = array($dokumen4base64,$filename4, $size4, $type4, '2', $jenisdok4, $date, $userid);
			} else {
				$filename4 = $dokuver['data']['rows'][3]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok4 = $dokuver['data']['rows'][3]['id'];
				$dokumen4 = array('',$filename4, '', '', '2', $jenisdok4, $date, $userid);
			}
		}

		$config5['file_name']          	= $dokuver['data']['rows'][4]['penamaan_file'] . '_' . $this->input->post('ipman_code');
		// $config5['upload_path']          = './assets/dokumen/dokumen_verifikator/';
		$config5['allowed_types']        = 'doc|docx|pdf';

		$this->upload->initialize($config5);
		// script uplaod dokumen kelima
		if ($dokpatenver) {
			if (!empty($_FILES['dokumen5']['name'])) {
				$this->upload->do_upload('dokumen5');
				$filename5 = $_FILES['dokumen5']['name'];
				$size5 = $_FILES['dokumen5']['size'];
				$type5 = $_FILES['dokumen5']['type'];
				$file_tmp5 = $_FILES['dokumen5']['tmp_name'];
				$data5 = file_get_contents($file_tmp5);
				$dokumen5base64 = base64_encode($data5);
				$jenisdok5 = $dokuver['data']['rows'][0]['id'];
				$dokumen5 = array($dokumen5base64,$filename5, $size5, $type5, '2', $jenisdok5, $date, $userid);
			} else {
				$filename5 = $dokpatenver[4]['name'];
				$size5 = $dokpatenver[4]['size'];
				$type5 = $dokpatenver[4]['type'];
				$jenisdok5 = $dokpatenver[4]['id'];
				$dokumen5 = array('',$filename5, $size5, $type5, '2', $jenisdok5, $date, $userid);
			}
		} else {
			if (!empty($_FILES['dokumen5']['name'])) {
				$filename5 = $_FILES['dokumen5']['name'];
				$size5 = $_FILES['dokumen5']['size'];
				$type5 = $_FILES['dokumen5']['type'];
				$file_tmp5 = $_FILES['dokumen5']['tmp_name'];
				$data5 = file_get_contents($file_tmp5);
				$dokumen5base64 = base64_encode($data5);
				$jenisdok5 = $dokuver['data']['rows'][0]['id'];
				//nama, size, type, role, jenis_dok, tgl_input, kode_input
				$dokumen5 = array($dokumen5base64,$filename5, $size5, $type5, '2', $jenisdok5, $date, $userid);
			} else {
				$filename5 = $dokuver['data']['rows'][4]['penamaan_file'] . '_' . $this->input->post('ipman_code');
				$jenisdok5 = $dokuver['data']['rows'][4]['id'];
				$dokumen5 = array('',$filename5, '', '', '2', $jenisdok5, $date, $userid);
			}
		}

		$dokumen = array($dokumen1, $dokumen2, $dokumen3, $dokumen4, $dokumen5);
		// print_r($dokumen);exit;
		

		$data = [
			'token' => $this->session->userdata('token'),
			'nomor_permohonan' => $this->input->post('no_permohonan'),
			'pemeriksa_paten' => htmlspecialchars($this->input->post('pemeriksa_paten', true)),
			'kontak_pemeriksa' => htmlspecialchars($this->input->post('kontak_pemeriksa', true)),
			'email_pemeriksa' => htmlspecialchars($this->input->post('email_pemeriksa', true)),
			'sertifikasi' => date('Y-m-d', strtotime($this->input->post('tgl_sertifikasi'))),
			'filling' => date('Y-m-d', strtotime($this->input->post('filling_date'))),
			'formalitas' => date('Y-m-d', strtotime($this->input->post('tgl_persyaratan'))),
			'publish' => date('Y-m-d', strtotime($this->input->post('tgl_publikasi'))),
			'pembayaran' => date('Y-m-d', strtotime($this->input->post('tgl_pembayaran'))),
			'pemberian' => date('Y-m-d', strtotime($this->input->post('tgl_pemberian'))),
			'jumlah_klaim' => $this->input->post('jumlah_klaim'),
			'nomor_paten' => $this->input->post('no_paten'),
			'tahun_granted' => $this->input->post('thn_granted'),
			'status' => $this->input->post('status'),
			'tindak_lanjut' => $this->input->post('tindak_lanjut'),
			'keterangan' => htmlspecialchars($this->input->post('keterangan', true)),
			'id' => $this->input->post('id'),
		];

		$updateverifikasi = $this->lapan_api_library->call('patens/updateverifikasipatensave', $data);
		if ($updateverifikasi['status'] == 200) {
			if ($dokpatenver) {
				$delete = [
					'code' => $this->input->post('ipman_code'),
					'role' => 2,
					'token' => $this->session->userdata('token')
				];

				$deletedokumen = $this->lapan_api_library->call('dokumen/deletedokumenbynomorpendaftar', $delete);
				foreach ($dokumen as $dok) :
					if (!empty($dok)) {
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

						$insertdokumen = $this->lapan_api_library->call('lib/adddokumen', $md);
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
					}
				endforeach;
			}
		}
		redirect('paten/monitoring_verifikator');
	}

	public function ajukan($id)
	{
		$data = [
			'token' => $this->session->userdata('token'),
			'id' => $id,
			'status' => 20,
			'pernah_diajukan' => 1
		];
		$return = $this->lapan_api_library->call('patens/ajukan', $data);
		redirect('paten/monitoring');
	}

	public function hapusdraft($id)
	{
		$data = [
			'token' => $this->session->userdata('token'),
			'id' => $id,
		];
		$dokmerek = $this->lapan_api_library->call('patens/deletedraft', $data);
		redirect('paten/monitoring');
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
		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('paten/timeline');
		$this->load->view('templates/footer');
	}

	public function input_inventor()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/side_menu');
		$this->load->view('paten/input_inventor');
		$this->load->view('templates/footer');
	}

	public function save_inventor()
	{
			$data = [
				'nik' => htmlspecialchars($this->input->post('nik', true)),
				'nama' => htmlspecialchars($this->input->post('nama', true)),
				'token' => $this->session->userdata('token')
			];
			$insertpendesain = $this->lapan_api_library->call('nonpegawai/insertpendesain', $data);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Inventor Baru telah ditambahkan! <a type="button" href="input" class="my-5 btn btn-success btn-sm">Tambah Paten</a></div>');
			redirect('paten/input_inventor');
	}
}
