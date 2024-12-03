<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>FIFO TROLLEY</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <style>
        /* Gaya untuk elemen pop-up */
        #popupModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            max-width: 800px;
            background-color: white;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 20px;
            z-index: 1000;
            /* Mengatur z-index yang lebih tinggi */
        }

        /* Gaya untuk tombol close */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ccc;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            text-align: center;
            line-height: 28px;
            /* Untuk mengatur vertikal tengah */
            font-size: 18px;
        }

        /* Gaya untuk header pop-up */
        .popup-header {
            display: flex;
            justify-content: flex-end;
        }

        /* Gaya untuk tombol close */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 1001;
            /* Memastikan tombol close muncul di depan pop-up */
        }

        #popupOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Warna overlay dan transparansi */
            z-index: 999;
            /* Atur z-index agar overlay berada di atas konten lain */
        }
    </style>
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="col-md-12">
                <div class="col-md-2" style="float: left;">
                    <a href="index.php">
                        <img src="images/logo.png"
                            style="width:128px;height:64px;vertical-align:middle;margin:10px 0 0 0;">
                        <br>

                    </a>
                </div>
                <div class="col-md-8" style="float: left;"> <br>
                    <h2 class="title-1" style="text-align:center;color:white;">FIFO TROLLEY - PRODUKSI LINE RING GEAR 3
                    </h2>

                </div>
                <div class="col-md-2" style="margin-top:0px;float: left;text-align: right;vertical-align:middle;"><br>
                    <div id="jam">10:07:23</div>

                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7">
            <br>
            <div class="container" style="max-width:1500px !important;">
                <div class="row" style="justify-content:center;">

                    <div class="col-lg-4">

                        <div class="au-card recent-report" style="padding:15px 15px 15px 15px !important;">
                            <div class="form-group row" style="margin-bottom:0px;">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="rfid_tag" placeholder="Tap Here.."
                                        oninput="func_scan()" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="popupOverlay" style="display: none;"></div>
                <div id="popupModal" style="display: none;">
                    <span class="close-button" onclick="closePopup()">&times;</span>
                    <div id="popupContent">
                        <!-- Konten pop-up Anda -->
                    </div>
                </div>
                <!-- STATISTIC-->
                <div id='divData1'>
                    <section class="statistic statistic2" style="padding-top:15px;">

                        <div class="row">
                            <div class="col-md-8" style="max-width: 53%; !important;">
                                <div class="row">
                                    <?php
                                    $i = 0;
                                    //$warna = array('success','warning','danger','info','success','warning','danger','info');
                                    include('configSql.php');

                                    $sql2 = "select t1.id, t1.rfid_tag, t1.date_time, t1.`position`, t2.color,t2.no_trolley, t2.partname from t_trans_fifo_trolley t1
                                  left join t_mst_fifo_trolley t2
                                  on t1.rfid_tag = t2.rfid_tag 
                                  where t2.kd_line = 'LK006' and t1.date_time = (select max(date_time) from t_trans_fifo_trolley where rfid_tag = t1.rfid_tag)
                                  and t1.rfid_tag in (select rfid_tag as rfid_tag from t_status_fifo where current_position ='store_wip')
                                  group by color order by t1.date_time asc;";
                                    //$arr = array();
                                    //$urutan = 1;
                                    $stmt = mysqli_query($conD26_2, $sql2);
                                    while ($row = mysqli_fetch_assoc($stmt)) {
                                        // $arr[$row->id][] = $row;
                                    
                                        echo " <div class='col-md-6' style='flex:0 0 32% !important;max-width:40% !important;'>";
                                        echo " <div class='card'>";
                                        if ($row['color'] == 'GREEN') {
                                            echo "<div class='card-header' style='background-color:#00b26f;text-align:center;'>";
                                        } else if ($row['color'] == 'BLUE') {
                                            echo "<div class='card-header' style='background-color:#00b5e9;text-align:center;'>";
                                        } else if ($row['color'] == 'ORANGE') {
                                            echo "<div class='card-header' style='background-color:#ff8300;text-align:center;'>";
                                        } else if ($row['color'] == 'PURPLE') {
                                            echo "<div class='card-header' style='background-color:#9c01a1;text-align:center;'>";
                                        } else if ($row['color'] == 'PINK') {
                                            echo "<div class='card-header' style='background-color:#ff45c4;text-align:center;'>";
                                        }

                                        echo "<strong class='card-title mb-3' style='color:white;'>RING GEAR " . $row['partname'] . "</strong>";
                                        echo " </div>";
                                        echo "<div class='card-body'>";
                                        echo "<div class='mx-auto d-block'>";
                                        echo "<h1 class='text-sm-center mt-2 mb-1' style='font-size: 100px;color:red;'>" . $row['no_trolley'] . "</h1>";
                                        echo " <hr> ";
                                        echo "<div class='location text-sm-center'>NEXT TROLLEY</div>";
                                        echo "</div>";
                                        echo "</div>";

                                        echo "</div>";
                                        echo "</div>";


                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4" style="max-width: 47%; !important;">
                                <h3 class="title-5 m-b-35">Production List</h3>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="font-size:15px;padding:20px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                    width="10%">SEQUENCE</th>
                                                <th style="font-size:15px;padding:20px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                    width="20%">PARTNO</th>
                                                <th style="font-size:15px;padding:20px 0px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                    width="10%">MODEL</th>
                                                <th style="font-size:15px;padding:20px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                    width="5%">QTY</th>
                                                <th style="font-size:15px;padding:20px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                    width="5%">NO TROLLEY</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('configSql.php');
                                            $sql = "SELECT * FROM t_list_fifo_prod_trolley WHERE status = 0 AND kd_line ='LK006' ORDER BY created_date;";
                                            $stmt = mysqli_query($conD26_2, $sql);

                                            while ($row = mysqli_fetch_assoc($stmt)) {
                                                $partname = $row['partname'];

                                                // Query kedua untuk setiap 'partname'
                                                $secondQuery = "SELECT tmft.color AS color, current_position, GROUP_CONCAT(DISTINCT tmft.no_trolley) AS no_trolley FROM t_status_fifo tsf
            LEFT JOIN t_mst_fifo_trolley tmft ON tsf.rfid_tag = tmft.rfid_tag
            WHERE tmft.partname = '$partname' AND tsf.current_position = 'store_wip' AND tmft.kd_line = 'LK006';";
                                                $secondStmt = mysqli_query($conD26_2, $secondQuery);
                                                $trolleyData = mysqli_fetch_assoc($secondStmt);

                                                echo "<tr style=text-align:center>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['partno'] . "</td>";
                                                echo "<td>" . $row['partname'] . "</td>";
                                                echo "<td>" . $row['qty'] . "</td>";
                                                echo "<td>" . $trolleyData['no_trolley'] . "</td>"; // Display 'no_trolley' from the second query
                                                echo "</tr>";
                                            }
                                            ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                </div>
                </section>
            </div>
            <!-- END STATISTIC-->

            <!-- STATISTIC CHART-->
            <div id='divData2'>

                <section class="statistic-chart">
                    <div class="container" style="max-width:1500px !important;">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="title-5 m-b-35">Data Trolley</h3>
                                        <div class="table-responsive table--no-card m-b-40">
                                            <table class="table table-borderless table-striped table-earning">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="10%">PART NAME</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="40%">TROLLEY ISI</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="40%">TROLLEY KOSONG</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include('configSql.php');
                                                    $sql = "                                          
                                                        select 'D09E, D41E'  as model,sum(case when tsf.current_position = 'store_wip' then 1 else 0 END) as count_empty,
                                                        sum(case when tsf.current_position = 'line_rg' then 1 else 0 END) as count_fill
                                                        from t_status_fifo tsf
                                                        left join t_mst_fifo_trolley tmft
                                                        on tsf.rfid_tag = tmft.rfid_tag
                                                        where tmft.kd_line = 'LK006' and tmft.partname = 'D09E, D41E'                                                       
                                                        union 
                                                        select 'D05E',sum(case when tsf.current_position = 'store_wip' then 1 else 0 END) as count_empty,
                                                        sum(case when tsf.current_position = 'line_rg' then 1 else 0 END) as count_fill
                                                        from t_status_fifo tsf
                                                        left join t_mst_fifo_trolley tmft
                                                        on tsf.rfid_tag = tmft.rfid_tag
                                                        where tmft.partname = 'D05E'
                                                        union 
                                                        select 'D31E',sum(case when tsf.current_position = 'store_wip' then 1 else 0 END) as count_empty,
                                                        sum(case when tsf.current_position = 'line_rg' then 1 else 0 END) as count_fill
                                                        from t_status_fifo tsf
                                                        left join t_mst_fifo_trolley tmft
                                                        on tsf.rfid_tag = tmft.rfid_tag
                                                        where tmft.partname = 'D31E';
                                                        ";
                                                    $stmt = mysqli_query($conD26_2, $sql);
                                                    while ($row = mysqli_fetch_assoc($stmt)) {
                                                        echo "<tr style=text-align:center>";
                                                        echo "<td>" . $row['model'] . "</td>";
                                                        echo "<td><a href='javascript:void(0)' onclick='showPopup(\"" . $row['model'] . "\", \"" . $row['count_fill'] . "\", \"" . $row['count_empty'] . "\")' style='color: grey;'>" . $row['count_fill'] . "</a></td>";
                                                        echo "<td><a href='javascript:void(0)' onclick='showPopup(\"" . $row['model'] . "\", \"\", \"" . $row['count_empty'] . "\")' style='color: grey;'>" . $row['count_empty'] . "</a></td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>

                                                </tbody>



                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="title-5 m-b-35">History Scan</h3>
                                        <div class="table-responsive table--no-card m-b-40">
                                            <table class="table table-borderless table-striped table-earning">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="10%">ID TRANSAKSI</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="20%">RFID TAG</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="15%">NO TROLLEY</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="15%">PART NAME</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="15%">SCAN AT</th>
                                                        <th style="font-size:15px;padding:22px 20px;font-family: Montserrat-ExtraBold; text-align:center !important;"
                                                            width="20%">SCAN TIME</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include('configSql.php');
                                                    $sql = "select t1.id, t1.rfid_tag, t1.date_time, t1.`position`, t2.color,t2.partname,t2.no_trolley from t_trans_fifo_trolley t1 
                                                    left join t_mst_fifo_trolley t2
                                                    on t1.rfid_tag = t2.rfid_tag
                                                    where t1.position = 'line_rg'
                                                    order by date_time asc limit 3;";

                                                    $stmt = mysqli_query($conD26_2, $sql);
                                                    while ($row = mysqli_fetch_assoc($stmt)) {
                                                        echo "<tr style=text-align:center>";
                                                        echo "<td>" . $row['id'] . "</td>";
                                                        echo "<td>" . $row['rfid_tag'] . "</td>";
                                                        echo "<td>" . $row['no_trolley'] . "</td>";
                                                        echo "<td>" . $row['partname'] . "</td>";
                                                        echo "<td>" . $row['position'] . "</td>";
                                                        echo "<td>" . $row['date_time'] . "</td>";

                                                        echo "</tr>";
                                                    }
                                                    ?>

                                                </tbody>



                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
            <!-- END STATISTIC CHART-->



            <!-- COPYRIGHT-->
            <section class="p-t-60 p-b-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © IT Dept 2023. All rights reserved. Template by <a
                                        href="https://colorlib.com">Colorlib</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END COPYRIGHT-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="sweetalert.min.js"></script>
    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script>
        function func_scan(e) {
            var rfid_tag = document.getElementById("rfid_tag").value;
            var pos = 'line_rg3';

            if (rfid_tag.length > '9') {
                event.preventDefault();
                var postData = {
                    "rfid_tag": rfid_tag,
                    "pos": pos
                };
                // Trigger the button element with a click
                $.ajax({
                    type: 'POST',
                    url: 'savedatafifo.php',
                    data: postData,
                    success: function (data) {
                        console.log(data);
                        if (data.status == 3) {
                            swal({
                                title: 'SUKSES!',
                                text: 'Data Berhasil Disimpan',
                                type: 'success',
                                icon: 'success',
                                timer: 2000
                            }).
                                then(function () {
                                    // window.location.href='op30-z.php';
                                    //window.location.href='op60a_harden.php';
                                    $('#divData1').load(' #divData1');
                                    $('#divData2').load(' #divData2');
                                    document.getElementById("rfid_tag").value = '';
                                    document.getElementById("rfid_tag").focus();
                                });

                        } else if (data.status == 1) {
                            swal({
                                title: 'ERROR!',
                                text: 'RFID Result kurang',
                                type: 'error',
                                icon: 'error',
                                timer: 1000
                            });
                            document.getElementById("rfid_tag").value = '';
                            document.getElementById("rfid_tag").focus();
                        } else if (data.status == 2) {
                            swal({
                                title: 'ERROR!',
                                text: 'Tidak Ada Trolley Kosong',
                                type: 'error',
                                icon: 'error'
                            }).then(function () {
                                $('#divData1').load(' #divData1 ');
                                $('#divData2').load(' #divData2 ');
                                document.getElementById("rfid_tag").value = '';
                            }).then(function () {
                                setTimeout(function () {
                                    document.getElementById("rfid_tag").focus();
                                }, 0);
                            });

                        } else if (data.status == 4) {
                            swal({
                                title: 'ERROR!',
                                text: 'TROLLEY TIDAK FIFO',
                                type: 'error',
                                icon: 'error'
                            }).then(function () {
                                $('#divData1').load(' #divData1 ');
                                $('#divData2').load(' #divData2 ');
                                document.getElementById("rfid_tag").value = '';
                            }).then(function () {
                                setTimeout(function () {
                                    document.getElementById("rfid_tag").focus();
                                }, 0);
                            });
                        } else {
                            alert('Data tidak ditemukan');
                            document.getElementById("rfid_tag").focus();
                        }
                    },
                    dataType: 'json'
                });


            }
        };

    </script>
    <script>
        function showPopup(model, count_fill, count_empty) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var popupContent = xhr.responseText;
                    document.getElementById('popupContent').innerHTML = popupContent;

                    // Menampilkan overlay dan pop-up
                    document.getElementById('popupOverlay').style.display = 'block';
                    document.getElementById('popupModal').style.display = 'block';
                }
            };

            var url;
            if (count_fill !== "") {
                url = "GetPopupDataRg3.php?type=fill&model=" + encodeURIComponent(model);
            } else {
                url = "GetPopupDataRg3.php?type=empty&model=" + encodeURIComponent(model);
            }

            xhr.open("GET", url, true);
            xhr.send();
        }

        function closePopup() {
            document.getElementById('popupModal').style.display = 'none';
            document.getElementById('popupOverlay').style.display = 'none';
        }

        function refreshDiv() {
            $('#divData1').load(location.href + ' #divData1');
            $('#divData2').load(location.href + ' #divData2');
        }

        setInterval(refreshDiv, 5000);

    </script>
    <script type="text/javascript">


        var currenttime = '<?php date_default_timezone_set('ASIA/JAKARTA');
        echo date("F d, Y H:i:s", time()) ?>' //PHP method of getting server date

        ///////////Stop editting here/////////////////////////////////

        var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
        var serverdate = new Date(currenttime)

        function padlength(what) {
            var output = (what.toString().length == 1) ? "0" + what : what
            return output
        }
        function displaytime() {
            serverdate.setSeconds(serverdate.getSeconds() + 1)
            var datestring = montharray[serverdate.getMonth()] + " " + padlength(serverdate.getDate()) + ", " + serverdate.getFullYear()
            var timestring = padlength(serverdate.getHours()) + ":" + padlength(serverdate.getMinutes()) + ":" + padlength(serverdate.getSeconds())
            document.getElementById("jam").innerHTML = timestring
        }

        window.onload = function () {
            setInterval("displaytime()", 1000)
        }

    </script>

</body>

</html>
<!-- end document-->