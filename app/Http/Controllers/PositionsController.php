<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Position;

class PositionsController extends Controller
{
    public function show(Position $position)
    {
        //dd($position);
        $contacts = $position->contacts;

        return view('contacts.index', compact('contacts'));
    }
}
