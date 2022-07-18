<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_Model
{

    private $_guzzle;

    public function __construct()
    {
        $this->_guzzle = new Client([
            'base_uri' => "http://localhost/ci_rest/mahasiswa/mhs",
            'auth' => ['admin', '1234']
        ]);
    }

    public function getAll()
    {
        $response = $this->_guzzle->request('GET', '', [
            'query' => [
                'KEY' => 'hyogas'
            ]
        ]);
        
        $result = json_decode($response->getBody()->getContents(), TRUE);
        return $result ['data'];
    }

    public function getById($npm){
        $response = $this->_guzzle->request('GET','',[
            'query' => [
                'KEY' => 'hyogas',
                'npm' => $npm
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(), TRUE);
        return $result['data'];
    }

    public function save($data){
        $response = $this->_guzzle->request('POST','',[
            'http_errors' => false,
            'form_params' => $data
        ]);
     $result = json_decode($response->getBody()->getContents(),TRUE);
     return $result;   
    }

    public function update($data, $npm)
    {
        $response = $this->_guzzle->request('PUT','',[
            'http_errors' => false,
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(),TRUE);
        return $result;   
    }

    public function delete($npm)
    {
        $response = $this->_guzzle->request('DELETE','',[
            'form_params' => [
                'http_errors' => false,
            'KEY' => 'hyogas',
            'npm' => $npm

            ]
        
        ]);
        $result = json_decode($response->getBody()->getContents(),TRUE);
        return $result;   
    }
}