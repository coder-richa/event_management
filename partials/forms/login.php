<span class="hidden" id="loginFrmContainer">
    <form
        name="loginFrm"
        id="loginFrm"
        method="POST"
        action="<?= LOGIN_API_URL ?>"
        enctype="multipart/form-data"
        >
        <div class="row form-alert  form-alert-success hidden">
            <div class="col-sm-12">Success</div>                    
        </div>
        <div class="row  form-alert  form-alert-failure hidden">
            <div class="col-sm-12">Error</div>                    
        </div>
        <div class="form-row">
            <div class="col-12">
                <label for="email" class="form-label isRequired">Email/Username</label>
                <div class="form-group">
                    <input
                        type="email"
                        id="emailLogin"
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
        </div>
        <div class="form-row">
            <div class="col-12">
                <label for="email" class="form-label isRequired">Password</label>
                <div class="form-group">
                    <input
                        type="password"
                        id="passwordLogin"
                        name="password"
                        class="form-control"
                        required="required"
                        data-validator="checkNonEmpty"
                        data-validationType="every"
                        />
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <button type="button" class="<?=FORM_LABEL_CLASS." ".FORM_SUBMIT_BTN_CLASS?>" id="loginBtn">
                            Log in
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</span>