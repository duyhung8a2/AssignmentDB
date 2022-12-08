<?php

// Start session 
if (!session_id()) {
    session_start();
}

// Retrieve session data 
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status message from session 
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Include database configuration file 
require_once 'dbConfig.php';

// Fetch the data from SQL server 
$sql = "SELECT * FROM HOC_VIEN ORDER BY ma_so DESC";
$query = $conn->prepare($sql);
$query->execute();
$members = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Display status message -->
<?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
<div class="col-xs-12">
    <div class="alert alert-success">
        <?php echo $statusMsg; ?>
    </div>
</div>
<?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
<div class="col-xs-12">
    <div class="alert alert-danger">
        <?php echo $statusMsg; ?>
    </div>
</div>
<?php } ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="./js/myScript.js">
    <!--css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" />
    <!-- library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="./js/myScript.js"></script>
    <script type="text/javascript" src="./js/bootstrap.js"></script>

</head>

<body>
    <div class="modal fade" id="userProdModal1Input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header text-center">
                    <h4 class="modal-title white-text w-100 font-weight-bold py-2">Số
                        buổi học của chi nhánh</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <form method="post">
                        <div class="md-form mb-5">
                            <i class="fas grey-text"></i>
                            <label data-error="wrong" data-success="right" for="form3">Mã chi nhánh:</label>
                            <input type="text" id="form3" name="ten_chi_nhanh" class="form-control validate"
                                placeholder="Ví dụ: CN2" required="">
                            </input>
                        </div>
                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <input type="submit" name="userSubmitProd" id="prod1-btn"
                                class="btn btn-outline-warning waves-effect"></input>
                        </div>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>

    <div class="modal fade" id="userProdModal2Input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header text-center">
                    <h4 class="modal-title white-text w-100 font-weight-bold py-2">Xem học phí theo học vấn</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <form method="post">
                        <div class="md-form mb-5">
                            <i class="fas grey-text"></i>
                            <label data-error="wrong" data-success="right" for="form3">Học vấn:</label>
                            <input type="number" id="form3" name="hoc_van" class="form-control validate"
                                placeholder="Ví dụ: 11" required="">
                            </input>
                        </div>
                        <!--Footer-->
                        <div class="modal-footer justify-content-center">
                            <input type="submit" name="userSubmitProd2" id="prod2-btn"
                                class="btn btn-outline-warning waves-effect"></input>
                        </div>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>


    <div id="container p-4">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <a id="hocvien-btn" class="btn btn-primary" data-table="1" href="#" data-toggle="button"
                        aria-pressed="false" autocomplete="off">Học viên</a>
                    <a href="" class="btn  btn-primary" data-toggle="modal" data-target="#userProdModal1Input">Tìm số
                        buổi học của chi nhánh </a>
                    <a href="" class="btn  btn-primary" data-toggle="modal" data-target="#userProdModal2Input">Xem học phí theo học vấn </a>
                </div>
            </div>
        </div>
    </div>

    <div id="hocvienWrapper" class="frameWrapper p-4">
        <div class="row">
            <div class="col-md-12 head">
                <div class="tableHeader text-center h6"> Học viên</div>
                <!-- Add link -->
                <div class="float-right">
                    <a href="addEdit.php" class="btn btn-success"><i class="plus"></i> Học viên mới</a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="1">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Mã số</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại học viên</th>
                    <th>Số điện thoại người thân</th>
                    <th>Học vấn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($members)) {
                    $count = 0;
                    foreach ($members as $row) {
                        $count++; ?>
                <tr>
                    <td>
                        <?php echo $count; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_so']; ?>
                    </td>
                    <td>
                        <?php echo $row['ten']; ?>
                    </td>
                    <td>
                        <?php echo $row['email']; ?>
                    </td>
                    <td>
                        <?php echo $row['ngay_sinh']; ?>
                    </td>
                    <td>
                        <?php echo $row['sdt_hoc_vien']; ?>
                    </td>
                    <td>
                        <?php echo $row['sdt_nguoi_than']; ?>
                    </td>
                    <td>
                        <?php echo $row['hoc_van']; ?>
                    </td>
                    <td>
                        <a href="addEdit.php?ma_so=<?php echo $row['ma_so']; ?>" class="btn btn-warning">edit</a>
                        <a href="userAction.php?action_type=delete&ma_so=<?php echo $row['ma_so']; ?>"
                            class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                    </td>
                </tr>
                <?php }
                } else { ?>
                <tr>
                    <td colspan="7">Không có học viên...</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php
    if (isset($_POST['userSubmitProd'])) {
        try {
            // 
            //$sql1 = "EXEC ? = so_buoi_hoc ?";
            $sql1 = "{CALL so_buoi_hoc(?)}";
            $statement = $conn->prepare($sql1);
            // Execution
            //$retval = 1;
            $ten_chi_nhanh = $_POST['ten_chi_nhanh'];
            //$statement->bindValue(1, $retval, PDO::PARAM_INT);
            //$statement->bindParam(1, $ten_chi_nhanh, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
            if ($statement->execute([$ten_chi_nhanh]) === false) {
                echo print_r($conn->errorInfo(), true);
            }
            // Fetch data. 
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            //var_dump("Return value: " . $retval);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>


    <div id="Procedure1Wrapper" class="frameWrapper p-4">
        <div class="col">
            <div class="row justify-content-center">
                <div class="tableHeader text-center h6"> Số
                    buổi học của chi nhánh</div>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="1">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Mã số lớp học</th>
                    <th>Số buổi học</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if (!empty($result)) {
                        $count = 0;
                        foreach ($result as $row) {
                            $count++;
                    ?>
                    <td>
                        <?php echo $count; ?>
                    </td>
                    <td>
                        <?php echo $row['masolophoc']; ?>
                    </td>
                    <td>
                        <?php echo $row['sobuoihoc']; ?>
                    </td>
                </tr>
                <?php
                        }
                    } else { ?>
                <tr>
                    <td colspan="7">Không có dữ liệu...</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- học vấn                      -->
    <?php
    if (isset($_POST['userSubmitProd2'])) {
        try {
            // 
            //$sql1 = "EXEC ? = so_buoi_hoc ?";
            $sql2 = "{CALL hoc_phi_theo_hoc_van(?)}";
            $statement = $conn->prepare($sql2);
            // Execution
            //$retval = 1;
            $hoc_van = $_POST['hoc_van'];
            //$statement->bindValue(1, $retval, PDO::PARAM_INT);
            //$statement->bindParam(1, $ten_chi_nhanh, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 20);
            if ($statement->execute([$hoc_van]) === false) {
                echo print_r($conn->errorInfo(), true);
            }
            // Fetch data. 
            $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            //var_dump("Return value: " . $retval);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>


    <div id="Procedure1Wrapper" class="frameWrapper p-4">
        <div class="col">
            <div class="row justify-content-center">
                <div class="tableHeader text-center h6"> Xem học phí theo học vấn</div>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="1">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Ngôn ngữ</th>
                    <th>Học phí</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if (!empty($result2)) {
                        $count = 0;
                        foreach ($result2 as $row) {
                            $count++;
                    ?>
                    <td>
                        <?php echo $count; ?>
                    </td>
                    <td>
                        <?php echo $row['ngonngu']; ?>
                    </td>
                    <td>
                        <?php echo $row['hocphi']; ?>
                    </td>
                </tr>
                <?php
                        }
                    } else { ?>
                <tr>
                    <td colspan="7">Không có dữ liệu...</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>