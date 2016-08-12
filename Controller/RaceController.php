<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Addnewrace':

                if (!empty($_FILES)) {

                    $filenya = $_FILES['brosur'];
                    $type = $filenya['type'];
                    $explodeType = explode('/', $type);
                    $imgKind = $explodeType[0];
                    $imgExt = $explodeType[1];
                    // Text
                    $judulRace = strtolower($_POST['judulRace']);
                    $roundKe = filter_var($_POST['roundKe'], FILTER_SANITIZE_NUMBER_INT);
                    $tanggal = strtolower($_POST['tanggal']);
                    $keterangan = $_POST['keterangan'];
                    $auth = $_POST['auth'];
                    //
                    // Image
                    $imageSize = $filenya['size'];
                    $imageSrc = $filenya['tmp_name'];
                    // Re Image
                    $uniqKey = rand(000000,999999);
                    $folder = 'Public/Race/';
                    $newImage = $folder . $judulRace . '-' . $uniqKey. '.' . $imgExt;
                    if (empty($judulRace) || empty($roundKe) || empty($tanggal) || empty($keterangan) || empty($auth)) {
                        echo '[{"err": "true","status": "Empty Race Form"}]';
                    } else {
                        include_once 'Model/AdminModel.php';
                        $AdminModel = new AdminModel();

                        $cekAuth = $AdminModel->TokenAuth($auth);
                        if ($cekAuth > 0) {
                            if ($imgKind == 'image') {

                                $saveImage = move_uploaded_file($imageSrc, $newImage);
                                if ($saveImage) {
                                    include_once 'Model/RiderModel.php';
                                    $RiderModel = new RiderModel();

                                    $saveRider = $RiderModel->TambahRider($txtRiderName, $newImage, $auth);
                                    if ($saveRider > 0) {
                                        echo '[{"err": "false","status": "Successed Save Rider"}]';
                                    } else {
                                        echo '[{"err": "true","status": "Failed Save Rider"}]';
                                    }
                                } else {
                                    echo '[{"err": "true","status": "Failed Move Rider File"}]';
                                }
                            } else {
                                echo '[{"err": "true","status": "File Bukan Gambar"}]';
                            }
                        } else {
                            echo '[{"err": "true","status": "Failed Auth"}]';
                        }
                    }
                } else {
                    echo '[{"err": "true","status": "Tidak Ada File Dipilih"}]';
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