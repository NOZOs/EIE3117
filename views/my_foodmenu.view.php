<div class="bg-light p-5 rounded">
    <h1>My Food Menu</h1>
    <p class="lead">Your Menu Items</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <h2>Your Food Menu Items</h2>
    <?php if (empty($foodmenu)): ?>
        <p>You haven't added any menu yet.</p>
    <?php else: ?>
    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead>
            <tr>
                <th class="col-md-6">Food Title</th>
                <th class="col-md-2">Price</th>
                <th class="col-md-2">Detail</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($foodmenu as $fm): ?>
            <tr>
                <td><?= htmlspecialchars($fm->foodTitle) ?></td>
                <td>$<?= number_format($fm->price, 2) ?></td>
                <td><a href="/d_fm?id=<?= $fm->id ?>" class="btn btn-primary">VIEW</a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php if (SessionController::getInstance()->isRestaurant()): ?>
        <a href="/add_fm" class="btn btn-warning">+ Add Food Menu Item</a>
    <?php endif; ?>
</div>