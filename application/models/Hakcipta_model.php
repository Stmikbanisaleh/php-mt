<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hakcipta_model extends CI_Model
{
    public function getHakciptaDraft()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 19 AND `mshakcipta`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 19";
            return $this->db->query($query)->result_array();
        }
    }

    public function getHakciptaDiajukan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 20 AND `mshakcipta`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 20";
            return $this->db->query($query)->result_array();
        }
    }

    public function getExportDiajukan()
    {
        $query = "SELECT `mshakcipta`.*,(SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `mshakcipta`.`UNIT_KERJA`) as UNIT_KERJA,
                                        (SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `mshakcipta`.`STATUS`) as STATUS
                FROM `mshakcipta`
                WHERE `status` = 20";
        return $this->db->query($query)->result_array();
    }

    public function getHakciptaDisetujui()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
        WHERE `mshakcipta`.`status` = 21 AND `mshakcipta`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
        WHERE `mshakcipta`.`status` = 21";
            return $this->db->query($query)->result_array();
        }
    }

    public function getHakciptaDitolak()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
        WHERE `mshakcipta`.`status` = 22 AND `mshakcipta`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
        WHERE `mshakcipta`.`status` = 22";
            return $this->db->query($query)->result_array();
        }
    }

    public function getHakciptaDitangguhkan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 23 AND `mshakcipta`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
            WHERE `mshakcipta`.`status` = 23";
            return $this->db->query($query)->result_array();
        }
    }

    public function getHakciptaDraftDetail($id)
    {
        $query = "SELECT `mshakcipta`.*,`dhakcipta`.*, `mspegawai`.*
        FROM `mshakcipta` 
        JOIN `dhakcipta` ON `mshakcipta`.`ID` = `dhakcipta`.`ID_HAKCIPTA`
        JOIN `mspegawai` ON `dhakcipta`.`NIK` = `mspegawai`.`NIK`
        WHERE `mshakcipta`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getHakciptaDiajukanDetail($id)
    {
        $query = "SELECT `mshakcipta`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `mshakcipta` ON `msrev`.`ID` = `mshakcipta`.`UNIT_KERJA`
        WHERE `mshakcipta`.`status` = 20
        AND `mshakcipta`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getAllPencipta()
    {
        $query = "SELECT DISTINCT `dhakcipta`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `mspegawai` ON `dhakcipta`.`NIK` = `mspegawai`.`NIK`

        UNION

        SELECT DISTINCT `dhakcipta`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `msnonpegawai` ON `dhakcipta`.`NIK` = `msnonpegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPencipta()
    {
        $query = "SELECT DISTINCT `dhakcipta`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `mspegawai` ON `dhakcipta`.`NIK` = `mspegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPenciptaNon()
    {
        $query = "SELECT DISTINCT `dhakcipta`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `msnonpegawai` ON `dhakcipta`.`NIK` = `msnonpegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPenciptaById($id)
    {
        $query = "SELECT DISTINCT * FROM `dhakcipta`
        WHERE `dhakcipta`.`ID_HAKCIPTA` = $id";
        return $this->db->query($query)->result_array();
    }

    public function getPenciptaExport($id)
    {
        $query = "SELECT  `dhakcipta`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `mspegawai` ON `dhakcipta`.`NIK` = `mspegawai`.`NIK`
        WHERE `dhakcipta`.ID_HAKCIPTA = $id
        UNION
        SELECT  `dhakcipta`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dhakcipta`
        JOIN `msnonpegawai` ON `dhakcipta`.`NIK` = `msnonpegawai`.`NIK`
        WHERE `dhakcipta`.ID_HAKCIPTA = $id";
        return $this->db->query($query)->result_array();
    }

    public function getIpmancode()
    {
        $query = $this->db->query("SELECT KODE,NO_URUT FROM msipmancode WHERE KODE = 'HC'");
        $kode = $query->row()->KODE;
        $nourut = sprintf('%04d', $query->row()->NO_URUT);

        return $kode . '_' . $nourut;
    }

    public function getDokumen($code)
    {
        $query = "SELECT `msdokumen`.*,`msjenisdokumen`.*,`msjenisdokumen`.`ID`
        FROM `msdokumen`
        JOIN `msjenisdokumen` ON `msdokumen`.`JENIS_DOKUMEN` = `msjenisdokumen`.`ID`
        WHERE `msdokumen`.`NOMOR_PENDAFTAR` = '$code' AND `msdokumen`.`ROLE` = 1";
        return $this->db->query($query)->result_array();
    }

    public function getDokumenVer($code)
    {
        $query = "SELECT `msdokumen`.*,`msjenisdokumen`.*,`msjenisdokumen`.`ID`
        FROM `msdokumen`
        JOIN `msjenisdokumen` ON `msdokumen`.`JENIS_DOKUMEN` = `msjenisdokumen`.`ID`
        WHERE `msdokumen`.`NOMOR_PENDAFTAR` = '$code' AND `msdokumen`.`ROLE` = 2";
        return $this->db->query($query)->result_array();
    }
}
