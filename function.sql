-- Tổng doanh thu theo ngay, tuan, thang
DELIMITER $$
drop function if exists tong_doanh_thu;
create function tong_doanh_thu(dateInput date, startDate date, endDate date, monthInput int, yearInput int)
returns decimal(38,0)
DETERMINISTIC
begin 
	declare total decimal(38, 0) default 0;
    if dateInput is not null then
		select sum(tongTien) into total from hoadon where ngayLap = dateInput;
    elseif startDate is not null and endDate is not null then
		select sum(tongTien) into total from hoadon where ngaylap BETWEEN startDate AND endDate;
	elseif monthInput is not null and yearInput is not null then
		select sum(tongTien) into total from hoadon where MONTH(ngayLap) = monthInput  AND YEAR(ngayLap) = yearInput;
	end if;
	return coalesce(total, 0);
end;
DELIMITER;

-- Tính tổng tiền 1 thuốc
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `get_total_value`(mathuoc_param INT) RETURNS decimal(10,2)
    DETERMINISTIC
BEGIN
    DECLARE total_value DECIMAL(10,2);

    SELECT soluongton * dongia 
    INTO total_value 
    FROM thuoc 
    WHERE mathuoc = mathuoc_param
    LIMIT 1;

    RETURN total_value;
END$$
DELIMITER ;