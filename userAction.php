<?php
// Start session 
if (!session_id()) {
    session_start();
}

// Include database configuration file 
require_once 'dbConfig.php';

// Set default redirect url 
$redirectURL = 'index.php';

function generateRandomString($length = 7)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['userSubmit'])) {
    // Get form fields value 
    $ma_so = $_POST['ma_so'];
    $ten = trim(strip_tags($_POST['ten']));
    $email = trim(strip_tags($_POST['email']));
    $ngay_sinh = trim(strip_tags($_POST['ngay_sinh']));
    $sdt_hoc_vien = trim(strip_tags($_POST['sdt_hoc_vien']));
    $sdt_nguoi_than = trim(strip_tags($_POST['sdt_nguoi_than']));
    $hoc_van = trim(strip_tags($_POST['hoc_van']));

    $id_str = '';
    if (!empty($ma_so)) {
        $id_str = '?ma_so=' . $ma_so;
    }

    // Fields validation 
    $errorMsg = '';
    if (empty($ten)) {
        $errorMsg .= '<p>Vui lòng nhập tên của bạn.</p>';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= '<p>Vui lòng nhập email của bạn.</p>';
    }
    if (empty($ngay_sinh)) {
        $errorMsg .= '<p>Vui lòng nhập ngày sinh của bạn. Ví dụ: yyyy-mm-dd</p>';
    }
    if (empty($sdt_hoc_vien)) {
        $errorMsg .= '<p>Vui lòng nhập số điện thoại của bạn.</p>';
    }
    if (empty($sdt_nguoi_than)) {
        $errorMsg .= '<p>Vui lòng nhập số điện thoại người thân của bạn.</p>';
    }
    if (empty($hoc_van)) {
        $errorMsg .= '<p>Vui lòng nhập học vấn của bạn trên thang 12.</p>';
    }
    //debug_print_backtrace();
    // Submitted form data 
    $userData = array(
        'ten' => $ten,
        'email' => $email,
        'ngay_sinh' => $ngay_sinh,
        'sdt_hoc_vien' => $sdt_hoc_vien,
        'sdt_nguoi_than' => $sdt_nguoi_than,
        'hoc_van' => $hoc_van
    );

    // Store the submitted field values in the session 
    $sessData['userData'] = $userData;

    // Process the form data 
    if (empty($errorMsg)) {
        if (!empty($ma_so)) {
            // Update data in SQL server 
            //$sql = "UPDATE HOC_VIEN SET ten = ?,  email = ?, ngay_sinh = ?, sdt_hoc_vien = ?, sdt_nguoi_than = ?, hoc_van = ? WHERE ma_so = ?";
            $sql = "{CALL sp_update_hoc_vien(?,?,?,?,?,?,?)}";
            $query = $conn->prepare($sql);
            $update = $query->execute(array($ma_so, $ten, $email, $ngay_sinh, $sdt_hoc_vien, $sdt_nguoi_than, $hoc_van));

            if ($update) {
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Member data has been updated successfully.';

                // Remove submitted field values from session 
                unset($sessData['userData']);
            } else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';

                // Set redirect url 
                $redirectURL = 'addEdit.php' . $id_str;
            }
        } else {
            try {
                // Insert data in SQL server 
                $new_ma_so = "HV" . generateRandomString();
                echo $new_ma_so;
                while (true) {
                    $sql_checkID = "SELECT * FROM HOC_VIEN WHERE ma_so = ?";
                    $new_ma_so = "HV" . generateRandomString();
                    $query_checkID = $conn->prepare($sql_checkID);
                    $result_checkID = $query_checkID->execute(array($new_ma_so));
                    if (!empty($result_checkID)) {
                        break;
                    }
                }


                //$sql = "INSERT INTO HOC_VIEN (ma_so, ten, email, ngay_sinh, sdt_hoc_vien, sdt_nguoi_than, hoc_van) VALUES (?,?,?,?,?,?,?)";
                $sql = "{CALL sp_insert_hoc_vien(?,?,?,?,?,?,?)}";
                $params = array(
                    &
                    $new_ma_so, &
                    $ten, &
                    $email, &
                    $ngay_sinh, &
                    $sdt_hoc_vien, &
                    $sdt_nguoi_than, &
                    $hoc_van
                );
                 $query = $conn->prepare($sql);
                // $query->bindValue(1, $new_ma_so);
                // $query->bindValue(2, $ten);
                // $query->bindValue(3, $email);
                // $query->bindValue(4, $ngay_sinh);
                // $query->bindValue(5, $sdt_hoc_vien);
                // $query->bindValue(6, $sdt_nguoi_than);
                // $query->bindValue(7, $hoc_van);

                $insert = $query->execute($params);
                //$insert = $query->execute();
                echo "New record created successfully";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
            if ($insert) {
                //$ma_so = $conn->lastInsertId(); 

                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Member data has been added successfully.';

                // Remove submitted field values from session 
                unset($sessData['userData']);
            } else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';

                // Set redirect url 
                $redirectURL = 'addEdit.php' . $id_str;
            }
        }
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = '<p>Please fill all the mandatory fields.</p>' . $errorMsg;

        // Set redirect url 
        $redirectURL = 'addEdit.php' . $id_str;
    }

    // Store status into the session 
    $_SESSION['sessData'] = $sessData;
} elseif ((isset($_REQUEST['action_type'])) && ($_REQUEST['action_type'] == 'delete') && !empty($_GET['ma_so'])) {
    $ma_so = $_GET['ma_so'];
    //
    // Delete data from SQL server 
    //$sql = "DELETE FROM HOC_VIEN WHERE ma_so = ?";
    $sql = "{CALL sp_delete_hoc_vien(?)}";
    $query = $conn->prepare($sql);
    $delete = $query->execute(array($ma_so));
    if ($delete) {
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Member data has been deleted successfully.';
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred, please try again.';
    }

    // Store status into the session 
    $_SESSION['sessData'] = $sessData;
}

// Redirect to the respective page
header("Location:" . $redirectURL);
exit();
?>