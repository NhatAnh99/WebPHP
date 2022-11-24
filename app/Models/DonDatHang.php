<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonDatHang extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'DDH_NgayDat', 'DDH_TongTien', 'DDH_TinhTrangGiao', 'DDH_TinhTrangThanhToan', 'DDH_PhiVanChuyen', 'DDH_TrangThai', 'GH_ID','KH_ID','DDH_MaDon'
    ];
    protected $primaryKey = 'DDH_ID';
 	protected $table = 'dondathang';

    public function thongtingiaohang()
    {
        return $this->belongsTo('App\Models\ThongTinGiaoHang','GH_ID');
    }

    public function khachhang()
    {
        return $this->belongsTo('App\Models\KhachHang','KH_ID');
    }
    public function chitietdondathang()
    {
        return $this->belongsTo('App\Models\ChiTietDonDatHang','CTDDH_ID');
    }
    public function sanpham()
    {
        return $this->belongsTo('App\Models\SanPham','SP_ID');
    }
}