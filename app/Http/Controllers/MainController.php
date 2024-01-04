<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $data = [

        ];
        return view('index', $data);
    }

    public function tasks() {
        $data = [

        ];
        return view('tasks', $data);
    }
}
