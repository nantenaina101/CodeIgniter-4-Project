<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EmailController extends BaseController
{
	public function __construct()
	{
		helper(['url','form']);
	}

    public function index()
    {
        $data['pageTitle'] = 'Contact';
    	return view('dashboard/contact', $data);
    }

    public function send()
    {
    	/*$validation = $this->validate([
    		'name'=>'required',
    		'fname'=>'required',
    		'email'=>'required|valid_email|is_unique[users.email]',
    		'sujet'=>'required|min_length[8]|max_length[50]',
    		'message'=>'required|min_length[200]|max_length[2000]|matches[password]',
    	]);*/

    	$validation = $this->validate([
    		'name'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'Le nom est obligatoire']
    		],
    		'fname'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'Le prénoms est obligatoire']
    		],
    		'email'=>[
    			'rules'=>'required|valid_email',
    			'errors'=>[
    				'required'=>'L\'email est obligatoire',
    				'valid_email'=>'Veuillez saisir une adresse email valide',
    			]
    		],
    		'sujet'=>[
    			'rules'=>'required|min_length[8]|max_length[50]',
    			'errors'=>[
    				'required'=>'Le sujet est obligatoire',
    				'min_length'=>'Le sujet doit contenir au moins 8 caractères',
    				'max_length'=>'Le sujet est trop long (au plus 50 caractères)'
    			]
    		],
    		'message'=>[
    			'rules'=>'required|min_length[200]|max_length[2000]',
    			'errors'=>[
    				'required'=>'Le message est obligatoire',
    				'min_length'=>'Le message doit contenir au moins 200 caractères',
    				'max_length'=>'Le message est trop long (au plus 2000 caractères)'
    			]
    		]
    	]);

    	if (!$validation) {
    		return view('dashboard/contact', ['validation'=>$this->validator]);
    	}else{
    		if ($this->isOnline()) {
    			$to = 'nantenainasoa39@gmail.com';
    			$fname = $this->request->getVar('fname');
    			$lname = $this->request->getVar('name');
    			$email = $this->request->getVar('email');
    			$sujet = $this->request->getVar('sujet');
    			$message = $this->request->getVar('message');

    			$email_service = \Config\Services::email();
    			$email_service->setTo($to);
    			$email_service->setFrom($email, $fname.' '.$lname);
    			$email_service->setSubject($sujet);
    			$email_service->setMessage($message);

    			if ($email_service->send()) {
					$data['pageTitle'] = 'Contact';
					$data['success'] = 'Contact envoyé avec succès !';
					//return view('dashboard/contact', $data);
					return view('dashboard/contact', $data);
    				//return view('dashboard/contact')->with('success', 'Contact envoyé avec succès');
    			} else {
    				return redirect()->to('user/contact')->with('error', 'Echec d\'envoie')->withInput();
    			}
    			
    		} else {
    			return redirect()->to('user/contact')->with('error', 'Vérifier votre connexion internet')->withInput();
    		}
    		
    	} 
    }

    public function isOnline($site = 'https://youtube.com/'){
    	if (@fopen($site, 'r')) {
    		return true;
    	}else{
    		return false;
    	}
    }
}
