<?php

namespace App\Http\Controllers;

use App\Enums\Models\TaskStatusEnum;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allTasks    = [];
        $activeTasks = [];
        $closeTasks  = [];

        if (auth()->check()) {
            $allTasks    = auth()->user()->tasks()->orderBy('id', 'desc')->get();
            $activeTasks = auth()->user()->tasks()->where('status', '!=', TaskStatusEnum::completed)->orderBy('id', 'desc')->get();
            $closeTasks  = auth()->user()->tasks()->where('status', TaskStatusEnum::completed)->orderBy('id', 'desc')->get();
        }

        return view('home', compact('allTasks', 'activeTasks', 'closeTasks'));
    }
}
