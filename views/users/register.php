<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Zarejestruj się</h3>
    </div>
    <div class="panel-body">
        <form method="POST" post="<?= $_SERVER[PHP_SELF] ?>">
            <div class="form-group">
                <label>Nazwa</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="mail" class="form-control"></input>
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Zarejestruj">
        </form>
    </div>
</div>