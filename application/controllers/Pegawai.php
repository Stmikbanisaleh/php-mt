<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
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
        $data['getPegawai'] = $this->lapan_api_library->call('pegawai/', ['token' => $this->session->userdata('token')]);

        if ($this->session->userdata('role_id') == 15) {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('pegawai/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('403.html');
            $this->load->view('templates/footer');
        }
    }
    
    public function input_pegawai()
    {
        if ($this->session->userdata('role_id') == 15) {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('pegawai/input');
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('403.html');
            $this->load->view('templates/footer');
        }
    }

    public function save_pegawai()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');

        if ($this->form_validation->run($this) == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Data tidak lengkap! </div>');
        } else {
            if ($this->session->userdata('token')) {
                $data = [
                    'kode_kepegawaian' => htmlspecialchars($this->input->post('kode_kepegawaian', true)),
                    'nik' => htmlspecialchars($this->input->post('nik', true)),
                    'nama' => htmlspecialchars($this->input->post('nama', true)),
                    'token' => $this->session->userdata('token')
                ];

                $this->lapan_api_library->call('pegawai/addpegawai', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Pegawai Baru telah ditambahkan! </div>');
                redirect('pegawai/index');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Token Expired! </div>');
                redirect('pegawai/index');
            }
        }
    }



    public function edit_pegawai($id)
    {
        if ($this->session->userdata('token')) {
            $data = [
                'token' => $this->session->userdata('token')
            ];
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Token Expired! </div>');
            redirect('pegawai/index');
        }
        $data = $this->lapan_api_library->call('pegawai/getpegawai',$data);
        print_r(json_encode($data));
        exit;
        if ($this->session->userdata('role_id') == 15) {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('pegawai/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/side_menu');
            $this->load->view('403.html');
            $this->load->view('templates/footer');
        }
    }

    public function update_pegawai()
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
            $this->load->view('pegawai/input_inventor', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'KODE_KEPEGAWAIAN' => htmlspecialchars($this->input->post('kode_kepegawaian', true)),
                'NIK' => htmlspecialchars($this->input->post('nik', true)),
                'NAMA' => htmlspecialchars($this->input->post('nama', true))
            ];
            $this->db->where('ID', $this->input->post('id'));
            $this->db->update('mspegawai', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pegawai Baru telah ditambahkan! </div>');
            redirect('pegawai/index');
        }
    }

    public function hapus_pegawai($id)
    {

        $this->db->query('DELETE FROM mspegawai WHERE ID=' . $id);
        redirect('pegawai/index');
    }
}
