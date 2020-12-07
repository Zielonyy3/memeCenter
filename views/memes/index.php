<?php if (isset($_SESSION['is_logged_in'])): ?>
    <a class="btn btn-warning btn-lg" href="<?= ROOT_PATH ?>memes/add">Dodaj mema</a>
<?php endif; ?>
<h2 class="text-center">Twoja memownia</h2>
<p class="lead text-center" style="font-size: 1.2rem;">Możesz dodawać swoje własne memy po <a
            href="<?= ROOT_PATH ?>users/login">zalogowaniu!</a></p>

<hr>
<?php
$i = 0;
foreach ($viewmodel as $row):
    ?>
    <?php if ($i % 2 == 0): ?>
    <div class="d-flex align-items-center bd-highlight justify-content-center">
<?php endif; ?>

    <div class="card text-center my-3 mx-5" style="max-width: 400px;">
        <div class="card-header">
            <h5><?= $row['title'] ?></h5>
        </div>
        <div class="card-body">
            <a href="<?= ROOT_PATH ?>memes/show/<?= $row['id'] ?>"><img class="card-img-top"
                                                                        src="<?= MEMES_ROOT_PATH . $row['path'] ?>"
                                                                        alt="Card image cap"></a>
        </div>
        <div class="card-footer text-muted">
            <h5>Autor: <a href="<?= ROOT_PATH ?>users/show/<?= $row['author_name'] ?>">
                    <mark><?= $row['author_name'] ?></a></h5>
        </div>
        <div class="card-footer text-muted d-flex alig-items-center justify-content-around"
             style="font-size: 2rem; padding: .7rem;">
            <i class="fas fa-heart mx-2"></i>
            <i class="fas fa-comment mx-2"></i>
        </div>
    </div>

    <?php if ($i % 2 == 1): ?>
    </div>
<?php endif; ?>

    <?php $i++; endforeach; ?>
