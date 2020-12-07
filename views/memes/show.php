<div class="row card-footer border d-flex justify-content-between align-items-baseline">
    <a href="<?= ROOT_PATH ?>memes" class="btn btn-primary px-4">Wróć</a>
    <h4><?= $viewdata['meme']['title'] ?></h4>
    <p class="p-0 m-0"><?= $viewdata['meme']['added_at'] ?></hp>

</div>
<div class="row">
    <div class="col-md-8">
        <div class="card-body">
            <img class="card-img-top" src="<?= MEMES_ROOT_PATH . $viewdata['meme']['path'] ?>" alt="Card image cap"
                 style="max-height: 80vh;width: auto; max-width: 100%;">
        </div>
    </div>
    <div class="col-md-4 pt-4">
        <div class=" p-2 d-flex justify-content-between align-items-start border-bottom">
            <a href="<?= ROOT_PATH ?>users/show/<?= $viewdata['meme']['author_name'] ?>">
                <img src="<?= AVATARS_PATH; ?><?= $viewdata['meme']['avatar'] ?>" alt="avatar"
                     class="rounded-circle w-auto" style="height: 100px; !important">
            </a>
            <div class="d-flex flex-column justify-content-between">
                <p><a href="<?= ROOT_PATH ?>users/show/<?= $viewdata['meme']['author_name'] ?>"
                      style="color: black;"><?= $viewdata['meme']['author_name'] ?></a></p>
                <p><strong>Points: <?= $viewdata['meme']['points'] ?></strong></p>
            </div>
        </div>
        <p class="p-3 border-bottom">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum ad illo eaque accusantium rerum harum
            consequatur qui ducimus aperiam, sit dignissimos quam, nesciunt necessitatibus temporibus ea voluptates amet
            minus eius.
        </p>
        <?php if (isset($_SESSION['is_logged_in']) && ($viewdata['meme']['author_id'] == $_SESSION['user_data']['id'])): ?>
            <button class="btn btn-danger px-4">Usuń mema</button>
            <hr>
        <?php endif; ?>
        <div>
            <form method="POST" action="<?= ROOT_PATH ?>memes/show/<?= $viewdata['meme']['id'] ?>">
                <div class="form-group">
                    <label for="comment"><h4>Dodaj komentarz</h4></label>
                    <textarea class="form-control" id="comment" rows="5" name="body"
                              placeholder="Musisz być zweryfikowanym użytkownikiem aby dodać komentarz!" <?= (isset($_SESSION['user_data']['is_verified']) && $_SESSION['user_data']['is_verified'] == true) ? '' : 'disabled'; ?>></textarea>
                    <input type="submit" value="Dodaj" name="submit" class="btn btn-warning mt-3 px-5 float-right">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>

    </div>

</div>
</div>
<div class="row mt-4">

    <?php if (count($viewdata['comments']) > 0): ?>
        <ul class="list-unstyled w-100">
            <?php foreach ($viewdata['comments'] as $comment): ?>
                <li class="media border card-footer py-2 px-3 w-100 my-3">
                    <a href="<?= ROOT_PATH ?>users/show/<?= $comment['name'] ?>">
                        <img src="<?= AVATARS_PATH; ?><?= $comment['avatar'] ?>" class="mr-3" alt="avatar"
                             style="height:64px;width:auto;">
                    </a>
                    <div class="media-body">
                        <div class="d-flex justify-content-between align-items-baseline w-100">
                            <h5 class=""><?= $comment['name'] ?></h5>
                            <p style="font-size: .8rem; margin: 0;"><?= $comment['created_at'] ?></p>
                        </div>
                        <p style="padding-bottom: 0rem; margin-bottom: 0;"><?= $comment['body'] ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="card-footer w-100 m-3 border text-center pb-0">
            <h5>Na razie nie ma tutaj żadnych komentarzy...</h5>
            <p class="" style="font-size: 1.1rem; font-weight: 300;">Bądz pierwszym który go doda!</p>
        </div>
        <!-- <h5>Na razie nie ma tutaj żadnych komentarzy!</h5> -->
    <?php endif; ?>

</div>
