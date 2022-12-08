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

// Get member data 
$memberData = $userData = array();
if (!empty($_GET['ma_so'])) {
    // Include database configuration file 
    require_once 'dbConfig.php';

    // Fetch data from SQL server by row ID 
    $sql = 'SELECT * FROM HOC_VIEN WHERE ma_so = ?';
    $query = $conn->prepare($sql);
    $query->execute([$_GET['ma_so']]);
    $memberData = $query->fetch(PDO::FETCH_ASSOC);
}
$userData = !empty($sessData['userData']) ? $sessData['userData'] : $memberData;
unset($_SESSION['sessData']['userData']);

$actionLabel = !empty($_GET['ma_so']) ? 'Edit' : 'Add';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
</head>

<body>
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
    <div class="container">
        <div class="col-md-12 align-items-center">
            <h2>
                <?php echo $actionLabel; ?> Học viên
            </h2>

        </div>
        <div class="col-md-12">
            <form method="post" action="userAction.php">
                <div class="form-group row">
                    <label>Tên</label>
                    <input type="text" class="form-control" name="ten" placeholder="Hãy nhập tên của bạn"
                        value="<?php echo !empty($userData['ten']) ? $userData['ten'] : ''; ?>" required="">
                </div>
                <div class="form-group row">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Hãy nhập email của bạn"
                        value="<?php echo !empty($userData['email']) ? $userData['email'] : ''; ?>" required="">
                </div>
                <div class="form-group row">
                    <label>Ngày sinh</label>
                    <input type="date" class="form-control" name="ngay_sinh" placeholder="Ví dụ: yyyy-mm-dd"
                        value="<?php echo !empty($userData['ngay_sinh']) ? $userData['ngay_sinh'] : ''; ?>" required="">
                </div>
                <div class="form-group row">
                    <label>Số điện thoại của bạn</label>
                    <input type="tel" class="form-control" name="sdt_hoc_vien" placeholder="Nhập số điện thoại của bạn"
                        value="<?php echo !empty($userData['sdt_hoc_vien']) ? $userData['sdt_hoc_vien'] : ''; ?>"
                        required="">
                </div>
                <div class="form-group row">
                    <label>Số điện thoại của người thân bạn</label>
                    <input type="tel" class="form-control" name="sdt_nguoi_than"
                        placeholder="Nhập số điện thoại của người thân bạn"
                        value="<?php echo !empty($userData['sdt_nguoi_than']) ? $userData['sdt_nguoi_than'] : ''; ?>"
                        required="">
                </div>
                <div class="form-group row">
                    <label>Trình độ học vấn</label>
                    <input type="number" class="form-control" name="hoc_van"
                        placeholder="Trình độ học vấn trên thang 12" min="1" max="12"
                        value="<?php echo !empty($userData['hoc_van']) ? $userData['hoc_van'] : ''; ?>" required="">
                </div>
                <div class="row">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                    <input type="hidden" name="ma_so"
                        value="<?php echo !empty($userData['ma_so']) ? $userData['ma_so'] : ''; ?>">
                    <input type="submit" name="userSubmit" class="btn btn-success" value="Submit">
                </div>

            </form>

        </div>
    </div>
</body>

</html>