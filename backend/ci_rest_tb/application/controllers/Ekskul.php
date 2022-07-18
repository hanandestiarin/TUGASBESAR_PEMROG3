<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Ekskul extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $idekskul = $this->get('id_ekskul');
        $data = $this->Semua_model->getDataEkskul($idekskul);
        if ($data) {
            $this->response(
                [
                    'data' => $data,
                    'status' => 'Data Berhasil Ditampilkan',
                    'response_code' => RestController::HTTP_OK
                ],
                RestController::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Gagal Ditampilkan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_post()
    {
        $data = array(
            'id_ekskul' => $this->post('id_ekskul'),
            'nama_ekskul' => $this->post('nama_ekskul'),
            'id_pendamping' => $this->post('id_pendamping'),
            'lokasi' => $this->post('lokasi'),
            'hari' => $this->post('hari'),
            'jam_mulai' => $this->post('jam_mulai'),
            'jam_selesai' => $this->post('jam_selesai')
        );
        $cekdata = $this->Semua_model->getDataekskul($this->post('id_ekskul'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_ekskul'] == NULL || $data['nama_ekskul'] == NULL || $data['id_pendamping']
            == NULL || $data['lokasi'] == NULL || $data['hari'] == NULL || $data['jam_mulai'] ==
            NULL || $data['jam_selesai'] == NULL 
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
                    'message' => 'Data Ekskul Sudah Ada',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertekskul($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Ekskul Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data Ekskul',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id_ekskul = $this->put('id_ekskul');
        $data = array(
            'id_ekskul' => $this->put('id_ekskul'),
            'nama_ekskul' => $this->put('nama_ekskul'),
            'id_pendamping' => $this->put('id_pendamping'),
            'lokasi' => $this->put('lokasi'),
            'hari' => $this->put('hari'),
            'jam_mulai' => $this->put('jam_mulai'),
            'jam_selesai' => $this->put('jam_selesai')
        );
        //Jika field npm tidak diisi
        if ($id_ekskul == NULL) {
            $this->response(
                [
                    'status' => $id_ekskul,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID ekskul Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updateekskul($data, $id_ekskul) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Ekskul Dengan Id Ekskul ' . $id_ekskul . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Ekskul Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $id_ekskul = $this->delete('id_ekskul');
        //Jika field npm tidak diisi
        if ($id_ekskul == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'id ekskul Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deleteekskul($id_ekskul) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data ekskul Dengan ID ekskul ' . $id_ekskul . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data ekskul Dengan ID ekskul ' . $id_ekskul . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}