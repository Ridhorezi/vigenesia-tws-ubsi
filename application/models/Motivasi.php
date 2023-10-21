<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Motivasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->mTbl = 'motivasi';
    }

    public function insert($data)
    {
        if (!array_key_exists("tanggal_input", $data)) {
            $data['tanggal_input'] = date("Y-m-d H:i:s");
        }

        $insert = $this->db->insert($this->mTbl, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id)
    {
        if (!array_key_exists("tanggal_update", $data)) {
            $data['tanggal_update'] = date("Y-m-d H:i:s");
        }

        $update = $this->db->update($this->mTbl, $data, array('id' => $id));
        return $update ? true : false;
    }

    public function delete($id)
    {
        $delete = $this->db->delete($this->mTbl, array('id' => $id));
        return $delete ? true : false;
    }
}
