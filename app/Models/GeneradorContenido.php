<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class GeneradorContenido extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'generador_contenidos';
    protected $primaryKey = 'IdUsuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nombre',
        'Apellido',
        'Celular',
        'CorreoElectronico',
        'FechaNacimiento',
        'Descripcion',
        'Sexo',
        'password',
        'ResidenciaDepartamento',
        'Nombre_perfil',
    ];
    public $timestamps = true;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the email for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'CorreoElectronico';
    }
}

