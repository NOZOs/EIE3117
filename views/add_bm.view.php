<div class="bg-light p-5 rounded">
    <h1><img src="images/bookmark.gif" /> PHPBookmark</h1>
    <p class="lead">Add Bookmarks</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <form accept-charset="UTF-8" role="form" method="post" action="/add_bm">
        <fieldset>
            <div class="input-group has-validation">
                <label class="input-group-text" for="bm_url">New BM: </label>
                <input class="form-control<?php echo($form_errors->has('bm_url') ? ' is-invalid' : '') ?>" placeholder="http://" name="bm_url" type="text" required autofocus>
                <?php if($form_errors->has('bm_url')): ?>
                    <span class="invalid-feedback">
                                <strong><?php echo $form_errors->getErrorMsg('bm_url'); ?></strong>
                            </span>
                <?php endif ?>
            </div>
            
            <div class="d-grid">
                <input class="btn btn-lg btn-warning" type="submit" value="Add Bookmark">
            </div>
        </fieldset>
    </form>
</div>