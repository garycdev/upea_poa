<?php
namespace App\Models\FutMot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutMov extends Model
{
    use HasFactory;
    protected $table      = 'fut_movimiento';
    protected $primaryKey = 'id_fut_mov';
    protected $fillable   = [
        'partida_codigo',
        'partida_monto',
        'id_fut_pp',
    ];
    public $timestamps = false;

    public function movimiento()
    {
        return $this->belongsTo(FutMov::class, 'id_fut_pp', 'id_fut_pp');
    }
}
