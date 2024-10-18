<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class VendorBank extends Model
{
    protected $table;

    public $timestamps = false;

    public function __construct(){
        $this->table = "vendor_bank";
    }

   
}
