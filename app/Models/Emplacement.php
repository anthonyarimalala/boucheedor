<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
{
    use HasFactory;
    protected $table = 'emplacements';
    protected $fillable = [
        'emplacement',
    ];




    public function listColor($previousEmplacement, $currentEmplacement, $currentColor, $couleur1, $couleur2){
        if ($previousEmplacement != $currentEmplacement){
            if ($currentColor == $couleur2) return $couleur1;
            else if ($currentColor == $couleur1) return $couleur2;
        }
        return $currentColor;
    }



}
