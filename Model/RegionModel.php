<?php

include_once 'KoneksiDB.php';

class RegionModel
{

    public $panggilKoneksi;

    function __construct()
    {
        $bukaKoneksi = new KoneksiDB();
        $this->panggilKoneksi = $bukaKoneksi->KoneksiDatabase();
        return $this->panggilKoneksi;
    }

    // Create
    public function TambahRegion($wilayah, $pengurus, $lon, $lat, $by)
    {
        $query = $this->panggilKoneksi->prepare("INSERT INTO region_tb (wilayah, pengurus, lon, lat, status_region, now_region, add_by) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $data = array($wilayah, $pengurus, $lon, $lat, 1, date('Y-m-d H:i:s'), $by);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }

    // Read All
    public function AllRegion()
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_region,wilayah,pengurus,lon,lat FROM region_tb WHERE status_region = 1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    // Read Once -> ID
    public function RegionId($id)
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_region,wilayah,pengurus,lon,lat FROM region_tb WHERE id_region = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->fetchAll();
        return $result;
    }

    // Update

    // Delete
    public function DelRegionId($id)
    {
        $query = $this->panggilKoneksi->prepare("UPDATE region_tb SET status_region = 2 WHERE id_region = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }
}