<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merek_model extends CI_Model
{
    public function getMerekDraft()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 19 AND `msmerek`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 19";
            return $this->db->query($query)->result_array();
        }
    }

    public function getMerekDiajukan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 20 AND `msmerek`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 20";
            return $this->db->query($query)->result_array();
        }
    }

    public function getExportDiajukan()
    {
        $query = "SELECT `msmerek`.*,(SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `msmerek`.`UNIT_KERJA`) as UNIT_KERJA,
                                        (SELECT 
                                                NAMA_REV
                                            FROM
                                                msrev
                                            WHERE
                                                id = `msmerek`.`STATUS`) as STATUS
                FROM `msmerek`
                WHERE `status` = 20";
        return $this->db->query($query)->result_array();
    }

    public function getMerekDisetujui()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 21 AND `msmerek`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 21";
            return $this->db->query($query)->result_array();
        }
    }

    public function getMerekDitolak()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 22 AND `msmerek`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 22";
            return $this->db->query($query)->result_array();
        }
    }

    public function getMerekDitangguhkan()
    {
        $user = $this->db->get_where('msuser', ['email' =>
        $this->session->userdata('email')])->row_array();
        $userid = $user['id'];
        $role = $user['role_id'];
        if ($role == 18) {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 23 AND `msmerek`.`KODE_INPUT` =$userid";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
            FROM `msrev` 
            JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
            WHERE `msmerek`.`status` = 23";
            return $this->db->query($query)->result_array();
        }
    }

    public function getMerekDraftDetail($id)
    {
        $query = "SELECT `msmerek`.*,`dmerek`.*, `mspegawai`.*
        FROM `msmerek` 
        JOIN `dmerek` ON `msmerek`.`ID` = `dmerek`.`ID_merek`
        JOIN `mspegawai` ON `dmerek`.`NIK` = `mspegawai`.`NIK`
        WHERE `msmerek`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getMerekDiajukanDetail($id)
    {
        $query = "SELECT `msmerek`.*,`msrev`.`NAMA_REV`
        FROM `msrev` 
        JOIN `msmerek` ON `msrev`.`ID` = `msmerek`.`UNIT_KERJA`
        WHERE `msmerek`.`status` = 20
        AND `msmerek`.`ID` = $id";
        return $this->db->query($query)->row_array();
    }

    public function getAllPendesain()
    {
        $query = "SELECT DISTINCT `dmerek`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dmerek`
        JOIN `mspegawai` ON `dmerek`.`NIK` = `mspegawai`.`NIK`

        UNION

        SELECT DISTINCT `dmerek`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dmerek`
        JOIN `msnonpegawai` ON `dmerek`.`NIK` = `msnonpegawai`.`NIK`        
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesain()
    {
        $query = "SELECT DISTINCT `dmerek`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dmerek`
        JOIN `mspegawai` ON `dmerek`.`NIK` = `mspegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainNon()
    {
        $query = "SELECT DISTINCT `dmerek`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dmerek`
        JOIN `msnonpegawai` ON `dmerek`.`NIK` = `msnonpegawai`.`NIK`
        ";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainById($id)
    {
        $query = "SELECT DISTINCT * FROM `dmerek`
        WHERE `dmerek`.`ID_MEREK` = $id";
        return $this->db->query($query)->result_array();
    }

    public function getPendesainExport($id)
    {
        $query = "SELECT  `dmerek`.*,`mspegawai`.`NIK`,`mspegawai`.`NAMA`
        FROM `dmerek`
        JOIN `mspegawai` ON `dmerek`.`NIK` = `mspegawai`.`NIK`
        WHERE `dmerek`.ID_merek = $id
        UNION
        SELECT  `dmerek`.*,`msnonpegawai`.`NIK`,`msnonpegawai`.`NAMA`
        FROM `dmerek`
        JOIN `msnonpegawai` ON `dmerek`.`NIK` = `msnonpegawai`.`NIK`
        WHERE `dmerek`.ID_merek = $id";
        return $this->db->query($query)->result_array();
    }

    public function getIpmancode()
    {
        $query = $this->db->query("SELECT KODE,NO_URUT FROM msipmancode WHERE KODE = 'MR'");
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
