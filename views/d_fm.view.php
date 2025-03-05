<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Menu Detail</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <form accept-charset="UTF-8" role="form" method="post" action="/d_fm">
        // add a tablr can show the current dish title eds and price 
        <table class="table table-hover"> 
            <thead>
                <tr>
                    <th class="col-md-3">Food Title</th>
                    <th class="col-md-8">Dish Description</th>
                    <th class="col-md-2">Price</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <fieldset>
            <div class="input-group has-validation">
                <label class="input-group-text" for="dfm_">FM: </label>
                <input class="form-control" placeholder="enter amount of dish="fm_fA" type="text" required autofocus>
                <?php if($form_errors->has('fm_fA')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('fm_fA'); ?></strong>

                            </span>
                <?php endif ?>
                
            </div>
            
            <div class="d-grid">
                <input class="btn btn-lg btn-warning" type="submit" value="Buy it">
            </div>
        </fieldset>
    </form>
</div>