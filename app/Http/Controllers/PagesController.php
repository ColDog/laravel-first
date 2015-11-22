<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PagesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }


    public function dashboard()
    {
        $messages = Redis::lrange('messages', 0, -1);
        $messages = $messages ? $messages : [];
        $tasks = Auth::user()->tasks()->get();
        return view('dashboard', compact('messages', 'tasks'));
    }
}
