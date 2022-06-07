<a href="<?= $router->generate('appuser-add') ?>" class="btn btn-success float-right">Ajouter</a>

<h2>Liste des Utilisateurs</h2>
<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">Nom</th>
            <th scope="col">Role</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appusersList as $appuser) : ?>
            <tr>
                <th scope="row"><?= $appuser->getId() ?></th>
                <td><?= $appuser->getEmail() ?></td>
                <td><?= $appuser->getName() ?></td>
                <td><?= $appuser->getRole() ?></td>
                <td class="text-right">
                    <a href="<?= $router->generate('appuser-edit', ['appuserId' => $appuser->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('appuser-delete', ['appuserId' => $appuser->getId()]) . '?token=' . $this->token ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>