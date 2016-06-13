<?php

include_once 'KoneksiDB.php';

class AdminModel {

    public $panggilKoneksi;

    function __construct() {
        $bukaKoneksi = new KoneksiDB();
        $this->panggilKoneksi = $bukaKoneksi->KoneksiDatabase();
        return $this->panggilKoneksi;
    }

    // Create

    // Read All

    // Read Once [Login] -> Email & Password
    public function Login($email,$pass) {
        $query = $this->panggilKoneksi->prepare("SELECT * FROM member_tb WHERE email = ? AND password = ?");
        $data = array($email,$pass);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }

    // Read Once [Get Data] -> Email & Password
    public function GetDataByLogin($email,$pass) {
        $query = $this->panggilKoneksi->prepare("SELECT email,nama_depan,nama_belakang,telepon,status_member,enc_token FROM member_tb WHERE email = ? AND password = ?");
        $data = array($email,$pass);
        $query->execute($data);
        $result = $query->fetchAll();
        return $result;
    }

    // Update

    // Delete
}