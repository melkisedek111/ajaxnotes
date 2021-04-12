<?php

namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\UserModel;
class Dashboard extends BaseController
{
	protected $DashboardModel;
	protected $UserModel;
	protected $session;
	public function __construct()
	{
		$this->session = session();
		$this->UserModel = new UserModel;
		$this->DashboardModel = new DashboardModel;
	}

	public function index()
	{
		return view('application\dashboard\main_view', ['navActive' => "home"]);
	}

	public function admin()
	{
		if(!$this->DashboardModel->checkIfUserIsAdmin($this->session->get('user_id')) AND $this->session->get('set_user')['user_level'] != 9) {
			return redirect()->to('/dashboard');
		}
		$users = $this->DashboardModel->selectAllUsers();
		return view('application\dashboard\admin_view', ['navActive' => "manageUser", 'users' => $users]);
	}

	protected function setUserSession() {
		if(!$this->session->has('set_user')) {
			$user = $this->UserModel->selectUser($this->session->get('user_id'));
			$this->session->set('set_user', $user);
		}
	}

	public function dashboard()
	{
		if(!$this->session->has('user_id')) return redirect()->to('/users/signin');
		$this->setUserSession();	
		$users = $this->DashboardModel->selectAllUsers();
		return view('application\dashboard\dashboard_view', ['users' => $users, 'navActive' => "dashboard"]);
	}
}
