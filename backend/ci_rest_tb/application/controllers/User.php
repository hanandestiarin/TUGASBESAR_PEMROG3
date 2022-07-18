<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class User extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $iduser = $this->get('id_user');
        $data = $this->Semua_model->getDataUser($iduser);
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
            'id_user' => $this->post('id_user'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'role' => $this->post('role'),
            'id_siswa' => $this->post('id_siswa'),
            'id_pendamping' => $this->post('id_pendamping'),
            'apikey' => $this->post('apikey')
            
        );
        $cekdata = $this->Semua_model->getDataUser($this->post('id_user'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_user'] == NULL || $data['username'] == NULL || $data['password']
            == NULL || $data['role'] == NULL || $data['id_siswa'] == NULL || $data['id_pendamping'] ==
            NULL || $data['apikey'] == NULL 
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
                    'message' => 'Data User Sudah Ada',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertuser($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data User Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data User',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id_user = $this->put('id_user');
        $data = array(
            'id_user' => $this->put('id_user'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            'role' => $this->put('role'),
            'id_siswa' => $this->put('id_siswa'),
            'id_pendamping' => $this->put('id_pendamping'),
            'apikey' => $this->put('apikey')
        );
        //Jika field npm tidak diisi
         
        if ($id_user == NULL) {
            $this->response(
                [
                    'status' => $id_user,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Id User Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updateuser($data, $id_user) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data User Dengan Id User ' . $id_user . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data User Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $id_user = $this->delete('id_user');
        //Jika field npm tidak diisi
        if ($id_user == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'id User Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deleteuser($id_user) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Pendamping Dengan User ' . $id_user . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Pendamping Dengan User ' . $id_user . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}