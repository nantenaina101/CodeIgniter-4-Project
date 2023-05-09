<?php

namespace App\Controllers;
use App\Models\User;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {	
        $user = new User;
        $loggedUser = session()->get('loggedUser');
        $userInfo = $user->find($loggedUser);
        $pageTitle = 'Home';
        $data = ['title'=>'Dashboard', 'status'=>'Connecté', 'userInfo'=>$userInfo, 'pageTitle'=>$pageTitle];
        return view('dashboard/home', $data);

    }

    public function profil()
    {
    	$user = new User;
        $loggedUser = session()->get('loggedUser');
        $userInfo = $user->find($loggedUser);
        $pageTitle = 'Profil';
        $data = ['title'=>'Dashboard', 'status'=>'Connecté', 'userInfo'=>$userInfo, 'pageTitle'=>$pageTitle];
    	return view('dashboard/profil', $data);
    }

    public function email()
    {
    	$data['pageTitle'] = 'Email';
    	return view('dashboard/email', $data);
    }
}
