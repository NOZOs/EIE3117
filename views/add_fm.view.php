<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Add Menu</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <form accept-charset="UTF-8" role="form" method="post" action="/add_fm">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <fieldset>
            <div class="input-group has-validation">
                <label class="input-group-text" for="fm_">New FM: </label>
                <input class="form-control" placeholder="enter your food title" name="fm_fT" type="text" required autofocus>
                <input class="form-control" placeholder="enter your dish description" name="fm_dD" type="text" required autofocus>
                <input class="form-control" placeholder="enter your price" name="fm_fP" type="number" required autofocus>
                <?php if($form_errors->has('fm_fT')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('fm_fT'); ?></strong>

                            </span>
                <?php endif ?>
                <?php if($form_errors->has('fm_dD')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('fm_dD'); ?></strong>

                            </span>
                <?php endif ?>
                <?php if($form_errors->has('fm_P')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('fm_fP'); ?></strong>

                            </span>
                <?php endif ?>
                
            </div>
            
            <div class="d-grid">
                <input class="btn btn-lg btn-warning" type="submit" value="Add FoodMenu">
            </div>
        </fieldset>
    </form>
</div>