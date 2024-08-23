<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'faculty',
        // Add other fields as necessary
    ];
}

class MA extends Model
{
    // Specify the table name if it's not the plural of the model name
    protected $table = 'clearance';
    
    // Set the primary key
    protected $primaryKey = 'Clearance_NO';
    
    // If the primary key is not an integer, set this
    public $incrementing = false;
    protected $keyType = 'string';

    // Disable timestamps if not needed
    public $timestamps = false;


    protected $fillable = ['MA_off_name', 'Department', 'Faculty', 'MA_picture', 'Clearance_No', 'Student_Reg_No','MA_approved'];
    // Specify the columns that are mass assignable


}
