    <?php
    class CustomerModule extends Module
    {
        public function __construct()
        {
            parent::__construct('users');
        }


        public function getAllCustomers()
        {
            try {
                $query = "SELECT 
                    u.id,
                    u.name as full_name,
                    u.phone,
                    u.email,
                    COUNT(DISTINCT o.id) as total_orders,
                    COALESCE(SUM(o.total), 0) as total_spent,
                    CASE 
                        WHEN COALESCE(SUM(o.total), 0) >= 10000000 THEN 'VIP'
                        WHEN COALESCE(SUM(o.total), 0) >= 5000000 THEN 'Thành viên'
                        ELSE 'Mới'
                    END as membership_level
                FROM users u
                LEFT JOIN orders o ON u.id = o.user_id
                GROUP BY u.id, u.name, u.phone, u.email
                ORDER BY total_spent DESC";

                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Error in getAllCustomers: " . $e->getMessage());
                return [];
            }
        }

        public function getCustomerDetails($customerId) {
            try {
                $query = "SELECT 
                    u.id,
                    u.name,
                    u.email,
                    u.phone AS user_phone,
                    a.full_name AS address_fullname,
                    a.phone AS address_phone,
                    a.address,
                    a.city,
                    a.country,
                    COUNT(DISTINCT o.id) AS total_orders,
                    COALESCE(SUM(o.total), 0) AS total_spent,
                    CASE 
                        WHEN COALESCE(SUM(o.total), 0) >= 10000000 THEN 'VIP'
                        WHEN COALESCE(SUM(o.total), 0) >= 5000000 THEN 'Thành viên'
                        ELSE 'Mới'
                    END AS membership_level
                FROM users u
                LEFT JOIN orders o ON u.id = o.user_id
                LEFT JOIN addresses a ON u.id = a.user_id
                WHERE u.id = :user_id
                GROUP BY 
                    u.id, u.name, u.email, u.phone,
                    a.full_name, a.phone, a.address, a.city, a.country";
                
                $stmt = $this->db->prepare($query);
                $stmt->execute(['user_id' => $customerId]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                error_log("Error in getCustomerDetails: " . $e->getMessage());
                return null;
            }
        }
        
    }
