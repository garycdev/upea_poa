<?php
namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConforClasprimPartipo extends Model
{
    use HasFactory;
    protected $table      = 'confor_clasprim_partipo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'partida_tid',
        'clasificador_pid',
        'configuracion_fid',
    ];

    public $timestamps = false;
}
