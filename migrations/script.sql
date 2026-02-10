-- email à utiliser :
-- admin@test.com

-- mot de passe à utiliser : 
-- admin


-- RÔLES
INSERT INTO roles (id_role, nom) VALUES
(1, 'Technicien'),
(2, 'TeamLeader'),
(3, 'Superviseur')
ON DUPLICATE KEY UPDATE nom = VALUES(nom);

-- STATUTS
INSERT INTO status (id_status, nom) VALUES
(1, 'Ouvert'),
(2, 'En cours'),
(3, 'Clôturé')
ON DUPLICATE KEY UPDATE nom = VALUES(nom);

-- PRIORITÉS
INSERT INTO priorities (id_priority, nom) VALUES
(1, 'Basse'),
(2, 'Normale'),
(3, 'Haute')
ON DUPLICATE KEY UPDATE nom = VALUES(nom);

-- TYPES D’APPAREILS
INSERT INTO types (id_type, nom) VALUES
(1, 'Smartphone'),
(2, 'Ordinateur'),
(3, 'Tablette')
ON DUPLICATE KEY UPDATE nom = VALUES(nom);

-- CLIENT DE TEST
INSERT INTO clients (id_client, fname, lname, email, phone_number) VALUES
(1, 'Jean', 'Dupont', 'jean.dupont@test.com', '0470000000')
ON DUPLICATE KEY UPDATE fname = VALUES(fname);

-- DEVICE DE TEST
INSERT INTO devices (id_device, model, serial_number, brand, type_id, client_id, submission_date, retrieve_date) VALUES
(1, 'iPhone 12', 'SN123456', 'Apple', 1, 1, NOW(), NULL)
ON DUPLICATE KEY UPDATE model = VALUES(model);

-- UTILISATEUR ADMIN (mot de passe = "admin")
INSERT INTO users (id_user, fname, lname, email, phone_number, password, role_id) VALUES
(1, 'Admin', 'System', 'admin@test.com', '0471000000',
 '$2y$10$uQwJtF2xJf9YpQeQ0uQxUe8xFq6ZQeX1o7Jq9Yp8uQxUe8xFq6ZQ', 
 3)
ON DUPLICATE KEY UPDATE email = VALUES(email);

-- TICKET DE TEST
INSERT INTO tickets (id_ticket, ticket_number, client_id, device_id, status_id, priority_id, created_by, assigned_to) VALUES
(1, 'TCK-0001', 1, 1, 1, 2, 1, 1)
ON DUPLICATE KEY UPDATE ticket_number = VALUES(ticket_number);

-- INTERVENTION DE TEST
INSERT INTO intervention (ticket_id, user_id, start_at, end_at, intervention_detail) VALUES
(1, 1, NOW(), NULL, 'Diagnostic initial')
ON DUPLICATE KEY UPDATE intervention_detail = VALUES(intervention_detail);
