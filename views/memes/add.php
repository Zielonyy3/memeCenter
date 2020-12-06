<?php if(isset($_SESSION['is_logged_in'])): ?>
    <label for="image"><h2 class="mb-0 pb-0">Dodaj mema</h2></label>
    <form method="POST" action="<?=ROOT_PATH?>/memes/add" enctype='multipart/form-data'>
    <div class="form-group">
        <label for="name">Nazwa mema</label>
        <input type="text" class="form-control" name="title">
        <small id="emailHelp" class="form-text text-muted">Nie używaj mylących nazw!</small>
    </div>
    <div class="custom-file form-group mb-4">
        <input type="file" class="custom-file-input" name="image">
        <label class="custom-file-label" for="customFile">Wybierz plik...</label>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Dodaj">
    </form>
<?php else: ?>
<h2>Musisz być zalogowany aby mieć dostęp do tego miejsca!</h2>
<a href="<?=ROOT_PATH?>users/login"  class="btn btn-danger mt-4 mx">Zaloguj się</a>
<?php endif; ?>