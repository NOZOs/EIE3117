<div class="bg-light p-5 rounded">
    <h1>PHPFoodMenu</h1>
    <p class="lead">Menu Detail</p>
    <p>Logged in as <strong><?= SessionController::getInstance()->getUser()->username; ?></strong></p>
    <p>you will turn back to main page after buying a food automatically.</p>
    <p>Only customer user can make order</p>
    <?php if (isset($foodmenu) && !empty($foodmenu)): ?>
        <?php $fm = $foodmenu[0]; ?>
        <form accept-charset="UTF-8" role="form" method="post" action="/buy_fm">
            <input type="hidden" name="fm_id" value="<?= htmlspecialchars($fm->id) ?>">
            <table class="table table-hover"> 
                <thead>
                    <tr>
                        <th>Food Title</th>
                        <th>Dish Description</th>
                        <th>Price</th>
                        <th>Buy</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($fm->foodTitle) ?></td>   
                        <td><?= htmlspecialchars($fm->dishDescription) ?></td>   
                        <td>$<?= htmlspecialchars($fm->price) ?></td>
                        <?php
                        if (!SessionController::getInstance()->isRestaurant()):
                        ?>
                        <td><input class="btn btn-lg btn-warning" type="submit" value="Buy!"></td>
                        <?php
                        endif
                        ?>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-success" href="/main">Go back to main</a>
        </form>
    <?php elseif (isset($error)): ?>
        <p class="text-danger"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>
