<?php

namespace MVC\App\Http\Controllers\Auth;

use MVC\App\Models\Users;
use MVC\Framework\Controller;
use MVC\Framework\Helpers\FlashMessages;
use MVC\Framework\Request;

class AuthController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setLayout('auth');
  }
  public function loginForm()
  {
    return $this->view('auth/login');
  }

  public function login(Request $request)
  {
    $users = new Users();
    $users->loadData($request->getBody());
    $model = $users;
    return $this->view('auth/login', compact('model'));
  }

  public function registerForm()
  {
    return $this->view('auth/register');
  }

  public function register(Request $request)
  {
    $users = new Users();
    if ($request->isPost()) {
      $this->validation(
        $request,
        [
          'firstname' => ['required'],
          'lastname' => ['required'],
          'email' => ['required', 'email', ['unique', 'class' => Users::class]],
          'password' => ['required', ['min', 'min' => 2], ['max', 'max' => 12]],
          'confirmPassword' => ['required', ['match', 'match' => 'password']],
        ]
      );

      if ($this->isValidate()) {
        $users->firstname = $request->input('firstname');
        $users->lastname = $request->lastname;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->save();
        (new FlashMessages)->setFlash('success', 'User created successfully');
        return $request->redirect('auth-login');
      }
      $request->redirect('auth-register');
    }
  }
}