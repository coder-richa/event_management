<?php
include_once dirname(__FILE__) . '/../settings/site-settings.php';
?>   
<!-- ======= Contact Us Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Contact Us</h2>
        </div>

        <div class="row">

            <div class="col-lg-6 d-flex" data-aos="fade-up">
                <div class="info-box">
                    <i class="bx bx-map"></i>
                    <h3>Our Address</h3>
                    <p><?= SITE_ADDRESS ?></p>
                </div>
            </div>

            <div class="col-lg-3 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="info-box">
                    <i class="bx bx-envelope"></i>
                    <h3>Email Us</h3>
                    <p><?= SITE_EMAIL ?></p>
                </div>
            </div>

            <div class="col-lg-3 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="info-box ">
                    <i class="bx bx-phone-call"></i>
                    <h3>Call Us</h3>
                    <p><?= SITE_CONTACT ?></p>
                </div>
            </div>

            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d848295.9861393345!2d150.37152490226384!3d-33.846975938661174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b129838f39a743f%3A0x3017d681632a850!2sSydney%20NSW%2C%20Australia!5e0!3m2!1sen!2sin!4v1630230334457!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

        </div>

    </div>
</section>
<!-- End Contact Us Section -->