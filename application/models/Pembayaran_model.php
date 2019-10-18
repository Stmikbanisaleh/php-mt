<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{
    public function getPembayaran(){
        $query = "SELECT `trpembayaran`.*,`mspaten`.`UNIT_KERJA`,`msrev`.`NAMA_REV` as UNIT
        FROM `trpembayaran` 
        JOIN `mspaten` ON `trpembayaran`.`NOMOR_PENDAFTAR` = `mspaten`.`NOMOR_PERMOHONAN`
        JOIN `msrev` ON `mspaten`.`UNIT_KERJA` = `msrev`.`ID`
        UNION
        SELECT `trpembayaran`.*,`msmerek`.`UNIT_KERJA`,`msrev`.`NAMA_REV` as UNIT
        FROM `trpembayaran` 
        JOIN `msmerek` ON `trpembayaran`.`NOMOR_PENDAFTAR` = `msmerek`.`NOMOR_PENDAFTAR`
        JOIN `msrev` ON `msmerek`.`UNIT_KERJA` = `msrev`.`ID`";
        return $this->db->query($query)->result_array();
    }

    public function getDetail($nopaten){
        $query = "SELECT `mspaten`.*,`msrev`.`NAMA_REV`
            FROM `mspaten` 
            JOIN `msrev` ON `mspaten`.`UNIT_KERJA` = `msrev`.`ID`
            WHERE `mspaten`.`NOMOR_PATEN` = '" . $nopaten . "'";
            return $this->db->query($query)->result();
    }
}
