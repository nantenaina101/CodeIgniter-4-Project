<?php

namespace App\Controllers;
use App\Models\User;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
    	$user = new User;
    	$loggedUser = session()->get('loggedUser');
    	$userInfo = $user->find($loggedUser);
    	$data = ['title'=>'Dashboard', 'status'=>'Connecté', 'userInfo'=>$userInfo];
        return view('home', $data);
    }
}
