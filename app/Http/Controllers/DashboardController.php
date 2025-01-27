<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function render(Request $request)
    {
        $page = $request->get('page', null);
        if (is_null($page))
        {
            return redirect()->route('dashboard', ['page' => session('lastpage', 1)]);
        }
        $page = max(1, $page);
        $max = 25;
        $list = TaskController::getTasksFrom(Auth::user());
        if ((count($list) > ($max * $page)))
        {
            $nextPage = $page + 1;
        } else {
            $nextPage = null;
        }
        $list = array_slice($list, $page > 1 ? (($page - 1) * $max) : 0, $max);
        $oldPage = $page > 1 ? ($page - 1) : null;
        if (count($list) == 0 && $page > 1)
        {
            return redirect()->route('dashboard', ['page' => 1]);
        }
        session([
            'lastpage' => $page
        ]);
        return view('dashboard', [
            'list' => $list,
            'page' => $page,
            'oldPage' => $oldPage,
            'nextPage' => $nextPage,
            'i' => ($page == 1) ? 1 : ((($page - 1) * $max) + 1)
        ]);
    }
    
    public function initialPage()
    {
        return self::tryRedirectToDashboard('main');
    }

    public static function tryRedirectToDashboard(string $viewName) {
        if (Auth::check())
        {
            return redirect()->route('dashboard');
        } else {
            return view($viewName);
        }
    }

}
