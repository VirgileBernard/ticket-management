<style>
    /* Style du Footer */
.main-footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    width: 100%;
    margin-top: 10vh;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap; /* Pour le mobile */
    padding: 0 20px;
}

.footer-section {
    flex: 1;
    margin-bottom: 20px;
    min-width: 250px;
}

.footer-section h3, .footer-section h4 {
    color: #3498db;
    margin-bottom: 15px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-section ul li a:hover {
    color: white;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    margin-top: 20px;
    border-top: 1px solid #34495e;
    font-size: 0.8em;
    color: #95a5a6;
}
</style>

<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h3>Support IT</h3>
            <p>Gestion simplifiée des tickets, du matériel et des équipes.</p>
        </div>
        
        <div class="footer-section links">
            <h4>Accès rapide</h4>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="tickets.php">Tickets</a></li>
                <li><a href="team.php">Équipe</a></li>
            </ul>
        </div>

        <div class="footer-section contact">
            <h4>Contact</h4>
            <p><i class="fas fa-envelope"></i> support@votreentreprise.com</p>
            <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
        </div>
    </div>
    
    <div class="footer-bottom">
        &copy; <?= date('Y'); ?> Application de Gestion | Tous droits réservés.
    </div>
</footer>