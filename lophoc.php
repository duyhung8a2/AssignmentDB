 <!-- Lớp học -->
    <!-- <div id="lophocWrapper" class="frameWrapper p-4">
        <div class="row">
            <div class="col-md-12 head">
                <div class="tableHeader text-center"> Lớp học</div>

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
    </div> -->




    
    <div class="modal fade" id="userProdModal1Result" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header text-center">
                    <h4 class="modal-title white-text w-100 font-weight-bold py-2">Tìm số
                        buổi học của chi nhánh</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
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
                                if (isset($_POST['userSubmitProd'])) {
                                    echo "<td>HTML here</td>";
                                    try {
                                        // 
                                        $sql1 = "EXEC ? = so_buoi_hoc ?";
                                        $statement = $conn->prepare($sql1);
                                        if ($statement === false) {
                                            echo print_r($conn->errorInfo(), true);
                                        }
                                        // Execution
                                        $retval = 0;
                                        $ten_chi_nhanh =  trim(strip_tags($_POST['ten_chi_nhanh']));
                                        $statement->bindParam(1, $retval, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
                                        $statement->bindParam(2, $ten_chi_nhanh, PDO::PARAM_STR);
                                        if ($statement->execute() === false) {
                                            echo print_r($conn->errorInfo(), true);
                                        }
                                        // Fetch data. 
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        var_dump("Return value: " . $retval);
                                    }catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
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
                                        }
                                     
                                } else { ?>
                            <td>
                                <?php echo array_key_exists('userSubmitProd', $_POST) ? "1" : "0"; ?>
                            </td>
                            <tr>
                                <td colspan="7">Không có dữ liệu...</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                <!--/.Content-->
            </div>
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
                if (isset($_POST['userSubmitProd'])) {
                    echo "<td>HTML here</td>";
                    try {
                        // 
                        $sql1 = "EXEC ? = so_buoi_hoc ?";
                        $statement = $conn->prepare($sql1);
                        if ($statement === false) {
                            echo print_r($conn->errorInfo(), true);
                        }
                        // Execution
                        $retval = 0;
                        $ten_chi_nhanh = trim(strip_tags($_POST['ten_chi_nhanh']));
                        $statement->bindParam(1, $retval, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
                        $statement->bindParam(2, $ten_chi_nhanh, PDO::PARAM_STR);
                        if ($statement->execute() === false) {
                            echo print_r($conn->errorInfo(), true);
                        }
                        // Fetch data. 
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        var_dump("Return value: " . $retval);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
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
                    }

                } else { ?>
            <td>
                <?php echo array_key_exists('userSubmitProd', $_POST) ? "1" : "0"; ?>
            </td>
            <tr>
                <td colspan="7">Không có dữ liệu...</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>