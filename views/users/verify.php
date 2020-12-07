<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Na twój adres mailowy został wysłany kod weryfikacyjny.</h3>
        <p class="lead">Kliknij <a href="<?= ROOT_PATH ?>/users/verify">tutaj</a> aby wysłać nowy kod</p>
    </div>
    <div class="panel-body">
        <form method="POST" post="<?= $_SERVER[PHP_SELF] ?>">
            <div class="form-group">
                <label>Podaj kod</label>
                <input type="text" name="code" class="form-control" placeholder="Podaj kod"></input>
            </div>
            <input type="submit" class="btn btn-primary" name="submitVerifyCode" value="Dalej">
            <a href="<?= ROOT_PATH ?>" class="btn btn-warning">Potem</a>
        </form>
    </div>
</div>