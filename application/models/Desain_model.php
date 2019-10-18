<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Desain_model extends CI_Model
{
    public function getdesainDraft()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 19 AND `msdesainindustri`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 19";
            return $this->db->query($query)->result_array();
        }
    }

    public function getdesainDiajukan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 20 AND `msdesainindustri`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 20";
            return $this->db->query($query)->result_array();
        }
    }

    public function getExportDiajukan()
    {
        $query = "SELECT `msdesainindustri`.*,(SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `msdesainindustri`.`UNIT_KERJA`) as UNIT_KERJA,
                                        (SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `msdesainindustri`.`STATUS`) as STATUS
                FROM `msdesainindustri`
                WHERE `status` = 20";
        return $this->db->query($query)->result_array();
    }

    public function getdesainDisetujui()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 21 AND `msdesainindustri`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 21";
            return $this->db->query($query)->result_array();
        }
    }

    public function getdesainDitolak()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 22 AND `msdesainindustri`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 22";
            return $this->db->query($query)->result_array();
        }
    }

    public function getdesainDitangguhkan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 23 AND `msdesainindustri`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
            WHERE `msdesainindustri`.`status` = 23";
            return $this->db->query($query)->result_array();
        }
    }

    public function getdesainDraftDetail($id)
    {
        $query = "SELECT `msdesainindustri`.*,`ddesainindustri`.*, `mspegawai`.*
        FROM `msdesainindustri` 
        JOIN `ddesainindustri` ON `msdesainindustri`.`ID` = `ddesainindustri`.`ID_DESAIN_INDUSTRI`
        JOIN `mspegawai` ON `ddesainindustri`.`NIK` = `mspegawai`.`NIK`
        WHERE `msdesainindustri`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getdesainDiajukanDetail($id)
    {
        $query = "SELECT `msdesainindustri`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `msdesainindustri` ON `msrev`.`ID` = `msdesainindustri`.`UNIT_KERJA`
        WHERE `msdesainindustri`.`status` = 20
        AND `msdesainindustri`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getKodeKepegawaian($id)
    {
        $query = "SELECT `ddesainindustri`.*,`mspegawai`.`KODE_KEPEGAWAIAN`,`mspegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `mspegawai` ON `ddesainindustri`.`KODE_KEPEGAWAIAN` = `mspegawai`.`KODE_KEPEGAWAIAN`
        WHERE `ddesainindustri`.`ID_DESAIN_INDUSTRI` = $id";
        return $this->db->query($query)->result_array();
    }

    public function getAllPendesain()
    {
        $query = "SELECT DISTINCT `ddesainindustri`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `mspegawai` ON `ddesainindustri`.`NIK` = `mspegawai`.`NIK`

        UNION

        SELECT DISTINCT `ddesainindustri`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `msnonpegawai` ON `ddesainindustri`.`NIK` = `msnonpegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesain()
    {
        $query = "SELECT DISTINCT `ddesainindustri`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `mspegawai` ON `ddesainindustri`.`NIK` = `mspegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainNon()
    {
        $query = "SELECT DISTINCT `ddesainindustri`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `msnonpegawai` ON `ddesainindustri`.`NIK` = `msnonpegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainById($id)
    {
        $query = "SELECT DISTINCT * FROM `ddesainindustri`
        WHERE `ddesainindustri`.`ID_DESAIN_INDUSTRI` = $id";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainExport($id)
    {
        $query = "SELECT  `ddesainindustri`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `mspegawai` ON `ddesainindustri`.`NIK` = `mspegawai`.`NIK`
        WHERE `ddesainindustri`.ID_DESAIN_INDUSTRI = $id
        UNION
        SELECT  `ddesainindustri`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `ddesainindustri`
        JOIN `msnonpegawai` ON `ddesainindustri`.`NIK` = `msnonpegawai`.`NIK`
        WHERE `ddesainindustri`.ID_DESAIN_INDUSTRI = $id";
        return $this->db->query($query)->result_array();
    }

    public function getIpmancode()
    {
        $query = $this->db->query("SELECT KODE,NO_URUT FROM msipmancode WHERE KODE = 'DI'");
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
