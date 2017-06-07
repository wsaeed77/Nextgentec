<?php 

namespace App\Model;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    //name "admin", "owner", "employee".
    //display_name "User Administrator", "Project Owner", "Widget Co. Employee".
    //discription 

    protected $fillable =   ['name','display_name','description'];
}