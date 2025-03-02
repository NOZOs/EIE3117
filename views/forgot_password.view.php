
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Forgot Password</h3>
            </div>
            <div class="card-body">
            <form accept-charset="UTF-8" role="form" method="post" action="/forgot_password">
                <fieldset>
                    <div class="input-group has-validation">
                        <input class="form-control<?php echo($form_errors->has('username') ? ' is-invalid' : '') ?>" placeholder="Username" name="username" type="text" required autofocus>
                        <?php if($form_errors->has('username')): ?>
                            <span class="invalid-feedback">
                                        <strong><?php echo $form_errors->getErrorMsg('username'); ?></strong>
                                    </span>
                        <?php endif ?>
                    </div>
                    
                    <div class="d-grid">
                        <input class="btn btn-lg btn-primary" type="submit" value="Change Password">
                    </div>
                </fieldset>
            </form>
            </div>
        </div>
    </div>