 <div class="row">
   <div class="col-md-6 offset-0">
     <div class="input-group">
      <input type="text" name="search_item" class="form-control" placeholder="Search Students here">
      <div class="input-group-append">
        <button class="btn btn-dark" type="button">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div>
   </div>
   <!--<div class="col-md-10">
      search here
   </div>-->
   <div class="col-md-2 offset-md-4">
    <?php user_add_link('reactions', $_SESSION['userPermmissions']) ?>
   </div>
 </div>
<br>
  <?php $uri = new \CodeIgniter\HTTP\URI(current_url()); ?>
 <div class="table-responsive">
   <table class="table table-bordered">
    <thead class="thead-dark">
      <tr class="text-center">
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($reactions)): ?>
        <th colspan="4" class="text-center">Empty</th>
      <?php else: ?>
        <?php $cnt = 1; ?>
        <?php foreach($reactions as $reaction): ?>
        <tr id="<?php echo $reaction['id']; ?>">
          <th scope="row"><?= $cnt++ ?></th>
          <td><?= ucwords($reaction['name']) ?></td>
          <td><?= ucwords($reaction['description']) ?></td>
          <td class="text-center">
            <?php
              users_action('reactions', $_SESSION['userPermmissions'], $reaction['id']);
            ?>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
 </div>
<hr>
