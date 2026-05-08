<?php
session_start();
include 'config.php';

// Logout handling
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
$customer = null;
if (isset($_SESSION['customer_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->execute([$_SESSION['customer_id']]);
    $customer = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHANDAN CYBER ZONE</title>
    <link rel="preload" as="style" href="assets/css/bootstrap.min.css" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </noscript>
    <link rel="preload" as="style" href="assets/css/all.min.css" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="assets/css/all.min.css">
    </noscript>
    <link rel="stylesheet" href="assets/css/csc-lp.css">
    <script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/custom-clean.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Cambria, "Times New Roman", serif;
            background: radial-gradient(circle at top left, rgba(255, 153, 51, 0.18), transparent 28%), radial-gradient(circle at top right, rgba(19, 136, 8, 0.18), transparent 30%), linear-gradient(135deg, #061427 0%, #0a1f3d 45%, #0b2d57 100%);
            color: #fff;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        .topbar {
            width: 100%;
            padding: 14px 18px;
            background: rgba(0, 0, 0, 0.18);
            border-bottom: 1px solid rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        @media (max-width: 991px) {
            .brand-text h1 {
                font-size: 28px;
            }

            .brand-text p {
                font-size: 13px;
            }

            .top-actions {
                gap: 8px;
            }

            .top-btn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .brand-logo {
                width: 60px;
                height: 60px;
                font-size: 22px;
            }
        }

        @media (max-width: 767px) {
            .topbar {
                padding: 12px 16px;
            }

            .topbar-inner {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }

            .brand-wrap {
                justify-content: center;
                gap: 12px;
            }

            .brand-logo {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .brand-text h1 {
                font-size: 24px;
                text-align: center;
            }

            .brand-text p {
                font-size: 12px;
                text-align: center;
            }

            .top-actions {
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
            }

            .profile-icon {
                width: 42px;
                height: 42px;
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .brand-text h1 {
                font-size: 20px;
                letter-spacing: 0;
            }

            .brand-text p {
                font-size: 11px;
            }

            .top-btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            .topbar {
                padding: 8px 12px;
            }

            .topbar-inner {
                gap: 8px;
            }

            .brand-logo {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: linear-gradient(145deg, #ffffff, #dfe7f2);
            color: #0b2d57;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.30);
            border: 2px solid rgba(255, 255, 255, 0.7);
        }

        .brand-text h1 {
            font-size: 45px;
            line-height: 1;
            margin-bottom: 0px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #fff;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.35);
        }

        .brand-text h1 span:first-child {
            color: #ffb347;
        }

        .brand-text h1 span:last-child {
            color: #9cf58f;
        }

        .brand-text p {
            font-size: 20px;
            color: #d9e7ff;
            letter-spacing: 0.5px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .top-btn {
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #113764, #0b2547);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.22);
            transition: 0.25s ease;
        }

        .top-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #15467f, #0d2f59);
        }

        .top-btn.gold {
            color: #111;
            background: linear-gradient(135deg, #ffd76a, #ffb300);
            border: none;
        }

        .top-btn.gold:hover {
            background: linear-gradient(135deg, #ffe28f, #ffc933);
        }

        .profile-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd86f, #ffb300);
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            box-shadow: 0 6px 16px rgba(255, 179, 0, 0.3);
            transition: 0.25s;
        }

        .profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(255, 179, 0, 0.4);
        }

        .profile-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: 0.25s;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .profile-icon:hover .profile-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 14px 20px;
            color: #0b2238;
            font-weight: 600;
            border-bottom: 1px solid rgba(11, 45, 87, 0.1);
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background: rgba(255, 216, 111, 0.3);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .section-wrap {
            max-width: 1300px;
            margin: 24px auto 40px;
            padding: 0 16px;
        }

        .section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        .section-title h3 {
            font-size: 28px;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
        }

        .doc-card {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.10), rgba(255, 255, 255, 0.04)), linear-gradient(145deg, #0c2242, #0f2d56);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .doc-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 38px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.10);
        }

        .doc-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, #ff9933, #ffffff, #138808);
        }

        .img-box {
            width: 100%;
            height: 170px;
            border-radius: 18px;
            background: linear-gradient(180deg, #ffffff, #eef4ff);
            border: 2px solid rgba(255, 255, 255, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: inset 0 0 18px rgba(11, 45, 87, 0.08);
            margin-bottom: 14px;
        }

        .img-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
        }

        .doc-card:hover .img-box img {
            transform: scale(1.04);
        }

        .doc-name {
            font-size: 22px;
            line-height: 1.2;
            min-height: 54px;
            color: #fff;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .btn-area {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .order-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px 14px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #ffd86f, #ffb300);
            color: #111;
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.22);
            transition: 0.25s ease;
        }

        .order-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ffe28f, #ffc933);
        }

        .footer {
            max-width: 1300px;
            margin: 0 auto 30px;
            padding: 0 16px;
        }

        .footer-box {
            border-radius: 22px;
            padding: 18px 20px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
            display: flex;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            color: #dce9ff;
        }

        .footer-box strong {
            color: #fff;
        }

        .empty-box {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
            padding: 30px 20px;
            border-radius: 20px;
            text-align: center;
            color: #fff;
            font-size: 18px;
        }

        .whatsapp-float {
            position: fixed;
            right: 18px;
            bottom: 18px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25d366, #128c7e);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.28);
            z-index: 99999;
            transition: 0.25s ease;
            border: 2px solid rgba(255, 255, 255, 0.85);
        }

        .whatsapp-float:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.35);
        }

        .whatsapp-float svg {
            width: 30px;
            height: 30px;
            fill: #fff;
        }

        .whatsapp-label {
            position: fixed;
            right: 86px;
            bottom: 27px;
            background: #0f172a;
            color: #fff;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.20);
            z-index: 99998;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* NEW SECTIONS CSS */
        .banner {
            padding: 20px;
            margin-bottom: 0px;
            background: linear-gradient(135deg, rgba(6, 20, 39, 0.9), rgba(11, 45, 87, 0.9));
            color: #fff;
        }

        @media (min-width: 992px) {
            .banner {
                padding-bottom: 0px;
                margin-bottom: 0px;
            }
        }

        .banner h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .banner p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .banner ul {
            list-style: none;
        }

        .banner li {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .custom-btn-primary {
            background: linear-gradient(135deg, #ffd86f, #ffb300);
            color: #111;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 10px 30px rgba(255, 179, 0, 0.4);
            transition: all 0.3s;
            border: none;
        }

        .custom-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 179, 0, 0.5);
        }

        .notification {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            padding: 0px 0;
        }

        .notification-box {
            width: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0 12px 12px 0;
        }

        .marquee {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
        }

        .our-services {
            padding: 80px 0;
            background: rgba(255, 255, 255, 0.03);
        }

        .our-services h2 {
            font-size: 3rem;
            color: #fff;
            margin-bottom: 0;
        }

        .our-services h2 span {
            background: linear-gradient(135deg, #ffd86f, #ffb300);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .main-tabs .nav-link {
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 5px;
            transition: all 0.3s;
        }

        .main-tabs .nav-link.active {
            background: linear-gradient(135deg, #ffd86f, #ffb300);
            color: #111;
        }

        .services-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px 20px;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .services-box:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .services-box img {
            width: 80px;
            height: 80px;
        }

        .services-box p {
            color: #fff;
            font-weight: 600;
            margin-top: 15px;
        }

        .img {
            width: stretch;
        }

        @media (max-width: 768px) {
            .banner h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="topbar-inner">
            <div class="brand-wrap">
                <div class="brand-logo">
                    <img loading="lazy" src="assets/images/Chandan.png" alt="Logo" style="width:70px; height:70px; border-radius: 16px;">
                </div>
                <div class="brand-text">
                    <h1><span>CHANDAN</span> <span>CYBER</span> <span>ZONE</span></h1>
                    <p>Fast document order portal for secure upload and easy processing</p>
                </div>
            </div>

            <div class="top-actions">
                <?php if (isset($customer) && $customer): ?>
                    <div class="profile-icon" style="position:relative;">
                        <?php echo htmlspecialchars(substr($customer['email'], 0, 1)); ?>
                        <div class="profile-dropdown">
                            <div class="dropdown-item"><?php echo htmlspecialchars($customer['email']); ?></div>
                            <a href="customer_orders.php" class="dropdown-item">Your Orders</a>
                            <a href="customer_addresses.php" class="dropdown-item">Saved Address</a>
                            <a href="index.php?logout" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="top-btn gold">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-------------------------------------------------------------------------------------------------------------------... -->
    <!-- Hero Start Here... -->
    <?php if (!isset($customer) || !$customer): ?>
        <section class="banner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="banner-padding-left mb-2 mb-lg-0">
                            <h1><span>Your Trusted Neighbourhood Kiosk
                                </span> for All Digital Services</h1>
                            <p class="mb-3 pe-2">Common Services Centres are the access points for delivery of
                                Government-to-Citizen (G2C) and Business to Citizen (B2C) e-Services within the reach of the
                                citizen.
                            </p>
                            <ul class="p-0 without-bg">
                                <li class="d-flex align-items-center position-relative mb-2">
                                    <span class="d-flex align-items-center justify-content-center me-2">
                                        <i class="fa-solid fa-hand-point-right"></i>
                                    </span>
                                    Government to Citizen Services (G2C)
                                </li>
                                <li class="d-flex align-items-center position-relative mb-2">
                                    <span class="d-flex align-items-center justify-content-center me-2">
                                        <i class="fa-solid fa-hand-point-right"></i>
                                    </span>
                                    Business to Citizen Services (B2C)
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="dashboard-in-laptop">
                            <img loading="lazy" src="assets/images/bg-tree.webp" alt="Background">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <!-- Hero End Here... -->

    <!-- Notification Start Here... -->
    <section class="notification">
        <div class="d-flex">
            <div class="notification-box d-flex align-items-center justify-content-center">
                <i class="fa-regular fa-hand-back-point-right text-white" style="animation: 1s ease-in-out 0s 1 normal none running bounce;"></i>
            </div>
            <div class="notification-content d-flex align-items-center w-100">
                <marquee class="marquee">
                    <ul class="d-flex align-items-center p-0">
                        <!-- <li class="me-3">
                     <a class="text-white">
                        The eKYC service has been temporarily suspended due to technical issues. Inconvenience caused is regretted.</a>
                  </li>
                  <li class="me-3"> / </li> -->
                        <li class="me-3">
                            <a class="text-white">
                                ***Welcome To CHANDAN CYBER ZONE*** 
                            </a>
                        </li>
                        <li class="me-3">
                            <a class="text-white">
                                ***!Site Maintenance work on progress, so no order received from customers.***
                            </a>
                        </li>
                        <li class="me-3">
                            <a class="text-white">
                                ***Some services may be unavailable. We apologize for the inconvenience and appreciate your patience as we work to improve our platform.***
                            </a>
                        </li>
                    </ul>
                </marquee>
            </div>
        </div>
    </section>
    <!-- Notification End Here... -->

    <?php if (!isset($customer) || !$customer): ?>
        <!-- Our Services Start Here... -->
        <section class="our-services">

            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-0">
                    <h2 class="h1">Our<span> Services</span></h2>
                    <ul class="nav nav-tabs main-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="https://digitalseva.csc.gov.in/#government-to-citizen" aria-selected="true" role="tab">Government to
                                Citizen Services
                                (G2C)</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="https://digitalseva.csc.gov.in/#business-to-citizen" aria-selected="false" tabindex="-1" role="tab">Business to Citizen
                                Services (B2C)</a>
                        </li>
                    </ul>
                </div>

                <!-- Tab panes start here... -->
                <div class="tab-content p-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="government-to-citizen" role="tabpanel" aria-labelledby="government-to-citizen" tabindex="0">

                        <ul class="nav nav-pills d-flex flex-nowrap mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item mb-2" role="presentation">
                                <button class="nav-link active" id="central-government-tab" data-bs-toggle="pill" data-bs-target="#central-government" type="button" role="tab" aria-controls="central-government" aria-selected="true">Government
                                    Services</button>
                            </li>


                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="central-government" role="tabpanel" aria-labelledby="central-government-tab" tabindex="0">
                                <div class="row justify-content-center">

                                    <!-- Aadhaar -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://uidai.gov.in/" class="d-block" title="Aadhaar" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/Aadhaar.webp" alt="Aadhaar">
                                                <p class="mb-0">Aadhaar</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PAN -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://tinpan.proteantech.in/" class="d-block" title="Permanent Account Number (PAN)" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/pan-card.svg" alt="PAN">
                                                <p class="mb-0">PAN</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PM E-SHRAM -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://eshram.gov.in/indexmain" class="d-block" title="Pradhan Mantri E-SHRAM Portal" target="_blank">
                                                <img class="mb-2" loading="lazy" src="assets/images/central-logo/eSharam.webp" alt="E-Shram">
                                                <p class="mb-0">e-Shram</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Ayushman Bharat -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://abdm.gov.in/" class="d-block" title="Ayushman Bharat Pradhan Mantri Jan Arogya Yojana" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/AYUSHMAN-BHARAT.webp" alt="Ayushman Bharat">
                                                <p class="mb-0">Ayushman</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- National Health Authority -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://nha.gov.in/" class="d-block" title="National Health Authority" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/nhealth.png" alt="National Health Authority">
                                                <p class="mb-0">National Health Authority</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Subhadra Yojana -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://subhadra.odisha.gov.in/" class="d-block">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/Subhadrayojana.jpg" alt="Subhadra Yojana">
                                                <p class="mb-0">Subhadra Yojana</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- CM Kissan -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://cmkisan.odisha.gov.in/" class="d-block">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/cmkissan.jpg" alt="CM Kissan">
                                                <p class="mb-0">CM Kissan</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PM-KISAN -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://pmkisan.gov.in/" class="d-block" title="Pradhan Mantri Kisan Samman Nidhi Yojana (PM-KISAN)">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/PM-Kisan.svg" alt="PM-KISAN">
                                                <p class="mb-0">PM-KISAN</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- E-District -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://edistrict.odisha.gov.in/" class="d-block" title="E-District Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/edistrict.jpg" alt="E-District">
                                                <p class="mb-0">E-District</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Ration -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://www.foododisha.in/citizenservice.asp?GL=eservice&lnk=29" class="d-block" title="Ration Card Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/rationcard.jpg" alt="Ration Card">
                                                <p class="mb-0">RATION-CARD</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Voter -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://voters.eci.gov.in/" class="d-block" title="Voter ID Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/Emblem.svg" alt="VOTER CARD">
                                                <p class="mb-0">VOTER CARD</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!--Driving L  -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://sarathi.parivahan.gov.in/sarathiservice/stateSelectBean.do" class="d-block" title="Driving Licence Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/dl.jpg" alt="Driving Licence">
                                                <p class="mb-0">Driving Licence</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Disability -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://swavlambancard.gov.in/" class="d-block" title="Swavlamban Card - Disability Certificate Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/disability.png" alt="Swavlamban Card">
                                                <p class="mb-0">Swavlamban Card</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- EPFO -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://unifiedportal-mem.epfindia.gov.in/memberinterface/" class="d-block" title="Employees' Provident Fund Organisation (EPFO) Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/epfo.png" alt="EPFO">
                                                <p class="mb-0">EPFO</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Udyam Services -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://eudyogaadhaar.org/" class="d-block" title="Udyam Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/UDYAM-SERVICES.webp" alt="Udyam Services">
                                                <p class="mb-0">Udyam Services</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- State Scolarship -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://scholarship.odisha.gov.in/website/home" class="d-block" title="State Scholarship Portal" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/statescolarship.jpg" alt="State Scholarship Portal">
                                                <p class="mb-0">State Scholarship</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- National Scolarship -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://scholarships.gov.in/" class="d-block" title="National Scholarship Portal" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/nsp.png" alt="National Scholarship Portal">
                                                <p class="mb-0">National Scholarship</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- ABC ID -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://www.abc.gov.in/" class="d-block" title="ABC ID" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/abcidcard.jpg" alt="ABC ID">
                                                <p class="mb-0">ABC ID</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- NPS -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://npstrust.org.in/" class="d-block" title="National Pension System (NPS)" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/nps.webp" alt="NPS">
                                                <p class="mb-0">NPS</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Passport -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://www.passportindia.gov.in/psp" class="d-block" title="Passport Services" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/Passport.webp" alt="Passport">
                                                <p class="mb-0">Passport</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Jeevan Pramaan -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://jeevanpramaan.gov.in/v1.0/#home" class="d-block" title="Jeevan Pramaan - Digital Life Certificate for Pensioners" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/JEEVAN-PRAMAAN.webp" alt="Jeevan Pramaan">
                                                <p class="mb-0">Jeevan Pramaan</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PM-Vishwakarma -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://pmvishwakarma.gov.in/" class="d-block" title="Pradhan Mantri Vishwakarma Kaushal Samman Yojana (PM-Vishwakarma)" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/PM-Vishvakarma.webp" alt="PM-Vishwakarma">
                                                <p class="mb-0">PM-Vishwakarma</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PM Fasal Bima Yojana -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-3 mb-lg-4">
                                            <a href="https://www.pmfby.gov.in/" class="d-block" title="Pradhan Mantri Fasal Bima Yojana (PMFBY)" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/pfby.svg" alt="PMFBY">
                                                <p class="mb-0">PM Fasal Bima Yojana</p>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- PM-SVANidhi -->
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="services-box text-center mb-4 mb-lg-4">
                                            <a href="https://www.pmsvanidhi.mohua.gov.in/" class="d-block" title="Pradhan Mantri Street Vendor’ Atmanirbhar Nidhi (PM-SVANidhi)" target="_blank">
                                                <img loading="lazy" class="mb-2" src="assets/images/central-logo/Atmanirbhar.svg" alt="PM-SVANidhi">
                                                <p class="mb-0">PM-SVANidhi</p>
                                            </a>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="business-to-citizen" role="tabpanel" aria-labelledby="business-to-citizen" tabindex="0">

                        <div class="row justify-content-center w-100">

                            <!------ Business to Citizen -------->

                            <!-- Banking -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/banking-services.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/new-launch.webp" alt="Banking">
                                        <p class="mb-0">Banking</p>
                                    </a>
                                </div>
                            </div>
                            <!-- DIGIPAY -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://digipay.csccloud.in/" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/new-launch-2.webp" alt="Digipay">
                                        <p class="mb-0">Digipay</p>
                                    </a>
                                </div>
                            </div>
                            <!-- DTH -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/dth-recharge.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/new-launch-3.webp" alt="DTH">
                                        <p class="mb-0">DTH</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/education-main.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/banner3.jpeg" alt="Education">
                                        <p class="mb-0">Education</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Electricity -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/electricity-bill-collection.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/banner4.jpeg" alt="Electricity">
                                        <p class="mb-0">Electricity</p>
                                    </a>
                                </div>
                            </div>
                            <!-- Fastag -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/fastag-services.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/bg-tree.webp" alt="Fastag">
                                        <p class="mb-0">Fastag</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Fee Payment -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/education-main.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/Chandan.png" alt="Fee Payment">
                                        <p class="mb-0">Fee Payment</p>
                                    </a>
                                </div>
                            </div>
                            <!-- Gas Bill -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://digitalseva.csc.gov.in/#!" class="d-block">
                                        <img loading="lazy" class="mb-2" src="assets/images/digital-india.webp" alt="Gas Bill">
                                        <p class="mb-0">Gas Bill</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Health -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/health-main.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/health_card.png" alt="Health">
                                        <p class="mb-0">Health</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Insurance -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/insurance-main.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/health_card.png" alt="Insurance">
                                        <p class="mb-0">Insurance</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Loan -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/loan-services.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/abc.png" alt="Loan">
                                        <p class="mb-0">Loan</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Pension -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/nationalpesion-services.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/uan.png" alt="Pension">
                                        <p class="mb-0">Pension</p>
                                    </a>
                                </div>
                            </div>


                            <!-- Skill -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/skill-courses.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/school_identity.png" alt="Skill">
                                        <p class="mb-0">Skill</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Telecom -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/mobile-recharge.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/eshram.png" alt="Telecom">
                                        <p class="mb-0">Telecom</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Travel -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/tours-travels-main.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/abc.png" alt="Travel">
                                        <p class="mb-0">Travel</p>
                                    </a>
                                </div>
                            </div>

                            <!-- Water Bill -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                <div class="services-box text-center mb-3 mb-lg-4">
                                    <a href="https://jaankari.csccloud.in/water.html" class="d-block" target="_blank">
                                        <img loading="lazy" class="mb-2" src="assets/images/ayushman.png" alt="Water Bill">
                                        <p class="mb-0">Water Bill</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab panes end here... -->
            </div>


        </section>
        <!-- Our Services End Here... -->
    <?php endif; ?>
    <?php if (!isset($customer) || !$customer): ?>
    <section class="airtelpayment-section py-5 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="display-4 fw-bold mb-4 text-warning">Keep your <br>Airtel Payment Bank <br>Account safe</h2>
                    <p class="lead mb-5">Open a Safe Second Account with Airtel Payments Bank</p>
                    <a href="https://www.airtelpayments.bank.in/" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-lg" target="_blank">KNOW MORE</a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="assets/images/airtelpaymentbank.svg" alt="Airtel Payments Bank Logo" class="img-fluid shadow-lg rounded" style="max-height: 350px; border-color:brown;">
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!----------------------------------------------------------------------------------------------------------------... -->  
    

    <!------------------------------------------------------------------------------------------------------------------------->

    <div class="section-wrap">
        <div class="section-title">
            <div>
                <h3>Select Document Order [Also Contact Via Whatsapp: 8984103098]</h3>
            </div>
        </div>

        <div class="grid">
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/aadhar.png" alt="Aadhar Card">
                </div>

                <div class="doc-name">Aadhar Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Aadhar+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">

                <div class="img-box">
                    <img src="assets/images/pan.png" alt="PAN Card">
                </div>

                <div class="doc-name">PAN Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=PAN Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/dl.png" alt="Driving License">
                </div>

                <div class="doc-name">Driving License</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Driving+License">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/ayushman.png" alt="Ayushman Card">
                </div>

                <div class="doc-name">Ayushman Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Ayushman+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/ration.png" alt="Ration Card">
                </div>

                <div class="doc-name">Ration Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Ration+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/voter.png" alt="Voter Card">
                </div>

                <div class="doc-name">Voter Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Voter+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/rc.png" alt="RC Card">
                </div>

                <div class="doc-name">RC Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=RC+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/eshram.png" alt="E-Shram Card">
                </div>

                <div class="doc-name">E-Shram Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=E-Shram+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/abc.png" alt="ABC Card">
                </div>

                <div class="doc-name">ABC Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=ABC+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/uan.png" alt="UAN Card">
                </div>

                <div class="doc-name">UAN Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=UAN+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/school_identity.png" alt="School Identity Card">
                </div>

                <div class="doc-name">School Identity Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=School+Identity+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/health_card.png" alt="Health Card">
                </div>

                <div class="doc-name">Health Card</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Health+Card">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/tshirt_printing.png" alt="T-shirt Printing">
                </div>

                <div class="doc-name">T-shirt Printing</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=T-shirt+Printing">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/mang_printing.png" alt="Mang Printing">
                </div>

                <div class="doc-name">Mang Printing</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Mang+Printing">
                        Order Now
                    </a>
                </div>
            </div>
            <div class="doc-card">
                <div class="img-box">
                    <img src="assets/images/photo_printing.png" alt="Photo Printing">
                </div>

                <div class="doc-name">Photo Printing</div>

                <div class="btn-area">
                    <a class="order-btn" href="order.php?doc=Photo+Printing">
                        Order Now
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="whatsapp-label">WhatsApp</div>
    <a href="https://wa.me/918984103098" class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
        <svg viewBox="0 0 32 32">
            <path d="M19.11 17.35c-.29-.15-1.72-.85-1.99-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.95 1.15-.17.2-.35.22-.64.07-.29-.15-1.24-.46-2.36-1.47-.87-.78-1.46-1.75-1.63-2.04-.17-.29-.02-.45.13-.59.13-.13.29-.35.44-.52.15-.17.2-.29.29-.49.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.29-1.05 1.02-1.05 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.1 3.21 5.09 4.5.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.08 1.72-.7 1.96-1.37.24-.67.24-1.24.17-1.37-.07-.12-.27-.2-.57-.35M16.02 4.8c-6.18 0-11.2 5.02-11.2 11.2 0 1.97.51 3.88 1.48 5.56L4.73 27.2l5.78-1.52a11.13 11.13 0 0 0 5.5 1.41h.01c6.18 0 11.2-5.02 11.2-11.2 0-2.99-1.16-5.79-3.28-7.91A11.12 11.12 0 0 0 16.02 4.8m0 20.29h-.01a9.06 9.06 0 0 1-4.62-1.27l-.33-.2-3.43.9.92-3.34-.22-.34a9.03 9.03 0 0 1-1.39-4.83c0-4.99 4.07-9.06 9.08-9.06 2.42 0 4.69.94 6.4 2.65a8.98 8.98 0 0 1 2.66 6.41c0 5-4.07 9.08-9.06 9.08" />
        </svg>
    </a>

    <footer>
        <div class="container pb-2 pb-xl-5">
            <div class="footer">
                <div class="footer-box">
                    <div><strong>Portal:</strong> CHANDAN CYBER ZONE</div>
                    <div><strong>Services:</strong> Aadhar, PAN, DL, Ayushman, Ration, Voter, RC, E-Shram, ABC, UAN, School Identity Card, Health Card, T-shirt Printing, Mang Printing, Photo Printing</div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6">
                    <h3 class="mb-3">Location & Address</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mb-2"><strong>Chandan Cyber Zone</strong></p>
                            <p class="small mb-2">Visit: <a href="https://maps.app.goo.gl/JgVmPQAjgdEXPrNw5?g_st=iw" target="_blank" class="text-white">Open Maps</a></p>
                            <p class="small"><br>Near Block Chhaka<br>AT-PO-PS- JAGANNATH PRASAD <br>Dist- Ganjam<br>State- Odisha<br>Pin- 761121 </p>
                            <p class="small mb-0">Phone: <a href="tel:+918984103098" class="text-white">8984103098</a></p>
                        </div>
                        <div class="col-md-6">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.726769940023!2d85.7428!3d20.25!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDE1JzAwIiBOIDg1wrA0NCc1MiIgvQ!5e0!3m2!1sen!2sin!4v1734574392000!5m2!1sen!2sin" width="100%" height="140" style="border:1px solid rgba(255,255,255,0.3);border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6">
                    <h3 class="mb-3">WhatsApp Chat</h3>

                    <a href="https://wa.me/918984103098" target="_blank">
                        <img src="assets/images/whatsapp-qr.jpeg" alt="WhatsApp QR Code" style="width:160px;height:160px;border-radius:12px;border:2px solid rgba(255,255,255,0.3);">
                    </a>
                    <p class="mt-2"><a href="https://wa.me/918984103098" class="btn btn-success btn-sm">Chat on WhatsApp</a></p>
                </div>

                <div class="col-xl-4 col-lg-6">
                    <h3 class="mb-3">Follow Us - Social Media</h3>
                    <ul class="p-0 d-flex flex-wrap gap-2">
                        <li><a href="https://www.youtube.com/user/CSCSCHEME" target="_blank" class="text-white fs-4"><i class="fa-brands fa-youtube"></i></a></li>
                        <li><a href="https://www.instagram.com/commonservicescenters/" target="_blank" class="text-white fs-4"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="https://www.facebook.com/cscscheme" target="_blank" class="text-white fs-4"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/common-services-centers-official/posts/?feedView=all" target="_blank" class="text-white fs-4"><i class="fa-brands fa-linkedin"></i></a></li>
                        <li><a href="https://x.com/CSCegov_" target="_blank" class="text-white fs-4"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="https://www.whatsapp.com/channel/0029Va5pY1EJpe8avzCDsy2f" target="_blank" class="text-white fs-4"><i class="fa-brands fa-whatsapp"></i></a></li>
                    </ul>
                    <a href="important_links.html" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-lg">Important Links</a>

                </div>
                
            </div>
        </div>

        <div class="bottom-footer">
            <div class="container py-3">
                <ul class="p-0 m-0 d-flex align-items-center flex-wrap justify-content-between">
                    <li>
                        Copyright &copy; 2026 Chandan Cyber Zone. All rights reserved.
                        <span class="mx-2 mx-xxl-4">|</span>
                    </li>
                    <li>Last Updates: 9 Nov 2024 <span class="mx-2 mx-xxl-4">|</span></li>
                    <li>Designed & Developed by <b><a href="https://www.facebook.com/MrAbhishekSahu9#" class="text-decoration-none" target="_blank">MR ABHISHEK</a></b> </li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Footer End Here... -->





    <script>
        if ('loading' in HTMLImageElement.prototype) {
            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                img.src = img.dataset.src || img.src;
            });
        }
    </script>
    <script type='text/javascript'>
        function initEmbeddedMessaging() {
            try {
                embeddedservice_bootstrap.settings.language = 'en_US'; // For example, enter 'en' or 'en-US'

                embeddedservice_bootstrap.init(
                    '00DdN00000MdGBW',
                    'CSC',
                    'https://cscprod.my.site.com/ESWCSC1753703059716', {
                        scrt2URL: 'https://cscprod.my.salesforce-scrt.com'
                    }
                );
            } catch (err) {
                console.error('Error loading Embedded Messaging: ', err);
            }
        };
    </script>
</body>

</html>