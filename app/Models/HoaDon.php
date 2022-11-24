<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'HD_NgayXuat', 'HD_VAT', 'HD_TongTienTT','HD_MaDon'
    ];
    protected $primaryKey = 'HD_ID';
 	protected $table = 'hoadon';

    public function dondathang(){
        return $this->hasMany('App\Models\DonDatHang');
    }
    public function thongtingiaohang(){
        return $this->hasMany('App\Models\ThongTinGiaoHang');
    }
    
}