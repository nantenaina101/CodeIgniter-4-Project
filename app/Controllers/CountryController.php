<?php

namespace App\Controllers;
use App\Models\Country;
use App\Controllers\BaseController;

class CountryController extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Pays';
    	return view('dashboard/countries', $data);
    }

    public function addCountry()
    {
    	$country = new Country;
    	$validation = \Config\Services::validation();
    	$this->validate([
    		'country_name'=>[
    			'rules'=>'required|is_unique[countries.country_name]',
    			'errors'=>[
    				'required'=>'Le pays est obligatoire',
    				'is_unique'=>'Ce pays est déjà enregistré'
    			]
    		],
    		'capital_city'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'Le capital est obligatoire']
    		]
    	]);

    	if ($validation->run() == false) {
    		$errors = $validation->getErrors();
    		echo json_encode([
    			'code'=>0,
    			'error'=>$errors
    		]);
    	}else{
    		$data = [
    			'country_name'=>$this->request->getPost('country_name'),
    			'capital_city'=>$this->request->getPost('capital_city')
    		];
    		$result = $country->save($data);
    		if ($result) {
    			echo json_encode([
    			'code'=>1,
    			'message'=>'Pays et Capital enregistrés'
    		]);
    		} else {
    			echo json_encode([
    			'code'=>0,
    			'message'=>'Il y a une erreur'
    		]);
    		}
    		
    	}
    }

    public function listCountry()
    {
    	$countries = new Country;
    	$pays = $countries->findAll();
    	$result = '';
    	foreach ($pays as $row) {
    		$result .= '<tr>
	            			<td>'.$row['id'].'</td>
	            			<td>'.$row['country_name'].'</td>
	            			<td>'.$row['capital_city'].'</td>
	            			<td>
	            				<button type="button" class="btn btn-success editCountry">
	            					<i class="fas fa-user-edit"></i>
	            				</button>
	            				<button type="button" data-id="'.$row['id'].'" data-country="'.$row['country_name'].'" class="btn btn-danger deleteCountry">
	            					<i class="fas fa-trash"></i>
	            				</button>
	            			</td>
	            		</tr>';
    	}
    	echo $result;
    }

    public function updateCountry()
    {
    	$country = new Country;
        $countryId = $this->request->getPost('countryId');
        $validation = \Config\Services::validation();
        $this->validate([
            'country_name'=>[
                'rules'=>'required|is_unique[countries.country_name]',
                'errors'=>[
                    'required'=>'Le pays est obligatoire',
                    'is_unique'=>'Ce pays est déjà enregistré'
                ]
            ],
            'capital_city'=>[
                'rules'=>'required',
                'errors'=>['required'=>'Le capital est obligatoire']
            ]
        ]);

        if ($validation->run() == false) {
            $errors = $validation->getErrors();
            echo json_encode([
                'code'=>0,
                'error'=>$errors
            ]);
        }else{
            $data = [
                'country_name'=>$this->request->getPost('country_name'),
                'capital_city'=>$this->request->getPost('capital_city')
            ];
            $result = $country->update($countryId, $data);
            if ($result) {
                echo json_encode([
                'code'=>1,
                'title'=>'Pays et Capital modifiés',
                'icon'=>'success',
                'button'=>'OK'
            ]);
            } else {
                echo json_encode([
                'code'=>0,
                'message'=>'Il y a une erreur'
            ]);
            }
            
        }
    }

    public function deleteCountry($id=null)
    {
        $country = new Country;
        $result = $country->delete($id);
        if ($result) {
            echo json_encode([
                'code'=>1,
                'title'=>'Pays et Capital supprimé',
                'icon'=>'success',
                'button'=>'OK'
            ]);
        } else {
            echo json_encode([
                'code'=>0,
                'message'=>'Il y a une erreur'
            ]);
        }
        
    }
}
