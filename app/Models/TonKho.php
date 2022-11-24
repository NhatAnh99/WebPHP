<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TonKho extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'TK_SoLuongDaBan', 'TK_SoLuongTonKho', 'SP_ID'
    ];
    protected $primaryKey = 'TK_ID';
 	protected $table = 'tonkho';

    
    
}