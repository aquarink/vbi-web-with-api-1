<?php

include_once 'KoneksiDB.php';

class TeamModel
{

    public $panggilKoneksi;

    function __construct()
    {
        $bukaKoneksi = new KoneksiDB();
        $this->panggilKoneksi = $bukaKoneksi->KoneksiDatabase();
        return $this->panggilKoneksi;
    }

    // Create
    public function TambahTeam($nama_team, $logo, $manager, $kontak, $sekretariat, $lon, $lat, $add_by)
    {
        $query = $this->panggilKoneksi->prepare("INSERT INTO team_tb (nama_team, logo, manager, kontak, sekretariat, lon, lat, status_team, now_team, add_by) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $data = array($nama_team, $logo, $manager, $kontak, $sekretariat, $lon, $lat, 1, date('Y-m-d H:i:s'), $add_by);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }

    // Read All
    public function AllTeam()
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_team,nama_team,logo,manager,kontak,sekretariat,lon,lat FROM team_tb WHERE status_team = 1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    // Read Once -> ID
    public function TeamId($id)
    {
        $query = $this->panggilKoneksi->prepare("SELECT id_team,nama_team,logo,manager,kontak,sekretariat,lon,lat FROM team_tb WHERE id_team = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->fetchAll();
        return $result;
    }

    // Update

    // Delete
    public function DelTeamId($id)
    {
        $query = $this->panggilKoneksi->prepare("UPDATE team_tb SET status_team = 2 WHERE id_team = ?");
        $data = array($id);
        $query->execute($data);
        $result = $query->rowCount();
        return $result;
    }
}