<?php 
include_once dirname(__FILE__).'/../settings/site-settings.php';
?>
<!-- ======= Hero Section ======= -->
        <section id="hero">
            <div class="hero-container">
                <div id="heroCarousel" style="background-image: url('assets/img/main.jpg');">

                    <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

                    <div class="carousel-inner" role="listbox">

                        <!-- Slide 1 -->
                        <div class="carousel-item active" style="background-image: url('assets/img/main.jpg');">
                            <div class="carousel-container">
                                <div class="carousel-content container">
                                    <h2 class="animate__animated animate__fadeInDown">Welcome to <span><?=SITE_NAME?></span></h2>
                                    <p class="animate__animated animate__fadeInUp">We are one of the best event management firm in Australia. We allows our customers to make bookings and view booked event details online.</p>
                                    <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section><!-- End Hero -->