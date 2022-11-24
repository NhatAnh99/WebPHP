<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'KM_TieuDe', 'KM_NoiDung', 'KM_GiaTri','KM_PhuongThuc', 'KM_Ngay', 'KM_SoNgay'
    ];
    protected $primaryKey = 'KM_ID';
 	protected $table = 'khuyenmai';


    
}