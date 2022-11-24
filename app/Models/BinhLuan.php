<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'BL_NoiDung', 'BL_PhanHoi','BL_TrangThai', 'CTDDH_ID', 'KH_ID','NV_ID'
    ];
    protected $primaryKey = 'BL_ID';
 	protected $table = 'binhluan';


    public function khachhang(){
        return $this->belongsTo('App\Models\KhachHang','KH_ID');
    }
    public function chitietdondathang(){
        return $this->belongsTo('App\Models\ChiTietDonDatHang','CTDDH_ID');
    }
    public function nhanvien(){
        return $this->belongsTo('App\Models\NhanVien','NV_ID');
    }
}