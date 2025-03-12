<?php

namespace App\Models;
use PDO;
require_once __DIR__ . '/../../bootstrap.php';

class Notification {
    private $pdo;
    private int $id;
    public string $content;
    public string $date;

    public function __construct() {
        global $PDO;
        if (!$PDO) {
            die("Lỗi kết nối CSDL.");
        }
        $this->pdo = $PDO;
    }

    private function fillFromRow($row): Notification {
        $notification = new Notification();
        $notification->id = $row['id'] ?? -1;
        $notification->content = $row['noi_dung'] ?? '';
        $notification->date = $row['ngay_tao'] ?? '';
        return $notification;
    }

    // Lấy $number thông báo gần nhất
    public function getNotifications($number) {
        $notifications = [];
        $statement = $this->pdo->prepare(
            "SELECT * 
             FROM thongbao
             ORDER BY ngay_tao DESC
             LIMIT :so_thong_bao"
        );
        $statement->bindValue(':so_thong_bao', (int) $number, PDO::PARAM_INT);
        $statement->execute();

        while($row = $statement->fetch()) {
            $notification = $this->fillFromRow($row);
            $notifications[] = $notification;
        }

        return $notifications;
    }
}