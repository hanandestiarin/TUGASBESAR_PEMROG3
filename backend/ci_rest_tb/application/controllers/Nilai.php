<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Nilai extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $idnilai = $this->get('id_nilai');
        $data = $this->Semua_model->getDataNilai($idnilai);
        if ($data) {
            $this->response(
                [
                    'data' => $data,
                    'status' => 'Data Nilai Berhasil Ditampilkan',
                    'response_code' => RestController::HTTP_OK
                ],
                RestController::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Nilai Ditampilkan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_post()
    {
        $data = array(
            'id_nilai' => $this->post('id_nilai'),
            'id_siswa' => $this->post('id_siswa'),
            'nama_siswa' => $this->post('nama_siswa'),
            'jumlah_nilai' => $this->post('jumlah_nilai'),
            'keterangan' => $this->post('keterangan')
           
        );
        $cekdata = $this->Semua_model->getDataNilai($this->post('id_nilai'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_nilai'] == NULL || $data['id_siswa'] == NULL || $data['nama_siswa']
            == NULL || $data['jumlah_nilai'] == NULL || $data['keterangan'] == NULL 
        ) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Yang Dikirim Tidak Boleh Ada Yang Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
                
            );

            //Jika data tersimpan
        } 
        elseif ($cekdata) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Anda Sudah Memasukkan Data Nilai Dengan ID yang sama, Pastikan Ada Data Yang Diganti ex: Nilai',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertnilai($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Nilai Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data Nilai',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $idnilai = $this->put('id_nilai');
        $data = array(
            'id_nilai' => $this->put('id_nilai'),
            'id_siswa' => $this->put('id_siswa'),
            'nama_siswa' => $this->put('nama_siswa'),
            'jumlah_nilai' => $this->put('jumlah_nilai'),
            'keterangan' => $this->put('keterangan')
        );
        //Jika field npm tidak diisi
        if ($idnilai == NULL) {
            $this->response(
                [
                    'status' => $idnilai,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Nilai Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updatenilai($data, $idnilai) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Nilai Dengan Id Nilai ' . $idnilai . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Nilai Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $idnilai = $this->delete('id_nilai');
        //Jika field npm tidak diisi
        if ($idnilai == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID nilai Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deletenilai($idnilai) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data nilai Dengan ID nilai ' . $idnilai . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data nilai Dengan ID nilai ' . $idnilai . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}