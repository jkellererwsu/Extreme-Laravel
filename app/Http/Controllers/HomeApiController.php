<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeApiController extends Controller
{
    public function index(){

        return 'Hello';
    }
}
