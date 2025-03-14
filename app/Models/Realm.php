<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Realm extends Model
{
    use HasFactory;
    protected $table = 'realms';
    protected $fillable = ['name', 'description', 'active'];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function users()
    {
        return $this->belongsToMany(UserAdmin::class, 'realm_user', 'realm_id', 'user_id');
    }
}