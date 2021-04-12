<?php

namespace App\Controllers;

use App\Models\PostsModel;

class Post extends BaseController
{
    protected $session;
    protected $requests;
    protected $rules;
    protected $messages;
    protected $rulesAndMessages;
    protected $PostsModel;
    protected $token;
    public function __construct()
    {
        $this->PostsModel = new PostsModel;
        $this->requests = \Config\Services::request();
        $this->session = session();
        $this->token = ['name' => csrf_token(), 'value' => csrf_hash()];
    }

    public function index()
    {
        return view('post\post_view');
    }
    public function getNotes() {
        $data['data'] = $this->PostsModel->getNotes();
        $data['token'] = $this->token;
        echo json_encode($data);
    }
    public function createNote() {
        $response = $this->PostsModel->createNewNote();
        $data['data'] = $response;
        $data['token'] = $this->token;
        echo json_encode($data);
    }
    public function updateNote() {
        $data['data'] = $this->PostsModel->updateNote($this->requests->getPost());
        $data['token'] = $this->token;
        echo json_encode($data);
    }
    public function deleteNote() {
        $data['data'] = $this->PostsModel->deleteNote($this->requests->getPost());
        $data['token'] = $this->token;
        echo json_encode($data);
    }
}
