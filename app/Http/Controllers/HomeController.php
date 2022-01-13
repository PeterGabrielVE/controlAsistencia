<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Asistencia;
use App\Usuario_Edificio;


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
        if(Auth::user()->hasRole('fiscal')){
            return redirect('report');
        }else{
            $asistencia = Asistencia::where('id_user',Auth::user()->id)->latest('id')->first();
            return view('pages.dashboard1',compact('asistencia'));
        }
    
    }

}

