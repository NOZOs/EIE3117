<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Foodmenuorder</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <h2>List of Order</h2>
    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead>
            <tr>
                <th class="col-md-1">Customer Name</th>
                <th class="col-md-2">Food Title</th>
                <th class="col-md-1">Price</th>
                <th class="col-md-1">Done?</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($foodmenuorder as $fmo): ?>
            <tr>
                <td><?= htmlspecialchars($fmo->customerName, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fmo->foodTitle, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($fmo->price, ENT_QUOTES, 'UTF-8') ?></td>
                <td><a href="/delete_fmo/<?=$fmo->id?>" class="btn btn-success">- DONE</a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
  </div>
  