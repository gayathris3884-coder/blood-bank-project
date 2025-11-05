<?php
// Include PostgreSQL connection
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
<div class="header">
<?php
$active="home";
include('head.php');
?>
</div>

<?php include 'ticker.php'; ?>

<div id="page-container" style="margin-top:50px; position: relative; min-height: 84vh;">
    <div class="container">
        <div id="content-wrap" style="padding-bottom:75px;">
            <div id="demo" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                </ul>

                <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="image/_107317099_blooddonor976.jpg" alt="image/_107317099_blooddonor976.jpg" width="100%" height="500">
                    </div>
                    <div class="carousel-item">
                        <img src="image/Blood-facts_10-illustration-graphics__canteen.png" alt="image/Blood-facts_10-illustration-graphics__canteen.png" width="100%" height="500">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>

            <br>
            <h1 style="text-align:center;font-size:45px;">Welcome to BloodBank & Donor Management System</h1>
            <br>

            <div class="row">
                <?php
                $pages = ['needforblood'=>'The need for blood', 'bloodtips'=>'Blood Tips', 'whoyouhelp'=>'Who you could Help'];
                foreach($pages as $type => $title){
                    echo '<div class="col-lg-4 mb-4"><div class="card">';
                    echo '<h4 class="card-header card bg-info text-white">'.$title.'</h4><p class="card-body overflow-auto" style="padding-left:2%;height:120px;text-align:left;">';
                    $sql = "SELECT page_data FROM pages WHERE page_type='$type'";
                    $result = pg_query($conn, $sql);
                    if($result && pg_num_rows($result) > 0){
                        while($row = pg_fetch_assoc($result)){
                            echo $row['page_data'];
                        }
                    }
                    echo '</p></div></div>';
                }
                ?>
            </div>

            <h2>Blood Donor Names</h2>
            <div class="row">
                <?php
                $sql = "SELECT dd.donor_name, dd.donor_number, dd.donor_gender, dd.donor_age, dd.donor_address, b.blood_group 
                        FROM donor_details dd 
                        JOIN blood b ON dd.donor_blood = b.blood_id 
                        ORDER BY RANDOM() 
                        LIMIT 6";
                $result = pg_query($conn, $sql);
                if($result && pg_num_rows($result) > 0){
                    while($row = pg_fetch_assoc($result)){
                        echo '<div class="col-lg-4 col-sm-6 portfolio-item"><br>
                        <div class="card" style="width:300px">
                        <img class="card-img-top" src="image/blood_drop_logo.jpg" alt="Card image" style="width:100%;height:300px">
                        <div class="card-body">
                        <h3 class="card-title">'.$row['donor_name'].'</h3>
                        <p class="card-text">
                        <b>Blood Group : </b>'.$row['blood_group'].'<br>
                        <b>Mobile No. : </b>'.$row['donor_number'].'<br>
                        <b>Gender : </b>'.$row['donor_gender'].'<br>
                        <b>Age : </b>'.$row['donor_age'].'<br>
                        <b>Address : </b>'.$row['donor_address'].'<br>
                        </p></div></div></div>';
                    }
                }
                ?>
            </div>

            <!-- Blood Groups Section -->
            <div class="row">
                <div class="col-lg-6">
                    <h2>BLOOD GROUPS</h2>
                    <p>
                    <?php
                    $sql = "SELECT page_data FROM pages WHERE page_type='bloodgroups'";
                    $result = pg_query($conn, $sql);
                    if($result && pg_num_rows($result) > 0){
                        while($row = pg_fetch_assoc($result)){
                            echo $row['page_data'];
                        }
                    }
                    ?>
                    </p>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded" src="image/blood_donationcover.jpeg" alt="">
                </div>
            </div>

            <hr>

            <!-- Call to Action Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4>UNIVERSAL DONORS AND RECIPIENTS</h4>
                    <p>
                    <?php
                    $sql = "SELECT page_data FROM pages WHERE page_type='universal'";
                    $result = pg_query($conn, $sql);
                    if($result && pg_num_rows($result) > 0){
                        while($row = pg_fetch_assoc($result)){
                            echo $row['page_data'];
                        }
                    }
                    ?>
                    </p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-secondary btn-block" href="donate_blood.php" style="background-color:#7FB3D5;color:#273746;">Become a Donor</a>
                </div>
            </div>

        </div>
    </div>

<?php include('footer.php'); ?>

</div>
</body>
</html>
