<?php
    ob_start();
    session_start();
    require 'phpspreadsheet/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($connect, "SET NAMES UTF8");
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
?>
<html >
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
    <link href="/LuananContent/select2_2.css" rel="stylesheet">
    <link href="/Luanan/Content/select2_2.css" rel="stylesheet">
    <script src="/Luanan/Content/select2_2.js"></script>
    <link rel="stylesheet" href="/Luanan/Content/css/seek.css">
</head>

<body cz-shortcut-listen="true" style="">
    <form method="post">
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
                                                <span><?=$_SESSION['quyen']?> | <?=$_SESSION['tk']?></span>

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
                    <div class="col-md-3">
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
                                                        <a style="color:#333;margin-left:3px" href="/Home/info">Thông
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
                                                            dẫn sử dụng cho SV</a>
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
                                                            href="/LuanAn/import.php">Import</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/export.php">Export</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px" href="/LuanAn/DuLieu/nienkhoa.php">Niên
                                                            khoá</a>
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
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/sinhVien.php">Sinh viên</a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <style>
                            th {
                                text-align: center;
                            }
                        </style>

                        <!-- content right -->
                        <div class="divmain">
                            <!-- content right title -->
                            <div class="bgtitle">Export</div>

                            <div>
                                <div id="divStudyProgams" style="overflow-x:scroll">
                                    <div class="form-horizontal">
                                        <div id="block-import" class="form-group" style="margin-right: 0px; margin-left: 10px;">
                                            <label class="lbl-Export" for="Export">Theo</label>

                                            <!-- onchange="document.getElementById('fieldExport').value=this.options[this.selectedIndex].text" -->
                                            <select style="width: auto;" id="fieldExport" class="fieldExport" name="fieldExport">
                                                <option value="all">Tất cả</option>
                                                <option value="dsLop">SV theo lớp</option>
                                                <option value="dsDaCoBHYT">SV đã có BHYT</option>
                                                <option value="dsChuaCoBHYT">SV Chưa có BHYT</option>
                                                <option value="dsSapHetHanBHYT">SV sắp hết hạn BHYT (< 3 tháng)</option>
                                                <option value="dsHetHanBHYT">SV đã hết hạn BHYT</option>
                                                <option value="dsDaDongTienBHYT">SV đã đóng tiền BHYT</option>                                               
                                                <option value="dsChuaDongTienBHYT">SV chưa đóng tiền BHYT</option>                                               
                                            </select>

                                            <button class="btn-common" id="ip-export" name="export">
                                                <ion-icon name="cloud-download-outline" style="height: 25px;"></ion-icon>
                                            </button>
                                        </div>

                                    </div>
                                <?php                              
                                ?>
                                </div>
                            </div>
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
    </form>

    <?php
        ob_end_flush();
    ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>