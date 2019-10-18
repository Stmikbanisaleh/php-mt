
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getUserRole()
    {
        $query = "SELECT `msuser`.*,`msrev`.*
        FROM `msuser` JOIN `msrev`
        ON `msuser`.`role_id` = `msrev`.`id`";
        return $this->db->query($query)->result_array();
    }

    public function getUserById($id)
    {
        $query = "SELECT `msuser`.*,`msrev`.*
        FROM `msuser` JOIN `msrev`
        ON `msuser`.`role_id` = `msrev`.`id`
        WHERE `msuser`.`id` =".$id;
        return $this->db->query($query)->row_array();
    }

    public function getUserRoleAndStatus()
    {
        $query = "SELECT `msuser`.*,
                    (SELECT 
                            NAMA_REV
                        FROM
                            msrev
                        WHERE
                            id = `msuser`.`role_id`) as role,
                    (SELECT 
                            NAMA_REV
                        FROM
                            msrev
                        WHERE
                            id = `msuser`.`is_active`) as status
                FROM msuser";
        return $this->db->query($query)->result_array();
    }
}
