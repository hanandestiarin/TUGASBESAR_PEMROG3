<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
    }
    //fungsi CRUD (GET, POST, PUT, DELETE) simpan di bawah sini
    public function mhs_get()
    {
        $npm = $this->get('npm');
        $data = $this->Mahasiswa_model->getDataMahasiswa($npm);
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

    public function mhs_post()
    {
        $data = array(
            'npm' => $this->post('npm'),
            'nama' => $this->post('nama'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'alamat' => $this->post('alamat'),
            'agama' => $this->post('agama'),
            'no_hp' => $this->post('no_hp'),
            'email' => $this->post('email')
        );
        $cekdata = $this->Mahasiswa_model->getDataMahasiswa($this->post('npm'));
        //Jika semua data wajib diisi
        if (
            $data['npm'] == NULL || $data['nama'] == NULL || $data['jenis_kelamin']
            == NULL || $data['alamat'] == NULL || $data['agama'] == NULL || $data['no_hp'] ==
            NULL || $data['email'] == NULL
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
        } elseif ($cekdata) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Sudah Ada',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Mahasiswa_model->insertMahasiswa($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Berhasil Ditambahkan',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Menambahkan Data',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function mhs_put()
    {
        $npm = $this->put('npm');
        $data = array(
            'nama' => $this->put('nama'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
            'alamat' => $this->put('alamat'),
            'agama' => $this->put('agama'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email')
        );
        //Jika field npm tidak diisi
        if ($npm == NULL) {
            $this->response(
                [
                    'status' => $npm,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'NPM Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Mahasiswa_model->updateMahasiswa($data, $npm) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function mhs_delete()
    {
        $npm = $this->delete('npm');
        //Jika field npm tidak diisi
        if ($npm == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'NPM Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Mahasiswa_model->deleteMahasiswa($npm) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Mahasiswa Dengan NPM ' . $npm . ' Tidak Ditemukan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}
