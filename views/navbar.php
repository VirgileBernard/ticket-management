<?php
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../Controllers/UserController.php';
require_once __DIR__ . '/../Controllers/RoleController.php';
require_once __DIR__ . '/../Controllers/TicketController.php';
require_once __DIR__ . '/../helpers/AccessControl.php';
// 1. Récupérer l'utilisateur connecté
$userId = $_SESSION['id_user'] ?? null;
if (!$userId) {
    header("Location: " . BASE_URL . "views/login.php");
    exit;
}

$user = UserController::getUserById($userId);

// 2. Récupérer son rôle
$role = RoleController::getRoleById($user->getRoleId());
$roleName = $role ? $role->getName() : "Inconnu";

// 3. Récupérer le compteur de tickets
$done = TicketController::countDoneTicketsByUser($userId);


// pour afficher dans la nav bar la page ouverte
$currentPage = basename($_SERVER['PHP_SELF']);

$active = [
    'home'     => ['index.php'],
    'tickets'  => ['tickets.php', 'openTicket.php', 'createTicket.php'],
    'clients'  => ['clients.php', 'openClient.php', 'createClient.php'],
    'materiel' => ['materiel.php', 'openDevice.php', 'createDevice.php'],
    'team'     => ['team.php', 'openUser.php', 'createUser.php'],
];

function isActive($section, $currentPage, $active) {
    return in_array($currentPage, $active[$section]) ? 'active' : '';
}


?>



<link rel="stylesheet" href="views/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<style>
.navbar {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* haut / bas */
    width: 15%;
    height: 100%;
    background-color: var(--bg-dark);
    overflow: hidden; /* évite les débordements */
    min-width: 200px;
    z-index: 10;
}


.nav-actions {
height: 25vh;
border-bottom: 1px solid var(--border);
display: grid;
grid-template-rows: repeat(3, auto);
}

.nav-links {
    flex: 1; /* prend tout l’espace restant */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.nav-links a {
    height: 6vh;
    color: var(--text-secondary);
    display: block;
    padding: 0.7rem 1.2rem;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 500;
    border-bottom: 1px solid var(--border);
    transition : all 0.3s ease-out;
}

.nav-links a:hover {
    background-color: var(--bg-light);
     color: var(--text-secondary);
     color:var(--text-primary);
}
.nav-links a.active {
    background-color: var(--bg-light);
    color: var(--text-secondary);
         color:var(--text-primary);
}


.userProfil {
    display: flex;
    margin: 0 auto;
    color: var(--text-seondary);
    gap: 5px;
}
.fa-person{
    color: var(--text);
}
.user-info {
    color: var(--text-primary);
    font-size: 14px;
    font-weight: bold;
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
    justify-content: center;
    flex-direction: column;
    color: var(--text-secondary);
}

.compteurIntervention{
    display: flex;
     color: var(--text-secondary);
     padding: .5rem 1rem;
}
.infoCompteur{
margin: 0 auto;
font-size:.9rem
}


#logout-btn {
    color: var(--text-secondary);
    transition : all .3s ease;
}

#logout-btn:hover{
    color: var(--text-primary);
    background-color: var(--redDelete);
}

.burgerBtn{
    color: var(--text-primary);
}

.burgerBtn:hover{
    color: var(--text-secondary);
}

.themeToggle { 
    display: flex;
     justify-content: center;
      align-items: center;
     }
      .toggle-btn {
         width: 42px;
          height: 42px;
           border-radius: 50%; 
           border: 1px solid var(--border);
            background-color: var(--bg);
             display: flex;
              justify-content: center;
               align-items: center;
                cursor: pointer;
                 transition: all .3s ease;
                  color: var(--text-secondary);
                 }
                  .toggle-btn i { 
                    font-size: 1.2rem;
                 } 
                 .toggle-btn:hover { 
                    background-color: var(--bg-light); 
                     box-shadow: var(--box-shadow); 
                            color: var(--text-primary);
                    }

    #open-sidebar-button, #close-sidebar-button{
        background: none;
        border : none;
        padding: 1em;
        display: none;
    }

