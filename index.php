<?php
$pageTitle = "Home";
include_once './partials/common_includes/header.php';
include_once './partials/slider.php';
?>
<main id="main">
    <?php
    include_once './partials/about-us.php';
    include_once './partials/services.php';
    include_once './partials/contact-us.php';
    include_once './partials/forms/login.php';
    include_once './partials/forms/register.php';
    ?>
</main>
<!-- End #main -->
<?php
include_once './partials/common_includes/footer.php';
?>        