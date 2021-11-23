<!--registration form starts-->
<?php
include_once dirname(__FILE__) . '/../../classes/City.php';
?> 
<span class="hidden" id="registrationFrmContainer">
    <form
        name="registrationFrm"
        id="registrationFrm"
        method="POST"
        action="<?= CUSTOMER_ADD_API_URL ?>"
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
                <label for="title" class="form-label isRequired">Title</label>
                <div class="form-group">
                    <input
                        type="radio"
                        name="title"
                        value="Mr."
                        id="titleMr"
                        required="required"
                        data-validator="checkNonEmpty"
                        data-validationType="every"
                        data-format="title"
                        />
                    <label for="titleMr">Mr</label>
                    <input
                        type="radio"
                        name="title"
                        value="Ms."
                        id="titleMs"
                        required="required"
                        data-validator="checkNonEmpty"
                        data-validationType="every"
                        data-format="title"
                        />
                    <label for="titleMs">Ms</label>
                    <input
                        type="radio"
                        name="title"
                        value="Mrs."
                        id="titleDr"
                        required="required"
                        data-validator="checkNonEmpty"
                        data-validationType="every"
                        data-format="title"
                        />
                    <label for="titleMs">Mrs</label>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="firstName" class="form-label isRequired">First Name</label>
                <div class="form-group">
                    <input
                        type="text"
                        id="firstName"
                        name="firstName"
                        class="form-control"
                        required="required"
                        data-type="lettersAndSpaces"
                        data-validator="checkNonEmpty,checkName"
                        data-validationType="every"
                        data-format="name"
                        />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="middleName" class="form-label">Middle Name</label>
                <div class="form-group">
                    <input
                        type="text"
                        id="middleName"
                        name="middleName"
                        class="form-control"
                        data-type="lettersAndSpaces"
                        data-validator="checkEmpty,checkName"
                        data-validationType="some"
                        data-format="name"
                        />
                </div>
            </div>

            <div class="col-sm-6">
                <label for="lastName" class="form-label isRequired">Last Name</label>
                <div class="form-group">
                    <input
                        type="text"
                        id="lastName"
                        name="lastName"
                        class="form-control"
                        required="required"
                        data-type="lettersAndSpaces"
                        data-validator="checkNonEmpty,checkName"
                        data-validationType="every"
                        data-format="name"
                        />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="email" class="form-label isRequired">Email</label>
                <div class="form-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        required="required"
                        data-type="email"
                        data-validator="checkNonEmpty,checkEmail"
                        data-validationType="every"
                        data-format="email"
                        />
                </div>
            </div>
            <div class="col-sm-6">
                <label for="phone" class="form-label isRequired">Contact Number</label>
                <div class="form-group">
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="form-control"
                        required="required"
                        data-type="phone"
                        data-validator="checkNonEmpty,checkPhone"
                        data-validationType="every"
                        data-format="phone"
                        />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="password" class="form-label isRequired">Password</label>
                <div class="form-group">
                    <input
                        type="password"
                        id="passwordRegistration"
                        name="password"
                        class="form-control"
                        required="required"
                        data-validator="checkNonEmpty"
                        data-validationType="every"
                        />
                </div>
            </div>
            <div class="col-sm-6">
                <label for="street" class="form-label isRequired">Street Number</label>
                <div class="form-group">
                    <input
                        type="text"
                        id="street"
                        name="street"
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
                        required="required"
                        data-type="phone"
                        data-validator="checkNonEmpty,checkPincode"
                        data-validationType="every"                           
                        />
                </div>
            </div>
            <div class="col-sm-6">
                <label for="city" class="form-label isRequired">City</label>
                <div class="form-group">
                    <select id="language" name="city" required="required" data-validator="checkNonEmpty"  data-validationType="every"  class="form-control">
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
                <button type="button" class="<?=FORM_LABEL_CLASS." ".FORM_SUBMIT_BTN_CLASS?>" id="registerBtn">
                    Submit
                </button>
            </div>
        </div>

    </form>
</span>
<!--registration form ends -->