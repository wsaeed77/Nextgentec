<?php namespace App\Model;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole {
    //name "admin", "owner", "employee".
    //display_name "User Administrator", "Project Owner", "Widget Co. Employee".
    //discription 
    
    protected $fillable =   ['name','display_name','description'];

   
    
}