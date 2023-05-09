<?php

namespace App\Controllers;
use App\Models\Post;
use App\Controllers\BaseController;

class PostController extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Article';
        return view('posts/index', $data);
    }

    public function add_post()
    {
    	$validation = \Config\Services::validation();
    	$this->validate([
    		'title'=>[
    			'rules'=>'required',
    			'errors'=>[
    				'required'=>'Le titre est obligatoire',
    			]
    		],
    		'category'=>[
    			'rules'=>'required',
    			'errors'=>['required'=>'La catégorie doit être mentionnée']
    		],
    		'body'=>[
    			'rules'=>'required|min_length[50]',
    			'errors'=>[
    				'required'=>'Décrire votre article',
    				'min_length'=>'La description devrait composer au moins 50 caractères'
    			],
    		],
            'image'=>[
                'rules'=>'uploaded[image]|max_size[image,5028]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors'=>[
                    'uploaded'=>'L\'mage est obligatoire',
                    'max_size'=>'Image trop volumineux',
                    'is_image'=>'Choisir une image',
                    'mime_in'=>'Choisir un format jpg ou jpeg ou png',
                ],
            ],
    	]);

    	if ($validation->run() == false) {
    		$errors = $validation->getErrors();
    		echo json_encode([
    			'code'=>0,
    			'error'=>$errors
    		]);
    	}else{
            $file = $this->request->getFile('image');
            $fileName = $file->getRandomName();
            $data = [
                'title'=>$this->request->getPost('title'),
                'category'=>$this->request->getPost('category'),
                'body'=>$this->request->getPost('body'),
                'image'=>$fileName,
                'created_at'=>date('Y-m-d h:i:s')
            ];

            $uploadedFile = $file->move('images/', $fileName);

            if ($uploadedFile) {
                $post = new Post;
                $result = $post->save($data);
                if ($result) {
                    echo json_encode([
                        'code'=>1,
                        'title'=>'Article enregistré evec succès',
                        'icon'=>'success',
                        'button'=>'Fermer'
                    ]);
                }
            }
        }
    }

    public function listPost()
    {
        $post = new Post;
        $posts = $post->findAll();
        $result = '';
        foreach ($posts as $row) {
            $result .= '<div class="col-md-4 mb-4" id="colParent">
                                <input type="hidden" value="'.$row['id'].'" id="idList">
                                <div class="card-shadow-sm">
                                    <a href="#" id="imageModal">
                                        <img style="max-height:300px;min-height:300px" src="images/'.$row['image'].'" class="img-fluid card-img-top image">
                                        <input type="hidden" value="'.$row['image'].'" id="imgShow">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="card-title font-weight-bold title" value="'.$row['title'].'">
                                            '.$row['title'].'
                                        </div>
                                        <div class="badge bg-dark category" value="'.$row['category'].'">
                                            '.$row['category'].'
                                        </div>
                                    </div>
                                    <p class="text-justify body overflow-ellipsis" onclick="showOrHide(this)" 
                                    style="cursor:pointer;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;">'.$row['body'].'</p>
                                    <div class="font-italic text-justify text-sm">Créer le : 
                                        '.$row['created_at'].'
                                    </div>';

                                if ($row['updated_at'] != null) {
                                    $result .= '<div class="font-italic text-justify text-sm">Modifier le : '.$row['updated_at'].'
                                                </div>';
                                }
                                $result .= '</div><div class="card-footer">
                                    <div class="d-flex justify-content-around align-items-center">
                                        <button class="btn btn-success btn-sm editPostBtn" role="button">
                                            <i class="fas fa-user-edit"></i> Modifier
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePostBtn" role="button">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>';
        }
        echo $result;
    }

    public function update_post()
     {
         $validation = \Config\Services::validation();
        $this->validate([
            'title'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Le titre est obligatoire',
                ]
            ],
            'category'=>[
                'rules'=>'required',
                'errors'=>['required'=>'La catégorie doit être mentionnée']
            ],
            'body'=>[
                'rules'=>'required|min_length[50]',
                'errors'=>[
                    'required'=>'Décrire votre article',
                    'min_length'=>'La description devrait composer au moins 50 caractères'
                ],
            ],
        ]);

        if ($validation->run() == false) {
            $errors = $validation->getErrors();
            echo json_encode([
                'code'=>0,
                'error'=>$errors
            ]);
        }else{
            $id = $this->request->getPost('editId');
            $file = $this->request->getFile('image');
            $fileNameIn = $file->getFilename();
            
            if ($fileNameIn != '') {
                unlink('images/' . $this->request->getPost('editImage'));
                $fileName = $file->getRandomName();
                $file->move('images/', $fileName);
            } else {
                $fileName = $this->request->getPost('editImage');
            }

            $data = [
                'title'=>$this->request->getPost('title'),
                'category'=>$this->request->getPost('category'),
                'body'=>$this->request->getPost('body'),
                'image'=>$fileName,
                'updated_at'=>date('Y-m-d h:i:s')
            ];

            $post = new Post;
            $result = $post->update($id, $data);
            if ($result) {
                echo json_encode([
                    'code'=>1,
                    'title'=>'Article modifié evec succès',
                    'icon'=>'success',
                    'button'=>'Fermer'
                ]);
            }
        }
    }

    public function deletePost()
     {
         $post = new Post;
         $id = $this->request->getPost('deleteId');
         $image = $this->request->getPost('deleteImage');
         $result = $post->delete($id);
         if ($result) {
             unlink('images/' . $image);
             echo json_encode([
                    'code'=>1,
                    'title'=>'Article supprimer evec succès',
                    'icon'=>'success',
                    'button'=>'Fermer'
                ]);
         }
     } 
}
?>

