<?php
require_once __DIR__ . '/../DAO/config/Baseurl.php';
require_once __DIR__ . '/../Controllers/UserController.php';
require_once __DIR__ . '/../Controllers/RoleController.php';
require_once __DIR__ . '/../Controllers/TicketController.php';
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
    color: var(--text-seondary);
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
}
.infoCompteur{
width: 90%;
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

.toggle-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text);
    font-size: 1.6rem;
    padding: 0.5rem;
    transition: color 0.3s ease;
}

.toggle-btn:hover {
    color: var(--actionYellow);
}

</style>
<nav class="navbar">

    <div class="nav-actions">

        <p class="user-info appliName">BERNITICKETS</p>

        <div class="themeToggle">
    <button id="themeToggleBtn" class="toggle-btn">
        <i class="fa-solid fa-moon"></i>
    </button>
</div>


        <div class="userProfil">
            <i class="fa-solid fa-person"></i>
            <div class="infoUser">
                <span class="user-info">
                    <?= htmlspecialchars($user->getFname()) ?>
                    <?= htmlspecialchars($user->getLname()) ?>
                </span>
                <span class="user-role"><?= htmlspecialchars($roleName) ?></span>
            </div>
        </div>

        <div class="compteurIntervention">
            <p class="infoCompteur">
                <?= $done ?> tickets clôturés / 15 pour devenir TeamLeader
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
