-- Tổng số lượng thuốc
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineQuantity`()
BEGIN
    SELECT SUM(soluongton) AS total_quantity FROM thuoc;
END$$
DELIMITER ;

-- Tổng loại thuốc
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineTypes`()
BEGIN
    SELECT COUNT(DISTINCT maloai) AS total_types FROM thuoc;
END$$
DELIMITER ;

-- Tổng tiền thuốc các loại
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineValue`()
BEGIN
    SELECT SUM(dongia * soluongton) AS total_value FROM thuoc;
END$$
DELIMITER ;

DELIMITER //
	CREATE PROCEDURE GetMedicinesByCategory(IN ten_loai_thuoc VARCHAR(255))
    BEGIN
		SELECT thuoc.mathuoc, thuoc.tenthuoc, thuoc.congdung, thuoc.dongia, thuoc.soluongton, thuoc.hansudung
        FROM thuoc
        join loaithuoc on thuoc.maloai = loaithuoc.maloai
        where loaithuoc.tenloai = ten_loai_thuoc COLLATE utf8mb4_general_ci
        ORDER BY thuoc.hansudung ASC;
    END //
DELIMITER ;


DELIMITER //
	CREATE PROCEDURE GetMedicinesByHSX(IN ten_hsx VARCHAR(255))
    BEGIN 
		SELECT thuoc.mathuoc, thuoc.tenthuoc, thuoc.congdung, thuoc.dongia, thuoc.soluongton, thuoc.hansudung
        FROM thuoc
        JOIN hangsanxuat on thuoc.mahangsx = hangsanxuat.mahangsx
        WHERE hangsanxuat.tenhang = ten_hsx COLLATE utf8mb4_general_ci
        ORDER BY thuoc.hansudung ASC;
	END //
DELIMITER ;


DELIMITER //
	CREATE PROCEDURE GetMedicinesByNCC(IN ten_ncc VARCHAR(255))
    BEGIN
		SELECT thuoc.mathuoc, thuoc.tenthuoc, thuoc.congdung, thuoc.dongia, thuoc.soluongton, thuoc.hansudung
        FROM thuoc
        JOIN nhacungcap on thuoc.manhacungcap = nhacungcap.manhacungcap
        WHERE nhacungcap.tennhacungcap = ten_ncc COLLATE utf8mb4_general_ci
        ORDER BY thuoc.hansudung ASC;
	END //
DELIMITER ; 

