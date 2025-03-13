CREATE TABLE thongbao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    noi_dung TEXT,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE thongbao
ADD COLUMN mathuoc INT,
ADD CONSTRAINT fk_mathuoc FOREIGN KEY (mathuoc) REFERENCES thuoc(mathuoc) ON DELETE CASCADE;
ALTER TABLE thuoc ADD COLUMN trang_thai ENUM('Chưa hết hạn', 'Sắp hết hạn', 'Hết hạn') DEFAULT 'Chưa hết hạn';
SET GLOBAL event_scheduler = ON;

DELIMITER //

CREATE TRIGGER before_insert_medicine
BEFORE INSERT ON thuoc
FOR EACH ROW
BEGIN
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN
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
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN
        SET NEW.trang_thai = 'Sắp hết hạn';
    ELSE
        SET NEW.trang_thai = 'Chưa hết hạn';
    END IF;
END;
//

DELIMITER ;

DELIMITER //

CREATE EVENT check_expired_medicines
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
DO
BEGIN
	-- Cập nhật trạng thái khi thuóc sắp hết hạn
    UPDATE thuoc
    set trang_thai = 'Sắp hết hạn'
    where hansudung > curdate() and hansudung < date_add(curdate() , INTERVAL 30 DAY)
			and trang_thai not in ('Hết hạn', 'Sắp hết hạn');
            
    -- Thêm thông báo vào bảng thông báo khi thuôc 
    insert into thongbao(mathuoc, noi_dung)
    select mathuoc, concat('Thuốc ', tenthuoc, ' sắp hết hạn, ngày hết hạn là ', hansudung)
    from thuoc
    where hansudung > curdate() and hansudung < date_add(curdate() , INTERVAL 30 DAY);
            
    -- Cập nhật trạng thái thuốc hết hạn
    UPDATE thuoc
    SET trang_thai = 'Hết hạn'
    WHERE hansudung <= CURDATE();

    -- Thêm thông báo vào bảng thongbao khi thuoc het han
    INSERT INTO thongbao (mathuoc, noi_dung)
    SELECT mathuoc,  CONCAT('Thuốc ', tenthuoc, ' đã hết hạn vào ngày ', hansudung)
    FROM thuoc
    WHERE hansudung <= CURDATE();
END;
//

DELIMITER ;





