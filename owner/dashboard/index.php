<?php
session_start();
include("include/header.php");
?>

<?php include("include/sidebar.php"); ?>

<!-- Content Start -->
<div class="content">
    <?php include("include/navbar.php"); ?>

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                    <span class="icon-circle">
                        <i class="fa fa-calendar-check fa-2x"></i>
                    </span>
                    <div class="ms-3">
                        <p class="mb-2 fw-bold" style="color:#800000;">Today's Bookings</p>
                        <h4 class="mb-0 text-secondary">15</h4>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                    <span class="icon-circle">
                        <i class="fa fa-chart-bar fa-2x"></i>
                    </span>
                    <div class="ms-3">
                        <p class="mb-2 fw-bold" style="color:#800000;">Total Sale</p>
                        <h4 class="mb-0 text-secondary">PKR 1,250,000</h4>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                    <span class="icon-circle">
                        <i class="fa fa-chart-area fa-2x"></i>
                    </span>
                    <div class="ms-3">
                        <p class="mb-2 fw-bold" style="color:#800000;">Today's Revenue</p>
                        <h4 class="mb-0 text-secondary">PKR 150,000</h4>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card p-4 d-flex align-items-center justify-content-between">
                    <span class="icon-circle">
                        <i class="fa fa-chart-pie fa-2x"></i>
                    </span>
                    <div class="ms-3">
                        <p class="mb-2 fw-bold" style="color:#800000;">Total Revenue</p>
                        <h4 class="mb-0 text-secondary">PKR 5,200,000</h4>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <!-- Sale & Revenue End -->

    <?php include("include/footer.php"); ?>
</div>

<!-- VIP Dashboard Styles -->
<style>
.stat-card {
    background: linear-gradient(145deg, #fff, #fff5f5);
    border-radius: 18px;
    box-shadow: 0 0 25px rgba(128,0,0,0.07);
    transition: all 0.3s;
    border: 2px solid #DAA52022;
}
.stat-card:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 8px 32px #DAA52044;
}
.icon-circle {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(45deg, #800000, #DAA520);
    color: #fff;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    box-shadow: 0 2px 8px #80000022;
    animation: pop 1.2s cubic-bezier(.17,.67,.83,.67) infinite alternate;
}
@keyframes pop {
    0% { transform: scale(1);}
    100% { transform: scale(1.08);}
}
.banner-card {
    border: 2px solid #DAA52044;
    background: linear-gradient(90deg,#fffbe6 60%,#fff5f5 100%);
}
.text-secondary {
    color: #DAA520 !important;
}
</style>