@media screen and (max-width: 900px){
    #open-sidebar-button{
        display: block;
        position:fixed;
        top: 0%;
        right: 0%;
    }

    #overlay{
        background-color: rgba(0, 0, 0, 0.8);
        position : fixed;
        inset: 0;
        z-index: 9; 
        display:none;
    }
    .navbar{
        position: fixed;
        top : 0;
        right : -100%;
        height: 100%;
        width: min(15em, 100%);
        z-index: 10;
        border-left : 1px solid var(--border);
        transition : all .4s ease-in-out;
    }

    .navbar.show {
        right : 0;
    }
    .navbar.show ~ #overlay{
        display: block;
    }

    .navbar ul {
        width: 100%;
        flex-direction : column;
    }

    .navbar a {
        width: 100%
        padding-left: 2.5em;
    }

    .bottomLinks{
        border-top : 1px solid var(--border);
    }
}

</style>

<nav class="navbar" id="navbar">

    <div class="nav-actions">

        <p class="user-info appliName">BERNITICKETS</p>

        <div class="userProfil">
            <i class="fa-solid fa-person"></i>
            <div class="infoUser">
                <span class="user-info">
                    <?= htmlspecialchars($user->getFname()) ?>
                    <?= htmlspecialchars($user->getLname()) ?>
                </span>
                <span class="user-role"><?= htmlspecialchars($roleName) ?></span>
            </div>

            
        <div class="themeToggle">
    <button id="themeToggleBtn" class="toggle-btn">
        <i class="fa-solid fa-moon"></i>
    </button>
</div>
        </div>

        <button id="open-sidebar-button" class="burgerBtn" onclick="openSidebar()">
    <i class="fa-solid fa-bars"></i>
</button>

        <div class="compteurIntervention">
            <p class="infoCompteur">
                <?php
                    $nextMilestone = '';
                    if (strtolower($roleName) === 'technicien') {
                        $nextMilestone = '15 pour devenir TeamLeader';
                        echo $done . ' tickets clôturés / ' . $nextMilestone;
                    } elseif (strtolower($roleName) === 'teamleader') {
                        $nextMilestone = '25 pour devenir Superviseur';
                        echo $done . ' tickets clôturés / ' . $nextMilestone;
                    }  else { echo '+ 25 interventions clôturées';}
                ?>
            </p>
        </div>

    </div>

    <div class="nav-links">
        <div class="topLinks">


<a href="<?= BASE_URL ?>views/index.php"
   class="<?= isActive('home', $currentPage, $active) ?>">
   Accueil
</a>

<a href="<?= BASE_URL ?>views/tickets.php"
   class="<?= isActive('tickets', $currentPage, $active) ?>">
   Tickets
</a>

<?php if (AccessControl::isSupervisor()): ?>
<a href="<?= BASE_URL ?>views/clients.php"
   class="<?= isActive('clients', $currentPage, $active) ?>">
   Clients
</a>

<a href="<?= BASE_URL ?>views/materiel.php"
   class="<?= isActive('materiel', $currentPage, $active) ?>">
   Matériel
</a>

<a href="<?= BASE_URL ?>views/team.php"
   class="<?= isActive('team', $currentPage, $active) ?>">
   Team
</a>
<?php endif; ?>


        </div>

        <div class="bottomLinks">
            <a href="<?= BASE_URL ?>process/processLogout.php" class="logout-btn" id="logout-btn">
                Déconnexion
            </a>
        </div>
    </div>


    <script>
const root = document.documentElement;
const btn = document.getElementById("themeToggleBtn");

const navbar = document.getElementById('navbar');




function openSidebar(){
    navbar.classList.add('show');
    document.getElementById("open-sidebar-button").style.display = "none";
}

function closeSidebar(){
    navbar.classList.remove('show');
    document.getElementById("open-sidebar-button").style.display = "block";
}


// 1. Charger le thème stocké ou détecter le thème système
const savedTheme = localStorage.getItem("theme");
if (savedTheme) {
    root.setAttribute("data-theme", savedTheme);
    updateIcon(savedTheme);
} else {
    const prefersLight = window.matchMedia("(prefers-color-scheme: light)").matches;
    const defaultTheme = prefersLight ? "light" : "dark";
    root.setAttribute("data-theme", defaultTheme);
    updateIcon(defaultTheme);
}

// 2. Toggle au clic
btn.addEventListener("click", () => {
    const current = root.getAttribute("data-theme");
    const next = current === "light" ? "dark" : "light";
    root.setAttribute("data-theme", next);
    localStorage.setItem("theme", next);
    updateIcon(next);
});

// 3. Changer l’icône selon le thème
function updateIcon(theme) {
    if (theme === "light") {
        btn.innerHTML = '<i class="fa-solid fa-moon"></i>';
    } else {
        btn.innerHTML = '<i class="fa-solid fa-sun"></i>';
    }
}
</script>

</nav>


<div id="overlay" onclick="closeSidebar()">

</div>
