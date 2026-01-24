<?php

require_once '../Controllers/TicketController.php';

 $roles = [ 1 => 'Technicien', 2 => 'TeamLeader', 3 => 'Superviseur' ]; $roleCode = $_SESSION["user_role"]; $roleName = $roles[$roleCode] ?? 'Inconnu'; 

// var_dump($_SESSION);
$userId = $_SESSION['id_user'];
$done = TicketController::countDoneTicketsByUser($userId);
?>

<link rel="stylesheet" href="views/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<style>
.navbar {
    background-color: var(--LM-bg-dark);
    justify-content: space-between;
    align-items: center;
    width: 15%;
    border-right: 1px solid var(--LM-border);
}
.nav-actions {
height: 30%;
border-bottom: 1px solid var(--LM-border);
display: grid;
grid-template-rows: repeat(3, auto);
}

.nav-links{
    height: 70%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.nav-links a {
    height: 6vh;
    color: var(--LM-text-secondary);
    display: block;
    padding: 0.7rem 1.2rem;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 500;
    border-bottom: 1px solid var(--LM-border);
    transition : all 0.3s ease-out;
}

.nav-links a:hover {
    background-color: var(--LMbg-light);
     color: var(--LM-text-secondary);
}
.bottomLinks{
    border-top: 1px solid var(--LM-border);
}


.user-info {
    color: var(--LM-text);
    font-size: 14px;
    font-weight: bold;
}

.userProfil {
    display: flex;
}
.fa-solid{
    width: 20%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
}
.appliName{
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1rem
}

.infoUser{
    padding: .2rem .2rem;
    display: flex;
    flex-direction: column;
}
.logout-btn {
    /* background-color: #e74c3c; */
    color: var(--LM-text);
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

<nav class="navbar">



        <div class="nav-actions">

            <p class="user-info appliName">BERNITICKETS</p>
        

            <div class="userProfil">
                <i class="fa-solid fa-person"></i>
                <div class="infoUser">
            <span class="user-info">
                <?= htmlspecialchars($_SESSION["user_fname"]) ?>
                <?= htmlspecialchars($_SESSION["user_lname"]) ?>
            </span>
            <span class="user-role"><?= htmlspecialchars($roleName) ?></span>
            </div>
            </div>

            <div class="compteurIntervention">
        
           <p class="user-info">Nbr d'interventions cloturées <?= $done ?></p>
         
            </div>

      
        </div>

        <div class="nav-links">
            <div class="topLinks">
        <a href="index.php">Accueil</a>
        <a href="tickets.php">Tickets</a>
        <a href="clients.php">Clients</a>
        <a href="materiel.php">Matériel</a>
        <a href="team.php">Team</a>
        </div>
        <div class="bottomLinks">

          <a href="../process/processLogout.php" class="logout-btn">
                Déconnexion
            </a>
            </div>
    </div>

    

  


</nav>
