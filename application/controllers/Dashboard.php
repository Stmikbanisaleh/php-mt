<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$data['user'] = $this->db->get_where('msuser', ['email' =>
		$this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];
		$data['role'] = $this->db->get_where('msrev', array('ID' => $roleId))->row_array();

		$this->load->model('Dashboard_model', 'dashboard');
		//$data['jumlahPaten'] = $this->dashboard->JumlahPaten();
		$data['jumlahMerek'] = $this->dashboard->JumlahMerek();
		$data['jumlahHakcipta'] = $this->dashboard->JumlahHakcipta();
		$data['jumlahDesain'] = $this->dashboard->JumlahDesain();
		$data['jumlahPaten'] = $this->dashboard->JumlahPaten();
		$data['grafikPaten'] = $this->dashboard->JumlahPatenPertahun();
		$data['grafikMerek'] = $this->dashboard->JumlahMerekPertahun();
		$data['grafikHakcipta'] = $this->dashboard->JumlahHakciptaPertahun();
		$data['grafikDesain'] = $this->dashboard->JumlahDesainPertahun();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
	}
}
