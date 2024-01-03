<?php
ob_start();
session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
mysqli_query($connect, "SET NAMES UTF8");
$NienKhoa = mysqli_query($connect, "Select * from nienkhoa order by NamHoc");
$Khoa = mysqli_query($connect, "Select * from khoa");

// var to export excel file
function updateCurSQL($curSQL, $condition)
{
    // nếu condition là string thì 2 bên phải có dấu cách VD: ' MSSV = 2020 '
    if (strstr($_SESSION['curSQL'], 'INNER')) {
        $position = strpos($_SESSION['curSQL'], 'WHERE');
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . " and " . $part2;
    } elseif ($position = strpos($_SESSION['curSQL'], 'where')) {
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . " and " . $part2;
    } elseif ($position === false) {
        $position = strpos($_SESSION['curSQL'], 'sinhvien');
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . $part2;
    } else {
        echo "func updateCurSQL = $curSQL";
    }
}
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
        <!-- search -->
        <form id="f-search" method="post" class="hidden3">
            <button type="button" class="btnclose" onclick="clicked_search()"><ion-icon
                    name="close-outline"></ion-icon></button>
            <div class="bl-search">
                <!-- document.getElementById('field-search').value=this.Option[this.selectedIndex].text -->
                <select style="width: auto" id="field-search" name="field-search" onchange="changeInputType()">
                    <option value="MSSV">MSSV</option>
                    <option value="Ho">Họ</option>
                    <option value="Ten">Tên</option>
                    <option value="MaTheBHYT">Mã thẻ BHYT</option>
                    <option value="Dot">Đợt</option>
                    <option value="SoThangDong">Số tháng đóng</option>
                    <option value="SoTienDong">Số tiền đóng</option>
                    <option value="TinhTrang">Tình trạng</option>
                    <option value="GhiChu">Ghi chú</option>
                </select>
                <input type="number" id="ip-search" name="ip-search" min="0">
                <button type="submit" class="btn btn-info" id="fs-btnfind" name="btn-find">Find</button>
            </div>
            <!-- <p style="font-size: 13px; margin: 5px 0 0 10%; width: 100%; text-align: left">Nếu muốn tìm những ô trống vui lòng nhập: "null"</p> -->
        </form>
        <form method="post" enctype="multipart/form-data">
            <?php
            if (isset($_POST['d-accept'])) {
                $selectedValues = $_POST['cb-mssv'];
                foreach ($selectedValues as $mssvd) {
                    mysqli_query($connect, "Delete from sinhvien where MSSV = " . $mssvd);
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
                        <div class="divmain" style="position: relative;">
                            <!-- content right title -->
                            <div class="bgtitle">Mua BHYT</div>
                            <div class="form-horizontal" style="text-align: center;">
                                <h3 colspan="3"
                                    style="text-align: center; font-size: 36px; color: #337ab7; font-weight: 600;">MUA
                                    BẢO HIỂM</h3>
                                <div class="" style="display: flex; justify-content: space-around;">
                                    <div class="form-outline1">
                                        <?php
                                        $resITinhtrang = mysqli_query($connect, "Select Dot from bhyt ORDER BY Dot DESC LIMIT 1");
                                        while ($row = mysqli_fetch_assoc($resITinhtrang)) {
                                            $idot = $row['Dot'];
                                            echo ("<input type='text' readonly name='newestDot' value='$idot'/>");
                                        }
                                        ?>
                                        <label class="form-label1" style="left: 5px; top: 0px" for="idot">Đợt</label>
                                    </div>
                                    <div class="form-outline1">
                                        <form method="get">
                                            <select style="width: 200px" id="selectOption" onchange="changeForm()"
                                                name="itype" class="form2">
                                                <?php
                                                if ($_GET['itype'] == 0) {
                                                    echo ("
                                                            <option selected value='0'>Lớp học</option>
                                                            <option value='1'>1 Sinh viên</option>
                                                        ");
                                                } else {
                                                    echo ("
                                                            <option value='0'>Lớp học</option>
                                                            <option selected value='1'>1 Sinh viên</option>
                                                        ");
                                                }
                                                ?>
                                            </select>
                                        </form>

                                        <label class="form-label1" style="left: 5px; top: 0px" for="idot">Loại
                                            hóa đơn</label>
                                    </div>
                                </div>
                            </div>

                            <form method="post">
                                <!-- lophoc -->
                                <div id="lopHocForm" style="display: none" style="position: relative">
                                    <!-- fiter -->
                                    <!-- <form method='post'> -->
                                    <div
                                        style="display: flex; justify-content: center; align-items: center; margin-top: 35px; margin-bottom: 25px;">
                                        <div class="form-group"
                                            style="margin-right: 0px; margin-left: 0px; display: flex; margin: 0;">
                                            <label class="control-label col-xs-12 col-sm-4 col-md-3">NienKhoa</label>
                                            <div class="col-xs-12 col-sm-8 col-md-9">
                                                <select style="width: auto" id="field-nienkhoa"
                                                    onchange="changedSelect()" name="field-nienkhoa">
                                                    <option value='all'>Tất cả</option>
                                                    <?php
                                                    $NienKhoa = mysqli_query($connect, "Select * from nienkhoa order by NamHoc");
                                                    while ($row = mysqli_fetch_assoc($NienKhoa)) {
                                                        $idnk = $row['IDNienKhoa'];
                                                        $namhoc = $row['NamHoc'];
                                                        echo ("<option value='$idnk'>$namhoc</option>");
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <label class="control-label col-xs-12 col-sm-4 col-md-3">Khoa</label>
                                            <div class="col-xs-12 col-sm-8 col-md-9">
                                                <select style="width: auto" id="field-khoa" onchange="changedSelect()"
                                                    name="field-khoa">
                                                    <option value='all'>Tất cả</option>
                                                    <?php
                                                    $Khoa = mysqli_query($connect, "Select * from khoa");
                                                    while ($row = mysqli_fetch_assoc($Khoa)) {
                                                        $idk = $row['IDKhoa'];
                                                        $tenkhoa = $row['TenKhoa'];
                                                        echo ("<option value='$idk'>$tenkhoa</option>");
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <label class="control-label col-xs-12 col-sm-4 col-md-3">Lớp</label>
                                            <div class="col-xs-12 col-sm-8 col-md-9">
                                                <select style="width: auto" id="field-lop" name="field-lop">

                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-info" type="submit" name="btn-filter">Lọc</button>
                                    </div>

                                    <button class="btn-common btn btn-default bl-tools1"
                                        style="position: absolute; z-index: 99; left: 28px; top: 174px;" id="search"
                                        type="button" onclick="clicked_search()" name="btn-search"><ion-icon
                                            name="search-outline"></ion-icon></button>
                                    <!-- </form>                          -->
                                    <div
                                        style='display: flex; flex-direction: column; justify-content: center; align-items: center'>
                                        <table id="tb-lop" class="table table-responsive">
                                            <thead>
                                                <tr id="tb-rheader">
                                                    <th class=""
                                                        style="display: flex; align-items: center; padding-top: 14px!important; justify-content: space-around; height: 43.5px">
                                                        <input type="checkbox" id="checkall" name="checkall" />Chọn
                                                    </th>
                                                    <th class="f-header">MSSV</th>
                                                    <th class="f-header">Họ Tên</th>
                                                    <th class="f-header">Lớp</th>
                                                    <th class="f-header">Tình trạng</th>
                                                    <th class="f-header">Mã thẻ BHYT</th>
                                                    <th class="f-header">Ngày tham gia</th>
                                                    <th class="f-header">Số tháng đóng</th>
                                                    <th class="f-header">Số tiền đóng</th>
                                                    <th class="f-header">Đợt</th>
                                                    <th class="f-header">Ghi chú</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST["btn-find"])) {
                                                    if ($_POST["ip-search"] == "") {
                                                        header("location: sinhvien.php");
                                                    } else {
                                                        $origin_string = $_POST["ip-search"];
                                                        $getquery = str_replace(
                                                            array('á', 'à', 'ả', 'ã', 'ạ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'đ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'),
                                                            array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', 'y'),
                                                            $origin_string
                                                        );
                                                        $getfield = $_POST["field-search"];

                                                        $s1ql = "select * from sinhvien inner join bhyt on 
                                                            sinhvien.Dot = bhyt.Dot
                                                            where sinhvien.$getfield LIKE '%$getquery%'";
                                                        if ($dataSV = mysqli_query($connect, $s1ql)) {
                                                            if (mysqli_num_rows($dataSV) > 0) {
                                                                while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                                    $mssv = $rows["MSSV"];
                                                                    $ho = $rows["Ho"];
                                                                    $ten = $rows["Ten"];
                                                                    $mathebhyt = $rows["MaTheBHYT"];
                                                                    //$ngaysinh = $rows["NgaySinh"]; //date("d/m/Y", strtotime($rows["NgaySinh"]));
                                                                    $ngaythamgia2 = $rows["NTG"]; //$rows["NTG"]; //date("d/m/Y", strtotime($rows["NTG"]));
                                                                    $sothangdong = $rows["SoThangDong"];
                                                                    $sotiendong = $rows["SoTienDong"];
                                                                    $tinhtrang = $rows["TinhTrang"];
                                                                    $ghichu = $rows["GhiChu"];
                                                                    $dot = $rows["Dot"];
                                                                    $lop = $rows["TenLop"];

                                                                    if ($tinhtrang == 0) {
                                                                        $ntt = 'Chưa mua';
                                                                    } else if ($tinhtrang == 1) {
                                                                        $ntt = 'Đã mua';
                                                                    } else {
                                                                        $ntt = 'Đang mua';
                                                                    }

                                                                    echo ("
                                                                        <tr>
                                                                    <td><input type='checkbox' class='mssv2' name='mssv1[]' readonly value='$mssv' /></td>
                                                                    <td class='r-header' style=' width: auto'>
                                                                        <label>$mssv</label>
                                                                    </td >
                                                                    <td class='r-header'>
                                                                        <label>$ho $ten</label>
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$lop</label>                                                               
                                                                    </td>

                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ntt</label>                                                               
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$mathebhyt</label>                                                               
                                                                    </td>                                                               
                                                                
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ngaythamgia2</label>   
                                                                    </td>
                                                                    <td class='r-header' style='text-align: center'>
                                                                        <input type='number' value='$sothangdong' name='sothangdong1[]'>                                                              
                                                                    </td>
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <input type='text' value='$sotiendong' name='sotiendong1[]'>                                                                                                                          
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$dot</label>  
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$ghichu</label>  
                                                                    </td>  
                                                                </tr>
                                                                    ");
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else if (isset($_POST["btn-filter"])) {
                                                    if (empty($_POST["field-lop"]) && $_POST["field-nienkhoa"] == "all" && $_POST["field-khoa"] == "all") {
                                                        if ($_POST["field-nienkhoa"] == "all" && $_POST["field-khoa"] == "all") {
                                                            $_SESSION['curSQL'] = "Select *
                                                                from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot 
                                                                order by TenLop Desc";
                                                        }
                                                        if ($dataSV = mysqli_query($connect, $_SESSION['curSQL'])) {
                                                            if (mysqli_num_rows($dataSV) > 0) {
                                                                while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                                    $mssv = $rows["MSSV"];
                                                                    $ho = $rows["Ho"];
                                                                    $ten = $rows["Ten"];
                                                                    $mathebhyt = $rows["MaTheBHYT"];
                                                                    //$ngaysinh = $rows["NgaySinh"]; //date("d/m/Y", strtotime($rows["NgaySinh"]));
                                                                    $ngaythamgia2 = $rows["NTG"]; //$rows["NTG"]; //date("d/m/Y", strtotime($rows["NTG"]));
                                                                    $sothangdong = $rows["SoThangDong"];
                                                                    $sotiendong = $rows["SoTienDong"];
                                                                    $tinhtrang = $rows["TinhTrang"];
                                                                    $ghichu = $rows["GhiChu"];
                                                                    $dot = $rows["Dot"];
                                                                    $lop = $rows["TenLop"];

                                                                    if ($tinhtrang == 0) {
                                                                        $ntt = 'Chưa mua';
                                                                    } else if ($tinhtrang == 1) {
                                                                        $ntt = 'Đã mua';
                                                                    } else {
                                                                        $ntt = 'Đang mua';
                                                                    }

                                                                    echo ("
                                                                        <tr>
                                                                    <td><input type='checkbox' class='mssv2' name='mssv1[]' readonly value='$mssv' /></td>
                                                                    <td class='r-header' style=' width: auto'>
                                                                        <label>$mssv</label>
                                                                    </td >
                                                                    <td class='r-header'>
                                                                        <label>$ho $ten</label>
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$lop</label>                                                               
                                                                    </td>

                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ntt</label>                                                               
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$mathebhyt</label>                                                               
                                                                    </td>                                                               
                                                                
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ngaythamgia2</label>   
                                                                    </td>
                                                                    <td class='r-header' style='text-align: center'>
                                                                        <input type='number' value='$sothangdong' name='sothangdong1[]'>                                                              
                                                                    </td>
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <input type='text' value='$sotiendong' name='sotiendong1[]'>                                                                                                                          
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$dot</label>  
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$ghichu</label>  
                                                                    </td>  
                                                                </tr>
                                                                    ");
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='8' class='r-header'>Không có dữ liệu</td></tr>";
                                                            }
                                                        }
                                                    } elseif (!empty($_POST["field-lop"])) {
                                                        if ($_POST["field-nienkhoa"] == "all" && $_POST["field-khoa"] != "all") {
                                                            $fieldKhoa = $_POST['field-khoa'];
                                                            $fieldLop = $_POST['field-lop'];
                                                            $_SESSION['curSQL'] = "Select * from sinhvien INNER join lop on sinhvien.TenLop =  lop.TenLop 
                                                                inner JOIN khoa on khoa.IDKhoa = lop.IDKhoa
                                                                inner join bhyt on sinhvien.Dot = bhyt.Dot   
                                                                WHERE khoa.IDKhoa = $fieldKhoa
                                                                AND lop.TenLop = '$fieldLop'";
                                                        } elseif ($_POST["field-nienkhoa"] != "all" && $_POST["field-khoa"] == "all") {
                                                            $fieldNienKhoa = $_POST['field-nienkhoa'];
                                                            $fieldLop = $_POST['field-lop'];
                                                            $_SESSION['curSQL'] = "Select * from sinhvien INNER join lop on sinhvien.TenLop =  lop.TenLop 
                                                                INNER JOIN nienkhoa on lop.IDNienKhoa = nienkhoa.IDNienKhoa
                                                                inner join bhyt on sinhvien.Dot = bhyt.Dot   
                                                                WHERE nienkhoa.IDNienKhoa = $fieldNienKhoa
                                                                AND lop.TenLop = '$fieldLop'";
                                                        } elseif ($_POST["field-nienkhoa"] != "all" && $_POST["field-khoa"] != "all") {
                                                            $fieldNienKhoa = $_POST['field-nienkhoa'];
                                                            $fieldKhoa = $_POST['field-khoa'];
                                                            $fieldLop = $_POST['field-lop'];
                                                            $_SESSION['curSQL'] = "Select * from sinhvien INNER join lop on sinhvien.TenLop =  lop.TenLop 
                                                                INNER JOIN nienkhoa on lop.IDNienKhoa = nienkhoa.IDNienKhoa
                                                                inner JOIN khoa on khoa.IDKhoa = lop.IDKhoa
                                                                inner join bhyt on sinhvien.Dot = bhyt.Dot   
                                                                WHERE nienkhoa.IDNienKhoa = '$fieldNienKhoa'
                                                                AND khoa.IDKhoa = $fieldKhoa
                                                                AND lop.IDLop = '$fieldLop'";
                                                        } else {
                                                            $fieldLop = $_POST['field-lop'];
                                                            $_SESSION['curSQL'] = "Select * from sinhvien INNER join lop on sinhvien.TenLop =  lop.TenLop   
                                                                inner join bhyt on sinhvien.Dot = bhyt.Dot                                                  
                                                                WHERE sinhvien.TenLop = '$fieldLop'";
                                                        }

                                                        if ($dataSV = mysqli_query($connect, $_SESSION['curSQL'])) {
                                                            if (mysqli_num_rows($dataSV) > 0) {
                                                                //echo($_SESSION['curSQL']);
                                                                while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                                    $mssv = $rows["MSSV"];
                                                                    $ho = $rows["Ho"];
                                                                    $ten = $rows["Ten"];
                                                                    $mathebhyt = $rows["MaTheBHYT"];
                                                                    //$ngaysinh = $rows["NgaySinh"]; //date("d/m/Y", strtotime($rows["NgaySinh"]));
                                                                    $ngaythamgia2 = $rows["NTG"]; //$rows["NTG"]; //date("d/m/Y", strtotime($rows["NTG"]));
                                                                    $sothangdong = $rows["SoThangDong"];
                                                                    $sotiendong = $rows["SoTienDong"];
                                                                    $tinhtrang = $rows["TinhTrang"];
                                                                    $ghichu = $rows["GhiChu"];
                                                                    $lop = $rows["TenLop"];
                                                                    $dot = $rows["Dot"];

                                                                    if ($tinhtrang == 0) {
                                                                        $ntt = 'Chưa mua';
                                                                    } else if ($tinhtrang == 1) {
                                                                        $ntt = 'Đã mua';
                                                                    } else {
                                                                        $ntt = 'Đang mua';
                                                                    }

                                                                    echo ("
                                                                        <tr>
                                                                    <td><input type='checkbox' class='mssv2' name='mssv1[]' readonly value='$mssv' /></td>
                                                                    <td class='r-header' style=' width: auto'>
                                                                        <label>$mssv</label>
                                                                    </td >
                                                                    <td class='r-header'>
                                                                        <label>$ho $ten</label>
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$lop</label>                                                               
                                                                    </td>

                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ntt</label>                                                               
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$mathebhyt</label>                                                               
                                                                    </td>                                                               
                                                                
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ngaythamgia2</label>   
                                                                    </td>
                                                                    <td class='r-header' style='text-align: center'>
                                                                        <input type='number' value='$sothangdong' name='sothangdong1[]'>                                                              
                                                                    </td>
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <input type='text' value='$sotiendong' name='sotiendong1[]'>                                                                                                                          
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$dot</label>  
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$ghichu</label>  
                                                                    </td>  
                                                                </tr>
                                                                    ");
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='8' class='r-header'>Không có dữ liệu</td></tr>";
                                                            }
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='8' class='r-header'>Vui lòng chọn lớp</td></tr>";
                                                    }
                                                } else {
                                                    if (empty($_SESSION['curSQL'])) {
                                                        $_SESSION['curSQL'] = "Select *
                                                                from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot 
                                                                order by TenLop Desc";
                                                    }
                                                    if ($dataSV = mysqli_query($connect, $_SESSION['curSQL'])) {
                                                        if (mysqli_num_rows($dataSV) > 0) {
                                                            //echo($_SESSION['curSQL']);
                                                            while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                                $mssv = $rows["MSSV"];
                                                                $ho = $rows["Ho"];
                                                                $ten = $rows["Ten"];
                                                                $mathebhyt = $rows["MaTheBHYT"];
                                                                //$ngaysinh = $rows["NgaySinh"]; //date("d/m/Y", strtotime($rows["NgaySinh"]));
                                                                $ngaythamgia2 = $rows["NTG"]; //$rows["NTG"]; //date("d/m/Y", strtotime($rows["NTG"]));
                                                                $sothangdong = $rows["SoThangDong"];
                                                                $sotiendong = $rows["SoTienDong"];
                                                                $tinhtrang = $rows["TinhTrang"];
                                                                $lop = $rows["TenLop"];
                                                                if ($tinhtrang == 0) {
                                                                    $ntt = 'Chưa mua';
                                                                } else if ($tinhtrang == 1) {
                                                                    $ntt = 'Đã mua';
                                                                } else {
                                                                    $ntt = 'Đang mua';
                                                                }
                                                                $ghichu = $rows["GhiChu"];
                                                                $dot = $rows["Dot"];

                                                                echo ("
                                                                <tr>
                                                                    <td><input type='checkbox' class='mssv2' name='mssv1[]' readonly value='$mssv' /></td>
                                                                    <td class='r-header' style=' width: auto'>
                                                                        <label>$mssv</label>
                                                                    </td >
                                                                    <td class='r-header'>
                                                                        <label>$ho $ten</label>
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$lop</label>                                                               
                                                                    </td>

                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ntt</label>                                                               
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$mathebhyt</label>                                                               
                                                                    </td>                                                               
                                                                
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ngaythamgia2</label>   
                                                                    </td>
                                                                    <td class='r-header' style='text-align: center'>
                                                                        <input type='number' value='$sothangdong' name='sothangdong1[]'>                                                              
                                                                    </td>
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <input type='text' value='$sotiendong' name='sotiendong1[]'>                                                                                                                          
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$dot</label>  
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$ghichu</label>  
                                                                    </td>  
                                                                </tr>
                                                                    ");
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div colspan='3' id='iNotis' style='color: #18e729; font-size: 13px'></div>
                                        <button type='submit' id='btn-add' style='text-align: center; width: 10%;'
                                            name='btn-buy' class='btn btn-success'>Mua</button>
                                    </div>
                                </div>

                                <!-- sinhvien -->
                                <div id="sinhVienForm" style="display: none">
                                    <!-- Nội dung form cho theo sinh viên -->
                                    <div class="bl-type"
                                        style="display: flex;justify-content: center;align-items: center;margin: 35px 0;">
                                        <label for="sinhVienInput">Mã sinh viên:</label>
                                        <input type="text" id="sinhVienInput" name="sinhVienInput">
                                        <input type="submit" name="btn_getType" value="Tìm" />
                                    </div>
                                    <?php
                                    if (isset($_POST["btn_getType"]) && !empty($_POST["btn_getType"])) {
                                        // $_SESSION['curOption'] = 1;
                                        echo "
                                            <div style='display: flex;flex-direction: column; align-items: center;'>
                                                <table id='tb-lop' class='table table-responsive'>
                                                    <thead>
                                                        <tr id='tb-rheader'>
                                                            <th class='f-header'>MSSV</th>
                                                            <th class='f-header'>Họ Tên</th>
                                                            <th class='f-header'>Lớp</th>
                                                            <th class='f-header'>Tình trạng</th>
                                                            <th class='f-header'>Mã thẻ BHYT</th>
                                                            <th class='f-header'>Ngày tham gia</th>
                                                            <th class='f-header'>Số tháng đóng</th>
                                                            <th class='f-header'>Số tiền đóng</th>
                                                            <th class='f-header'>Đợt</th>
                                                            <th class='f-header'>Ghi chú</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";
                                        $mssv_s = $_POST['sinhVienInput'];
                                        $sql = "select * from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where MSSV = '$mssv_s'";
                                        if ($dataSV = mysqli_query($connect, $sql)) {
                                            if (mysqli_num_rows($dataSV) > 0) {
                                                while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                    $mssv = $rows["MSSV"];
                                                    $ho = $rows["Ho"];
                                                    $ten = $rows["Ten"];
                                                    $mathebhyt = $rows["MaTheBHYT"];
                                                    $ngaythamgia2 = $rows["NTG"];
                                                    $sothangdong = $rows["SoThangDong"];
                                                    $sotiendong = $rows["SoTienDong"];
                                                    $tinhtrang = $rows["TinhTrang"];
                                                    $ghichu = $rows["GhiChu"];
                                                    $dot = $rows["Dot"];
                                                    if ($tinhtrang == 0) {
                                                        $ntt = 'Chưa mua';
                                                    } else if ($tinhtrang == 1) {
                                                        $ntt = 'Đã mua';
                                                    } else {
                                                        $ntt = 'Đang mua';
                                                    }
                                                    $lop = $rows["TenLop"];

                                                    $resITinhtrang = mysqli_query($connect, "Select Dot from bhyt ORDER BY Dot DESC LIMIT 1");
                                                    while ($r = mysqli_fetch_assoc($resITinhtrang)) {
                                                        $ndot = $r['Dot'];
                                                    }

                                                    echo ("
                                                                <tr>
                                                                    <input type='hidden' name='mssv2' readonly value='$mssv' />  
                                                                    <td class='r-header' style=' width: auto'>
                                                                        <label>$mssv</label>
                                                                    </td >
                                                                    <td class='r-header'>
                                                                        <label>$ho $ten</label>
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$lop</label>                                                               
                                                                    </td>

                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ntt</label>                                                               
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$mathebhyt</label>                                                               
                                                                    </td>                                                               
                                                                
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <label>$ngaythamgia2</label>   
                                                                    </td>
                                                                    <td class='r-header' style='text-align: center'>
                                                                        <input type='number' value='$sothangdong' name='sothangdong2'>                                                              
                                                                    </td>
                                                                    <td class='r-header' style='text-align: right'>
                                                                        <input type='text' value='$sotiendong' name='sotiendong2'>                                                                                                                          
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$dot</label>  
                                                                    </td>
                                                                    <td class='r-header'>
                                                                        <label>$ghichu</label>  
                                                                    </td>  
                                                                </tr>
                                                            ");
                                                }
                                            }
                                        } else {
                                            echo ("
                                                                <tr><td colspan='8' class='r-header'>Không có dữ liệu</td></tr>
                                                            ");
                                        }
                                        echo ("
                                                        </tbody>
                                                    </table>         
                                                <div colspan='3' id='iNotis' style='color: #18e729; font-size: 13px'></div>
                                                <button type='submit' id='btn-add' style='text-align: center; width: 10%;' name='btn-buysv' class='btn btn-success'>Mua</button>                                     
                                            </div>
                                            ");
                                    } else {
                                        echo ("
                                                <div class='r-header'>Hãy nhập tìm kiếm</div>
                                            ");
                                    }
                                    ?>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <?php
    if (isset($_POST["btn-buy"])) {
        // $isOK = true;
        $Masosinhvien = (!empty($_POST['mssv1'])) ? $_POST['mssv1'] : null;
        $type = (isset($_GET['itype'])) ? $_GET['itype'] : 0;
        if ($Masosinhvien != null) {
            $arr1 = array("");
            $arr2 = array("");
            $arr3 = array("");
            $resITinhtrang = mysqli_query($connect, "Select Dot from bhyt ORDER BY Dot DESC LIMIT 1");
            while ($row = mysqli_fetch_assoc($resITinhtrang)) {
                $ndot = $row['Dot'];
            }
            $NOW = getdate();
            $ngayhientai = $NOW['year'] . '-' . $NOW['mon'] . '-' . $NOW['mday'];

            $sothangdong = $_POST['sothangdong1'];
            $sotiendong = $_POST['sotiendong1'];
            $soluongsv = count($Masosinhvien);
            $tong = 0;

            for ($i = 0; $i < $soluongsv; $i++) {
                $resultsv = mysqli_query($connect, "select * FROM sinhvien where MSSV = '$Masosinhvien[$i]'");
                $r = mysqli_fetch_assoc($resultsv);
                $tt = $r['TinhTrang'];
                if ($tt != 2 && $tt != 1) {
                    $getTienCanDong = mysqli_query($connect, "select Gia FROM bhyt where Dot = $ndot");
                    while ($row = mysqli_fetch_assoc($getTienCanDong)) {
                        $gia = $row["Gia"];
                    }

                    if ($sothangdong[$i] == 0) {
                        $tiencandong = $gia;
                    } else {
                        $tiencandong = $gia * (double) $sothangdong[$i];
                    }
                    if ($sotiendong[$i] == 0.000) {
                        $check = false;
                    } else {
                        $check = true;
                    }

                    if ($sotiendong[$i] >= (double) ($tiencandong - 0.1) && $check === true) {
                        (double) $tong = (double) $tong + $sotiendong[$i];
                        mysqli_query($connect, "insert into Hoadon (Dot,NgayXuat,Type) values ($ndot,'$ngayhientai',$type)");
                        $mahdrs = mysqli_query($connect, "Select MaHD from hoadon ORDER BY MaHD DESC LIMIT 1");
                        $ro = mysqli_fetch_assoc($mahdrs);
                        $idHD = $ro['MaHD'];
                        mysqli_query($connect, "insert into cthd (MaHD,MSSV,ThanhTien,SoThang) values ($idHD,'$Masosinhvien[$i]',$tiencandong,$sothangdong[$i])");
                        mysqli_query($connect, "update sinhvien set Dot = $ndot, TinhTrang = 2, SoThangDong = $sothangdong[$i], SoTienDong = $sotiendong[$i] where MSSV = '$Masosinhvien[$i]'");
                    } else {
                        $_SESSION['notis'] = 1;
                        array_push($arr1, $Masosinhvien[$i]);
                    }
                } else {
                    // if ($tt == 1) {
                    //     $_SESSION['notis'] = 3;
                    //     array_push($arr2, $Masosinhvien[$i]);
                    //     break;
                    // } 
                    if($tt == 2) {
                        $_SESSION['notis'] = 4;
                        array_push($arr3, $Masosinhvien[$i]);
                    }
                }
            }
            $_SESSION['arr1'] = $arr1;
            // $_SESSION['arr2'] = $arr2;
            $_SESSION['arr3'] = $arr3;
            mysqli_query($connect, "update HoaDon set Total = $tong where MaHD = $idHD");
            header("location: /LuanAn/DuLieu/muaBHYT.php?itype=$type");
        } else {
            echo (
                "<script type='text/javascript'>
                        alert('Vui lòng chọn sinh viên nào muốn mua!');
                    </script>"
            );
        }

    } else if (isset($_POST["btn-buysv"])) {
        $Masosinhvien = $_POST['mssv2'];
        $resITinhtrang = mysqli_query($connect, "Select Dot from bhyt ORDER BY Dot DESC LIMIT 1");
        while ($row = mysqli_fetch_assoc($resITinhtrang)) {
            $ndot = $row['Dot'];
        }
        $checkType = $_GET['itype'];
        $type = ($checkType == null) ? 0 : $checkType;
        $sothangdong = $_POST['sothangdong2'];
        $sotiendong = $_POST['sotiendong2'];
        $NOW = getdate();
        $ngayhientai = $NOW['year'] . '-' . $NOW['mon'] . '-' . $NOW['mday'];
        $resultsv = mysqli_query($connect, "select * FROM sinhvien where MSSV = '$Masosinhvien'");
        while ($r = mysqli_fetch_assoc($resultsv)) {
            $tt = $r['TinhTrang'];

            if ($tt != 2 && $tt != 1) {
                $getTienCanDong = mysqli_query($connect, "select Gia FROM bhyt where Dot = $ndot");
                while ($row = mysqli_fetch_assoc($getTienCanDong)) {
                    $gia = $row["Gia"];
                }

                if ($sothangdong == 0) {
                    $tiencandong = $gia;
                } else {
                    $tiencandong = $gia * (double) $sothangdong;
                }
                if ($sotiendong == 0.000) {
                    $check = false;
                } else {
                    $check = true;
                }
                if ($sotiendong >= (double) ($tiencandong - 0.01) && $check === true) {
                    mysqli_query($connect, "insert into hoadon (Dot,NgayXuat,Total,Type) values ($ndot,'$ngayhientai',$tiencandong,$type);");
                    $mahdrs = mysqli_query($connect, "Select MaHD from hoadon ORDER BY MaHD DESC LIMIT 1");
                    $ro = mysqli_fetch_assoc($mahdrs);
                    $idHD = $ro['MaHD'];
                    mysqli_query($connect, "insert into cthd (MaHD,MSSV,ThanhTien,SoThang) values ($idHD,'$Masosinhvien',$tiencandong,$sothangdong)");
                    mysqli_query($connect, "update sinhvien set Dot = $ndot, TinhTrang = 2, SoThangDong = $sothangdong, SoTienDong = $sotiendong where MSSV = '$Masosinhvien'");
                    echo (
                        "<script type='text/javascript'>
                                alert('Mua thành công.');
                            </script>"
                    );
                } else {
                    echo (
                        "<script type='text/javascript'>
                                alert('Sinh viên chưa đóng đủ tiền không thể mua.');
                            </script>"
                    );
                }
            } else {
                if ($tt == 1) {
                    echo ("<script type='text/javascript'>
                                alert('BHYT của sinh viên: Đã có. Không thể mua.');
                            </script>"
                    );
                } else {
                    echo ("
                        <script type='text/javascript'>
                            alert('BHYT của sinh viên: Đang mua. Không thể mua.');
                        </script>"
                    );
                }
            }
        }
    }
    ?>

    <footer class="footer" style="margin-top: 20px;">
        <div style="background: #003768; color: white; ">
            <div class="row">
                <div class="col-md-3"> </div>
                <div class="col-md-6"
                    style="height: 100px; padding-top: 5px; margin-bottom: 15px; display: flex; justify-content: space-around">
                    <div style="float:left; ">
                        <div style="padding-bottom: 20px">
                            <img src="../Content/logo/YU_white.png" style="width: 127px; padding-top: 10px">
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
    <?php
    if (isset($_SESSION['notis'])) {
        if ($_SESSION['notis'] == 1 && isset($_SESSION['arr1'])) {
            echo "
                <script type='text/javascript'>
                    alert('Sinh viên chưa đóng đủ tiền không thể mua. MSSV:";

            for ($i = 0; $i < count($_SESSION['arr1']); $i++) {
                $masosinhvien = $_SESSION['arr1'][$i];
                echo "$masosinhvien" . " ;";
            }
            echo "');
                </script>";
            // unset($_SESSION['arr1']);
        } 
        // else if ($_SESSION['notis'] == 3 && isset($_SESSION['arr2'])) {
        //     echo "
        //             <script type='text/javascript'>
        //                 alert('BHYT của sinh viên: Đã có. Không thể mua. MSSV:";

        //     for ($i = 0; $i < count($_SESSION['arr2']); $i++) {
        //         $masosinhvien = $_SESSION['arr2'][$i];
        //         echo "$masosinhvien" . " ;";
        //     }
        //     echo "');
        //             </script>";
        // }
         else if ($_SESSION['notis'] == 4 && isset($_SESSION['arr3'])) {
            echo "
                <script type='text/javascript'>
                    alert('BHYT của sinh viên: Đang mua. Không thể mua. MSSV:  ";

            for ($i = 0; $i < count($_SESSION['arr3']); $i++) {
                $masosinhvien = $_SESSION['arr3'][$i];
                echo "$masosinhvien" . " ;";
            }
            echo "');
                </script>";
        }
    }
    ob_end_flush();
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            // Xử lý sự kiện khi checkbox với id là 'checkall' được thay đổi
            $('#checkall').change(function () {
                // Nếu checkbox 'checkall' được chọn
                if (this.checked) {
                    // Thiết lập checked cho tất cả các checkbox có class là 'mssv2'
                    $('.mssv2').prop('checked', true);
                } else {
                    // Bỏ checked cho tất cả các checkbox có class là 'mssv2'
                    $('.mssv2').prop('checked', false);
                }
            });
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
        function changeForm() {
            var selectOption = document.getElementById("selectOption");
            var lopHocForm = document.getElementById("lopHocForm");
            var sinhVienForm = document.getElementById("sinhVienForm");
            if (selectOption.value == 0) {
                lopHocForm.style.display = "block";
                sinhVienForm.style.display = "none";
                //k reload
                //window.history.replaceState(null, document.title, "?itype=0");
                window.location.href = "/LuanAn/DuLieu/muaBHYT.php?itype=0";
            } else if (selectOption.value == 1) {
                lopHocForm.style.display = "none";
                sinhVienForm.style.display = "block";
                //k reload
                //window.history.replaceState(null, document.title, "?itype=1");
                window.location.href = "/LuanAn/DuLieu/muaBHYT.php?itype=1";
            }
        }

        var selectOption = document.getElementById("selectOption");
        var lopHocForm = document.getElementById("lopHocForm");
        var sinhVienForm = document.getElementById("sinhVienForm");
        if (selectOption.value == 0) {
            lopHocForm.style.display = "block";
            sinhVienForm.style.display = "none";
            check = 0;
        } else if (selectOption.value == 1) {
            lopHocForm.style.display = "none";
            sinhVienForm.style.display = "block";
        }

        // document.getElementById('btn-add').addEventListener('click', function () {
        //     var imssv = document.getElementById('imssv').value;
        //     var iho = document.getElementById('iho').value;
        //     var iten = document.getElementById('iten').value;
        //     var igioitinh = document.getElementById('igioitinh').value;
        //     var ingaysinh = document.getElementById('ingaysinh').value;
        //     var ilop = document.getElementById('ilop').value;
        //     var iphuongxa = document.getElementById('iphuongxa').value;
        //     var iquanhuyen = document.getElementById('iquanhuyen').value;
        //     var itinhthanh = document.getElementById('itinhthanh').value;
        //     var ibhyt = document.getElementById('ibhyt').value;
        //     var isotiendong = document.getElementById('isotiendong').value;
        //     var ingaythamgia = document.getElementById('ingaythamgia').value;
        //     var isothangdong = document.getElementById('isothangdong').value;
        //     var icccd = document.getElementById('icccd').value;
        //     var ighichu = document.getElementById('ighichu').value;

        //     var xhr = new XMLHttpRequest();
        //     xhr.open('POST', 'insertProcess.php', true);
        //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //     xhr.onreadystatechange = function () {
        //         if (xhr.readyState === XMLHttpRequest.DONE) {
        //             if (xhr.status === 200) {
        //                 document.getElementById('iNotis').innerHTML = xhr.responseText;
        //             } else {
        //                 console.error('Lỗi khi gửi dữ liệu');
        //             }
        //         }
        //     };

        //     //&Lop: tên của cột trong csdl
        //     var formData = 'MSSV=' + encodeURIComponent(imssv) + '&Ho=' + encodeURIComponent(iho) + '&Ten=' + encodeURIComponent(iten) + '&GioiTinh=' + encodeURIComponent(igioitinh) + '&NgaySinh=' + encodeURIComponent(ingaysinh)
        //         + '&TenLop=' + encodeURIComponent(ilop) + '&PhuongXa=' + encodeURIComponent(iphuongxa) + '&QuanHuyen=' + encodeURIComponent(iquanhuyen) + '&TinhThanh=' + encodeURIComponent(itinhthanh) + '&MaTheBHYT=' + encodeURIComponent(ibhyt)
        //         + '&NTG=' + encodeURIComponent(ingaythamgia) + '&SoThangDong=' + encodeURIComponent(isothangdong) + '&SoTienDong=' + encodeURIComponent(isotiendong) + '&SoCCCD=' + encodeURIComponent(icccd) + '&GhiChu=' + encodeURIComponent(ighichu);
        //     xhr.send(formData);

        //     //thông báo 3s
        //     var inotis = document.getElementById('iNotis');
        //     inotis.style.display = 'block';
        //     setTimeout(() => {
        //         if (inotis) {
        //             inotis.style.display = 'none';
        //         }
        //     }, 3000);
        // });

        function clicked_search() {
            var div_hidden = document.getElementsByClassName("hidden3");
            var div_hidden1 = document.getElementById("bg-transp");
            for (var i = 0; i < div_hidden.length; i++) {
                div_hidden[i].classList.toggle("show3");
            }
            div_hidden1.classList.toggle("show-trans");
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>