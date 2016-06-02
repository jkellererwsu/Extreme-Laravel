<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;

class TagsController extends Controller
{
    public function show(Tag $tag)
    {
        $contacts = $tag->contacts;

        return view('contacts.index', compact('contacts'));
    }
}
