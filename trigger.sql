CREATE TABLE thongbao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    noi_dung TEXT,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE thuoc ADD COLUMN trang_thai ENUM('Chưa hết hạn', 'Sắp hết hạn', 'Hết hạn') DEFAULT 'Chưa hết hạn';
SET GLOBAL event_scheduler = ON;

DELIMITER //

CREATE TRIGGER before_insert_medicine
BEFORE INSERT ON thuoc
FOR EACH ROW
BEGIN
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN
        SET NEW.trang_thai = 'Sắp hết hạn';
    ELSE
        SET NEW.trang_thai = 'Chưa hết hạn';
    END IF;
END;
//

CREATE TRIGGER before_update_medicine
BEFORE UPDATE ON thuoc
FOR EACH ROW
BEGIN
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN
        SET NEW.trang_thai = 'Sắp hết hạn';
    ELSE
        SET NEW.trang_thai = 'Chưa hết hạn';
    END IF;
END;
//

DELIMITER ;

DELIMITER //

CREATE EVENT check_expired_medicines
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
BEGIN
	SET SQL_SAFE_UPDATES = 0;
    -- Cập nhật trạng thái thuốc hết hạn
    UPDATE thuoc
    SET trang_thai = 'Hết hạn'
    WHERE hansudung <= CURDATE();

    -- Thêm thông báo vào bảng thongbao
    INSERT INTO thongbao (noi_dung)
    SELECT CONCAT('Thuốc ', tenthuoc, ' đã hết hạn vào ngày ', hansudung)
    FROM thuoc
    WHERE hansudung <= CURDATE();
    SET SQL_SAFE_UPDATES = 1;
END;
//

DELIMITER ;



