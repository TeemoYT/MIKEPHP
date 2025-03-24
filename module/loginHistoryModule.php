<?php
class LoginHistoryModule extends Module {
    public function __construct() {
        parent::__construct('login_history');
    }

    public function addLoginHistory($userId, $ipAddress) {
        try {
            $query = "INSERT INTO login_history (user_id, ip_address) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$userId, $ipAddress]);
        } catch (Exception $e) {
            error_log("Error adding login history: " . $e->getMessage());
            return false;
        }
    }

    public function getLoginHistory($userId, $limit = 10) {
        try {
            $query = "SELECT login_time, ip_address 
                     FROM login_history 
                     WHERE user_id = ? 
                     ORDER BY login_time DESC 
                     LIMIT ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userId, $limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting login history: " . $e->getMessage());
            return [];
        }
    }

    public function getLastLogin($userId) {
        try {
            $query = "SELECT login_time, ip_address 
                     FROM login_history 
                     WHERE user_id = ? 
                     ORDER BY login_time DESC 
                     LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting last login: " . $e->getMessage());
            return null;
        }
    }
} 