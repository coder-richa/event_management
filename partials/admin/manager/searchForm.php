<div class="row form-row">
    <form action="<?=EVENT_MANAGER_GET_API_URL?>" method="post" class="searchFrm">
        <div class="row">
            <div class="col-sm-2 form-group">
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First name" required="required">
            </div>
            <div class="col-sm-2 form-group">
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last name" required="required">
            </div>
            <div class="col-sm-2 form-group">
                <input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="Contact Number" required="required">
            </div>
            <div class="col-sm-2 form-group">
                <input type="text" name="email_id" class="form-control" id="email_id" placeholder="E-mail ID" required="required">
            </div>
            <div class="col-sm-2 form-group">
                <button type="button" class="<?=FORM_SUBMIT_BTN_CLASS?> searchTableBtn" data-target="#searchResult" >Search</button>
            </div>
        </div>
    </form>
</div>