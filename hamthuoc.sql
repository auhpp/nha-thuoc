-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 12, 2025 lúc 09:27 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nha_thuoc`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineQuantity` ()   BEGIN
    SELECT SUM(soluongton) AS total_quantity FROM thuoc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineTypes` ()   BEGIN
    SELECT COUNT(DISTINCT maloai) AS total_types FROM thuoc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalMedicineValue` ()   BEGIN
    SELECT SUM(dongia * soluongton) AS total_value FROM thuoc;
END$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_total_value` (`mathuoc_param` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE total_value DECIMAL(10,2);

    -- Chỉ lấy một giá trị duy nhất
    SELECT soluongton * dongia 
    INTO total_value 
    FROM thuoc 
    WHERE mathuoc = mathuoc_param
    LIMIT 1;

    RETURN total_value;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `machitiethd` int(11) NOT NULL,
  `mahoadon` int(11) DEFAULT NULL,
  `mathuoc` int(11) DEFAULT NULL,
  `soluongban` int(11) NOT NULL,
  `giaban` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hangsanxuat`
--

CREATE TABLE `hangsanxuat` (
  `mahangsx` int(11) NOT NULL,
  `tenhang` varchar(255) NOT NULL,
  `quocgia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hangsanxuat`
--

INSERT INTO `hangsanxuat` (`mahangsx`, `tenhang`, `quocgia`) VALUES
(1, 'Công ty Dược Hậu Giang', 'Việt Nam'),
(2, 'Công ty Pymepharco', 'Việt Nam'),
(3, 'Công ty Sanofi', 'Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `mahoadon` int(11) NOT NULL,
  `makhachhang` int(11) DEFAULT NULL,
  `ngaylap` date NOT NULL,
  `tongtien` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `makhachhang` int(11) NOT NULL,
  `tenkhachhang` varchar(255) NOT NULL,
  `sodienthoai` varchar(15) DEFAULT NULL,
  `diachi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaithuoc`
--

CREATE TABLE `loaithuoc` (
  `maloai` int(11) NOT NULL,
  `tenloai` varchar(255) NOT NULL,
  `donvitinh` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaithuoc`
--

INSERT INTO `loaithuoc` (`maloai`, `tenloai`, `donvitinh`) VALUES
(1, 'Thuốc giảm đau', 'Viên'),
(2, 'Thuốc kháng sinh', 'Viên'),
(3, 'Thuốc kháng viêm', 'Viên'),
(4, 'Thuốc tiêu hóa', 'Viên'),
(5, 'Thuốc chống dị ứng', 'Viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `manhacungcap` int(11) NOT NULL,
  `tennhacungcap` varchar(255) NOT NULL,
  `sodienthoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`manhacungcap`, `tennhacungcap`, `sodienthoai`) VALUES
(1, 'Công ty Dược Hậu Giang', '0123456789'),
(2, 'Công ty Pymepharco', '0123456780'),
(3, 'Công ty Sanofi', '0123456781');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `mataikhoan` int(11) NOT NULL,
  `makhachhang` int(11) DEFAULT NULL,
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `loaitaikhoan` enum('admin','nhanvien','khachhang') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL,
  `noi_dung` text DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbao`
--

INSERT INTO `thongbao` (`id`, `noi_dung`, `ngay_tao`) VALUES
(1, 'Thuốc Paracetamol đã hết hạn vào ngày 2006-05-01', '2025-03-12 08:23:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuoc`
--

CREATE TABLE `thuoc` (
  `mathuoc` int(11) NOT NULL,
  `maloai` int(11) DEFAULT NULL,
  `mahangsx` int(11) DEFAULT NULL,
  `manhacungcap` int(11) DEFAULT NULL,
  `tenthuoc` varchar(255) NOT NULL,
  `congdung` text DEFAULT NULL,
  `dongia` decimal(10,2) NOT NULL,
  `soluongton` int(11) NOT NULL,
  `hansudung` date NOT NULL,
  `trang_thai` enum('Chưa hết hạn','Sắp hết hạn','Hết hạn') DEFAULT 'Chưa hết hạn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuoc`
--

INSERT INTO `thuoc` (`mathuoc`, `maloai`, `mahangsx`, `manhacungcap`, `tenthuoc`, `congdung`, `dongia`, `soluongton`, `hansudung`, `trang_thai`) VALUES
(1, 1, 2, 1, 'Paracetamol', 'Giảm đau, hạ sốt', 5000.00, 110, '2026-12-31', 'Chưa hết hạn'),
(2, 1, 2, 2, 'Efferalgan', 'Hạ sốt, giảm đau', 6000.00, 1203, '2027-05-15', 'Chưa hết hạn'),
(3, 2, 1, 1, 'Amoxicillin', 'Kháng sinh phổ rộng', 7000.00, 80, '2026-09-20', 'Chưa hết hạn'),
(4, 2, 2, 3, 'Azithromycin', 'Kháng khuẩn mạnh', 9000.00, 60, '2027-03-12', 'Chưa hết hạn'),
(5, 2, 3, 1, 'Ibuprofen', 'Kháng viêm, giảm đau', 8000.00, 75, '2027-02-28', 'Chưa hết hạn'),
(6, 3, 1, 2, 'Diclofenac', 'Giảm viêm, đau khớp', 7500.00, 85, '2026-09-15', 'Chưa hết hạn'),
(7, 1, 2, 1, 'Omeprazole', 'Giảm acid dạ dày', 8500.00, 50, '2027-06-10', 'Chưa hết hạn'),
(8, 1, 3, 3, 'Domperidone', 'Hỗ trợ tiêu hóa', 9500.00, 60, '2026-12-05', 'Chưa hết hạn'),
(9, 5, 1, 2, 'Loratadine', 'Giảm dị ứng, mẩn ngứa', 7200.00, 90, '2027-08-01', 'Chưa hết hạn'),
(10, 5, 2, 3, 'Cetirizine', 'Chống dị ứng mạnh', 8200.00, 270, '2026-10-25', 'Chưa hết hạn'),
(13, 5, 1, 2, 'Paracetamol', 'Giảm đau, hạ sốt', 14000.00, 320, '2006-05-01', 'Sắp hết hạn');

--
-- Bẫy `thuoc`
--
DELIMITER $$
CREATE TRIGGER `before_insert_medicine` BEFORE INSERT ON `thuoc` FOR EACH ROW BEGIN
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN
        SET NEW.trang_thai = 'Sắp hết hạn';
    ELSE
        SET NEW.trang_thai = 'Chưa hết hạn';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_medicine` BEFORE UPDATE ON `thuoc` FOR EACH ROW BEGIN
    IF NEW.hansudung <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN
        SET NEW.trang_thai = 'Sắp hết hạn';
    ELSE
        SET NEW.trang_thai = 'Chưa hết hạn';
    END IF;
END
$$
DELIMITER ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`machitiethd`),
  ADD KEY `mahoadon` (`mahoadon`),
  ADD KEY `mathuoc` (`mathuoc`);

--
-- Chỉ mục cho bảng `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  ADD PRIMARY KEY (`mahangsx`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`mahoadon`),
  ADD KEY `makhachhang` (`makhachhang`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`makhachhang`);

--
-- Chỉ mục cho bảng `loaithuoc`
--
ALTER TABLE `loaithuoc`
  ADD PRIMARY KEY (`maloai`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`manhacungcap`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`mataikhoan`),
  ADD UNIQUE KEY `tendangnhap` (`tendangnhap`),
  ADD KEY `makhachhang` (`makhachhang`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  ADD PRIMARY KEY (`mathuoc`),
  ADD KEY `maloai` (`maloai`),
  ADD KEY `mahangsx` (`mahangsx`),
  ADD KEY `manhacungcap` (`manhacungcap`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `machitiethd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  MODIFY `mahangsx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `mahoadon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `makhachhang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loaithuoc`
--
ALTER TABLE `loaithuoc`
  MODIFY `maloai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `manhacungcap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `mataikhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  MODIFY `mathuoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`mahoadon`) REFERENCES `hoadon` (`mahoadon`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`mathuoc`) REFERENCES `thuoc` (`mathuoc`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`makhachhang`) REFERENCES `khachhang` (`makhachhang`);

--
-- Các ràng buộc cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`makhachhang`) REFERENCES `khachhang` (`makhachhang`);

--
-- Các ràng buộc cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  ADD CONSTRAINT `thuoc_ibfk_1` FOREIGN KEY (`maloai`) REFERENCES `loaithuoc` (`maloai`),
  ADD CONSTRAINT `thuoc_ibfk_2` FOREIGN KEY (`mahangsx`) REFERENCES `hangsanxuat` (`mahangsx`),
  ADD CONSTRAINT `thuoc_ibfk_3` FOREIGN KEY (`manhacungcap`) REFERENCES `nhacungcap` (`manhacungcap`);

DELIMITER $$
--
-- Sự kiện
--
CREATE DEFINER=`root`@`localhost` EVENT `check_expired_medicines` ON SCHEDULE EVERY 1 DAY STARTS '2025-03-12 15:23:29' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
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
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
