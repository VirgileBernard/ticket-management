<?php session_start(); ?>

<style>
.navbar {
    background-color: #2c3e50;
    display: flex;
    justify-content: space-between;
    padding: 0 50px;
    height: 60px;
    align-items: center;
}

.nav-links a {
    color: white;
    text-decoration: none;
    margin-right: 20px;
    font-size: 16px;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.user-info {
    color: #ecf0f1;
    font-size: 14px;
    font-weight: bold;
}

.logout-btn {
    background-color: #e74c3c;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

<nav class="navbar">
    <div class="nav-links">
        <a href="index.php">Accueil</a>
        <a href="tickets.php">Tickets</a>
        <a href="clients.php">Clients</a>
        <a href="materiel.php">Matériel</a>
        <a href="team.php">Team</a>
    </div>

    <?php if (!empty($_SESSION["logged_in"])): ?>
        <div class="nav-actions">
            <span class="user-info">
                <?= htmlspecialchars($_SESSION["user_fname"]) ?>
                <?= htmlspecialchars($_SESSION["user_lname"]) ?>
                | Rôle : <?= htmlspecialchars($_SESSION["user_role"]) ?>
            </span>

            <a href="../process/processLogout.php" class="logout-btn">
                Déconnexion
            </a>
        </div>
    <?php endif; ?>
</nav>
