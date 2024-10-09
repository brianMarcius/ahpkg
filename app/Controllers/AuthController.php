<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use App\Models\LogActivities;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model = new Users();
        $log_activities = new LogActivities();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->where('username', $username)->first();
        // dd($data);
        if($data){
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = [
                    'user_id'       => $data['id'],
                    'username'      => $data['username'],
                    'fullname'      => $data['fullname'],
                    'email'         => $data['email'],
                    'level'         => $data['level'],
                    'school_id'     => $data['school_id'],
                    'first_login'     => $data['first_login'],
                    'logged_in'     => TRUE
                ];

                // $model->update($data['id'],[
                //     'first_login' => 0
                // ]);
                
                $session->set($ses_data);

                $log_data = [
                    'tables_name' => 'users',
                    'description' => 'Login to scheva',
                    'before' => '',
                    'after' => '',
                    'create_date' => date('Y-m-d H:i:s'),
                    'create_by' => $data['id'],
                    'active' => 1
                ];

                $log_activities->insert_log($log_data);

                return redirect()->to('/dashboard');
            }else{
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/');
            }
        }else{
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/');
        }
    }
 
    public function logout()
    {
        $session = session();
        $log_activities = new LogActivities();

        $log_data = [
            'tables_name' => 'users',
            'description' => 'Logout from scheva',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        $session->destroy();
        return redirect()->to('/');
    }
}
