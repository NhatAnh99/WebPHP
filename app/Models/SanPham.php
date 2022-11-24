<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SanPham extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'SP_Ten', 'SP_Gia', 'SP_SoLuong', 'SP_Size','SP_Hinh', 'SP_MoTa', 'SP_MauSac', 'SP_TrangThai','PC_ID', 'XH_ID', 'LSP_ID'
    ];
    protected $primaryKey = 'SP_ID';
 	protected $table = 'sanpham';

 	public function PhongCach()
    {
        return $this->belongsTo('App\Models\PhongCach', 'PC_ID');
    }
    public function XuHuong()
    {
        return $this->belongsTo('App\Models\XuHuong','XH_ID');
    }
    public function LoaiSanPham()
    {
        return $this->belongsTo('App\Models\LoaiSanPham', 'LSP_ID');
    }
    public function DonNhapHang()
    {
        return $this->hasMany('App\Models\DonNhapHang');
    }
    public function chitietdondathang()
    {
        return $this->belongsTo('App\Models\ChiTietDonDatHang','CTDDH_ID');
    }
    
}