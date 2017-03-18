<div class="view hm-black-light">
    <div class="full-bg-img flex-center" >
        <form action="/login/action" method="POST">
            <ul  style="margin: 40px">
                <li>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="text" id="form1" class="form-control" name="password">
                                <label for="form1">Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form">
                                <input type="password" id="form2" class="form-control" name="password_confirm">
                                <label for="form2">Confirm Password</label>
                                <input type="hidden" name="token" id="token" value="<?= $this->request_token; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p id="reset-message">Forgot Password? <a id="lost-password">Reset</a></p>
                    </div>
                </li>
                <li>
                    <div class="md-form">
                        <button type="submit" class="btn btn-default btn-rounded">Login</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>