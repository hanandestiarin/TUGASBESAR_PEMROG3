<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    private $_table_mhs = 't_mahasiswa';

    //fungsi untuk menampilkan data
    public function getDataMahasiswa($npm)
    {
        if ($npm) {
            $this->db->from($this->_table_mhs);
            $this->db->where('npm', $npm);
            $query = $this->db->get()->row_array();
            return $query;
        } else {
            $this->db->from($this->_table_mhs);
            $query = $this->db->get()->result_array();
            return $query;
        }
    }

    //fungsi untuk menambahkan data
    public function insertMahasiswa($data)
    {
        //Menggunakan Query Builder
        $this->db->insert($this->_table_mhs, $data);
        return $this->db->affected_rows();
        // return $query;
    }

    //fungsi untuk mengubah data
    public function updateMahasiswa($data, $npm)
    {
        //Menggunakan Query Builder
        $this->db->update($this->_table_mhs, $data, ['npm' => $npm]);
        return $this->db->affected_rows();
        // return $query;
    }

    //fungsi untuk menghapus data
    public function deleteMahasiswa($npm)
    {
        //Menggunakan Query Builder
        $this->db->delete($this->_table_mhs, ['npm' => $npm]);
        return $this->db->affected_rows();
        // return $query;
    }
}
