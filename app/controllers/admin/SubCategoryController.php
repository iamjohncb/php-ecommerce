<?php
namespace App\controllers\admin;

use App\classes\CSRFToken;
use App\classes\Redirect;
use App\classes\Request;
use App\classes\Session;
use App\classes\ValidateRequest;
use App\controllers\BaseController;
use App\models\Category;
use App\models\SubCategory;

class SubCategoryController extends BaseController
{
    public function store()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            $extra_errors = [];

            if(CSRFToken::verifyCSRFToken($request->token, false)){
                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'mixed' => true],
                    'category_id' => ['required' => true]
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                $duplicate_subcategory = SubCategory::where('name', $request->name)
                    ->where('category_id', $request->category_id)->exists();

                if($duplicate_subcategory){
                    $extra_errors['name'] = array('Subcategory already exist.');
                }

                $category = Category::where('id', $request->category_id)->exists();
                if(!$category){
                    $extra_errors['name'] = array('Invalid product category.');
                }

                if($validate->hasError() || $duplicate_subcategory || !$category){
                    $errors = $validate->getErrorMessages();
                    count($extra_errors) ? $response = array_merge($errors, $extra_errors) : $response = $errors;
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($response);
                    exit;
                }
                //process form data
                SubCategory::create([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'slug' => slug($request->name)
                ]);
                echo json_encode(['success' => 'Subcategory create successfully']);
                exit;
            }
            throw new \Exception('Token mismatch');
        }

        return null;
    }

    public function edit($id)
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCSRFToken($request->token, false)){
                $rules = [
                    'name' => ['required' => true, 'minLength' => 3, 'string' => true, 'unique' => 'categories']
                ];
                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);
                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit;
                }

                Category::where('id', $id)->update(['name' => $request->name]);
                echo json_encode(['success' => 'Record Update Successfully']);
                exit;
            }
            throw new \Exception('Token mismatch');
        }

        return null;
    }

    public function delete($id)
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCSRFToken($request->token)){
                Category::destroy($id);
                Session::add('success', 'Category Deleted');
                Redirect::to('/admin/product/categories');
            }
            throw new \Exception('Token mismatch');
        }

        return null;
    }
}