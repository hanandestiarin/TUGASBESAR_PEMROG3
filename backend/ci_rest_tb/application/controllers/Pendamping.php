<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Pendamping extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function index_get()
    {
        $idpendamping = $this->get('id_pendamping');
        $data = $this->Semua_model->getDataPendamping($idpendamping);
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
            'id_pendamping' => $this->post('id_pendamping'),
            'nip' => $this->post('nip'),
            'nama_pendamping' => $this->post('nama_pendamping'),
            'tempat_lahir' => $this->post('tempat_lahir'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'agama' => $this->post('agama'),
            'alamat' => $this->post('alamat'),
            'no_hp' => $this->post('no_hp'),
            'email' => $this->post('email')
        );
        $cekdata = $this->Semua_model->getDatapendamping($this->post('id_pendamping'));
        //Jika semua data wajib diisi
        
        if (
            $data['id_pendamping'] == NULL || $data['nip'] == NULL || $data['nama_pendamping']
            == NULL || $data['tempat_lahir'] == NULL || $data['tanggal_lahir'] == NULL || $data['agama'] ==
            NULL || $data['alamat'] == NULL || $data['no_hp'] == NULL || $data['email'] == NULL
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
                    'message' => 'Data Pendamping Sudah Ada',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertpendamping($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Pendamping Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data Pendamping',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id_pendamping = $this->put('id_pendamping');
        $data = array(
            'id_pendamping' => $this->put('id_pendamping'),
            'nip' => $this->put('nip'),
            'nama_pendamping' => $this->put('nama_pendamping'),
            'tempat_lahir' => $this->put('tempat_lahir'),
            'tanggal_lahir' => $this->put('tanggal_lahir'),
            'agama' => $this->put('agama'),
            'alamat' => $this->put('alamat'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email')
        );
        //Jika field npm tidak diisi
        if ($id_pendamping == NULL) {
            $this->response(
                [
                    'status' => $id_pendamping,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Id Pendamping Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updatependamping($data, $id_pendamping) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Pendamping Dengan Id Pendamping ' . $id_pendamping . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Pendamping Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_delete()
    {
        $id_pendamping = $this->delete('id_pendamping');
        //Jika field npm tidak diisi
        if ($id_pendamping == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'id Pendamping Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deletependamping($id_pendamping) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Pendamping Dengan id_pendamping ' . $id_pendamping . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Pendamping Dengan id_pendamping ' . $id_pendamping . ' Tidak Ditemukan atau sudah terhapus' ,
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}