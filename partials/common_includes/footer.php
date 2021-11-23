<?php
include_once dirname(__FILE__) . '/../../settings/site-settings.php';
?>
<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span><?= SITE_NAME ?></span></strong>. All Rights Reserved
        </div>
    </div>
</footer><!-- End Footer -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- Modal start-->
<div class="modal hidden" id="popupFormModal">
    <h2 class="modal-title">Modal</h2>
    <a href="javascript:void(0)" class="close-modal">&times;</a>
    <div class="modal-body"></div>
</div>
<!-- Modal end-->

<!-- Modal start-->
<div class="modal error-modal hidden" id="successModal">
    <h2 id="successModalHeading">Success</h2>
    <a href="javascript:void(0)" class="close-modal">&times;</a>
    <div class="modal-body">
        <p>Record updated successfully</p>
    </div>
</div>
<!-- Modal end-->

<div class="overlay hidden"></div>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/purecounter/purecounter.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
 <script src="assets/js/main.js"></script>
<!-- Template Main JS File -->
<!--<script src="assets/js/main.js"></script>-->
<script src="assets/js/query-selector.js"></script>
<script src="assets/js/dom-manipulation-functions.js"></script>
<script src="assets/js/data-formatter.js"></script>
<script src="assets/js/animation.js"></script>
<script src="assets/js/utility.js"></script>
<script src="assets/js/ajax-request-functions.js"></script>
<script src="assets/js/form-field-functions.js"></script>
<script src="assets/js/validations.js"></script>
<script src="assets/js/higher-order-functions.js"></script>
<script src="assets/js/event-functions.js"></script>
<script src="assets/js/modal-operations.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>