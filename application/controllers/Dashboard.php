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
		$data['jumlahPaten'] = $this->lapan_api_library->call('patens/getpaten', ['token' => $this->session->userdata('token')]);
		$data['jumlahMerek'] = $this->lapan_api_library->call('mereks/getmerek', ['token' => $this->session->userdata('token')]);
		$data['jumlahHakcipta'] = $this->lapan_api_library->call('hakciptas/gethakcipta', ['token' => $this->session->userdata('token')]);
		$data['jumlahDesain'] = $this->lapan_api_library->call('desain/getdesain', ['token' => $this->session->userdata('token')]);

		$data['grafikPaten'] = $this->lapan_api_library->call('patens/getpatenbyyear', ['token' => $this->session->userdata('token')]);
		$data['grafikPaten'] = $data['grafikPaten']['data'][0];

		$data['grafikMerek'] = $this->lapan_api_library->call('mereks/getmerekbyyear', ['token' => $this->session->userdata('token')]);
		$data['grafikMerek'] = $data['grafikMerek']['data'][0];

		$data['grafikHakcipta'] = $this->lapan_api_library->call('hakciptas/gethakciptabyyear', ['token' => $this->session->userdata('token')]);
		$data['grafikHakcipta'] = $data['grafikHakcipta']['data'][0];

		$data['grafikDesain'] = $this->lapan_api_library->call('desain/getdesainbyyear', ['token' => $this->session->userdata('token')]);
		$data['grafikDesain'] = $data['grafikDesain']['data'][0];


		$data['jumlahPaten'] = $data['jumlahPaten']['data']['count'];
		$data['jumlahMerek'] = $data['jumlahMerek']['data']['count'];
		$data['jumlahHakcipta'] = $data['jumlahHakcipta']['data']['count'];
		$data['jumlahDesain'] = $data['jumlahDesain']['data']['count'];


		$this->load->view('templates/header', $data);
		$this->load->view('templates/side_menu');
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
	}
}
