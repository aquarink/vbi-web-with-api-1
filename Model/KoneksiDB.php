<?php

error_reporting(0);

class KoneksiDB {

    protected $koneksi;
    public $nama_database = 'vbi_v3_2016';
    public $driver_server = 'mysql';
    public $server_database = 'localhost';
    public $port_server = '3306';
    public $username_koneksi = 'root';
    public $password_koneksi = 'mangaps';

    public function KoneksiDatabase() {

        try {
            $this->koneksi = new PDO("$this->driver_server:host=$this->server_database;port=$this->port_server;dbname=$this->nama_database",
                $this->username_koneksi, $this->password_koneksi);
            return $this->koneksi;
        } catch (Exception $ex) {
            var_dump($ex);
        }
    }
}