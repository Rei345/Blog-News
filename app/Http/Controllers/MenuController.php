<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::whereNull('parent_menu')
            ->with(['submenu' => fn($q) => $q->orderBy('urutan_menu', 'asc')])
            ->orderBy('urutan_menu', 'asc')
            ->get();

        return view('backend.content.menu.list', compact('menu'));
    }
}
