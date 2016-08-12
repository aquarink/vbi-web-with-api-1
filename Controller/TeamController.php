<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Addnewteam':

                if (!empty($_FILES)) {

                    $filenya = $_FILES['image'];
                    $type = $filenya['type'];
                    $explodeType = explode('/', $type);
                    $imgKind = $explodeType[0];
                    $imgExt = $explodeType[1];
                    // Text
                    $txtTeamnama = strtolower($_POST['txtTeamnama']);
                    $txtTeammanager = strtolower($_POST['txtTeammanager']);
                    $txtTeamtelepon = strtolower($_POST['txtTeamtelepon']);
                    $txtTeamalamat = strtolower($_POST['txtTeamalamat']);
                    $auth = $_POST['auth'];
                    //
                    $koordinat = $_POST['txtTeamkoordinat'];
                    $explodeKoordinat = explode('&', $koordinat);
                    $lonTeam = $explodeKoordinat[0];
                    $latTeam = $explodeKoordinat[1];
                    // Image
                    $imageSize = $filenya['size'];
                    $imageSrc = $filenya['tmp_name'];
                    // Re Image
                    $folder = 'Public/Team/';
                    $newImage = $folder . $txtTeamnama . '-(' . $lonTeam . '&' . $latTeam . ').' . $imgExt;
                    if (empty($txtTeamnama) || empty($txtTeammanager) || empty($txtTeamtelepon) || empty($txtTeamalamat) || empty($koordinat) || empty($koordinat) || empty($auth)) {
                        echo '[{"err": "true","status": "Empty Form"}]';
                    } else {
                        include_once 'Model/AdminModel.php';
                        $AdminModel = new AdminModel();

                        $cekAuth = $AdminModel->TokenAuth($auth);
                        if ($cekAuth > 0) {
                            if ($imgKind == 'image') {

                                $saveImage = move_uploaded_file($imageSrc, $newImage);
                                if ($saveImage) {
                                    include_once 'Model/TeamModel.php';
                                    $TeamModel = new TeamModel();

                                    $insertTeam = $TeamModel->TambahTeam($txtTeamnama, $newImage, $txtTeammanager, $txtTeamtelepon, $txtTeamalamat, $lonTeam, $latTeam, $auth);
                                    if ($insertTeam > 0) {
                                        echo '[{"err": "false","status": "Successed Save Team"}]';
                                    } else {
                                        echo '[{"err": "true","status": "Failed Save Team"}]';
                                    }
                                } else {
                                    echo '[{"err": "true","status": "Failed Move File"}]';
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

            case 'Allteam':
                include_once 'Model/TeamModel.php';
                $TeamModel = new TeamModel();

                $allTeam = $TeamModel->AllTeam();

                foreach ($allTeam as $allTeamArray) {
                    $dataTeam[] = $allTeamArray;
                }
                echo json_encode($dataTeam);
                break;

            case 'Teamby':
                include_once 'Model/TeamModel.php';
                $TeamModel = new TeamModel();
                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $teamById = $TeamModel->TeamId($id);
                if ($teamById > 0) {
                    foreach ($teamById as $teamBy) {
                        $teamID[] = $teamBy;
                    }
                } else {
                    echo '[{"err": "true","status": "ID Tidak Ada"}]';
                }
                echo json_encode($teamID);
                break;

            case 'Teamdel':
                include_once 'Model/TeamModel.php';
                $TeamModel = new TeamModel();
                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $teamById = $TeamModel->TeamId($id);
                if ($teamById > 0) {
                    $deleteTeam = $TeamModel->DelTeamId($id);
                    if ($deleteTeam > 0) {
                        echo '[{"err": "false","status": "Team Telah Dihapus"}]';
                    } else {
                        echo '[{"err": "true","status": "Team Gagal Dihapus"}]';
                    }
                } else {
                    echo '[{"err": "true","status": "ID Tidak Ada"}]';
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