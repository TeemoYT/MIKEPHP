<?php
require_once __DIR__ . '/module.php';

class OrderModule extends Module
{

    public function __construct()
    {
        parent::__construct('order');
    }

    public function getOrderListItem()
    {

        $sql = "
            SELECT 
                o.id AS 'id', 
                u.name AS 'name', 
                u.phone AS 'phone',
                (SELECT SUM(oi.quantity) FROM order_items oi WHERE oi.order_id = o.id) AS 'sumProduct',
                a.address AS 'address', 
                o.created_at AS 'created_at', 
                p.payment_method AS 'payment_method', 
                os.status_name AS 'status' 
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN addresses a ON o.address_id = a.id
            JOIN payments p ON o.id = p.order_id
            JOIN order_status os ON o.status_id = os.id
            GROUP BY o.id, u.name, u.phone, a.address, o.created_at, p.payment_method, o.status_id;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOrderDetails($order_id)
    {
        $sql = "
            SELECT 
                oi.id AS id, 
                oi.order_id AS order_id,
                p.name AS product_name,
                oi.size AS size,
                oi.quantity AS quantity,
                oi.price AS price,
                p.image_url AS image_url,
                (oi.quantity * oi.price) AS item_total,
                (SELECT SUM(oi2.quantity * oi2.price) 
                FROM order_items oi2 
                WHERE oi2.order_id = oi.order_id) AS sumprice
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = $order_id;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
