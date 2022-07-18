<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Siswa_model extends CI_Model
{
    private $_table_siswa = 't_siswa';

    //fungsi untuk menampilkan data
    public function getDataSiswa($idsiswa)
    {
        if ($idsiswa) {
            $this->db->from($this->_table_siswa);
            $this->db->where('id_siswa', $idsiswa);
            $query = $this->db->get()->row_array();
            return $query;
        } else {
            $this->db->from($this->_table_siswa);
            $query = $this->db->get()->result_array();
            return $query;
        }
    }

    //fungsi untuk menambahkan data
    public function insertsiswa($data)
    {
        //Menggunakan Query Builder
        $this->db->insert($this->_table_siswa, $data);
        return $this->db->affected_rows();
        // return $query;
    }

    //fungsi untuk mengubah data
    public function updatesiswa($data, $idsiswa)
    {
        //Menggunakan Query Builder
        $this->db->update($this->_table_siswa, $data, ['id_siswa' => $idsiswa]);
        return $this->db->affected_rows();
        // return $query;
    }

    //fungsi untuk menghapus data
    public function deletesiswa($idsiswa)
    {
        //Menggunakan Query Builder
        $this->db->delete($this->_table_siswa, ['id_siswa' => $idsiswa]);
        return $this->db->affected_rows();
        // return $query;
    }
}
