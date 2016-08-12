<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Addnewkelas':
                $data = file_get_contents('php://input');
                $datanya = json_decode($data);

                $namaKelas = $datanya->namaKelas;
                $auth = $datanya->auth;

                if (empty($namaKelas) || empty($auth)) {
                    echo 'Redirect To VBI Website Page';
                } else {

                    include_once 'Model/AdminModel.php';
                    $AdminModel = new AdminModel();

                    $cekAuth = $AdminModel->TokenAuth($auth);

                    if ($cekAuth > 0) {
                        include_once 'Model/KelasModel.php';
                        $KelasModel = new KelasModel();

                        $addKelas = $KelasModel->TambahKelas($namaKelas, $auth);

                        if ($addKelas > 0) {
                            echo 'asas';
                            $allKelas = $KelasModel->AllKelas();
                            foreach ($allKelas as $allKelasArray) {
                                $dataKelas[] = json_decode('{"err": "false","status": "Success Add Kelas"}');
                                $dataKelas[] = $allKelasArray;
                            }
                            echo json_encode($dataKelas);
                        } else {
                            echo 'asas';
                        }
                    } else {
                        echo '[{"err": "true","status": "Failed Auth"}]';
                    }
                }
                break;

            case 'Allkelas':
                include_once 'Model/KelasModel.php';
                $KelasModel = new KelasModel();

                $allKelas = $KelasModel->AllKelas();
                foreach ($allKelas as $allKelasArray) {
                    $dataKelas[] = json_decode('{"err": "false","status": "Success Load Kelas"}');
                    $dataKelas[] = $allKelasArray;
                }
                echo json_encode($dataKelas);
                break;

            case 'Kelasby':
                include_once 'Model/KelasModel.php';
                $KelasModel = new KelasModel();

                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $kelasById = $KelasModel->KelasId($id);
                if ($kelasById > 0) {
                    foreach ($kelasById as $kelasBy) {
                        $kelasID[] = $kelasBy;
                    }
                    echo json_encode($kelasID);
                } else {
                    echo '[{"err": "true","status": "ID Kelas Tidak Ada"}]';
                }
                break;

            case 'Kelasdel':
                include_once 'Model/KelasModel.php';
                $KelasModel = new KelasModel();

                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $kelasById = $KelasModel->KelasId($id);
                if ($kelasById > 0) {
                    $deleteKelas = $KelasModel->DelKelasId($id);
                    if ($deleteKelas > 0) {
                        echo '[{"err": "false","status": "Kelas Telah Dihapus"}]';
                    } else {
                        echo '[{"err": "true","status": "Kelas Gagal Dihapus"}]';
                    }
                } else {
                    echo '[{"err": "true","status": "ID Kelas Tidak Ada"}]';
                }
                break;

            default:
                echo "Deff";
                break;
        }

    }
} else {
    echo 'ga';
}

?>