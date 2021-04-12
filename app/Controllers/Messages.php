<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MessageModel;
use App\Models\DashboardModel;
class Messages extends BaseController
{
    protected $UserModel;
    protected $DashboardModel;
    protected $session;
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
        $this->MessageModel = new MessageModel;
        $this->DashboardModel = new DashboardModel;
        $this->rules =  [
            'message' => 'required',
            'comment' => 'required',
        ];
        $this->messages = [
            'message' => [
                'required' => 'Message is requried'
            ],
            'comment' => [
                'required' => 'Comment is requried'
            ]
        ];

        if ($this->requests->getPost()) {
            $this->rulesAndMessages = $this->getRules($this->rules, $this->messages, $this->requests->getPost());
        }
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

    public function show()
    {
        $users = $this->DashboardModel->selectAllUsers();
        return view('application\dashboard\user_messages_view', ['navActive' => "showMessages", 'users' => $users]);
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

    public function deleteComment()
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            if ($this->requests->getMethod(true) === "POST") {
                $toUserId = explode("|", $this->requests->getPost('other_id'))[1];
                $response = $this->MessageModel->deleteMessageComment($this->requests->getPost(), $this->session->get('user_id'));
                if ($response) {
                    $this->alert('success', 'Success!', "Your comment has been deleted!");
                    return redirect()->to("/users/show/{$toUserId}");
                } else {
                    $this->alert('danger', 'Error', "Something went wrong while posting your comment");
                    return redirect()->to("/users/show/{$toUserId}");
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function deleteMessage()
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            if ($this->requests->getMethod(true) === "POST") {
                $toUserId = $this->requests->getPost('other_id');
                $response = $this->MessageModel->deletePostMessage($this->requests->getPost(), $this->session->get('user_id'));
                if ($response) {
                    $this->alert('success', 'Success!', "Your message has been deleted!");
                    return redirect()->to("/users/show/{$toUserId}");
                } else {
                    $this->alert('danger', 'Error', "Something went wrong while posting your comment");
                    return redirect()->to("/users/show/{$toUserId}");
                }
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function postComment()
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            if ($this->requests->getMethod(true) === "POST") {
                if (!$this->validatePost($this->rulesAndMessages['rules'], $this->rulesAndMessages['messages'], $this->requests->getPost())) { // this will check the validation of the post if there's one then throw a friendly notification
                    $this->session->setFlashdata('comment_error_message_'.$this->requests->getPost('message_id'), $this->rulesAndMessages['messages']['comment']['required']);
                    return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                } else {
                    $response = $this->MessageModel->createNewComment($this->requests->getPost(), $this->session->get('user_id'));
                    if ($response) {
                        $this->alert('success', 'Success!', "Your comment has been posted");
                        return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                    } else {
                        $this->alert('danger', 'Error', "Something went wrong while posting your comment");
                        return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                    }
                }
            }
        } else {
            return redirect()->to('/');
        }
    }
    
    public function postMessage()
    {
        if ($this->session->has('user_id') and $this->session->has('set_user')) {
            if ($this->requests->getMethod(true) === "POST") {
                if (!$this->validatePost($this->rulesAndMessages['rules'], $this->rulesAndMessages['messages'], $this->requests->getPost())) { // this will check the validation of the post if there's one then throw a friendly notification
                    return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                } else {
                    $response = $this->MessageModel->createNewPost($this->requests->getPost(), $this->session->get('user_id'));
                    if ($response) {
                        $this->alert('success', 'Success!', "Your message has been posted");
                        return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                    } else {
                        $this->alert('danger', 'Error', "Something went wrong while posting your message");
                        return redirect()->to("/users/show/{$this->requests->getPost('to_user_id')}");
                    }
                }
            }
        } else {
            return redirect()->to('/');
        }
    }
}
