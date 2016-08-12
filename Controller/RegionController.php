<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Addnew':

                $data = file_get_contents('php://input');
                $datanya = json_decode($data);

                $wilayahReg = $datanya->wilayahRegion;
                $pengurusReg = $datanya->pengurusRegion;
                $koordinatReg = $datanya->koordinatRegion;
                $explodeKoordinat = explode('&', $koordinatReg);
                $lonReg = $explodeKoordinat[0];
                $latReg = $explodeKoordinat[1];
                $authToken = $datanya->auth;

                if (empty($wilayahReg) || empty($pengurusReg) || empty($koordinatReg) || empty($authToken)) {
                    echo '[{"err": "true","status": "Empty Form"}]';
                } else {
                    include_once 'Model/AdminModel.php';
                    $AdminModel = new AdminModel();

                    $cekAuth = $AdminModel->TokenAuth($authToken);
                    if ($cekAuth > 0) {
                        // Token Ada
                        include_once 'Model/RegionModel.php';
                        $RegionModel = new RegionModel();

                        $addRegion = $RegionModel->TambahRegion($wilayahReg, $pengurusReg, $lonReg, $latReg, $authToken);
                        if ($addRegion > 0) {
                            $allRegion = $RegionModel->AllRegion();

                            foreach ($allRegion as $allRegionArray) {
                                $dataRegion[] = json_decode('{"err": "false","status": "Success Add Region"}');
                                $dataMember[] = $allRegionArray;
                            }
                            echo json_encode($dataMember);
                        } else {
                            echo '[{"err": "true","status": "Failed Add Region"}]';
                        }
                    } else {
                        echo '[{"err": "true","status": "Failed Auth"}]';
                    }
                }
                break;

            case 'Allreg':
                include_once 'Model/RegionModel.php';
                $RegionModel = new RegionModel();

                $allRegion = $RegionModel->AllRegion();

                foreach ($allRegion as $allRegionArray) {
                    $dataRegion[] = $allRegionArray;
                }
                echo json_encode($dataRegion);
                break;

            case 'Regiondel':
                include_once 'Model/RegionModel.php';
                $RegionModel = new RegionModel();
                $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                $regionById = $RegionModel->RegionId($id);
                if ($regionById > 0) {
                    $deleteRegion = $RegionModel->DelRegionId($id);
                    if ($deleteRegion > 0) {
                        echo '[{"err": "false","status": "Region Telah Dihapus"}]';
                    }
                } else {
                    echo '[{"err": "true","status": "ID Region Tidak Ada"}]';
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