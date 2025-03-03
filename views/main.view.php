<div class="bg-light p-5 rounded">
    <h1> PHPFoodMenu</h1>
    <p class="lead">Main</p>
    <p>Logged in as <strong><?=SessionController::getInstance()->getUser()->username;?></strong></p>
    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead>
            <tr>
                <th class="col-md-10">FoodMenu</th>
                <th class="col-md-2">View</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($bookmarks as $bm): ?>
                <tr>
                    <td><a href="<?=htmlspecialchars($bm->url)?>"><?=htmlspecialchars($bm->url)?></a></td>
                    <td><a href="/delete_bm/<?=$bm->id?>" class="btn btn-danger">- VIEW</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    
    <a href="/add_bm" class="btn btn-warning">+ Add FoodMenu</a>
  </div>