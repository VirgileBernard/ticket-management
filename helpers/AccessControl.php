<?php

require_once __DIR__ . '/../DAO/config/Baseurl.php';

/**
 * Helper class to manage role-based access control
 * 
 * Roles:
 * 1 = Technicien
 * 2 = Team Leader
 * 3 = Superviseur
 */

class AccessControl {

    // Define role IDs as constants
    const ROLE_TECHNICIAN = 1;
    const ROLE_TEAM_LEADER = 2;
    const ROLE_SUPERVISOR = 3;

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Get current user role ID from session
     */
    public static function getUserRoleId() {
        return isset($_SESSION['role_id']) ? intval($_SESSION['role_id']) : null;
    }

    /**
     * Check if current user is a supervisor
     */
    public static function isSupervisor() {
        return self::getUserRoleId() === self::ROLE_SUPERVISOR;
    }

    /**
     * Check if current user is a team leader
     */
    public static function isTeamLeader() {
        return self::getUserRoleId() === self::ROLE_TEAM_LEADER;
    }

    /**
     * Check if current user is a technician
     */
    public static function isTechnician() {
        return self::getUserRoleId() === self::ROLE_TECHNICIAN;
    }

    /**
     * Check if user can create/delete users, clients, devices, tickets
     */
    public static function canCreateDelete() {
        return self::isSupervisor();
    }

    /**
     * Check if user can modify clients, devices, or users
     */
    public static function canModifyMasters() {
        return self::isSupervisor();
    }

    /**
     * Check if user can modify a ticket (only intervention detail)
     */
    public static function canModifyTicket() {
        return self::isSupervisor() || self::isTeamLeader() || self::isTechnician();
    }

    /**
     * Redirect and exit if unauthorized
     */
    public static function requireRole($requiredRole) {
        if (self::getUserRoleId() !== $requiredRole) {
            $_SESSION['flash_message_error'] = 'Accès refusé. Vous n\'avez pas les permissions nécessaires.';
            header('Location: ' . BASE_URL . 'views/index.php');
            exit;
        }
    }

    /**
     * Redirect and exit if not supervisor
     */
    public static function requireSupervisor() {
        if (!self::isSupervisor()) {
            $_SESSION['flash_message_error'] = 'Accès refusé. Seul un superviseur peut effectuer cette action.';
            header('Location: ' . BASE_URL . 'views/index.php');
            exit;
        }
    }

    /**
     * Redirect and exit if cannot create/delete
     */
    public static function requireCreateDeleteAccess() {
        if (!self::canCreateDelete()) {
            $_SESSION['flash_message_error'] = 'Accès refusé. Vous n\'avez pas les permissions pour créer ou supprimer.';
            header('Location: ' . BASE_URL . 'views/index.php');
            exit;
        }
    }

    /**
     * Redirect and exit if cannot modify ticket
     */
    public static function requireTicketModifyAccess() {
        if (!self::canModifyTicket()) {
            $_SESSION['flash_message_error'] = 'Accès refusé. Vous n\'avez pas les permissions pour modifier ce ticket.';
            header('Location: ' . BASE_URL . 'views/index.php');
            exit;
        }
    }
}
?>
