<div class="bg-light p-5 rounded">
    <h1><img src="images/bookmark.gif" /> PHPBookmark</h1>
    <p class="lead">Change Password</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <form accept-charset="UTF-8" role="form" method="post" action="/change_password">
        <fieldset>
            <div class="input-group has-validation">
                <label class="input-group-text" for="current_password">Current Password</label>
                <input class="form-control<?php echo($form_errors->has('current_password') ? ' is-invalid' : '') ?>" placeholder="Current Password" name="current_password" type="password" value="" required>
                <?php if($form_errors->has('current_password')):?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('current_password'); ?></strong>
                            </span>
                <?php endif ?>
            </div>
            <div class="input-group has-validation">
                <label class="input-group-text" for="new_password">New Password</label>
                <input class="form-control<?php echo($form_errors->has('new_password') ? ' is-invalid' : '') ?>" placeholder="New Password" name="new_password" type="password" value="">
                <?php if($form_errors->has('new_password')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('new_password'); ?></strong>
                            </span>
                <?php endif ?>    
            </div>
            <div class="input-group has-validation">
                <label class="input-group-text" for="confirm_new_password">Confirm New Password</label>
                <input class="form-control<?php echo($form_errors->has('confirm_new_password') ? ' is-invalid' : '') ?>" placeholder="Confirm New Password" name="confirm_new_password" type="password" value="">
                <?php if($form_errors->has('confirm_new_password')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('confirm_new_password'); ?></strong>
                            </span>
                <?php endif ?>    
            </div>
            
            <div class="d-grid">
                <input class="btn btn-lg btn-primary" type="submit" value="Confirm Password Change">
            </div>
        </fieldset>
    </form>
  </div>