<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xuhuong extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'XH_Ten', 'XH_TrangThai', 'XH_Nam'
    ];
    protected $primaryKey = 'XH_ID';
 	protected $table = 'xuhuong';


    public function SanPham()
    {
        return $this->hasMany('App\Models\SanPham');
    }
    
}