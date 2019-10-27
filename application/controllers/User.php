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
		// print_r("expression");exit;
		// print_r("expression");exit;
		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $roleId = $data['user']['role_id'];
		// $data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		// $data['getRole'] = $this->db->query("SELECT ID,NAMA_REV FROM msrev WHERE GOLONGAN=5 AND NAMA_REV != 'Pengembang'")->result_array();
		$data['getRole'] = $this->lapan_api_library->call('rev/getrolenotpengembang', ['token' => $this->session->userdata('token')]);

		print_r(json_encode($data['getRole']));exit;

		$get_alluser = $this->lapan_api_library->call('users/getalluser', ['token' => $this->session->userdata('token')]);
		// file_put_contents('foo.png', base64_decode($get_alluser['data']['rows'][0]['image']));exit;
		// printf('<img src="data:image/png;base64,%s" />', $get_alluser['data']['rows'][0]['image']);exit;
		// $base64 ='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';
		// printf('<img src="data:image/png;base64,%s" />', $base64);exit;
		// print_r(json_encode($get_alluser['data']['rows'][0]['image']));exit;

		$this->load->model('User_model', 'usermod');
		$data['getUser'] = $this->usermod->getUserRole();
		$data['getRoleStatus'] = $this->usermod->getUserRoleAndStatus();

		print_r(json_encode($data['getUser']));exit;

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
		// $data['user'] = $this->db->get_where('msuser', ['email' =>
		// $this->session->userdata('email')])->row_array();
		// $roleId = $data['user']['role_id'];
		// $data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();
		// $data['getRole'] = $this->db->query("SELECT ID,NAMA_REV FROM msrev WHERE GOLONGAN=5 AND NAMA_REV != 'Pengembang'")->result_array();
		$this->load->model('User_model', 'usermod');
		// $data['getUser'] = $this->usermod->getUserRole();
		$data['getRoleStatus'] = $this->usermod->getUserRoleAndStatus();

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[msuser.email]', [
			'is unique' => 'This email is already registered'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
			'matches' => 'Password dont match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		$this->form_validation->set_rules('role_id', 'Role', 'required');

		if ($this->form_validation->run($this) == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/side_menu');
			$this->load->view('user/list', $data);
			$this->load->view('templates/footer');
		} else {

			$datauser = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => $this->input->post('role_id', true),
				'is_active' => 4,
			];

			$email = $this->input->post('email');

			//siapkan token
			$token = $this->_token();
			$user_token = [
				'email' => 'dediprasetio03@gmail.com',
				'token' => $token,
				'date_created' => time()
			];

			// $this->db->insert('msuser', $datauser);
			// $this->db->insert('msusertoken', $user_token);


			$this->_send_email($token, 'verify');

			redirect('user');
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
