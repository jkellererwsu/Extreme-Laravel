<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\Http\Requests;

class ApiGroupsController extends Controller
{
    public function index(){

        return Group::latest('name')->get();
    }
}
