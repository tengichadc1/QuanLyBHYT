<?php
session_start();
ob_start();
#Librady
require 'phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once "Query.php";
$query = new Query();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$connect = new mysqli("localhost", "root", "", "db_luanan");
mysqli_query($connect, "SET NAMES UTF8");
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thông tin đào tạo</title>

    <link href="/Luanan/Content/bootstrap.css" rel="stylesheet">
    <link href="/Luanan/Content/site.css" rel="stylesheet">
    <link href="/Luanan/Content/menu.css" rel="stylesheet">
    <link href="/Luanan/Content/css/Yersin.css" rel="stylesheet">

    <script src="/Luanan/Scripts/modernizr-2.6.2.js"></script>

    <script src="/Luanan/Scripts/jquery-1.10.2.js"></script>
    <script src="/Luanan/Scripts/jquery.validate.unobtrusive.js"></script>

    <script src="/Luanan/Scripts/respond.js"></script>
    <script src="/Luanan/Scripts/bootstrap.min.js"></script>
    <script src="/Luanan/Scripts/function.js"></script>

    <script type="text/javascript" src="/Luanan/Scripts/moment.min.js"></script>
    <script type="text/javascript" src="/Luanan/Scripts/bootstrap-datetimepicker.min.js"></script>


    <link rel="stylesheet" href="/Luanan/Content/bootstrap-datetimepicker.css">
    <link href="/Luanan/Content/select2-bootstrap.css" rel="stylesheet">
    <link href="/Luanan/Content/select2_2.css" rel="stylesheet">
    <link rel="stylesheet" href="/Luanan/Content/css/seek.css">
    <script src="/Luanan/Content/select2_2.js"></script>

</head>

