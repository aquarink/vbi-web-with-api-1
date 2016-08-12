<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Addnewrider':

                if (!empty($_FILES)) {

                    $filenya = $_FILES['avaImage'];
                    $type = $filenya['type'];
                    $explodeType = explode('/', $type);
                    $imgKind = $explodeType[0];
                    $imgExt = $explodeType[1];
                    // Text
                    $txtRiderName = strtolower($_POST['txtRiderNama']);
                    $auth = $_POST['auth'];
                    //
                    // Image
                    $imageSize = $filenya['size'];
                    $imageSrc = $filenya['tmp_name'];
                    // Re Image
                    $uniqKey = rand(000000,999999);
                    $folder = 'Public/Rider/';
                    $newImage = $folder . $txtRiderName . '-' . $uniqKey. '.' . $imgExt;
                    if (empty($txtRiderName) || empty($auth)) {
                        echo '[{"err": "true","status": "Empty Form"}]';
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

            case 'Allrider':
                include_once 'Model/RiderModel.php';
                $RiderModel = new RiderModel();

                $allRider = $RiderModel->AllRider();

                foreach ($allRider as $allRiderArray) {
                    $dataRider[] = $allRiderArray;
                }
                echo json_encode($dataRider);
                break;

            case 'Riderby':
                include_once 'Model/RiderModel.php';
                $RiderModel = new RiderModel();

                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $riderById = $RiderModel->RiderId($id);
                if ($riderById > 0) {
                    foreach ($riderById as $riderBy) {
                        $riderID[] = $riderBy;
                    }
                } else {
                    echo '[{"err": "true","status": "ID Rider Tidak Ada"}]';
                }
                echo json_encode($riderID);
                break;

            case 'Riderdel':
                include_once 'Model/RiderModel.php';
                $RiderModel = new RiderModel();

                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $riderById = $RiderModel->RiderId($id);
                if ($riderById > 0) {
                    $deleteRider = $RiderModel->DelRiderId($id);
                    if ($deleteRider > 0) {
                        echo '[{"err": "false","status": "Rider Telah Dihapus"}]';
                    } else {
                        echo '[{"err": "true","status": "Rider Gagal Dihapus"}]';
                    }
                } else {
                    echo '[{"err": "true","status": "ID Rider Tidak Ada"}]';
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