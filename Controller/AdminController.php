<?php

if (isset($urlArray[2])) {
    if (empty($urlArray[2])) {
        echo 'ada tapi kosong';
    } else {

        include_once 'Model/AdminModel.php';
        $AdminModel = new AdminModel();

        $case = ucfirst($urlArray[2]);
        switch ($case) {
            case 'Login':
                $data = file_get_contents('php://input');
                $datanya = json_decode($data);

                $email = $datanya->emailVbi;
                $pass = $datanya->passVbi;

                if (empty($email) || empty($pass)) {
                    echo 'Redirect To VBI Website Page';
                } else {
                    $cekData = $AdminModel->Login($email, $pass);

                    if ($cekData > 0) {
                        $loadData = $AdminModel->GetDataByLogin($email, $pass);

                        session_start();
                        foreach ($loadData as $dataMemberArray) {
                            $dataMember[] = json_decode('{"err": "false","status": "Success Login"}');
                            $dataMember[] = $dataMemberArray;
                            session_start();
                            $_SESSION['tokens'] = $dataMember['enc_token'];
                        }
                        echo json_encode($dataMember);
                    } else {
                        echo '[{"err": "true","status": "Failed Login"}]';
                    }
                }
                break;

            case 'Logout':
                echo '[{"firstName":"John", "lastName":"Doe"},
                        {"firstName":"Anna", "lastName":"Smith"},
                        {"firstName":"Peter", "lastName":"Jones"}]';
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