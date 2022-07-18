<?php
defined('BASEPATH') or exit('No direct script access allowed');
//import library dari Format dan RestController
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
class Siswa extends RestController{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Semua_model');
    }

    public function siswa_get()
    {
        $idsiswa = $this->get('id_siswa');
        $data = $this->Semua_model->getDataSiswa($idsiswa);
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

    public function siswa_post()
    {
        $data = array(
            'id_siswa' => $this->post('id_siswa'),
            'nis' => $this->post('nis'),
            'nama_siswa' => $this->post('nama_siswa'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            'tempat_lahir' => $this->post('tempat_lahir'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'agama' => $this->post('agama'),
            'alamat' => $this->post('alamat'),
            'kelas' => $this->post('kelas'),
            'jurusan' => $this->post('jurusan'),
            'rombel' => $this->post('rombel'),
            'no_hp' => $this->post('no_hp'),
            'email' => $this->post('email')
        );
        $cekdata = $this->Semua_model->getDataSiswa($this->post('id_siswa'));
        //Jika semua data wajib diisi
        if (
            $data['id_siswa'] == NULL || $data['nis'] == NULL || $data['nama_siswa']
            == NULL || $data['username']
            == NULL || $data['password']
            == NULL || $data['tempat_lahir'] == NULL || $data['tanggal_lahir'] == NULL || $data['agama'] ==
            NULL || $data['alamat'] == NULL || $data['kelas'] == NULL || $data['jurusan'] == NULL 
            || $data['rombel'] == NULL || $data['no_hp'] == NULL || $data['email'] == NULL
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
                    'message' => 'Data Siswa Sudah Ada',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        } elseif ($this->Semua_model->insertsiswa($data) > 0) {
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

    public function siswa_put()
    {
        $id_siswa = $this->put('id_siswa');
        $data = array(
            'nis' => $this->put('nis'),
            'nama_siswa' => $this->put('nama_siswa'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            'tempat_lahir' => $this->put('tempat_lahir'),
            'tanggal_lahir' => $this->put('tanggal_lahir'),
            'agama' => $this->put('agama'),
            'alamat' => $this->put('alamat'),
            'kelas' => $this->put('kelas'),
            'jurusan' => $this->put('jurusan'),
            'rombel' => $this->put('rombel'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email')
        );
        //Jika field npm tidak diisi
        if ($id_siswa == NULL) {
            $this->response(
                [
                    'status' => $id_siswa,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Id Siswa Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Jika data berhasil berubah
        } elseif ($this->Semua_model->updatesiswa($data, $id_siswa) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_CREATED,
                    'message' => 'Data Siswa Dengan Id Siswa ' . $id_siswa . ' Berhasil Diubah',
                ],
                RestController::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Gagal Mengubah Data Siswa Pastikan Anda Mengisi tidak ada data yang sama dengan data sebelumnya',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }

    public function siswa_delete()
    {
        $id_siswa = $this->delete('id_siswa');
        //Jika field npm tidak diisi
        if ($id_siswa == NULL) {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'ID siswa Tidak Boleh Kosong',
                ],
                RestController::HTTP_BAD_REQUEST
            );
            //Kondisi ketika OK
        } elseif ($this->Semua_model->deleteSiswa($id_siswa) > 0) {
            $this->response(
                [
                    'status' => true,
                    'response_code' => RestController::HTTP_OK,
                    'message' => 'Data Siswa Dengan Id_siswa ' . $id_siswa . ' Berhasil Dihapus',
                ],
                RestController::HTTP_OK
            );
            //Kondisi gagal
        } else {
            $this->response(
                [
                    'status' => false,
                    'response_code' => RestController::HTTP_BAD_REQUEST,
                    'message' => 'Data Siswa Dengan Id_siswa ' . $id_siswa . ' Tidak Ditemukan',
                ],
                RestController::HTTP_BAD_REQUEST
            );
        }
    }
}