<?php

namespace App\Controllers;
use App\Models\User;
use App\Libraries\Hash;
use App\Controllers\BaseController;

class AuthController extends BaseController
{

	public function __construct()
	{
		helper(['url','form']);
	}

    public function index()
    {
        return view('auth/login');
    }

    public function register()
    {
    	return view('auth/register');
    }

    public function save()
    {
    	/*$validation = $this->validate([
    		'fname'=>'required',
    		'lname'=>'required',
    		'email'=>'required|valid_email|is_unique[users.email]',
    		'password'=>'required|min_length[8]|max_length[20]',
    		'c_password'=>'required|min_length[8]|max_length[20]|matches[password]',
    	]);*/

    	$validation = $this->validate([
    		'fname'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'Le prénom est obligatoire']
    		],
    		'lname'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'Le nom est obligatoire']
    		],
    		'email'=>[
    			'rules'=>'required|valid_email|is_unique[users.email]',
    			'errors'=>[
    				'required'=>'L\'email est obligatoire',
    				'valid_email'=>'Veuillez saisir une adresse email valide',
    				'is_unique'=>'Cet email est déjà utilisé'
    			]
    		],
    		'password'=>[
    			'rules'=>'required|min_length[8]|max_length[20]',
    			'errors'=>[
    				'required'=>'Le mot de passe est obligatoire',
    				'min_length'=>'Le mot de passe doit contenir au moins 8 caractères',
    				'max_length'=>'Le mot de passe est trop long (au plus 20 caractères)'
    			]
    		],
    		'c_password'=>[
    			'rules'=>'required|matches[password]',
    			'errors'=>[
    				'required'=>'Confirmer votre mot de passe',
    				'matches'=>'Entrer un mot de passe identique au précedent'
    			]
    		]
    	]);

    	if (!$validation) {
    		return view('auth/register', ['validation'=>$this->validator]);
    	} else {
    		$fname = $this->request->getPost('fname');
    		$lname = $this->request->getPost('lname');
    		$email = $this->request->getPost('email');
    		$password = $this->request->getPost('password');

    		$data = [
    			'name'=>$fname.' '.$lname,
    			'email'=>$email,
    			'password'=>Hash::make($password)
    		];

    		$user = new User;
    		//$result = $user->save($data);
    		$result = $user->insert($data);

    		if (!$result) {
    			return redirect()->back()->with('error', 'Quelque chose ne va pas');
    		} else {
    			//return redirect()->to('inscription')->with('success', 'Vous êtes inscrit');
    			$last_id = $user->insertId();
    			session()->set('loggedUser', $last_id);
    			return redirect()->to('user/home');
    		}
    		
    	}
    	
    }

    public function login()
    {
    	$validation = $this->validate([
    		
    		'email'=>[
    			'rules'=>'required|valid_email|is_not_unique[users.email]',
    			'errors'=>[
    				'required'=>'L\'email est obligatoire',
    				'valid_email'=>'Veuillez saisir une adresse email valide',
    				'is_not_unique'=>'Cet email n\'est pas encore enregistré'
    			]
    		],
    		'password'=>[
    			'rules'=>'required|min_length[8]|max_length[20]',
    			'errors'=>[
    				'required'=>'Le mot de passe est obligatoire',
    				'min_length'=>'Le mot de passe doit contenir au moins 8 caractères',
    				'max_length'=>'Le mot de passe est trop long (au plus 20 caractères)'
    			]
    		]
    	]);

    	if (!$validation) {
    		return view('auth/login', ['validation'=>$this->validator]);
    	}else{
    		$email = $this->request->getPost('email');
    		$password = $this->request->getPost('password');
    		$user = new User;
    		$user_info = $user->where('email', $email)->first();
    		
    		$check_password = Hash::check($password, $user_info['password']);
    		if (!$check_password) {
    			session()->setFlashdata('error', 'Mot de passe incorrect');
    			return redirect()->to('/')->withInput();
    		}else{
    			$user_id = $user_info['id'];
    			session()->set('loggedUser', $user_id);
    			return redirect()->to('user/home');
    		}
    	}
    }

    public function logout()
    {
    	if (session()->has('loggedUser')) {
    		session()->remove('loggedUser');
    		return redirect()->to('/')->with('success', 'Vous êtes déconnecté');
    	}
    }
}
