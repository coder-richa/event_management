<?php
include_once dirname(__FILE__) . '/../../../classes/state.php';
?> 
<!-- ======= Services Section ======= -->
<section class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Manager</h2>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
                <form
                    name="getAddFrm"
                    id="getAddFrm"
                    method="POST"
                    action="<?= EVENT_MANAGER_SAVE_FORM_API_URL ?>"
                    enctype="multipart/form-data"
                    >
                    <button data-title="Add Manager"  data-showmodal="1"  data-target="<?=TARGET_FORM_MODEL?>" type="button" class="<?=FORM_SUBMIT_BTN_CLASS?> pull-right" style="float: right;">Add Manager</button>
                </form>
            </div>
        </div>
        <?php include_once dirname(__FILE__) . '/searchForm.php'; ?>
        <div id="searchResult">

        </div> 
    </div>   
</section><!-- End Services Section -->