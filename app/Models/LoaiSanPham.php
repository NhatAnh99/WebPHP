<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'LSP_Ten', 'LSP_MoTa'
    ];
    protected $primaryKey = 'LSP_ID';
 	protected $table = 'loaisanpham';

    public function sanpham(){
        return $this->hasMany('App\Models\SanPham');
    }
    
}