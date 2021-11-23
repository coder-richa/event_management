<?php 
include_once dirname(__FILE__).'/../classes/services.php';
?>
<!-- ======= Services Section ======= -->
<section class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Services</h2>
        </div>

        <div class="row">
            <?php
            $services = Services::getALL();
            foreach ($services as $service) {
                ?>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up">
                    <div class="icon"><i class="<?=$service->getIcon();?>"></i></div>
                    <h4 class="title"><a href=""><?=$service->getTitle();?></a></h4>
                    <p class="description"><?=$service->getDescription();?></p>
                </div>     
                <?php
            }
            ?>           
        </div>

    </div>
</section><!-- End Services Section -->