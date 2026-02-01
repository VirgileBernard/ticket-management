<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <?php
        session_start();
    ?>

<style>

/* Centrage de la page */
.login-page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--bg-dark);
}

/* Carte du formulaire */
.login-form {
    background: var(--bg);
    width: 350px;
    padding: 40px;
    border-radius: var(--borderRadius);
    box-shadow: var(--shadow);
    text-align: center;
    border: 1px solid var(--border);
}

/* Titre */
.login-form h1 {
    color: var(--text);
    margin-bottom: 10px;
    font-size: 24px;
}

/* Sous-texte */
.login-form p {
    color: var(--text-secondary);
    margin-bottom: 30px;
    font-size: 14px;
}

/* Groupes d’inputs */
.input-group {
    text-align: left;
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--text-secondary);
    font-size: 13px;
}

/* Inputs */
.input-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: var(--borderRadius);
    background-color: var(--bg-light);
    color: var(--text);
    box-sizing: border-box;
    transition: border-color .2s ease, box-shadow .2s ease;
}

/* Focus moderne */
.input-group input:focus {
    border-color: var(--actionBrown);
    outline: none;
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--actionBrown) 40%, transparent);
}

/* Bouton */
.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: var(--actionBrown);
    color: var(--text-contrast);
    border: none;
    border-radius: var(--borderRadius);
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: background-color .2s ease, transform .1s ease;
}

/* Hover */
.btn-submit:hover {
    background-color: color-mix(in srgb, var(--actionBrown) 80%, black);
}

/* Petit effet de clic */
.btn-submit:active {
    transform: scale(0.98);
}

/* Message d’erreur */
.error {
    color: var(--redDelete);
    background: color-mix(in srgb, var(--redDelete) 10%, transparent);
    padding: 10px;
    border-radius: var(--borderRadius);
    margin-top: 15px;
    font-size: 14px;
    text-align: left;
    border: 1px solid var(--redDelete);
}

</style>

    <title>BERNITICKETS</title>
</head>

<body class="login-page">

<div class="login-container">

    <!-- ✅ IMPORTANT : action vers le fichier process (pas vers UserController.php) -->
    <form action="../process/processLogin.php" method="POST" class="login-form">
        <h1>BERNITICKETS</h1>
        <p>Connectez vous pour accéder à votre app</p>
        

        <div class="input-group">
            <label>Email de l'utilisateur</label>
            <input
                type="email"
                name="email"
                placeholder="Entrez votre email"
                
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            >
        </div>

        <div class="input-group">
            <label>Mot de passe</label>
            <input
                type="password"
                name="password"
                placeholder="••••••••"
                
            >
        </div>


        <input type="submit" value="Se connecter" class="btn-submit">

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

    </form>

</div>

    <script>
const root = document.documentElement;

// 1. Vérifier si un thème est stocké
const savedTheme = localStorage.getItem("theme");

if (savedTheme) {
    root.setAttribute("data-theme", savedTheme);
} else {
    // 2. Sinon, utiliser la préférence système
    const prefersLight = window.matchMedia("(prefers-color-scheme: light)").matches;
    root.setAttribute("data-theme", prefersLight ? "light" : "dark");
}

</script>

</body>
</html>
