<div class="col-md-10 offset-md-1">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title">Registering</h3>
        </div>
        <div class="card-body">
            <form accept-charset="UTF-8" role="form" method="post" action="/register">
                <fieldset>
                    
                    <div class="input-group has-validation">
                        <label class="input-group-text" for="username">Username</label>
                        <input class="form-control<?php echo($form_errors->has('username') ? ' is-invalid' : '') ?>" placeholder="Username" name="username" type="text" required autofocus>
                        <?php if($form_errors->has('username')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('username'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group has-validation">
                        <label class="input-group-text" for="password">Password</label>
                        <input class="form-control<?php echo($form_errors->has('password') ? ' is-invalid' : '') ?>" placeholder="Password" name="password" type="password" required>
                        <?php if($form_errors->has('password')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('password'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group has-validation">
                        <label class="input-group-text" for="confirm_password">Confirm Password</label>
                        <input class="form-control<?php echo($form_errors->has('confirm_password') ? ' is-invalid' : '') ?>" placeholder="Confirm Password" name="confirm_password" type="password" required>
                        <?php if($form_errors->has('confirm_password')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('confirm_password'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group has-validation">
                        <label class="input-group-text" for="email">E-Mail Address</label>
                        <input class="form-control<?php echo($form_errors->has('email') ? ' is-invalid' : '') ?>" placeholder="E-Mail Address" name="email" type="email" required>
                        <?php if($form_errors->has('email')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('email'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group has-validation">
                        <label class="input-group-text" for="nick_name">Nick Name</label>
                        <input class="form-control<?php echo($form_errors->has('nick_name') ? ' is-invalid' : '') ?>" placeholder="Nick Name" name="nick_name" type="text" required>
                        <?php if($form_errors->has('nick_name')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('nick_name'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="input-group has-validation">
                        <label class="input-group-text" for="type">User Type</label>
                        <select class="form-control<?php echo($form_errors->has('type') ? ' is-invalid' : '') ?>" name="type" required>
                            <option value="consumer" selected>Consumer</option>
                            <option value="restaurant">Restaurant</option>
                        </select>
                        <?php if($form_errors->has('type')): ?>
                            <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('type'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid mt-3">
                        <input class="btn btn-lg btn-primary" type="submit" value="Register">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>