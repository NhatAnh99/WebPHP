<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietKhuyenMai extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'CTKM_NgayBD', 'CTKM_NgayKT', 'SP_ID', 'KM_ID'
    ];
    protected $primaryKey = 'CTKM_ID';
 	protected $table = 'chitietkhuyenmai';


    
}