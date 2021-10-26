<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'candidate_id', 'party_id', 'user_id', 'delete_request'];


     public function Party() {

        return $this->belongsTo(Party::class, 'party_id', 'id');
      }

     public function user() {

        return $this->belongsTo(User::class, 'user_id', 'id');
      }
    

}
