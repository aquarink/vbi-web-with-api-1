<?php

include_once 'KoneksiDB.php';

class KelasModel
{

    public $panggilKoneksi;

    function __construct()
    {
        $bukaKoneksi = new KoneksiDB();
        $this->panggilKoneksi = $bukaKoneksi->KoneksiDatabase();
        return $this->panggilKoneksi;
    }

    // Create
    public function TambahKelas($namaKelas, $by)
    {
        $query = $this->panggilKoneksi->prepare("INSERT INTO kelas_tb (nama_kelas, status_kelas, now_kelas, add_by) VALUES(?, ?, ?, ?)");
        $data = array($namaKelas, 1, date('Y-m-d H:i:s'), $by);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }

    // Read All
    public function AllKelas()
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_kelas,nama_kelas FROM kelas_tb WHERE status_kelas = 1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    // Read Once -> ID
    public function KelasId($id)
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_kelas,nama_kelas FROM kelas_tb WHERE id_kelas = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->fetchAll();
        return $result;
    }

    // Update

    // Delete
    public function DelKelasId($id)
    {
        $query = $this->panggilKoneksi->prepare("UPDATE kelas_tb SET status_kelas = 2 WHERE id_kelas = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }
}