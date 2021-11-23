<?php
@session_start();
include_once dirname(__FILE__) . '/../../settings/site-settings.php';
include_once dirname(__FILE__) .'./site-menus.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?= SITE_NAME ?> - <?= $pageTitle ?></title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
        <!-- Google Fonts -->
        <link href="assets/vendor/font/open-sans.css" rel="stylesheet">
        <!-- Vendor CSS Files -->

        <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>

        <!-- ======= Top Bar ======= -->
        <section id="topbar" class="d-flex align-items-center">
            <h2 class="hidden">top</h2>
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope-fill"></i><a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>
                    <i class="bi bi-phone-fill phone-icon"></i> <?= SITE_CONTACT ?>
                </div>
                <div class="social-links d-none d-md-block">
                    <a href="<?= SITE_TWITTER ?>" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="<?= SITE_FACEBOOK ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="<?= SITE_INSTA ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="<?= SITE_LINKEDIN ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </section>

        <!-- ======= Header ======= -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center">

                <div class="logo me-auto">
                    <h1><a href="index.php"><?= SITE_NAME ?></a></h1>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <?php
                        foreach ($siteMenu as $menu) {
                            $dataAttributes = array();
                            if (isset($menu['data-attr'])) {
                                foreach ($menu['data-attr'] as $key => $val) {
                                    $dataAttributes[] = $key . "='" . $val . "'";
                                }
                            }
                            ?>
                            <li><a class="nav-link scrollto <?= $pageTitle == $menu['title'] ? "active" : "" ?> <?= isset($menu['custom-class']) && !empty($menu['custom-class']) ? $menu['custom-class'] : "" ?>" href="<?= isset($menu['link']) && !empty($menu['link']) ? $menu['link'] : "javascript:void(0);" ?>" <?= implode(" ", $dataAttributes) ?>><?= $menu['title'] ?></a></li>
                            <?php
                        }
                        ?>


                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->