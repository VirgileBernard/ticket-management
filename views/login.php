<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
        session_start();
    ?>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .login-page {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background: white;
            width: 350px;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-form h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .login-form p {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 13px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        .input-group input:focus {
            border-color: #3498db;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #34495e;
        }

        .error {
            color: #c0392b;
            background: #fdecea;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 14px;
            text-align: left;
        }
    </style>

    <title>Connexion</title>
</head>

<body class="login-page">

<div class="login-container">

    <!-- ✅ IMPORTANT : action vers le fichier process (pas vers UserController.php) -->
    <form action="../process/processLogin.php" method="POST" class="login-form">
        <h1>Connexion</h1>
        <p>Accédez à votre espace de l'app</p>
        

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

</body>
</html>
