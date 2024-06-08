<?php 
include('includes/checklogin.php');
check_login();

$aid = $_SESSION['odmsaid'];
$sql = "SELECT * from tbladmin where ID = :aid";
$query = $dbh->prepare($sql);
$query->bindParam(':aid', $aid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$userRole = '';
if ($query->rowCount() > 0) {
    foreach ($results as $row) {
        $userRole = $row->AdminName;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php @include("includes/head.php");?>

<body>
    <div class="container-scroller">

        <?php @include("includes/header.php");?>

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel"><br>
                <div class="content-wrapper">
                    <?php if ($userRole == 'Admin') { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 stretch-card grid-margin">
                                    <div class="card bg-gradient-info card-img-holder text-white"
                                        style="height: 130px;">
                                        <div class="card-body">
                                            <h4 class="font-weight-normal mb-3">Total New Booking</h4>
                                            <?php 
                                            $sql ="SELECT ID from tblbooking where Status is null";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $totalnewbooking=$query->rowCount();
                                            ?>
                                            <h2 class="mb-5"><?php echo htmlentities($totalnewbooking);?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card grid-margin">
                                    <div class="card bg-gradient-warning card-img-holder text-white"
                                        style="height: 130px;">
                                        <div class="card-body">
                                            <h4 class="font-weight-normal mb-3">Total Approved Booking</h4>
                                            <?php 
                                            $sql ="SELECT ID from tblbooking where Status='Approved'";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $totalappbooking=$query->rowCount();
                                            ?>
                                            <h2 class="mb-5"><?php echo htmlentities($totalappbooking);?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card grid-margin">
                                    <div class="card bg-gradient-primary card-img-holder text-white"
                                        style="height: 130px;">
                                        <div class="card-body">
                                            <h4 class="font-weight-normal mb-3">Total Cancelled Booking</h4>
                                            <?php 
                                            $sql ="SELECT ID from tblbooking where Status='Cancelled'";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $totalcanbooking=$query->rowCount();
                                            ?>
                                            <h2 class="mb-5"><?php echo htmlentities($totalcanbooking);?></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card grid-margin">
                                    <div class="card bg-gradient-success card-img-holder text-white"
                                        style="height: 130px;">
                                        <div class="card-body">
                                            <h4 class="font-weight-normal mb-3">Total Services</h4>
                                            <?php 
                                            $sql ="SELECT ID from tblservice";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $totalserv=$query->rowCount();
                                            ?>
                                            <h2 class="mb-5"><?php echo htmlentities($totalserv);?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="piechart" style="width:100%; height: 300px;"></div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="float: left;">New Bookings</h5>
                                </div>
                                <div id="editData4" class="modal fade">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">View Booking details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="info_update4">
                                                <?php @include("view_newbookings.php");?>
                                            </div>
                                            <div class="modal-footer ">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th>Booking ID</th>
                                                <th class="d-none d-sm-table-cell">Customer Name</th>
                                                <th class="d-none d-sm-table-cell">Mobile Number</th>
                                                <th class="d-none d-sm-table-cell">Email</th>
                                                <th class="d-none d-sm-table-cell">Booking Date</th>
                                                <th class="d-none d-sm-table-cell">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql="SELECT * from tblbooking where Status='Approved'";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0) {
                                                foreach($results as $row) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo htmlentities($cnt);?></td>
                                                <td class="font-w600"><?php echo htmlentities($row->BookingID);?></td>
                                                <td class="font-w600"><?php echo htmlentities($row->Name);?></td>
                                                <td class="font-w600">0<?php echo htmlentities($row->MobileNumber);?>
                                                </td>
                                                <td class="font-w600"><?php echo htmlentities($row->Email);?></td>
                                                <td class="font-w600">
                                                    <span
                                                        class="badge badge-info"><?php echo htmlentities($row->BookingDate);?></span>
                                                </td>
                                                <?php if($row->Status=="") { ?>
                                                <td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
                                                <?php } else { ?>
                                                <td class="d-none d-sm-table-cell">
                                                    <span
                                                        class="badge badge-success"><?php echo htmlentities($row->Status);?></span>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                                $cnt=$cnt+1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <!-- Fancy User Dashboard -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Welcome to Your Dashboard</h4>
                                    <p class="card-text">Here you can see an overview of your bookings and manage your
                                        account.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <img src="assets/img/fancy_dashboard_image1.png" class="card-img-top"
                                                    alt="..." style="max-width: 50%; height: auto;">
                                                <div class=" card-body">
                                                    <h5 class="card-title">Manage Your Bookings</h5>
                                                    <p class="card-text">View, approve, or cancel your bookings.</p>
                                                    <a href="new_bookings.php" class="btn btn-primary">View Bookings</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <img src="assets/img/fancy_dashboard_image2.png"
                                                    class="card-img-top img-centered" alt="..."
                                                    style="max-width: 50%; height: auto;">
                                                <div class=" card-body">
                                                    <h5 class="card-title">Profile Settings</h5>
                                                    <p class="card-text">Update your personal information and change
                                                        your password.</p>
                                                    <a href="profile.php" class="btn btn-primary">Go to Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php @include("includes/footer.php");?>
            </div>
        </div>
    </div>
    <?php @include("includes/foot.php");?>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Party decorations', 11],
            ['Party DJ', 2],
            ['Ceremony Music', 2],
            ['Uplighters', 2],
            ['Photo Booth Hire', 7]
        ]);

        var options = {
            title: 'Demanding Services'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
    </script>
</body>

</html>