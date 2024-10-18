<?php

namespace App\Models;

use App\Merchant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reseller extends Authenticatable
{
    use Notifiable;
    protected $table = 'resellers';
    protected $fillable = [
        'username', 'first_name', 'last_name', 'mobile_no', 'email', 'password'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function update_reseller($field){
        return DB::table($this->table)->where('id',Auth::guard('reseller')->user()->id)->update($field);
    }

    public function getResellerPassword()
    {
        return $this->password;
    }

    public function merchants()
    {
        return $this->belongsTo(Merchant::class);
    }
}
