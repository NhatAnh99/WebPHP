-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2021 lúc 01:11 CH
-- Phiên bản máy phục vụ: 5.7.14
-- Phiên bản PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thoitrang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `BL_ID` int(10) NOT NULL,
  `BL_NoiDung` text NOT NULL,
  `BL_PhanHoi` text NOT NULL,
  `CTDDH_ID` int(10) NOT NULL,
  `KH_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdondathang`
--

CREATE TABLE `chitietdondathang` (
  `CTDDH_ID` int(10) NOT NULL,
  `CTDDH_SoLuong` int(11) NOT NULL,
  `CTDDH_DonGia` decimal(10,0) NOT NULL,
  `SP_ID` int(10) NOT NULL,
  `DDH_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietkhuyenmai`
--

CREATE TABLE `chitietkhuyenmai` (
  `CTKM_ID` int(10) NOT NULL,
  `CTKM_NgayBD` datetime NOT NULL,
  `CTKM_NgayKT` datetime NOT NULL,
  `SP_ID` int(10) NOT NULL,
  `KM_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondathang`
--

CREATE TABLE `dondathang` (
  `DDH_ID` int(10) NOT NULL,
  `DDH_MaDon` varchar(30) NOT NULL,
  `DDH_NgayDat` datetime NOT NULL,
  `DDH_TongTien` decimal(10,0) NOT NULL,
  `DDH_TinhTrangGiao` int(11) NOT NULL,
  `DDH_TinhTrangThanhToan` int(11) NOT NULL,
  `DDH_PhiVanChuyen` int(11) NOT NULL,
  `DDH_TrangThai` int(11) NOT NULL,
  `GH_ID` int(10) NOT NULL,
  `CTDDH_ID` int(10) NOT NULL,
  `KH_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donnhaphang`
--

CREATE TABLE `donnhaphang` (
  `DNH_ID` int(10) NOT NULL,
  `DNH_MaDon` varchar(255) NOT NULL,
  `DNH_Ngay` datetime NOT NULL,
  `DNH_TongTien` decimal(10,0) NOT NULL,
  `DNH_SoLuong` int(11) NOT NULL,
  `DNH_GiaNhap` decimal(10,0) NOT NULL,
  `SP_ID` int(10) NOT NULL,
  `NCC_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `HD_ID` int(10) NOT NULL,
  `HD_NgayXuat` datetime NOT NULL,
  `HD_VAT` int(11) NOT NULL,
  `HD_TongTienTT` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `KH_ID` int(10) NOT NULL,
  `KH_Ten` varchar(255) NOT NULL,
  `KH_GioiTinh` int(11) NOT NULL,
  `KH_Email` varchar(100) NOT NULL,
  `KH_Hinh` varchar(255) NOT NULL,
  `KH_SDT` int(25) NOT NULL,
  `KH_DiaChi` varchar(255) NOT NULL,
  `KH_TrangThai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `KM_ID` int(10) NOT NULL,
  `KM_TieuDe` varchar(255) NOT NULL,
  `KM_NoiDung` text NOT NULL,
  `KM_GiaTri` decimal(10,0) NOT NULL,
  `KM_Ngay` datetime NOT NULL,
  `KM_Gia` decimal(10,0) NOT NULL,
  `KM_SoNgay` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `LSP_ID` int(10) NOT NULL,
  `LSP_Ten` varchar(255) NOT NULL,
  `LSP_MoTa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`LSP_ID`, `LSP_Ten`, `LSP_MoTa`) VALUES
(1, 'áo bà ba', 'áo bà ba'),
(2, 'quần', 'quần'),
(3, 'áo thun', 'áo thun'),
(4, 'd', 'd'),
(5, 'aaa', 'aaa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `NCC_ID` int(10) NOT NULL,
  `NCC_Ten` varchar(255) NOT NULL,
  `NCC_SDT` int(25) NOT NULL,
  `NCC_Email` varchar(100) NOT NULL,
  `NCC_Hinh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`NCC_ID`, `NCC_Ten`, `NCC_SDT`, `NCC_Email`, `NCC_Hinh`) VALUES
(1, 'ggg', 1234567890, 'abc@gmail.com', 'img733.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `NV_ID` int(10) NOT NULL,
  `NV_Ten` varchar(255) NOT NULL,
  `NV_GioiTinh` int(11) NOT NULL,
  `NV_Email` varchar(100) NOT NULL,
  `NV_SDT` int(25) NOT NULL,
  `NV_DiaChi` varchar(255) NOT NULL,
  `NV_MatKhau` varchar(255) NOT NULL,
  `NV_TaiKhoan` varchar(255) NOT NULL,
  `create_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongcach`
--

CREATE TABLE `phongcach` (
  `PC_ID` int(10) NOT NULL,
  `PC_Ten` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phongcach`
--

INSERT INTO `phongcach` (`PC_ID`, `PC_Ten`) VALUES
(1, 'a'),
(2, 'b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `SP_ID` int(10) NOT NULL,
  `SP_Ten` varchar(255) NOT NULL,
  `SP_Gia` decimal(10,0) NOT NULL,
  `SP_Hinh` varchar(255) NOT NULL,
  `SP_SoLuong` int(11) NOT NULL,
  `SP_Size` varchar(100) NOT NULL,
  `SP_MoTa` text NOT NULL,
  `SP_MauSac` varchar(100) NOT NULL,
  `SP_TrangThai` int(11) NOT NULL,
  `PC_ID` int(10) NOT NULL,
  `XH_ID` int(10) NOT NULL,
  `LSP_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`SP_ID`, `SP_Ten`, `SP_Gia`, `SP_Hinh`, `SP_SoLuong`, `SP_Size`, `SP_MoTa`, `SP_MauSac`, `SP_TrangThai`, `PC_ID`, `XH_ID`, `LSP_ID`) VALUES
(18, 'a', '10000', 'img541.jpg', 11, '1', 'bbb', '1', 1, 2, 3, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtingiaohang`
--

CREATE TABLE `thongtingiaohang` (
  `GH_ID` int(10) NOT NULL,
  `GH_Ten` varchar(255) NOT NULL,
  `GH_Email` varchar(100) NOT NULL,
  `GH_SDT` int(25) NOT NULL,
  `GH_DiaChi` varchar(255) NOT NULL,
  `GH_ThanhToan` decimal(10,0) NOT NULL,
  `GH_TongTien` decimal(10,0) NOT NULL,
  `GH_TrangThai` int(11) NOT NULL,
  `HD_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuhuong`
--

CREATE TABLE `xuhuong` (
  `XH_ID` int(10) NOT NULL,
  `XH_Ten` varchar(255) NOT NULL,
  `XH_TrangThai` int(11) NOT NULL,
  `XH_Nam` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `xuhuong`
--

INSERT INTO `xuhuong` (`XH_ID`, `XH_Ten`, `XH_TrangThai`, `XH_Nam`) VALUES
(1, 'a', 1, '2021-11-14 00:00:00'),
(2, 'b', 1, '2021-11-14 00:00:00'),
(3, 'c', 1, '2021-11-14 00:00:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`BL_ID`);

--
-- Chỉ mục cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD PRIMARY KEY (`CTDDH_ID`);

--
-- Chỉ mục cho bảng `chitietkhuyenmai`
--
ALTER TABLE `chitietkhuyenmai`
  ADD PRIMARY KEY (`CTKM_ID`);

--
-- Chỉ mục cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`DDH_ID`);

--
-- Chỉ mục cho bảng `donnhaphang`
--
ALTER TABLE `donnhaphang`
  ADD PRIMARY KEY (`DNH_ID`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`HD_ID`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`KH_ID`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`KM_ID`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`LSP_ID`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`NCC_ID`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`NV_ID`);

--
-- Chỉ mục cho bảng `phongcach`
--
ALTER TABLE `phongcach`
  ADD PRIMARY KEY (`PC_ID`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`SP_ID`);

--
-- Chỉ mục cho bảng `thongtingiaohang`
--
ALTER TABLE `thongtingiaohang`
  ADD PRIMARY KEY (`GH_ID`);

--
-- Chỉ mục cho bảng `xuhuong`
--
ALTER TABLE `xuhuong`
  ADD PRIMARY KEY (`XH_ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `BL_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `chitietkhuyenmai`
--
ALTER TABLE `chitietkhuyenmai`
  MODIFY `CTKM_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `DDH_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `donnhaphang`
--
ALTER TABLE `donnhaphang`
  MODIFY `DNH_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `HD_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `KH_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  MODIFY `KM_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `LSP_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `NCC_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `NV_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `phongcach`
--
ALTER TABLE `phongcach`
  MODIFY `PC_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `SP_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT cho bảng `thongtingiaohang`
--
ALTER TABLE `thongtingiaohang`
  MODIFY `GH_ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `xuhuong`
--
ALTER TABLE `xuhuong`
  MODIFY `XH_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
