<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'KH_Ten', 'KH_GioiTinh', 'KH_Email', 'KH_Hinh', 'KH_SDT', 'KH_DiaChi', 'KH_TrangThai'
    ];
    protected $primaryKey = 'KH_ID';
 	protected $table = 'khachhang';


    public function sanpham_yeuthich(){
        return $this->hasMany('App\Models\SanPhamYeuThich', 'KH_ID');
        
    }
    public function dondathang(){
        return $this->hasMany('App\Models\DonDatHang');
    }
    public function sanpham()
    {
        return $this->belongsTo('App\Models\SanPham','SP_ID');
    }
}