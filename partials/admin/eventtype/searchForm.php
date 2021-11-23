<div class="row form-row">
    <form action="<?=EVENT_TYPE_GET_API_URL?>" method="post" class="searchFrm">
        <div class="row">
            <div class="col-sm-3 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Event Type" required="required">
            </div>
            <div class="col-sm-3 form-group">
                <button type="button" class="<?=FORM_SUBMIT_BTN_CLASS?> searchTableBtn" data-target="#searchResult" >Search</button>
            </div>
        </div>
    </form>
</div>