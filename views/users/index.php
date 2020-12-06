<div class="row pb-3" ><h1 >Lista użytkowników</h1></div>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Nazwa</th>
      <th scope="col">Mail</th>
      <th scope="col">Data dołączenia</th>
      <th scope="col">Punkty</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($viewmodel as $row): ?>
        <?php if((isset($_SESSION['user_data']['id'])) && $_SESSION['user_data']['id'] == $row['id']):?>
            <tr class="table-success">
        <?php else: ?>
            <tr>
        <?php endif; ?>
                <td scope="row" style="width:32px;padding:4px 0 4px 4px;">      
                  <a href="<?=ROOT_PATH?>users/show/<?=$row['name']?>">
                    <img src="<?=AVATARS_PATH;?><?=$row['avatar']?>" alt="avatar" style="width:48px;height:auto;">
                  </a>
              </td>
                <td ><a style="color: black;" href="<?=ROOT_PATH?>users/show/<?=$row['name']?>"><?=$row['name']?></a></td>
                <td><?=$row['mail']?></td>
                <td><?=$row['join_date']?></td>
                <td><?=$row['points']?></td>
            </tr>
    <?php endforeach; ?>
  </tbody>
</table>