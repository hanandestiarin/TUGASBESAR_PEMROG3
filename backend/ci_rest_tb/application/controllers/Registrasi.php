<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Registrasi extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $id_registrasi = $this->get('id_registrasi');
        $data = $this->Semua_model->getDataRegistrasi($id_registrasi);
        if ($data) {
            $this->response(
                [
                    'data' => $data,
                    'status' => 'Data Registrasi Berhasil Ditampilkan',
                    'response_code' => RestController::HTTP_OK
                ],
                RestController::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Registrasi Ditampilkan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_post()
    {
        $data = array(
            'id_registrasi' => $this->post('id_registrasi'),
            'id_ekskul' => $this->post('id_ekskul'),
            'id_siswa' => $this->post('id_siswa'),
            'tanggal_daftar' => $this->post('tanggal_daftar')
            
           
        );
        $cekdata = $this->Semua_model->getDataregistrasi($this->post('id_registrasi'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_registrasi'] == NULL || $data['id_ekskul'] == NULL || $data['id_siswa']
            == NULL || $data['tanggal_daftar'] == NULL 
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
                    'message' => 'Anda Sudah Memasukkan Data Registrasi Dengan ID yang sama, Pastikan Ada Data Yang Diganti ',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertregistrasi($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Registrasi Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data Registrasi',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id_registrasi = $this->put('id_registrasi');
        $data = array(
            'id_registrasi' => $this->put('id_registrasi'),
            'id_ekskul' => $this->put('id_ekskul'),
            'id_siswa' => $this->put('id_siswa'),
            'tanggal_daftar' => $this->put('tanggal_daftar')
        );
        //Jika field npm tidak diisi
        if ($id_registrasi == NULL) {
            $this->response(
                [
                    'status' => $id_registrasi,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Registrasi Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updateregistrasi($data, $id_registrasi) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Registrasi Dengan Id Registrasi ' . $id_registrasi . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Registrasi Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $id_registrasi = $this->delete('id_registrasi');
        //Jika field npm tidak diisi
        if ($id_registrasi == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Registrasi Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deleteregistrasi($id_registrasi) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Registrasi Dengan ID Registrasi ' . $id_registrasi . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Registrasi Dengan ID Registrasi ' . $id_registrasi . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}