<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$role = $this->lapan_api_library->call('rev/getrolenotpengembang', ['token' => $this->session->userdata('token')]);
		$data['getRole'] = $role['data'];
		$get_alluser = $this->lapan_api_library->call_gateway('users/getalluser', ['token' => $this->session->userdata('token')]);
		$status = $this->lapan_api_library->call_gateway('users/getuserrole', ['token' => $this->session->userdata('token')]);
		// print_r($status);exit;
		$data['getRoleStatus'] = $status['data'];

		if ($this->session->userdata('role_id') == 15) {
			$this->load->view('templates/header');
			$this->load->view('templates/side_menu');
			$this->load->view('user/list', $data);
			$this->load->view('templates/footer');
		} else {
			$this->load->view('templates/header');
			$this->load->view('templates/side_menu');
			$this->load->view('403.html');
			$this->load->view('templates/footer');
		}
	}

	private function _token($length = 12)
	{
		$str = "";
		$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str  .= $characters[$rand];
		}
		return $str;
	}

	public function adduser()
	{
		$data['getRole'] = $this->lapan_api_library->call('rev/getrolenotpengembang', ['token' => $this->session->userdata('token')]);
		$data['getRole'] = $data['getRole']['data'][0];

		$data['getRoleStatus'] = $this->lapan_api_library->call_gateway('users/getuserrole', ['token' => $this->session->userdata('token')]);
		$data['getRoleStatus'] = $data['getRoleStatus']['data'][0];

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		$this->form_validation->set_rules('role_id', 'Role', 'required');

		if ($this->form_validation->run($this) == false) {
			$this->load->view('templates/header');
			$this->load->view('templates/side_menu');
			$this->load->view('user/list', $data);
			$this->load->view('templates/footer');
		} else {

			$datauser = [
				'token' => ['token' => $this->session->userdata('token')],
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'default.jpg',
				'password' => $this->input->post('password1'),
				'role_id' => $this->input->post('role_id', true),
				'is_active' => 4,
			];

			$insert = $this->lapan_api_library->call_gateway('users/register', $datauser);
			$email = $this->input->post('email');

			//siapkan token
			$token = $this->_token();
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];
			$inserttoken = $this->lapan_api_library->call_gateway('users/inserttoken', $user_token);
			$this->_send_email($token, 'verify');
			if($insert['status'] == 200 ){
				redirect('user');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
															'.$insert['messages'].'
															</div>');
				redirect('user');
			}

			
		}
	}

	private function _send_email($token, $type)
	{
		require 'assets/PHPMailer/PHPMailerAutoload.php';


		$mail = new PHPMailer;

		// Konfigurasi SMTP
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'dummyarif3228@gmail.com';
		$mail->Password = '1234dummy';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom('dummyarif3228@gmail.com');
		// Menambahkan penerima
		$mail->addAddress($this->input->post('email'));
		// Menambahkan beberapa penerima
		//$mail->addAddress('penerima2@contoh.com');
		//$mail->addAddress('penerima3@contoh.com');

		// Menambahkan cc atau bcc 
		//$mail->addCC('cc@contoh.com');
		//$mail->addBCC('bcc@contoh.com');


		if ($type == 'verify') {
			// Subjek email
			$mail->Subject = 'Manajemen Teknologi LAPAN - Verifikasi akun';

			// Mengatur format email ke HTML
			$mail->isHTML(true);

			// Konten/isi email
			$mailContent = 'Klik untuk aktivasi <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>';

			$mail->Body = $mailContent;
			// Menambahakn lampiran
			//$mail->addAttachment('berita/'.$file);
			//$mail->addAttachment('lmp/file2.png', 'nama-baru-file2.png'); //atur nama baru

		}

		// Kirim email
		if (!$mail->send()) {
			$pes = 'Pesan tidak dapat dikirim.';
			$mai = 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$pes = 'Pesan telah terkirim';
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('msuser', ['email' => $email])->row_array();

		if ($user) {
			$user_token  = $this->db->get_where('msusertoken', ['token' => $token])->row_array();

			if ($user_token) {
				$this->db->set('is_active', 3);
				$this->db->where('email', $email);
				$this->db->update('msuser');

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Aktivasi berhasil,silahkan Login</div>');
				redirect('auth');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Aktivasi gagal,token salah</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Aktivasi gagal,User salah</div>');
			redirect('auth');
		}
	}
}
