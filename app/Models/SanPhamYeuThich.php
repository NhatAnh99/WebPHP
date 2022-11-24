<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamYeuThich extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'KH_ID',
    	'SP_ID',
    ];
 	protected $table = 'sanphamyeuthich';
 	public $incrementing = false;
 	protected $primaryKey = 'id';
}
