-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 07, 2025 lúc 08:11 AM
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
-- Dữ liệu chi tiết hóa đơn
INSERT INTO `chitiethoadon` (`machitiethd`, `mahoadon`, `mathuoc`, `soluongban`, `giaban`) VALUES
(1, 1, 1, 2, 75000),
(2, 1, 2, 1, 100000),
(3, 2, 3, 3, 60000),
(4, 2, 4, 2, 50000),
(5, 3, 5, 5, 70000),
(6, 3, 6, 3, 90000),
(7, 4, 7, 1, 120000),
(8, 4, 8, 4, 80000),
(9, 5, 9, 2, 40000),
(10, 5, 10, 1, 110000),
(11, 6, 1, 3, 120000),
(12, 6, 2, 5, 60000),
(13, 7, 3, 4, 70000),
(14, 7, 4, 2, 150000),
(15, 8, 5, 1, 130000),
(16, 8, 6, 3, 100000),
(17, 9, 7, 2, 90000),
(18, 9, 8, 4, 80000),
(19, 10, 9, 5, 110000),
(20, 10, 10, 1, 70000),
(21, 11, 1, 1, 150000),
(22, 11, 2, 2, 100000),
(23, 12, 3, 1, 60000),
(24, 12, 4, 3, 50000),
(25, 13, 5, 2, 70000),
(26, 13, 6, 4, 90000),
(27, 14, 7, 1, 120000),
(28, 14, 8, 2, 80000),
(29, 15, 9, 5, 40000),
(30, 15, 10, 1, 110000),
(31, 16, 1, 3, 120000),  
(32, 16, 2, 4, 100000), 
(33, 17, 3, 2, 60000),   
(34, 17, 4, 5, 50000),   
(35, 18, 5, 4, 70000),   
(36, 18, 6, 2, 75000),   
(37, 19, 7, 3, 90000),   
(38, 19, 8, 2, 150000),  
(39, 20, 9, 1, 40000),   
(40, 20, 10, 5, 70000);  

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
-- Dữ liệu bảng hóa đơn
INSERT INTO `hoadon` (`mahoadon`, `makhachhang`, `ngaylap`, `tongtien`) VALUES
(1, 1, '2025-01-05', 150000.00),
(2, 2, '2025-01-06', 200000.00),
(3, 3, '2025-01-10', 350000.00),
(4, 4, '2025-01-12', 400000.00),
(5, 5, '2025-01-14', 250000.00),
(6, 6, '2025-01-20', 500000.00),
(7, 7, '2025-02-01', 550000.00),
(8, 8, '2025-02-02', 450000.00),
(9, 9, '2025-02-05', 120000.00),
(10, 10, '2025-02-07', 300000.00),
(11, 1, '2025-02-10', 600000.00),
(12, 2, '2025-02-12', 750000.00),
(13, 3, '2025-02-15', 850000.00),
(14, 4, '2025-02-17', 420000.00),
(15, 5, '2025-02-20', 200000.00),
(16, 6, '2025-02-23', 950000.00),
(17, 7, '2025-03-01', 800000.00),
(18, 8, '2025-03-03', 450000.00),
(19, 9, '2025-03-05', 320000.00),
(20, 10, '2025-03-07', 400000.00);

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
-- Dữ liệu bảng khách hàng
INSERT INTO `khachhang` (`makhachhang`, `tenkhachhang`, `sodienthoai`, `diachi`) VALUES
(1, 'Nguyễn Văn A', '0901234567', '123 Đường ABC, Quận 1, TP.HCM'),
(2, 'Trần Thị B', '0912345678', '456 Đường DEF, Quận 2, TP.HCM'),
(3, 'Lê Minh C', '0923456789', '789 Đường GHI, Quận 3, TP.HCM'),
(4, 'Phạm Thị D', '0934567890', '101 Đường JKL, Quận 4, TP.HCM'),
(5, 'Nguyễn Thị E', '0945678901', '202 Đường MNO, Quận 5, TP.HCM'),
(6, 'Hoàng Văn F', '0956789012', '303 Đường PQR, Quận 6, TP.HCM'),
(7, 'Lê Thị G', '0967890123', '404 Đường STU, Quận 7, TP.HCM'),
(8, 'Trần Minh H', '0978901234', '505 Đường VWX, Quận 8, TP.HCM'),
(9, 'Phan Thị I', '0989012345', '606 Đường YZA, Quận 9, TP.HCM'),
(10, 'Nguyễn Văn J', '0990123456', '707 Đường BCD, Quận 10, TP.HCM');

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
  `hansudung` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuoc`
--

INSERT INTO `thuoc` (`mathuoc`, `maloai`, `mahangsx`, `manhacungcap`, `tenthuoc`, `congdung`, `dongia`, `soluongton`, `hansudung`) VALUES
(1, 1, 1, 1, 'Paracetamol', 'Giảm đau, hạ sốt', 5000.00, 100, '2026-12-31'),
(2, 1, 2, 2, 'Efferalgan', 'Hạ sốt, giảm đau', 6000.00, 120, '2027-05-15'),
(3, 2, 1, 1, 'Amoxicillin', 'Kháng sinh phổ rộng', 7000.00, 80, '2026-09-20'),
(4, 2, 2, 3, 'Azithromycin', 'Kháng khuẩn mạnh', 9000.00, 60, '2027-03-12'),
(5, 3, 3, 1, 'Ibuprofen', 'Kháng viêm, giảm đau', 8000.00, 75, '2027-02-28'),
(6, 3, 1, 2, 'Diclofenac', 'Giảm viêm, đau khớp', 7500.00, 85, '2026-09-15'),
(7, 4, 2, 1, 'Omeprazole', 'Giảm acid dạ dày', 8500.00, 50, '2027-06-10'),
(8, 4, 3, 3, 'Domperidone', 'Hỗ trợ tiêu hóa', 9500.00, 60, '2026-12-05'),
(9, 5, 1, 2, 'Loratadine', 'Giảm dị ứng, mẩn ngứa', 7200.00, 90, '2027-08-01'),
(10, 5, 2, 3, 'Cetirizine', 'Chống dị ứng mạnh', 8200.00, 70, '2026-10-25');

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
-- AUTO_INCREMENT cho bảng `thuoc`
--
ALTER TABLE `thuoc`
  MODIFY `mathuoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
