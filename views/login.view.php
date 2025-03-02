
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Login into the Application</h3>
            </div>
            <div class="card-body">
                <form accept-charset="UTF-8" role="form" method="post" action="/login">
                    <fieldset>
                        <div class="input-group has-validation">
                            <input class="form-control<?php echo($form_errors->has('username') ? ' is-invalid' : '') ?>" placeholder="Username" name="username" type="text" required autofocus>
                            <?php if($form_errors->has('username')): ?>
                                <span class="invalid-feedback">
                                            <strong><?php echo $form_errors->getErrorMsg('username'); ?></strong>
                                        </span>
                            <?php endif ?>
                        </div>
                        <div class="input-group has-validation">
                            <input class="form-control<?php echo($form_errors->has('password') ? ' is-invalid' : '') ?>" placeholder="Password" name="password" type="password" value="" required>
                            <?php if($form_errors->has('password')): ?>
                                <span class="invalid-feedback">
                                            <strong><?php echo $form_errors->getErrorMsg('password'); ?></strong>
                                            </span>
                            <?php endif ?>
                        </div>
                        <?php // TODO: Do we need captcha, or other fields for login? ?>
                        <div class="d-grid">
                            <input class="btn btn-lg btn-success" type="submit" value="Login">
                        </div>
                    </fieldset>
                </form>
                <a href="/forgot_password">Forgot your password?</a>
            </div>
        </div>
    </div>