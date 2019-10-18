<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function JumlahPaten()
    {
        $paten = $this->db->get('mspaten')->result_array();
        $jumlah = count($paten);
        return $jumlah;
    }
    public function JumlahMerek()
    {
        $merek = $this->db->get('msmerek')->result_array();
        $jumlah = count($merek);
        return $jumlah;
    }
    public function JumlahHakcipta()
    {
        $hakcipta = $this->db->get('mshakcipta')->result_array();
        $jumlah = count($hakcipta);
        return $jumlah;
    }
    public function JumlahDesain()
    {
        $desain = $this->db->get('msdesainindustri')->result_array();
        $jumlah = count($desain);
        return $jumlah;
    }

    function JumlahPatenPertahun()
    {
        $query = $this->db->query("SELECT * FROM (SELECT YEAR(TGL_INPUT) as tahun,count(*) as total 
        FROM mspaten GROUP BY YEAR(TGL_INPUT) DESC LIMIT 5)as paten ORDER BY tahun ASC;");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function JumlahMerekPertahun()
    {
        $query = $this->db->query("SELECT * FROM (SELECT YEAR(TGL_INPUT) as tahun,count(*) as total 
        FROM msmerek GROUP BY YEAR(TGL_INPUT) DESC LIMIT 5)as merek ORDER BY tahun ASC;");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function JumlahHakciptaPertahun()
    {
        $query = $this->db->query("SELECT * FROM (SELECT YEAR(TGL_INPUT) as tahun,count(*) as total 
        FROM mshakcipta GROUP BY YEAR(TGL_INPUT) DESC LIMIT 5)as hakcipta ORDER BY tahun ASC;");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function JumlahDesainPertahun()
    {
        $query = $this->db->query("SELECT * FROM (SELECT YEAR(TGL_INPUT) as tahun,count(*) as total 
        FROM msdesainindustri GROUP BY YEAR(TGL_INPUT) DESC LIMIT 5)as desain ORDER BY tahun ASC;");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}
