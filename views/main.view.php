<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Main</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead>
            <tr>
                <th class="col-md-10">FoodMenu - Title</th>
                <th class="col-md-2">View</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($foodmenu as $fm): ?>
            <tr>
                <td><?= htmlspecialchars($fm->foodTitle) ?></td>
                <td>- VIEW</td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    
    <a href="/add_fm" class="btn btn-warning">+ Add FoodMenu</a>
  </div>