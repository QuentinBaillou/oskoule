<?php if (!empty($errorList)) : ?>
    <div class="alert alert-warning" role="alert">
        <?php foreach ($errorList as $error) : ?>
            <?= $error ?>
            <br>
        <?php endforeach ?>
    </div>
<?php endif ?>
<a href="<?= $router->generate('appuser-list') ?>" class="btn btn-success float-right">Retour</a>
<h2><?= ($editMode) ? 'Mettre à jour' : 'Ajouter'; ?> un utilisateur</h2>

<form action="" method="POST" class="mt-5">
    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="" value="<?= $appuser->getEmail() ?>">
    </div>
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= $appuser->getName() ?>">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="" value="<?= $appuser->getPassword() ?>">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Statut</label>
        <select name="status" id="status" class="form-control">
            <option value="0">-</option>
            <option value="1">actif</option>
            <option value="2">désactivé</option>
        </select>
    </div>
    <input type="hidden" name="csrf-token" value="<?= $this->token ?>">
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>