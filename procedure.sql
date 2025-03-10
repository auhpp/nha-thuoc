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