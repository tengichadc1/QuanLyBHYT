<?php
    session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($connect, "SET NAMES UTF8");
    // $_SESSION['idtk'] = null; 
    // $_SESSION['tk'] = null; 
    // $_SESSION['quyen'] = null;
?>

<html
    class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo chung</title>

    <script src="Scripts/modernizr-2.6.2.js"></script>

    <script src="Scripts/jquery-1.10.2.js"></script>
    <!-- <script src="/Scripts/jquery.validate.unobtrusive.js"></script> -->

    <script src="Scripts/respond.js"></script>
    <script src="Scripts/bootstrap.min.js"></script>
    <script src="Scripts/function.js"></script>

    <link href="Content/bootstrap.css" rel="stylesheet">
    <link href="Content/site.css" rel="stylesheet">
    <link href="Content/menu.css" rel="stylesheet">
    <link href="Content/css/Yersin.css" rel="stylesheet">

    <script type="text/javascript" src="Scripts/moment.min.js"></script>
    <script type="text/javascript" src="Scripts/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="Content/bootstrap-datetimepicker.css">
    <!-- <link href="/Content/css/main.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="Content/css/seek.css">

</head>

<body>
    <div class="" style="background:#fff;min-height:100vh;margin: 0px 1px">
        <header id="header">
            <div class="row" style="color: white">
                <div class="col-md-10" style="background:#0A314F; height: 50px">
                    <div style="font-weight: bold; padding: 15px 20px 0px 100px; float: left">
                        Thành viên của
                    </div>
                    <div>
                        <a><img src="Content/logo/Logo_IGC.png" style="width: 120px"></a>
                    </div>
                </div>
                <div class="col-md-2" style="background:#0A314F; height: 50px">
                    <div class="cus-ttcedu">
                        <div style="float:left">
                            <a href="https://www.youtube.com/channel/UCLxhuk1kJOMT-GN8wjNOy4g" target="_blank"><img
                                    src="Content/logo/youtobe.png"></a>
                        </div>
                        <div style="float:left">
                            <a href="https://www.facebook.com/truongsonadezi/" target="_blank"><img
                                    src="Content/logo/facebook.png"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <img style="width: 100%;max-height: 400px;" src="Content/logo/banner-yersin.jpg">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div id="header">
                        <nav class="navbar navbar-default stylecolor">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse in" id="menu">
                                <ul class="nav navbar-nav">
                                    <li><a href="/News/ReturnPageByRole">Trang chủ</a></li>
                                    <li><a href="/public/TraCuuVanBang">Tra cứu văn bằng</a></li>
                                    <li><a href="/public/tracuuthoikhoabieu">Tra cứu thời khóa biểu</a></li>

                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="dropdown stylecolor" style="padding: 10px 10px 0px 0px">
                                        <span><a href="/Luanan/logon">Đăng nhập</a></span>

                                        <ul class="dropdown-menu stylecolor">

                                            <div class="divider"></div>

                                        </ul>

                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div id="body" style="margin-top:1px">
            <div class="row">
                <form method="post">
                    <!-- left -->
                    <div class="col-md-3">
                        <div class="accordion" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading menuhome" style="padding:10px">
                                    <a class="" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <!-- <span style="color:#fff !important" class="glyphicon glyphicon-th"></span> -->
                                        <b style="color:#fff !important">Tra cứu</b>
                                    </a>
                                </div>
                            </div>
                            <div style="border:1px solid #dfdfdf;border-top:0px;background:#fff">
                                <div class="input-group">
                                    <select style="width: auto" id="field-search" onchange="changeInputType()" name="field-search">
                                        <option value='MSSV'>MSSV</option>
                                        <option value='MaTheBHYT'>BHYT</option>
                                        <option value='SoCCCD'>CCCD</option>                                        
                                    </select>
                                    <div class="form-outline">
                                            
                                        <input type="number" name="ip-search" class="form1" class="form-control"
                                            placeholder=" " />
                                        <label class="form-label lbli" for="form1">###</label>
                                    </div>

                                    <button type="submit" name="btn-search" class="btn btn-primary">
                                        <ion-icon name="search"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- right -->
                    <div class="col-md-9">
                        <div class="divmain">
                            <div class="bgtitle">Thông tin</div>
                            <?php
                                if (isset($_POST['btn-search'])) 
                                {
                                    $field_search = $_POST['field-search'];
                                    $mssv = $_POST["ip-search"];
                                    $query_search = "select * from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where $field_search = " . $mssv;
                                    $result = mysqli_query($connect, $query_search);
                                    if (mysqli_num_rows($result) > 0) 
                                    {
                                        while ($row = mysqli_fetch_assoc($result)) 
                                        {
                                            $mssv1 = $row["MSSV"];
                                            $ten =$row["Ho"]. " " . $row["Ten"];
                                            $gt = $row["GioiTinh"];
                                            $ngaysinh = $row["NgaySinh"];
                                            $lop = $row["TenLop"];
                                            $bhyt = $row["MaTheBHYT"];
                                            $sotiendong = $row["SoTienDong"];
                                            $ngaythamgia = $row["NTG"];
                                            $sothangdong = $row["SoThangDong"];
                                            $tinhtrang = $row["TinhTrang"];

                                            echo ("
                                                <div id='inf'>
                                                    <div class=''>
                                                        <div class='col-md-12 cus-header'>
                                                            Thông tin Sinh viên
                                                        </div>           
                                                        <div class='col-md-12  cus-boder'>
                                                            MSSV: <label>$mssv1</label>
                                                        </div>            
                                                        <div class='col-md-12  cus-boder'>
                                                            Họ tên: <label>$ten</label>
                                                        </div>            
                                                        <div class='col-md-12  cus-boder'>
                                                            Giới tính: <label>$gt</label>
                                                        </div>           
                                                        <div class='col-md-12  cus-boder'>
                                                            Ngày sinh: <label>$ngaysinh</label>
                                                        </div>            
                                                        <div class='col-md-12  cus-boder'>
                                                            Lớp: <label>$lop</label>
                                                        </div>
                                                    </div>
                
                                                    <div class='col-md-4'>
                                                        <div class='row'>
                                                            <div class='col-md-12 cus-header'>
                                                                BHYT
                                                            </div>
                                                            <div class='col-md-12  cus-boder'>
                                                                Mã thẻ BHYT: <label>$bhyt</label>
                                                            </div>
                                                            <div class='col-md-12  cus-boder'>
                                                                Ngày tham gia: <label>$ngaythamgia</label>
                                                            </div>
                                                            <div class='col-md-12  cus-boder'>
                                                                Số tháng đóng: <label>$sothangdong</label>
                                                            </div>
                                                            <div class='col-md-12  cus-boder'>
                                                                Số tiền đóng: <label>$sotiendong</label>
                                                            </div>
                                                            <div class='col-md-12  cus-boder'>");
                                                                    if ($tinhtrang == 1) {
                                                                        echo ("Số tiền đóng: <label style='color :red'><b>Đã có</b></label>");                                                                       
                                                                    }
                                                                    else if($tinhtrang == 0)
                                                                    {
                                                                        echo ("Số tiền đóng: <label style='color :red'><b>Chưa có</b></label>");    
                                                                    }else
                                                                    {
                                                                        echo ("Số tiền đóng: <label style='color :red'><b>Đang mua</b></label>");    
                                                                    }
                                                                    echo ("</div>"); // Kết thúc thẻ select
                                                        echo ("
                                                        </div>
                                                    </div>
                                                </div>
                                            ");
                                        }
                                    }
                                    else
                                    {
                                        echo $query_search;

                                        echo ("
                                                <div id='inf'>
                                                    <div class=''>
                                                        <h3>Không tìm thấy kết quả</h3>
                                                    </div>
                                                </div>
                                            ");
                                    }
                                }
                            ?>
                        </div>

                    </div>
                    <form>
            </div>

        </div>
    </div>

    <footer class="footer">
        <div style="background: #003768; color: white;">
            <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-10" style="height: 100px; padding-top: 5px; margin-bottom: 15px">
                    <div style="float:left; ">
                        <div style="padding-bottom: 20px">
                            <img src="Content/logo/YU_white.png" style="width: 127px; padding-top: 10px">
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

    <script>
        function changeInputType() {
            var selectedOption = document.getElementById('field-search').value;
            var inputSearch = document.getElementById('ip-search');

            if (selectedOption === 'CCCD' || selectedOption === 'MSSV') {
                inputSearch.type = 'number';
            } 
            else 
            {
                inputSearch.type = 'text';
            }
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>