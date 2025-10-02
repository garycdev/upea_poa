<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Configuracion\UnidadCarreraArea;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'ci_persona',
        'nombre',
        'apellido',
        'usuario',
        'password',
        'estado',
        'celular',
        'perfil',
        'email',
        'id_unidad_carrera',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const CREATED_AT = 'creado_el';
    const UPDATED_AT = 'editado_el';

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: fn($value) => ucfirst($value),
            get: fn($value) => $value,
        );
    }

    protected function apellido(): Attribute
    {
        return new Attribute(
            set: fn($value) => ucfirst($value),
            get: fn($value) => $value,
        );
    }

    public function unidad_carrera()
    {
        return $this->hasOne(UnidadCarreraArea::class, 'id', 'id_unidad_carrera');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
    public function rol_verifica()
    {
        if (isset($this->id_unidad_carrera)) {
            if (stripos($this->unidad_carrera->nombre_completo, 'PLANIFICA') !== false) {
                $user = 'planifica';
            } elseif (stripos($this->unidad_carrera->nombre_completo, 'PRESUPUESTO') !== false) {
                $user = 'presupuesto';
            } else {
                $user = 'user';
            }
        } else {
            $user = '';
        }

        return $user;
    }
}
