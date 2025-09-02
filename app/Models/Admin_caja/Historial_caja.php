<?php

namespace App\Models\Admin_caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin_caja\Caja;

class Historial_caja extends Model
{
    use HasFactory;
    protected $table = 'rl_historial_caja';
    protected $fillable=[
        'fecha',
        'hora',
        'concepto',
        'documento_privado',
        'saldo',
        'caja_id',
        'usuario_id',
    ];
    public $timestamps = false;
    //relacion reversa de caja
    public function caja(){
        return $this->belongsTo(Caja::class, 'caja_id', 'id');
    }
}
