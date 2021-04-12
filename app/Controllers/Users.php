<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DashboardModel;
use App\Models\MessageModel;
class Users extends BaseController
{
    protected $UserModel;
    protected $session;
    protected $DashboardModel;
    protected $requests;
    protected $rules;
    protected $messages;
    protected $rulesAndMessages;
    protected $MessageModel;
    public function __construct()
    {
        $this->requests = \Config\Services::request();
        $this->UserModel = new UserModel;
        $this->session = session();
        $this->DashboardModel = new DashboardModel;
        $this->MessageModel = new MessageModel;

        $this->rules =  [
            'email' => 'required|valid_email',
            'first_name' => 'required|min_length[3]|max_length[150]|alpha_space',
            'last_name' => 'required|min_length[3]|max_length[150]|alpha_space',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'description' => 'required',
            'message' => 'required',
        ];
        $this->messages = [
            'email' => [
                'required' => 'Email is required!',
                'valid_email' => 'Email is invalid!'
            ],
            'first_name' => [
                'required' => 'First name is required',
                'min_length' => 'First name must be at least 3 characters',
                'max_length' => 'First name is too long!',
                'alpha' => 'First name should be letter'
            ],
            'last_name' => [
                'required' => 'Last name is required',
                'min_length' => 'Last name must be at least 3 characters',
                'max_length' => 'Last name is too long!',
                'alpha' => 'Last name should be letter'
            ],
            'password' => [
                'required' => 'Password is required!',
                'min_length' => 'Password should at least 8 characters'
            ],
            'confirm_password' => [
                'required' => 'Confirm password is required!',
                'matches' => 'Confirm password doesn\'t match to your password'
            ],
            'description' => [
                'required' => 'Description is requried'
            ],
            'message' => [
                'required' => 'Message is requried'
            ]
        ];

        if($this->requests->getPost()) {
            $this->rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost());
        }
    }

    
    
    public function index()
    {
        $data = [
            'title' => "This is login page"
        ];
        return view('application\signinandsignout\sign_view', ['data' => $data]);
    }

    public function signin()
    {
        if ($this->session->has('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('application\signinandsignout\signin_view');
    }
    
    protected function alert($class, $head, $message)
    {
        $this->session->setFlashdata('alert', true);
        $this->session->setFlashdata('class', $class);
        $this->session->setFlashdata('head', $head);
        $this->session->setFlashdata('message', $message);
    }

    protected function getRules(array $rules, array $messages, $posts)
    {
        $setRules = [];
        $setMessages = [];
        foreach ($posts as $key => $_) {
            if (@$rules[$key]) {
                $setRules[$key] = @$rules[$key];
            }
            if (@$messages[$key]) {
                $setMessages[$key] = @$messages[$key];
            }
        }
        return ['rules' => $setRules, 'messages' => $setMessages];
    }

    protected function validatePost(array $rules, array $messages, array $post): bool
    {
        $isFormValid = $this->validate($rules, $messages);
        foreach ($this->validator->getErrors() as $name => $errors) {
            $this->session->setFlashdata('signup_error_'.$name, $errors);
        }
        foreach ($post as $name => $_) {
            $this->session->setFlashdata('signup_value_'.$name, $this->requests->getPost($name));
        }
        return $isFormValid;
    }

    public function processSignInUser()
    {
        if ($this->requests->getMethod(true) === 'POST') {
            $rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost());
            if (!$this->validatePost($rulesAndMessages['rules'], $rulesAndMessages['messages'], $this->requests->getPost())) {
                return redirect()->to('/signin');
            } else {
                $isUserGet = $this->UserModel->getUserDetails($this->requests->getPost());
                if ($isUserGet) {
                    $this->session->set('user_id', $isUserGet['user_id']);
                    $this->session->set('set_user', $isUserGet);
                    return redirect()->to('/dashboard');
                } else {
                    $this->session->setFlashdata('signup_error_email', 'Email or password does not matched!');
                    return redirect()->to('/users/signin');
                }
            }
        }
    }

    public function signout()
    {
        if ($this->requests->getMethod(true) === 'POST') {
            $this->session->destroy();
            return redirect()->to('/users/signin');
        }
    }


    public function processCreateUser()
    {
        if ($this->requests->getMethod(true) === 'POST') {
            $rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost()); // get the rules and messages
            
            $email = $this->requests->getPost('email'); 
            $emailCount = $this->UserModel->checkUserEmail($email); // check email count
            if ($emailCount > 0) { // if email is greater than 0 then throw error
                foreach ($this->requests->getPost() as $name => $_) {
                    $this->session->setFlashdata('signup_value_'.$name, $this->requests->getPost($name));
                }
                $this->session->setFlashdata('signup_error_email', 'Email already exists!');
                if(isset($_POST['create_new_user'])) {
                    return redirect()->to('/users/new');
                }
                return redirect()->to('/signup');
            } elseif (!$this->validatePost($rulesAndMessages['rules'], $rulesAndMessages['messages'], $this->requests->getPost())) { // validate posts
                if(isset($_POST['create_new_user'])) {
                    return redirect()->to('/users/new');
                }
                return redirect()->to('/signup');
            } else {
                $isUserCreated = $this->UserModel->createUser($this->requests->getPost());
                if ($isUserCreated) {
                    if(isset($_POST['create_new_user'])) {
                        $this->alert('success', 'Success!', "New user has been created");
                    } else {
                        $this->alert('success', 'Success', "Welcome to Village88");
                        $this->session->set('user_id', $isUserCreated);
                    }
                    return redirect()->to('/dashboard');
                }
            }
        }
    }

    public function signup()
    {
        if ($this->session->has('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('application\signinandsignout\signup_view');
    }


    public function new()
    {
        return view('application\user\new_view');
    }


    public function edit($id)
    {
        if (!$this->DashboardModel->checkIfUserIsAdmin($this->session->get('user_id')) and $this->session->get('set_user')['user_level'] != 9) {
            return redirect()->to('/dashboard');
        }
        $user = $this->UserModel->selectUser($id);
        if ($user) {
            return view('application\user\edit_view', ['user' => $user]);
        } else {
            return redirect()->to('/dashboard');
        }
    }

    public function updateUserPassword()
    {
        if (!$this->DashboardModel->checkIfUserIsAdmin($this->session->get('user_id')) and $this->session->get('set_user')['user_level'] != 9) {
            return redirect()->to('/dashboard');
        }

        if ($this->requests->getMethod(true) === "POST") {
            if (empty($this->requests->getPost('user_id'))) {
                return redirect()->to('/dashboard/admin');
            }
            $user = $this->UserModel->selectUser($this->requests->getPost('user_id')); // get the user detail from the database using user_id that attached from the form

            if (!$user) {
                return redirect()->to('/dashboard/admin'); // user does not exists because of bypassing redirect to dashboard
            }

            $rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost());

            if (!$this->validatePost($rulesAndMessages['rules'], $rulesAndMessages['messages'], $this->requests->getPost())) {
                return redirect()->to("/users/edit/{$user['user_id']}"); // redirect to the edit page if there is error in validation
            } else {
                $isUserPasswordUpdated = $this->UserModel->updateUserPassword($this->requests->getPost()); // this method will update the user password then will return a boolean
                if ($isUserPasswordUpdated) { // if there are changes in the database then redirect to the dashboard admin else redirect to the edit page
                    $this->alert('success', 'Success', "User Password has been updated!");
                    return redirect()->to("/dashboard/admin");
                } else {
                    $this->alert('success', 'Warning', "No changes has been made!");
                    return redirect()->to("/users/edit/{$user['user_id']}");
                }
            }
        }
    }

    public function updateUserInformation()
    {
        /**
         * PREVENTING BYPASS USER_LEVEL
         * if user_level is not set then
         * it will not check the user_level of the normal user
         */
        if (isset($_POST['user_level'])) {
            if (!$this->DashboardModel->checkIfUserIsAdmin($this->session->get('user_id')) and $this->session->get('set_user')['user_level'] != 9) {
                return redirect()->to('/dashboard');
            }
        }

        if ($this->requests->getMethod(true) === 'POST') {
            if (empty($this->requests->getPost('user_id'))) {
                return redirect()->to('/dashboard/admin');
            }
            
            $rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost());
            
            $user = $this->UserModel->selectUser($this->requests->getPost('user_id')); // get the user detail from the database using user_id that attached from the form

            if (!$user) {
                return redirect()->to('/dashboard/admin'); // user does not exists because of bypassing redirect to dashboard
            }

            /**
             * USER UPDATING
             * if the user is updating their profile
             * with email address then this will going to true
             */
            if (isset($_POST['email'])) {
                $email = $this->requests->getPost('email');
                $emailCount = $this->UserModel->checkUserEmail($email); // get email count from the database
            }
            
            
            if ($user['email'] != @$email and !empty($this->requests->getPost('email')) and @$emailCount > 0) { // check if the email from the database and email from the form is not equal the proceed to checking of email from the database
                // if checking of email from database does exist then throw an error notification
                foreach ($this->requests->getPost() as $name => $_) {
                    $this->session->setFlashdata('signup_value_'.$name, $this->requests->getPost($name));
                }
                $this->session->setFlashdata('signup_error_email    ', 'Email already exists!');
                return redirect()->to("/users/edit/{$user['user_id']}"); // redirect to the edit page if email already exists

            } elseif (!$this->validatePost($rulesAndMessages['rules'], $rulesAndMessages['messages'], $this->requests->getPost())) { // this will check the validation of the post if there's one then throw a friendly notification
                
                /**
                 * UPDATING THE USER DESCRIPTION
                 * is post decription is set then redirect to profile
                 */
                if (isset($_POST['description'])) {
                    return redirect()->to('/users/profile');
                }

                return redirect()->to("/users/edit/{$user['user_id']}"); // redirect to the edit page if there is error in validation
            } else {
                $isUserUpdated = $this->UserModel->updateUser($this->requests->getPost()); // this method will update the user informtaion then will return a boolean
                if ($isUserUpdated) { // if there are changes in the database then redirect to the dashboard admin else redirect to the edit page
                    $this->alert('success', 'Success', "User information has been updated!");
                    return redirect()->to("/dashboard/admin");
                } else {
                    $this->alert('success', 'Warning', "No changes has been made!");
                    return redirect()->to("/users/edit/{$user['user_id']}");
                }
            }
        }
    }
    public function profile()
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            $user = $this->UserModel->selectUser($this->session->get('user_id'));
            return view('application\user\profile_view', ['user' => $user]);
        } else {
            return redirect()->to("/");
        }
    }
    public function show($id)
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            $user = $this->UserModel->selectUser($id);
            $messages = $this->MessageModel->selectMessageByUser($id);
            if ($user) {
                return view('application\user\show_view', ['user' => $user, 'messages' => $messages, 'comments' => function($id){ return $this->MessageModel->selectCommentsByMessage($id);}]);
            } else {
                return redirect()->to('/users/signin');
            }
        } else {
            return redirect()->to("/users/signin");
        }
    }
    
    public function deleteUser()
    {
        if (!$this->DashboardModel->checkIfUserIsAdmin($this->session->get('user_id')) and $this->session->get('set_user')['user_level'] != 9) {
            return redirect()->to('/dashboard');
        }
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            if ($this->requests->getMethod(true) === "POST") {
                $response = $this->UserModel->deleteUser($this->requests->getPost());
                if ($response) {
                    $this->alert('success', 'Success!', "The user has been deleted!");
                    return redirect()->to("/dashboard/admin");
                } else {
                    $this->alert('danger', 'Error', "Something went wrong while posting your comment");
                    return redirect()->to("/dashboard/admin");
                }
            }
        } else {
            return redirect()->to('/');
        }
    }
}
