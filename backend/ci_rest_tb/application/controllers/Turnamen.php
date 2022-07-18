<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Turnamen extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $id_turnamen = $this->get('id_turnamen');
        $data = $this->Semua_model->getDataTurnamen($id_turnamen);
        if ($data) {
            $this->response(
                [
                    'data' => $data,
                    'status' => 'Data Turnamen Berhasil Ditampilkan',
                    'response_code' => RestController::HTTP_OK
                ],
                RestController::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Turnamen Ditampilkan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_post()
    {
        $data = array(
            'id_turnamen' => $this->post('id_turnamen'),
            'nama_turnamen' => $this->post('nama_turnamen'),
            'tingkat_turnamen' => $this->post('tingkat_turnamen'),
            'lokasi' => $this->post('lokasi'),
            'hari' => $this->post('hari'),
            'id_ekskul' => $this->post('id_ekskul')
            
           
        );
        $cekdata = $this->Semua_model->getDataTurnamen($this->post('id_turnamen'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_turnamen'] == NULL || $data['nama_turnamen'] == NULL || $data['tingkat_turnamen']
            == NULL || $data['lokasi'] == NULL || $data['hari'] == NULL || $data['id_ekskul'] == NULL 
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
                    'message' => 'Anda Sudah Memasukkan Data Turnamen Dengan ID yang sama, Pastikan Ada Data Yang Diganti',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertturnamen($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Turnamen Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data Turnamen',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id_turnamen = $this->put('id_turnamen');
        $data = array(
            'id_turnamen' => $this->put('id_turnamen'),
            'nama_turnamen' => $this->put('nama_turnamen'),
            'tingkat_turnamen' => $this->put('tingkat_turnamen'),
            'lokasi' => $this->put('lokasi'),
            'hari' => $this->put('hari'),
            'id_ekskul' => $this->put('id_ekskul')
            
        );
        //Jika field npm tidak diisi
        if ($id_turnamen == NULL) {
            $this->response(
                [
                    'status' => $id_turnamen,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Turnamen Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updateturnamen($data, $id_turnamen) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Turnamen Dengan Id Turnamen ' . $id_turnamen . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Turnamen Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $id_turnamen = $this->delete('id_turnamen');
        //Jika field npm tidak diisi
        if ($id_turnamen == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID Turnamen Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deleteregistrasi($id_turnamen) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Turnamen Dengan ID Turnamen ' . $id_turnamen . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Turnamen Dengan ID Turnamen ' . $id_turnamen . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}