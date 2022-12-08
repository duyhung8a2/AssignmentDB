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
$sql1 = "SELECT * FROM LOP_HOC ORDER BY ma_so DESC";
$query = $conn->prepare($sql);
$query->execute();
$members = $query->fetchAll(PDO::FETCH_ASSOC);

$query1 = $conn->prepare($sql1);
$query1->execute();
$classrooms = $query1->fetchAll(PDO::FETCH_ASSOC);

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
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./js/myScript.js">
    <!-- jQuery css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <!-- jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="./js/myScript.js"></script>
</head>

<body>
    <div id="container p-4">
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <a id="hocvien-btn" class="btn btn-primary" data-table="1" href="#" data-toggle="button"
                        aria-pressed="false" autocomplete="off">Học viên</a>
                    <a id="lophoc-btn" class="btn btn-primary" data-table="2" href="#" data-toggle="button"
                        aria-pressed="false" autocomplete="off">Lớp học</a>

                </div>
            </div>
        </div>
    </div>

    <div id="hocvienWrapper" class="frameWrapper p-4">
        <div class="row">
            <div class="col-md-12 head">
                <div class="tableHeader text-center"> Học viên</div>
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
                    <td colspan="7">No member(s) found...</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- Lớp học -->
    <div id="lophocWrapper" class="frameWrapper p-4">
        <div class="row">
            <div class="col-md-12 head">
                <div class="tableHeader text-center"> Lớp học</div>
                <!-- Add link -->
                <div class="float-right">
                    <a href="addEdit.php" class="btn btn-success"><i class="plus"></i> Lớp học mới</a>
                </div>
            </div>
        </div>
        <table id="table" class="table table-striped table-bordered" id="2">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Mã số lớp học</th>
                    <th>Số lượng học viên</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Mã khoá học</th>
                    <th>Mã giảng viên</th>
                    <th>Mã trợ giảng</th>
                    <th>Mã chi nhánh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($classrooms)) {
                    $count = 0;
                    foreach ($classrooms as $row) {
                        $count++; ?>
                <tr>
                    <td>
                        <?php echo $count; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_so']; ?>
                    </td>
                    <td>
                        <?php echo $row['so_luong_hoc_vien']; ?>
                    </td>
                    <td>
                        <?php echo $row['ngay_bat_dau']; ?>
                    </td>
                    <td>
                        <?php echo $row['ngay_ket_thuc']; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_khoa_hoc']; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_giang_vien']; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_TA']; ?>
                    </td>
                    <td>
                        <?php echo $row['ma_chi_nhanh']; ?>
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
                    <td colspan="7">No member(s) found...</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>