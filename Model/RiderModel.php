<?php

include_once 'KoneksiDB.php';

class RiderModel
{

    public $panggilKoneksi;

    function __construct()
    {
        $bukaKoneksi = new KoneksiDB();
        $this->panggilKoneksi = $bukaKoneksi->KoneksiDatabase();
        return $this->panggilKoneksi;
    }

    // Create
    public function TambahRider($nama_rider, $photo, $add_by)
    {
        $query = $this->panggilKoneksi->prepare("INSERT INTO rider_tb (nama_rider,photo,status_rider,now_rider,add_by) VALUES(?, ?, ?, ?, ?)");
        $data = array($nama_rider, $photo, 1, date('Y-m-d H:i:s'), $add_by);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }

    // Read All
    public function AllRider()
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_rider,nama_rider,photo FROM rider_tb WHERE status_rider = 1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    // Read Once -> ID
    public function RiderId($id)
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_rider,nama_rider,photo FROM rider_tb WHERE id_rider = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->fetchAll();
        return $result;
    }

    // Update

    // Delete
    public function DelRiderId($id)
    {
        $query = $this->panggilKoneksi->prepare("UPDATE rider_tb SET status_rider = 2 WHERE id_rider = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }
}