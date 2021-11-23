<?php
include_once dirname(__FILE__) . '/../../../classes/City.php';
include_once dirname(__FILE__) . '/../../../classes/EventType.php';
include_once dirname(__FILE__) . '/../../../classes/Services.php';
?> 
<!-- ======= Services Section ======= -->
<section class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Make Booking</h2>
        </div>
        <div class="row form-row">
            <form
                name="registrationFrm"
                id="registrationFrm"
                method="POST"
                action="<?= EVENT_SAVE_API_URL ?>"
                enctype="multipart/form-data"       
                >

                <div class="row form-alert  form-alert-success hidden">
                    <div class="col-sm-12">Success</div>                    
                </div>
                <div class="row  form-alert  form-alert-failure hidden">
                    <div class="col-sm-12">Error</div>                    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="event_start_on" class="form-label isRequired">Event Start On</label>
                        <div class="form-group">
                            <input
                                type="text"
                                id="event_start_on"
                                name="event_start_on"
                                class="form-control"
                                placeholder="Start Date"
                                required="required"
                                data-type=""
                                data-validator="checkNonEmpty"
                                data-validationType="every"
                                />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="event_end_on" class="form-label isRequired">Event End On</label>
                        <div class="form-group">
                            <input
                                type="text"
                                id="event_end_on"
                                placeholder="End Date"
                                name="event_end_on"
                                class="form-control"
                                required="required"
                                data-type=""
                                data-validator="checkNonEmpty"
                                data-validationType="every"
                                />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="type_id" class="form-label isRequired">Event Type</label>
                        <div class="form-group">
                            <select id="type_id" name="type_id" required="required" data-validator="checkNonEmpty"  data-validationType="every"  class="form-control">
                                <option value="">Event Type</option>
 <?php
                                $eventTypes = EventType::getALL();
                                foreach ($eventTypes as $eventType) {
                                    ?>
                                    <option value="<?= $eventType->getType_id() ?>"><?= $eventType->getTitle() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="street_no" class="form-label isRequired">Street Number</label>
                        <div class="form-group">
                            <input
                                type="text"
                                id="street_no"
                                name="street_no"
                                placeholder="Street Number"
                                class="form-control"
                                required="required"
                                data-type="lettersAndSpaces"
                                data-validator="checkNonEmpty"
                                data-validationType="every"                           
                                />
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="pincode" class="form-label isRequired">Pincode Number</label>
                        <div class="form-group">
                            <input
                                type="text"
                                id="pincode"
                                name="pincode"
                                class="form-control"
                                placeholder="Pincode Number"
                                required="required"
                                data-type="phone"
                                data-validator="checkNonEmpty,checkPincode"
                                data-validationType="every"                           
                                />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="city_id" class="form-label isRequired">Event City</label>
                        <div class="form-group">
                            <select id="city_id" name="city_id" required="required" data-validator="checkNonEmpty"  data-validationType="every"  class="form-control">
                                <option value="">City</option>
                                <?php
                                $cities = City::getALL();
                                foreach ($cities as $city) {
                                    ?>
                                    <option value="<?= $city->getCity_id() ?>"><?= $city->getTitle() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-6">
                        <label for="description" class="form-label isRequired">Description</label>
                        <div class="form-group">
                            <textarea
                                id="description"
                                name="description"
                                class="form-control"
                                required="required"
                                data-validator="checkNonEmpty"
                                data-validationType="every"
                                ></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="services" class="form-label isRequired">Services</label>
                        <div class="form-group">
                            <select id="services" name="services[]" required="required" data-validator="checkNonEmpty" multiple="multiple"  data-validationType="every"  class="form-control">
                                <option value="">Services</option>
                                <?php
                                $services = Services::getALL();
                                foreach ($services as $service) {
                                    ?>
                                    <option value="<?= $service->getService_id() ?>"><?= $service->getTitle() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="special_requirement" class="form-label ">Special Requirements</label>
                        <div class="form-group">
                            <input
                                type="text"
                                id="special_requirement"
                                name="special_requirement"
                                class="form-control"
                                placeholder="Special Requirements"
                                />
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="<?= FORM_LABEL_CLASS . " " . FORM_SUBMIT_BTN_CLASS ?> " id="registerBtn">
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>   
</section><!-- End Services Section -->