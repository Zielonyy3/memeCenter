<div class="text-center">
    <h1>Witaj w Meme Center</h1>
    <p class="lead">Obejrzyj sobie najfajniejsze memy</p>
    <a class="btn btn-primary btn-lg text-center" href="<?= ROOT_PATH ?>memes">Zobacz teraz</a>

    <hr>
    <h2>
        <mark>Ostatnio dodane memy</mark>
    </h2>

    <div class="d-flex align-items-center bd-highlight justify-content-between p-5" syle="max-height: 200px;">
        <?php foreach ($viewmodel as $row): ?>
            <div class="card flex-fill mx-2" style="width: 18rem; max-width: 300px;">
                <div class="p-1 border-bottom">
                    <p class="card-text" style="font-size: .9rem"><?= $row['added_at'] ?></p>
                </div>
                <a href="<?= ROOT_PATH ?>memes/show/<?= $row['id'] ?>"><img class="card-img-top"
                                                                            src="<?= MEMES_ROOT_PATH . $row['path'] ?>"
                                                                            alt="Card image cap"></a>
                <div class="card-body">
                    <h5 class="card-title"><?= $row['title'] ?></h5>
                    <p class="card-text">Autor: <a href="<?= ROOT_PATH ?>users/show/<?= $row['author_name'] ?>">
                            <mark><?= $row['author_name'] ?></mark>
                        </a></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</div>
