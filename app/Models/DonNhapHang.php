<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonNhapHang extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'DNH_MaDon', 'DNH_Ngay', 'DNH_TongTien', 'DNH_SoLuong', 'DNH_GiaNhap', 'SP_ID', 'NCC_ID'
    ];
    protected $primaryKey = 'DNH_ID';
 	protected $table = 'donnhaphang';

    public function SanPham(){
        return $this->belongsTo('App\Models\SanPham', 'SP_ID');
    }
	public function NhaCungCap(){
        return $this->belongsTo('App\Models\NhaCungCap', 'NCC_ID');
    }
    public function NhanVien(){
        return $this->hasMany('App\Models\NhanVien');
    }


}