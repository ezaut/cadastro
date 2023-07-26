<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Candidato extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'candidato';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'cpf',
        'sexo',
        'nome_mae',
        'dt_nascimento',
        'escolaridade',
        'vinculo',
        'endereco',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'rg',
        'org_exp',
        'dt_emissao',
        'telefone'
    ];

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
        'password' => 'hashed',
    ];
}
