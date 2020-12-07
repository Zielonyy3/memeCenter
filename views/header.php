<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="<?= ROOT_PATH ?>">Meme Center</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item active">
              <a class="nav-link" href="#">Strona główna <span class="sr-only">(current)</span></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="<?= ROOT_PATH ?>memes">Memy</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= ROOT_PATH ?>users" tabindex="-1" aria-disabled="true">Użytkownicy</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['is_logged_in'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT_PATH ?>users/show/<?= $_SESSION['user_data']['name'] ?>"
                       tabindex="-1" aria-disabled="true" disabled="disabled"><?= $_SESSION['user_data']['name']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT_PATH ?>users/logout" tabindex="-1"
                       aria-disabled="true">Wyloguj</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT_PATH ?>users/register" tabindex="-1" aria-disabled="true">Utwórz
                        konto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= ROOT_PATH ?>users/login" tabindex="-1"
                       aria-disabled="true">Zaloguj</a>
                </li>
            <?php endif; ?>
        </ul>
        </form>
    </div>
</nav>
</header>
<?php Messages::display() ?>

<div class="row m-5"></div>
