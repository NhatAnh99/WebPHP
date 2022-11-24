<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XaPhuongThiTran extends Model
{
	public $timestamps = false;
    protected $fillable = [
    	'Xa_name', 'Xa_type','QH_ID'
    ];
    protected $primaryKey = 'Xa_ID';
 	protected $table = 'xaphuongthitran';

}
    