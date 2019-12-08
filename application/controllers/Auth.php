<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','lapan_api_library'));
	}


	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == false) {
			$this->load->view('auth');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');


		$data2 = array(
			'email' => $email,
			'password' => $password);
		$user = $this->lapan_api_library->call('users/login',$data2);
		// print_r(json_encode($user['data']['status']));exit;
		// exit;
		if ($user['data']['status'] == 200) {
			//cek aktif
			if ($user['data']['is_active'] == 3) {
				// print_r($user['role_id']);
				// exit;
				if ($user['data']['token']) {
					$data = [
						'email' => $user['data']['email'],
						'role_id' => $user['data']['role'],
						'user_id' => $user['data']['user_id'],
						'name' => $user['data']['name'],
						'is_active' => $user['data']['is_active'],
						'name_rev' => $user['data']['nama_rev'],
						'status' => $user['data']['status_rev'],
						'keterangan' => $user['data']['keterangan'],
						'golongan' => $user['data']['golongan'],
						'token' => $user['data']['token']
					];


					$this->session->set_userdata($data);
					// echo "berhasil";
					redirect('dashboard');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
						Password salah!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Akun belum aktif!</div>');
				redirect('auth');
			}
			//cek password

		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email belum terdaftar</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Anda sudah log out</div>');
		redirect('auth');
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

	public function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == false) {
			$this->load->view('forgot_password');
		} else {
			$email = $this->input->post('email');
			$data = [
				'email' => $email,
				'is_active' => 3
			];
			// $user = $this->db->get_where('msuserstandar', ['EMAIL' => $email, 'IS_ACTIVE' => 3])->row_array();
			$user = $this->lapan_api_library->call_gateway('users/getuserbyemail', $data);
			$user = $user['rows'][0];
			if ($user) {
				$token = $this->_token();
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				$insert = $this->lapan_api_library->call_gateway('users/inserttoken', $user_token);
				$this->_send_email($token, 'forgot');
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Periksa email untuk reset password!</div>');
				redirect('auth');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email belum terdaftar!</div>');
				redirect('auth');
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


		if ($type == 'forgot') {
			// Subjek email
			$mail->Subject = 'Manajemen Teknologi LAPAN - Reset Password';

			// Mengatur format email ke HTML
			$mail->isHTML(true);

			// Konten/isi email
			$mailContent = 'Klik untuk reset password akun anda : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>';

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
		$user = $this->lapan_api_library->call_gateway('users/getuserbyemail2', ['email' => $email]);
		// print_r($user);exit;
		if ($user) {

			$user_token = $this->lapan_api_library->call_gateway('users/getuserstdbytoken', ['token' => $token]);
			// print_r($user_token);exit;
			if (count($user_token)) {
				$aktivasi = $this->lapan_api_library->call_gateway('users/aktivasiuser', ['is_active' => '3', 'email' => $email]);
				if($aktivasi['status'] == 200){
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
				Aktivasi berhasil,silahkan Login</div>');
				}
				$haha = $this->lapan_api_library->call_gateway('users/deletetoken', ['email' => $email]);
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

	public function resetpassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		$data = [
			'email' => $email,
		];
		$user = $this->lapan_api_library->call_gateway('users/getuserbyemail', $data);
		// $user = $this->db->get_where('msuserstandar', ['EMAIL' => $email])->row_array();
		$user = $user['rows'][0];
		if ($user) {
			$user = $this->lapan_api_library->call_gateway('users/getuserbyemail', $data);
			$token = ['token' => $token];
			$user_token  = $this->lapan_api_library->call_gateway('users/getuserstdbytoken', $token);
			if ($user_token[0]) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Reset password gagal,token salah</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Reset password gagal,Email salah</div>');
			redirect('auth');
		}
	}

	public function changepassword()
	{
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Password Ulang', 'required|trim|min_length[8]|matches[password1]');

		if ($this->form_validation->run() == false) {
			$this->load->view('change_password');
		} else {
			$password = $this->input->post('password1');
			$email = $this->session->userdata('reset_email');
			$data = [
				'password' => $password,
				'email' => $email
			];
			$user_token  = $this->lapan_api_library->call_gateway('users/updatepassword', $data);
			// $this->db->set('PASSWORD', $password);
			// $this->db->where('EMAIL', $email);
			// $this->db->update('msuserstandar');
			$deletetoken  = $this->lapan_api_library->call_gateway('users/deletetoken', $data);
			// $this->db->delete('msusertokenstd', ['EMAIL' => $email]);

			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Password telah diubah,silahkan Login</div>');
			redirect('auth');
		}
	}
}
