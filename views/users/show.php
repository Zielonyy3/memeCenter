<div class="modal fade" id="changeAvatarModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeAvatarLabel">Zmień avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?=ROOT_PATH?>users/show/<?=$viewmodel['user']['name']?>" enctype='multipart/form-data'>
            <div class="form-group">
                <label for="avatar">Wybierz zdjęcie</label>
                <input type="file" class="form-control-file" id="avatarSelect" name="avatar">
            </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Zmień" name="changeAvatar">
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
<!-- modal 2 -->
<div class="modal fade" id="changeNameModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeNameLabel">Zmień nazwe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?=ROOT_PATH?>users/show/<?=$viewmodel['user']['name']?>">
            <div class="form-group">
                <label for="avatar">Nowa nazwa</label>
                <input type="text" class="form-control-file" id="name" name="name">
            </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Zmień" name="changeName">
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
<!-- modal 3 -->
<div class="modal fade" id="changeMailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeMailLabel">Zmień mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?=ROOT_PATH?>users/show/<?=$viewmodel['user']['name']?>">
            <div class="form-group">
                <label for="avatar">Nowy mail</label>
                <input type="email" class="form-control-file" id="mail" name="mail">
            </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Zmień" name="changeName">
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
<!--  -->

<div class="row">
    <div class="col-7">
        <div class="row">
            <div class="w-100 mr-4 p-2 d-flex justify-content-between align-items-end border-bottom">
                <div class="d-flex w-50 align-items-end">
                    <img src="<?=AVATARS_PATH;?><?=$viewmodel['user']['avatar']?>" alt="avatar" class="rounded-circle w-auto mr-4" style="height: 100px; !important">
                    <div class="row"><h5><?=$viewmodel['user']['name']?><h5></div>
                </div>
                    
                <div class="d-flex flex-column justify-content-between">
                    <div class="row">Punktów:<strong><?=' '.$viewmodel['user']['points']?></strong></div>
                    <div class="row">Data dołączenia: <strong><?=$viewmodel['user']['join_date']?></strong></div>
                    <div class="row">Mail: <strong><?=$viewmodel['user']['mail']?></strong></div>
                </div>
            </div>
        </div>
        <?php if(isset($_SESSION['is_logged_in']) && ($_SESSION['user_data']['id'] == $viewmodel['user']['id'])): ?>
            <div class="row">

                <div class="col-sm">
                    <div class="row mt-3 d-flex justify-content-start">
                            <button type="button" class="btn btn-info mx-2" data-toggle="modal" data-target="#changeAvatarModal" style="width: 120px;">Zmień avatar</button>
                            <button class="btn btn-info mx-2" data-toggle="modal" data-target="#changeNameModal" style="width: 120px;">Zmień nazwę</button>
                            <button class="btn btn-primary mx-2" data-toggle="modal" data-target="#changeMailModal" style="width: 120px;">Zmień mail</button>
                    </div>
                    <div class="row mt-3 d-flex justify-content-start">
                        <div class="mx-2" style="width: 120px;"><a href="" class="btn btn-primary w-100">Zmień hasło</a></div>
                        <div class="mx-2" style="width: 120px;"><a href="<?=ROOT_PATH?>users/verify" class="btn btn-warning w-100">Zweryfikuj</a></div>
                        <div class="mx-2" style="width: 120px;"><a href="" class="btn btn-danger w-100">Usuń konto</a></div>
                    </div>
                </div>
                
            </div>
        <?php endif; ?>
    </div>
    <div class="col-5" style="padding-bottom: 200px;">
        <h3 class="text-center">Ostatnie aktywności</h3>
        <hr>
        <table class="table table-borderless">
            <thead>
            </thead>
            <tbody>
              <?php foreach($viewmodel['activities'] as $activity): ?>
                <tr>
                    <th scope="row"><?=$activity['created_at']?></th>
                    <td><?=$activity['name'].' '.$activity['action']?><a href="<?=ROOT_PATH.'memes/show/'.$activity['meme_id']?>">mema</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<hr>
<?php if(isset($_SESSION['is_logged_in']) && ($_SESSION['user_data']['id'] == $viewmodel['user']['id'])): ?>
    <h4 class="text-center"><mark>Twoje ostatnio dodane memy</mark></h4>
<?php else: ?>
    <h4 class="text-center"><mark>Ostatnio dodane memy <?=$viewmodel['user']['name']?></mark></h4>
<?php endif; ?>
<?php 
    $i=0; 
    foreach($viewmodel['memes'] as $meme): 
?>
<?php if($i%2==0): ?>
    <div class="d-flex align-items-center bd-highlight justify-content-center">
<?php endif; ?>

  <div class="card text-center my-3 mx-5" style="max-width: 400px;">
    <div class="card-header">
      <h5><?=$meme['title']?></h5>
    </div>
    <div class="card-body">
    <a href="<?=ROOT_PATH?>memes/show/<?=$meme['id']?>"><img class="card-img-top" src="<?=MEMES_ROOT_PATH.$meme['path']?>" alt="Card image cap"></a>
    </div>
    <div class="card-footer text-muted d-flex alig-items-center justify-content-around" style="font-size: 2rem; padding: .7rem;">
      <i class="fas fa-heart mx-2"></i>
      <i class="fas fa-comment mx-2"></i>
    </div>
  </div>

<?php if($i%2==1): ?>
    </div>
<?php endif; ?>

<?php $i++; endforeach; ?>