<body cz-shortcut-listen="true" style="">
    <div class="" style="background:#fff;min-height:100vh; margin: 0px 1px">
        <header id="header">
            <div class="row" style="color: white">
                <div class="col-md-10" style="background:#0A314F; height: 50px">
                    <div style="font-weight: bold; padding: 15px 20px 0px 100px; float: left">
                        Thành viên của
                    </div>
                    <div>
                        <a><img src="/Luanan/Content/logo/Logo_IGC.png" style="width: 120px"></a>
                    </div>
                </div>
                <div class="col-md-2" style="background:#0A314F; height: 50px">
                    <div class="cus-ttcedu">
                        <div style="float:left">
                            <a href="https://www.youtube.com/channel/UCLxhuk1kJOMT-GN8wjNOy4g" target="_blank"><img
                                    src="/Luanan/Content/logo/youtobe.png"></a>
                        </div>
                        <div style="float:left">
                            <a href="https://www.facebook.com/truongsonadezi/" target="_blank"><img
                                    src="/Luanan/Content/logo/facebook.png"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <img style="width: 100%;max-height: 400px;" src="/Luanan/Content/logo/banner-yersin.jpg">
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
                                            <li><a href="/Home/Info">Thông tin</a></li>

                                            <!--  -->
                                            <li><a href="">Đổi mật khẩu</a></li>


                                            <li class="divider"></li>
                                            <li><a href="/Login/Logout">Đăng xuất</a></li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div id="body" style="padding-bottom: 5px">
            <div class="row">
                <div class="col-md-9" style="width: 100%">
                    <style>
                        th {
                            text-align: center;
                        }
                    </style>

                    <!-- content right -->
                    <div class="divmain">
                        <form method="post" enctype="multipart/form-data">

                            <a style="margin: 0px 0px 0px 8px; position: relative; bottom: 5px"
                                href="/LuanAn/DuLieu/sinhvien.php">Quay lại</a>
                            <!-- content right title -->
                            <div class="bgtitle">Import</div>
                            <div>
                                <div id="divStudyProgams" style="overflow-x:scroll">
                                    <div class="row1"
                                        style="display: flex; width: 90%; justify-content: space-between; margin: auto; align-items: center;">
                                        <a href="/LuanAn/sample.xlsx" name="sample" style="margin-left: 10px;"
                                            class="btn btn-default">Mẫu File excel import (Sample)</a>

                                        <div class="bl-display" style="display: flex;">
                                            <input type="file" id="ip-import" accept=".xls, .xlsx" name="ip-import"/>
                                            <button id="openFileButton" style="display: none" class="btn-common">Mở Tệp
                                                Excel</button>
                                            <button class="btn-common" name="btn-import">Import</button>
                                        </div>

                                        <!-- <div id="block-import" style="display: flex; align-items: center">
                                        </div> -->
                                    </div>

                                    <div id="excelContainer"></div>
                                </div>

                                <?php
                                if (isset($_POST["btn-import"])) {
                                    if (isset($_FILES["ip-import"])) {
                                        $target_dir = "uploads/"; // Thư mục lưu trữ file upload
                                        $target_file = $target_dir . basename($_FILES["ip-import"]["name"]);
                                        $uploadOk = 1;
                                        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                        // Kiểm tra kiểu file
                                        if ($fileType != "xlsx" && $fileType != "xls") {
                                            echo "Chỉ chấp nhận file Excel.";
                                            $uploadOk = 0;
                                        }

                                        if ($uploadOk == 1) {
                                            if (move_uploaded_file($_FILES["ip-import"]["tmp_name"], $target_file)) {
                                                $inputFileName = 'file.xlsx';
                                                $spreadsheet = IOFactory::load($target_file);
                                                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                                                $arrayCount = count($sheetData);
                                                for ($i = 2; $i <= $arrayCount; $i++) {
                                                    $dataLop = mysqli_query($connect, "select TenLop from lop");

                                                    $mssv = trim($sheetData[$i]["B"]);
                                                    $ho = trim($sheetData[$i]["C"]);
                                                    $ten = trim($sheetData[$i]["D"]);
                                                    $mathebhyt = trim($sheetData[$i]["K"]);
                                                    $gioitinh = trim($sheetData[$i]["E"]);
                                                    $lop = trim($sheetData[$i]["G"]);
                                                    $sothangdong = trim($sheetData[$i]["M"]);
                                                    $phuongxa = trim($sheetData[$i]["H"]);
                                                    $quanhuyen = trim($sheetData[$i]["I"]);
                                                    $tinhthanh = trim($sheetData[$i]["J"]);
                                                    $cccd = trim($sheetData[$i]["O"]);
                                                    $ghichu = trim($sheetData[$i]["P"]);
                                                    $ngaysinh = $sheetData[$i]["F"];
                                                    $dot = trim($sheetData[$i]["R"]);
                                                    $tinhtrang = trim($sheetData[$i]["Q"]);
                                                    //$ngaysinh = date("Y-m-d", strtotime($ns));   

                                                    //$ngaythamgia = trim($sheetData[$i]["L"]);
                                                    //$ngaythamgia1 = date("Y-m-d", strtotime($ngaythamgia));
                                
                                                    $so = trim($sheetData[$i]["N"]);
                                                    $sotiendong = str_replace(",", ".", $so);

                                                    $lopTonTai = false; // Biến này sẽ kiểm tra xem $lophay có tồn tại trong kết quả hay không

                                                    while ($row = mysqli_fetch_assoc($dataLop)) {
                                                        if ($row['TenLop'] === $lop) {
                                                            $lopTonTai = true;
                                                            break; // Nếu tìm thấy, thoát khỏi vòng lặp
                                                        }
                                                    }

                                                    if ($lopTonTai) {
                                                        mysqli_query($connect,"insert INTO `sinhvien`(MSSV, Ho, Ten, GioiTinh, NgaySinh, TenLop, PhuongXa, QuanHuyen, TinhThanh, MaTheBHYT, SoThangDong, SoTienDong, SoCCCD, GhiChu, TinhTrang, Dot) 
                                                            VALUES ('$mssv','$ho','$ten','$gioitinh','$ngaysinh','$lop','$phuongxa','$quanhuyen','$tinhthanh','$mathebhyt',$sothangdong,$sotiendong,'$cccd','$ghichu',$tinhtrang,$dot)");
                                                    } else {
                                                        echo ("<h3>Chưa có lớp: <b>'$lop'</b></h3>
                                                        ");
                                                    }                                                                                                           
                                                    // mysqli_query($connect,"insert INTO `lop` (`TenLop`, `SiSo`, `IDKhoa`, `IDNienKhoa`) VALUES ('$lop', 0, 1, 1)");
                                                    // mysqli_query($connect,"insert INTO `sinhvien`(MSSV, Ho, Ten, GioiTinh, NgaySinh, TenLop, PhuongXa, QuanHuyen, TinhThanh, MaTheBHYT, SoThangDong, SoTienDong, SoCCCD, GhiChu, TinhTrang, Dot) 
                                                    // VALUES ('$mssv','$ho','$ten','$gioitinh','$ngaysinh','$lop','$phuongxa','$quanhuyen','$tinhthanh','$mathebhyt',$sothangdong,$sotiendong,'$cccd','$ghichu',$tinhtrang,$dot)");
                                            



                                                    // $query->ThemMoi(
                                                    //     "sinhvien",
                                                    //     ["MSSV", "Ho", "Ten", "GioiTinh", "NgaySinh", "TenLop", "PhuongXa", "QuanHuyen", "TinhThanh", "MaTheBHYT", "SoThangDong", "SoTienDong", "SoCCCD", 
                                                    //     "GhiChu", "TinhTrang", "Dot"],
                                                    //     ["MSSV" => , "Ho" => $ho, "Ten" => $ten, "GioiTinh" => $gioitinh, "NgaySinh" => $ngaysinh, "TenLop" => $lop, "PhuongXa" => $phuongxa, 
                                                    //     "QuanHuyen" => $quanhuyen, "TinhThanh" => $tinhthanh, "MaTheBHYT" => $mathebhyt, "SoThangDong" => $sothangdong,
                                                    //     "SoTienDong" => $sotiendong, "SoCCCD" => $cccd, "GhiChu" => $ghichu, "TinhTrang" => $tinhtrang, "Dot" => $dot]
                                                    // );
                                                }
                                                echo "<span id='iNotis' style='width: 300px' class='label label-success'>Import thành công.</span>";
                                            } else {
                                                echo "<span id='iNotis' style='width: 300px' class='label label-danger'>Có lỗi xảy ra khi tải lên file.</span>";
                                            }
                                        }
                                    } 
                                    else {
                                        echo "<span id='iNotis' style='width: 300px' class='label label-danger'>Chưa chọn file hoặc có lỗi xảy ra.</span>";
                                    }
                                }

                                // if(isset($_POST["sample"]))
                                // {
                                //     header("location: sample.xlsx");
                                // }
                                ?>



                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <footer class="footer">
            <div style="background: #003768; color: white; ">
                <div class="row">
                    <div class="col-md-1"> </div>
                    <div class="col-md-10" style="height: 100px; padding-top: 5px; margin-bottom: 15px">
                        <div style="float:left; ">
                            <div style="padding-bottom: 20px">
                                <img src="/Luanan/Content/logo/YU_white.png" style="width: 127px; padding-top: 10px">
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
                    <div class="col-md-7">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
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
    </div>
    <script type="text/javascript">
        const fileInput = document.getElementById("ip-import");
        const openFileButton = document.getElementById("openFileButton");
        const excelContainer = document.getElementById("excelContainer");

        openFileButton.addEventListener("click", function () {
            fileInput.click();
        });

        fileInput.addEventListener("change", function (e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const data = e.target.result;

                    // Sử dụng thư viện SheetJS để hiển thị tệp Excel trong trình duyệt
                    const workbook = XLSX.read(data, { type: "array" });

                    // Truy xuất sheet đầu tiên từ workbook
                    const sheet = workbook.Sheets[workbook.SheetNames[0]];

                    // Chuyển sheet thành HTML table
                    const htmlTable = XLSX.utils.sheet_to_html(sheet);

                    // Hiển thị bảng HTML trong div có id là "excelContainer"
                    excelContainer.innerHTML = htmlTable;
                };

                reader.readAsArrayBuffer(file);
            }
        });

        var inotis = document.getElementById('iNotis');
        inotis.style.display = 'block';
        setTimeout(() => {
            if (inotis) {
                inotis.style.display = 'none';
            }
        }, 3000);
    </script>
    <script src="/LuanAn/sheetjs-github/dist/xlsx.full.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>