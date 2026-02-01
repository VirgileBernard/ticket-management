<?php

require_once __DIR__ . '/../../Controllers/UserController.php';
require_once __DIR__ . '/../../Controllers/RoleController.php';

session_start();

// Vérifier que l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun user sélectionné.");
}

$user_id = intval($_GET['id']);
$user = UserController::openUser($user_id);

// 2. Récupérer son rôle
$roles = RoleController::getRoles();
$role = RoleController::getRoleById($user->getRoleId());
$roleName = $role ? $role->getName() : "Inconnu";


if(!$user) {
    die("Ce user n'existe pas.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membre <?= htmlspecialchars($user->getLname()) ?></title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .userPass{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: 150px;
        }

    </style>
</head>
<body>
<div class="main">

    <?php include __DIR__ . '/../navbar.php'; ?>
        <div class="container">

    <div class="ticketInfo">

    <!-- <?php var_dump($roles) ?> -->

        <div class="topTicket">
            <div class="leftTopTicket">
                <p>Informations du membre</p>

                <!-- <?php var_dump($user); ?> -->
            </div>
            <div class="rightTopTicket">
                <div class="userId">
               <p>     ID: #<?= htmlspecialchars($user->getIdUser()) ?></p>
                </div>
            </div>
        </div>

        <!-- MODE LECTURE -->
        <div id="userView">

            <div class="midTicket">
                <div class="leftMidTicket">
                    <div class="userInformations">
                        <p class="txt-secondary">Nom</p>
                        <p><?= htmlspecialchars($user->getLname()) ?></p>
                    </div>

                    <div class="userEmail">
                        <p class="txt-secondary">Email</p>
                        <p><?= htmlspecialchars($user->getEmail()) ?></p>
                    </div>

                    <div class="userRole">
                        <p class="txt-secondary">Rôle</p>
                        <p><?= htmlspecialchars($roleName) ?></p>
                    </div>

                    <div class="userPhone">
                        <p class="txt-secondary">Telephone</p>
                        <p><?= htmlspecialchars($user->getPhoneNumber()) ?></p>
                    </div>
                </div>

                <div class="rightMidTicket">
                    <div class="userPrenom">
                        <p class="txt-secondary">Prénom</p>
                        <p><?= htmlspecialchars($user->getFname()) ?></p>
                    </div>

                    <div class="userPass">
                        <p class="txt-secondary">Mot de passe</p>
                        <p class="userPass"><?= htmlspecialchars($user->getPassword()) ?></p>
                    </div>

                    <div class="userTeam">
                        <p class="txt-secondary">Équipe</p>
                        <p>equipe a compléter</p>
                    </div>
                </div>
            </div>

                  <div class="bottomTicket">
            <button id="editBtn" class="btn-primary">Modifier</button>

                 <form action="../../process/deleteUser.php" method="POST">
    <input type="hidden" name="id_user" value="<?= $user->getIdUser() ?>">
    <button
        type="submit"
        id="dangerBtn"
        onclick="return confirm('Supprimer définitivement cet utilisateur ?');"
    >Supprimer
    </button>
</form>
            
        </div>

        </div>
        
  

        <!-- MODE ÉDITION (caché au départ) -->
        <form id="editForm" action="../../process/updateUser.php" method="POST" style="display:none;">

            <input type="hidden" name="id_user" value="<?= $user->getIdUser() ?>">

            <div class="midTicket">
                <div class="leftMidTicket">

                    <div class="userInformations">
                        <p class="txt-secondary">Nom</p>
                        <input type="text" name="lname" value="<?= htmlspecialchars($user->getLname()) ?>">
                    </div>

                    <div class="userEmail">
                        <p class="txt-secondary">Email</p>
                        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">
                    </div>
                       <div class="userPhone">
                    <p class="txt-secondary">Téléphone</p>
                    <input type="text" name="phone_number" value="<?= htmlspecialchars($user->getPhoneNumber()) ?>">
                </div>

                    <div class="userRole">
                        <p class="txt-secondary">Rôle</p>
                        <select name="role_id">
                            <?php
                            foreach ($roles as $role): ?>
                            <option value="<?= $role->getId(); ?>">
                                <?= $role->getName(); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="rightMidTicket">

                    <div class="userPrenom">
                        <p class="txt-secondary">Prénom</p>
                        <input type="text" name="fname" value="<?= htmlspecialchars($user->getFname()) ?>">
                    </div>

                    <div class="userPass">
                        <p class="txt-secondary">Mot de passe</p>
                        <input type="text" name="password" value="<?= htmlspecialchars($user->getPassword()) ?>">
                    </div>

                    <div class="userTeam">
                        <p class="txt-secondary">Équipe</p>
                        <p>equipe a compléter</p>
                    </div>

                </div>
            </div>

            <div class="bottomTicket">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <button type="button" id="cancelBtn" class="btn-secondary">Annuler</button>
            </div>

        </form>

    </div>

</div>

<script>
const editBtn = document.getElementById('editBtn');
const editForm = document.getElementById('editForm');
const userView = document.getElementById('userView');
const cancelBtn = document.getElementById('cancelBtn');

if (editBtn) {
    editBtn.addEventListener('click', () => {
        userView.style.display = 'none';
        editForm.style.display = 'block';
    });
}

if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
        editForm.style.display = 'none';
        userView.style.display = 'block';
    });
}
</script>

</body>
</html>
