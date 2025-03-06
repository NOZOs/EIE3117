<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Main</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <h2>List of FoodMenu</h2>
    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead>
            <tr>
                <th class="col-md-3">Resturant</th>
                <th class="col-md-8">Food Title</th>
                <th class="col-md-2">Detail</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($foodmenu as $fm): ?>
            <tr>
                <td><?= htmlspecialchars($fm->username) ?></td>
                <td><?= htmlspecialchars($fm->foodTitle) ?></td>
                <td><a href="/d_fm?id=<?= $fm->id ?>" class="btn btn-primary">VIEW</a></td>
                
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    
    <a href="/add_fm" class="btn btn-warning">+ Add FoodMenu</a>
  </div>
  