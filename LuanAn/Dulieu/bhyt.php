<?php
ob_start();
session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
mysqli_query($connect, "SET NAMES UTF8");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thông tin đào tạo</title>

    <link href="../Content/bootstrap.css" rel="stylesheet">
    <link href="../Content/site.css" rel="stylesheet">
    <link href="../Content/menu.css" rel="stylesheet">
    <link href="../Content/css/Yersin.css" rel="stylesheet">

    <script src="../Scripts/modernizr-2.6.2.js"></script>

    <script src="../Scripts/jquery-1.10.2.js"></script>
    <!-- <script src="../Scripts/jquery.validate.unobtrusive.js"></script> -->

    <script src="../Scripts/respond.js"></script>
    <script src="../Scripts/bootstrap.min.js"></script>
    <script src="../Scripts/function.js"></script>

    <script type="text/javascript" src="../Scripts/moment.min.js"></script>
    <script src="../Content/select2_2.js"></script>
    <script type="text/javascript" src="../Scripts/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="../Content/bootstrap-datetimepicker.css">
    <link href="../Content/select2-bootstrap.css" rel="stylesheet">
    <link href="../Content/select2_2.css" rel="stylesheet">
    <link href="../Content/css/seek.css" rel="stylesheet">
</head>

<body cz-shortcut-listen="true" style="">
    <div class="" style="background:#fff;min-height:100vh; margin: 0px 1px">
        <div id="bg-transp" class="hide-trans"></div>
        <!-- Form insert -->
        <form id="ins-form" method="post" class="hidden2">
            <table id="tb-add" style="width: 100%;">
                <tr class="" style="position: relative;">
                    <td colspan="3" style="text-align: center; font-size: 26px; color: #337ab7; font-weight: 600;">THÊM
                        MỚI</td>
                    <td><button type="submit" class="btnclose" onclick="clicked_add()"
                            style="width: 35px; height: 35px; top: -10px; right: 2%;"><ion-icon
                                name="close-outline"></ion-icon></button></td>
                </tr>
                <tr class="">
                    <td class="form-outline1">
                        <input type="text" class="form-control form1" id="intg" name="intg" placeholder=" dd/mm/yyyy">
                        <label class="form-label1" for="intg">Ngày tham gia</label>
                    </td>
                    <td colspan="2" class="form-outline1">
                        <input type="gia" name="igia" id="igia" class="form-control form1" placeholder=" ">
                        <label class="form-label" for="igia">Giá</label>
                    </td>
                </tr>
                <tr class="">
                    <td colspan='2' id='iNotis' style='color: #18e729; font-size: 13px'>

                    </td>
                </tr>

                <tr class="">
                    <td colspan="2" style="text-align: center;">
                        <button type="button" id="btn-add" name="btn-add" class="btn btn-success">Thêm</button>
                    </td>
                </tr>
            </table>
        </form>

        <form method="post" enctype="multipart/form-data">
            <?php
            // process Update datas
            if (isset($_POST['btn-updates'])) {
                $dotold = $_POST["ip-dotold"];
                $newdot = $_POST["ip-dot"];
                $newntg = $_POST["ip-ntg"];
                $newgia = $_POST["ip-gia"];

                for ($i = 0; $i < count($dotold); $i++) 
                {
                    $uquery = "update bhyt SET Dot = $newdot[$i], NTG = '$newntg[$i]', Gia = $newgia[$i]
                    WHERE Dot = $dotold[$i]";
                    mysqli_query($connect, $uquery);
                }
            }
            ?>
            <header id="header">
                <div class="row" style="color: white">
                    <div class="col-md-10" style="background:#0A314F; height: 50px">
                        <div style="font-weight: bold; padding: 15px 20px 0px 100px; float: left">
                            Thành viên của
                        </div>
                        <div>
                            <a><img src="../Content/logo/Logo_IGC.png" style="width: 120px"></a>
                        </div>
                    </div>
                    <div class="col-md-2" style="background:#0A314F; height: 50px">
                        <div class="cus-ttcedu">
                            <div style="float:left">
                                <a href="https://www.youtube.com/channel/UCLxhuk1kJOMT-GN8wjNOy4g" target="_blank"><img
                                        src="../Content/logo/youtobe.png"></a>
                            </div>
                            <div style="float:left">
                                <a href="https://www.facebook.com/truongsonadezi/" target="_blank"><img
                                        src="../Content/logo/facebook.png"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <img style="width: 100%;max-height: 400px;" src="../Content/logo/banner-yersin.jpg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div id="header">
                            <nav class="navbar navbar-default stylecolor">
                                <div class="navbar-collapse collapse" id="menu">
                                    <ul class="nav navbar-nav">
                                        <li><a href="/LuanAn/index.php">Trang chủ</a></li>
                                        <li><a href="#"></a></li>
                                        <li><a href="#"></a></li>
                                    </ul>

                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="dropdown stylecolor">
                                            <a data-toggle="dropdown" href="" class="stylecolor">
                                                <span>
                                                    <?= $_SESSION['quyen'] ?> |
                                                    <?= $_SESSION['tk'] ?>
                                                </span>

                                                <span class="caret"></span>
                                            </a>

                                            <ul class="dropdown-menu stylecolor">
                                                <!-- cung url cua thong tin -->
                                                <li><a href="tttk.php">Thông tin</a></li>

                                                <!--  -->
                                                <li><a href="/LuanAn/changePass.php">Đổi mật khẩu</a></li>


                                                <li class="divider"></li>
                                                <li><a href="/LuanAn/logon.php">Đăng xuất</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>

            <div id="body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="accordion" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading menuhome" style="padding:10px">
                                    <a class="" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span style="color:#fff !important" class="glyphicon glyphicon-th"></span>
                                        <b style="color:#fff !important">Chức năng</b>
                                    </a>
                                </div>
                            </div>

                            <!-- Nav left -->
                            <div style="border:1px solid #dfdfdf;border-top:0px;background:#fff">
                                        <!-- navleft Trang ca nhan -->
                                        <div class="accordion-group" id="accordion-group">
                                            <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                                <a class="accordion-toggle collapse_0"
                                                    onclick="setCookie('menukey','collapse_0',1000)" data-toggle="collapse"
                                                    data-parent="#leftMenu" href="#collapse_0">
                                                    <span style="color: #003768 !important; padding-top: 10px !important;"
                                                        class="glyphicon glyphicon-chevron-right text-color">
                                                    </span> <span style="color:#333 !important">Thông tin</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12 accordion-inner"
                                                style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px" href="tttk.php">Thông
                                                                    tin cá nhân</a>
                                                            </li>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="https://drive.google.com/file/d/0B-pUp8vuvCF-NnB0S3NhNnptVHk4WWZTOC1hWXVKS2h0R0xz/view?resourcekey=0-L_j9oBOwH4X8D2LX7ISIAg">Hướng
                                                                    dẫn sử dụng</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- navleft Tra cuu thong tin -->
                                        <div class="accordion-group" id="accordion-group">
                                            <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                                <a class="accordion-toggle collapse_1"
                                                    onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                                    data-parent="#leftMenu" href="#collapse_1">
                                                    <span style="color: #003768 !important; padding-top: 10px !important;"
                                                        class="glyphicon glyphicon-chevron-right text-color">
                                                    </span> <span style="color:#333 !important">Dữ liệu</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12 accordion-inner"
                                                style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="/LuanAn/DuLieu/nienkhoa.php">Năm
                                                                    học</a>
                                                            </li>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="/LuanAn/DuLieu/khoa.php">Khoa</a>
                                                            </li>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="/LuanAn/DuLieu/lop.php">Lớp</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="accordion-group" id="accordion-group">
                                            <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                                <a class="accordion-toggle collapse_1"
                                                    onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                                    data-parent="#leftMenu" href="#collapse_1">
                                                    <span style="color: #003768 !important; padding-top: 10px !important;"
                                                        class="glyphicon glyphicon-chevron-right text-color">
                                                    </span> <span style="color:#333 !important">Quản lí</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12 accordion-inner"
                                                style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="/LuanAn/DuLieu/sinhVien.php">Sinh viên & BHYT</a>
                                                            </li>
                                                            <li style="padding:7px 0px">
                                                                <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                <a style="color:#333;margin-left:3px"
                                                                    href="/LuanAn/DuLieu/bhyt.php">Đợt</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-group" id="accordion-group">
                                                <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                                    <a class="accordion-toggle collapse_1"
                                                        onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                                        data-parent="#leftMenu" href="#collapse_1">
                                                        <span style="color: #003768 !important; padding-top: 10px !important;"
                                                            class="glyphicon glyphicon-chevron-right text-color">
                                                        </span> <span style="color:#333 !important">Mua</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="col-md-12 accordion-inner"
                                                    style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <ul>
                                                                <li style="padding:7px 0px">
                                                                    <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                    <a style="color:#333;margin-left:3px"
                                                                        href="/LuanAn/DuLieu/muaBHYT.php">Mua BHYT</a>
                                                                </li>
                                                                <li style="padding:7px 0px">
                                                                    <div id="test" style="width: 13px;
                                                                                height: 1px;
                                                                                border-bottom: 1px dotted #555;
                                                                                float: left;
                                                                                padding-top: 10px"></div>
                                                                    <a style="color:#333;margin-left:3px"
                                                                        href="/LuanAn/DuLieu/hoadon.php">Xuất hóa đơn</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <style>
                            th {
                                text-align: center;
                            }
                        </style>

                        <!-- content right -->
                        <div class="divmain">
                            <!-- content right title -->
                            <div class="bgtitle">Sinh viên</div>

                            <div>
                                <div class="form-horizontal"
                                    style="display: flex; width: 95%; justify-content: space-between; margin: auto; align-items: center">
                                    <div class="btn-common btn btn-default bl-tools1" id="add" name="btn-insert"
                                        onclick="clicked_add()"><ion-icon name="add"></ion-icon>
                                    </div>
                                </div>

                                <div id="divStudyProgams" style="overflow: auto;">
                                    <!-- data -->
                                    <table id="tb-lop" class="table table-responsive">
                                        <!-- <table class="table table-hover" id="tb-sv"> -->
                                        <thead>
                                            <tr id="tb-rheader">
                                                <th class="f-header">Đợt</th>
                                                <th class="f-header">Ngày tham gia</th>
                                                <th class="f-header">Giá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($dataSV = mysqli_query($connect, "Select * from bhyt")) {
                                                if (mysqli_num_rows($dataSV) > 0) {
                                                    while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                        $dot = $rows["Dot"];
                                                        $ntg = $rows["NTG"];
                                                        $gia = $rows["Gia"];

                                                        echo ("
                                                            <tr>
                                                                <input type='hidden' name='ip-dotold[]' value='$dot'>                                                                                                                                                                              
                                                                <td class='r-header' style='text-align: center;'>
                                                                    <input type='text' style='text-align: center;'  name='ip-dot[]' value='$dot'>
                                                                </td>
                                                                <td class='r-header' style='text-align: center;'>
                                                                    <input type='text' style='text-align: center;' name='ip-ntg[]' value='$ntg'>
                                                                </td>
                                                                <td class='r-header' style='text-align: center;'>
                                                                    <input type='text' style='text-align: center;' name='ip-gia[]' value='$gia'>
                                                                </td> 
                                                            </tr>
                                                        ");
                                                    }
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button class="btn-common btn btn-default bl-tools1" id="btn-updates"
                            style="color:#333 !important" type="submit" name="btn-updates">Lưu<ion-icon
                                style="font-size: 15px;" name="save-sharp"></ion-icon></button>

                    </div>
                </div>
            </div>

            <footer class="footer" style="margin-top: 20px;">
                <div style="background: #003768; color: white; ">
                    <div class="row">
                        <div class="col-md-3"> </div>
                        <div class="col-md-6"
                            style="height: 100px; padding-top: 5px; margin-bottom: 15px; display: flex; justify-content: space-around">
                            <div style="float:left; ">
                                <div style="padding-bottom: 20px">
                                    <img src="../Content/logo/YU_white.png"
                                        style="width: 127px; padding-top: 10px">
                                </div>
                            </div>
                            <div style="float:left; padding: 10px 0px 0px 15px ">
                                <div class="cus-ttcedu-footer" style="font-weight:bold">
                                    TRƯỜNG CAO ĐẲNG CÔNG NGHỆ VÀ QUẢN TRỊ SONADEZI
                                </div>
                                <div class="cus-ttcedu-footer">
                                    Địa chỉ: <b>Số 01, đường 6A, KCN Biên Hòa II, Biên Hòa, Đồng Nai </b>
                                </div>
                                <div class="cus-ttcedu-footer">
                                    Website: <b>www.sonadezi.edu.vn</b> | Email: <b>info@sonadezi.edu.vn</b>
                                </div>
                                <div class="cus-ttcedu-footer">
                                    Điện thoại: <b>0251.3994.011/012/013 </b> - Fax: <b>0251.3994.010 </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>

                </div>
                <div
                    style="width: 100%; height: 45px; background:#0A314F; color: white;font-size: 12px; font-weight: bold; padding-top: 15px">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        Copyright © 2019 PSC. All rights reserved
                    </div>
                </div>
            </footer>
        </form>

    </div>

    <?php
    ob_end_flush();
    ?>
    <script type="text/javascript">
        // event click btn-add(tool bar right)
        function clicked_add() {
            var div_hidden = document.getElementsByClassName("hidden2");
            var div_hidden1 = document.getElementById("bg-transp");
            for (var i = 0; i < div_hidden.length; i++) {
                div_hidden[i].classList.toggle("show2");
            }
            div_hidden1.classList.toggle("show-trans");
        }
        document.getElementById('btn-add').addEventListener('click', function () {
            var intg = document.getElementById('intg').value;
            var igia = document.getElementById('igia').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insertBHYT.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('iNotis').innerHTML = xhr.responseText;
                    } else {
                        console.error('Lỗi khi gửi dữ liệu');
                    }
                }
            };

            //&Lop: tên của cột trong csdl
            var formData = 'NTG=' + encodeURIComponent(intg) + '&Gia=' + encodeURIComponent(igia);
            xhr.send(formData);

            //thông báo 3s
            var inotis = document.getElementById('iNotis');
            inotis.style.display = 'block';
            setTimeout(() => {
                if (inotis) {
                    inotis.style.display = 'none';
                }
            }, 3000);
        });

        function changedSelect() {
            var selectElement = document.getElementById('field-lop');
            var selectedValueK = document.getElementById('field-khoa').value;
            var selectedValueNK = document.getElementById('field-nienkhoa').value;

            //rs select tag 
            selectElement.innerHTML = "";
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'filterSV.php?selectedValueKhoa=' + selectedValueK + '&selectedValueNKhoa=' + selectedValueNK, true);
            // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Cấu hình header
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    console.log(JSON.parse(xhr.responseText));
                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.value = data[i].value;
                        option.text = data[i].text;
                        selectElement.add(option);
                    }
                }
            };
            xhr.send();
        }

        function changeInputType() {
            var selectedOption = document.getElementById('field-search').value;
            var inputSearch = document.getElementById('ip-search');

            if (selectedOption === 'MSSV' || selectedOption === 'SoThangDong' || selectedOption === 'SoTienDong' || selectedOption === 'TinhTrang' || selectedOption === 'Dot') {
                inputSearch.type = 'number';
            }
            else {
                inputSearch.type = 'text';
            }
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>