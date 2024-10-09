<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \App\Models\Users;
use \App\Models\UserDatatable;
use Config\Services;
use App\Models\LogActivities;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        $this->session->set('first_login',0);

    }

    public function index()
    {
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'users',
            'description' => 'Access menu users',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('masters/users/user_list');

    }

    public function create($errorMessage = '')
    {
        $data['levels'] = $this->db->table('levels')->get()->getResult();
        $data['schools'] = $this->db->table('schools')->get()->getResult();
        $data['error_message'] = $errorMessage;

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'users',
            'description' => 'Access form users',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('masters/users/user_form',$data);

    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $user = new Users();
        $validation->setRules(['val-username' => 'required', 'val-fullname' => 'required', 'val-email' => 'required', 'val-password' => 'required', 'val-level' => 'required','val-nip' => 'required', 'val-gol' => 'required', 'val-jabatan' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }

        $checkUsername = $user->where('username',$this->request->getPost('val-username'))->countAllResults();
        $isUsernameUnique = 1;
        if ($checkUsername > 0) {
            $errorMessage = 'Username is already taken';
            $isUsernameUnique = 0;
        }


        $checkEmail = $user->where('email',$this->request->getPost('val-email'))->countAllResults();
        $isEmailUnique = 1;
        if ($checkEmail > 0) {
            $errorMessage = 'Email is already taken';
            $isEmailUnique = 0;
        }


        // jika data valid, simpan ke database
        if($isDataValid && $isEmailUnique && $isUsernameUnique){
            if ($this->request->getPost('val-level') == 2) {
                if ($this->request->getPost('val-school') == '') {
                    $errorMessage = 'School is required for this level';
                }else{
                    $checkUser = $user->where('school_id',$this->request->getPost('val-school'))->countAllResults();
                    if ($checkUser > 0) {
                        $errorMessage = 'School already has a user';
                    }else{
                        $hashed_password = password_hash($this->request->getPost('val-password'), PASSWORD_DEFAULT);
                        $user->insert([
                            "username" => $this->request->getPost('val-username'),
                            "fullname" => $this->request->getPost('val-fullname'),
                            "email" => $this->request->getPost('val-email'),
                            "password" => $hashed_password,
                            "decrypted_password" => $this->request->getPost('val-password'),
                            "level" => $this->request->getPost('val-level'),
                            "school_id" => $this->request->getPost('val-school'),
                            "nip" => $this->request->getPost('val-nip'),
                            "golongan" => $this->request->getPost('val-gol'),
                            "jabatan" => $this->request->getPost('val-jabatan'),
                        ]);

                        $inserted_id = $user->getInsertID();


                        $log_activities = new LogActivities();
                        $log_data = [
                            'tables_name' => 'users',
                            'description' => 'Insert data users level pengawas',
                            'before' => '',
                            'after' => $inserted_id,
                            'create_date' => date('Y-m-d H:i:s'),
                            'create_by' => $this->session->get('user_id'),
                            'active' => 1
                        ];
                
                        $log_activities->insert_log($log_data);
                
                        return redirect('master/users/list');        
                    }
    
                }
            }else{
                $hashed_password = password_hash($this->request->getPost('val-password'), PASSWORD_DEFAULT);
                $user->insert([
                    "username" => $this->request->getPost('val-username'),
                    "fullname" => $this->request->getPost('val-fullname'),
                    "email" => $this->request->getPost('val-email'),
                    "password" => $hashed_password,
                    "decrypted_password" => $this->request->getPost('val-password'),
                    "level" => $this->request->getPost('val-level'),
                    "school_id" => $this->request->getPost('val-school'),
                    "nip" => $this->request->getPost('val-nip'),
                    "golongan" => $this->request->getPost('val-gol'),
                    "jabatan" => $this->request->getPost('val-jabatan'),
                ]);

                $inserted_id = $user->getInsertID();


                $log_activities = new LogActivities();
                $log_data = [
                    'tables_name' => 'users',
                    'description' => 'Insert data users level kepala sekolah',
                    'before' => '',
                    'after' => $inserted_id,
                    'create_date' => date('Y-m-d H:i:s'),
                    'create_by' => $this->session->get('user_id'),
                    'active' => 1
                ];
        
                $log_activities->insert_log($log_data);
        

                return redirect('master/users/list');        

            }

        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->create($errorMessage);

    }

    public function getData(){
        $request = Services::request();
        $datatable = new UserDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->username;
                $row[] = $list->fullname;
                $row[] = $list->email;
                $row[] = $list->levelname;
                $row[] = $list->schoolname;
                $row[] = $list->nip;
                $row[] = $list->golongan;
                $row[] = $list->jabatan;
                $row[] = '<div class="btn-group">
                            <a type="button" class="btn btn-sm btn-info text-white" href="/master/users/edit/'.$list->id.'"><i class="fa fa-pencil"></i></a>
                            <a type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete('.$list->id.')"><i class="fa fa-trash"></i></a>
                        </div>';
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function edit($id, $errorMessage = ''){
        $user = new Users();
        $data['levels'] = $this->db->table('levels')->get()->getResult();
        $data['schools'] = $this->db->table('schools')->get()->getResult();
        $data['user'] = $user->find($id);
        $data['error_message'] = $errorMessage;
        // dd($data['user']);
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'users',
            'description' => 'Access form edit user',
            'before' => '',
            'after' => $id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('masters/users/user_form_edit',$data);

    }

    public function update()
    {
        $validation =  \Config\Services::validation();
        $user = new Users();
        $validation->setRules(['val-id' => 'required', 'val-username' => 'required', 'val-fullname' => 'required', 'val-email' => 'required', 'val-nip' => 'required', 'val-gol' => 'required', 'val-jabatan' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }
        $id = $this->request->getPost('val-id');

        $checkUsername = $user->where('username',$this->request->getPost('val-username'))->where('id !=',$id)->countAllResults();
        $isUsernameUnique = 1;
        if ($checkUsername > 0) {
            $errorMessage = 'Username is already taken';
            $isUsernameUnique = 0;
        }


        $checkEmail = $user->where('email',$this->request->getPost('val-email'))->where('id !=',$id)->countAllResults();
        $isEmailUnique = 1;
        if ($checkEmail > 0) {
            $errorMessage = 'Email is already taken';
            $isEmailUnique = 0;
        }


        // jika data valid, simpan ke database
        if($isDataValid && $isEmailUnique && $isUsernameUnique){
            if ($this->request->getPost('val-level') == 2) {
                if ($this->request->getPost('val-school') == '') {
                    $errorMessage = 'School is required for this level';
                }else{
                    $checkUser = $user->where('school_id',$this->request->getPost('val-school'))->where('id !=',$id)->countAllResults();
                    if ($checkUser > 0) {
                        $errorMessage = 'School already has a user';
                    }else{
                        $user->update($id,[
                            "username" => $this->request->getPost('val-username'),
                            "fullname" => $this->request->getPost('val-fullname'),
                            "email" => $this->request->getPost('val-email'),
                            "level" => $this->request->getPost('val-level'),
                            "school_id" => $this->request->getPost('val-school'),
                            "nip" => $this->request->getPost('val-nip'),
                            "golongan" => $this->request->getPost('val-gol'),
                            "jabatan" => $this->request->getPost('val-jabatan'),

                        ]);

                        if ($this->request->getPost('password') != '') {
                            $hashed_password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                            $user->update($id,[
                                "password" => $hashed_password,
                                "decrypted_password" => $this->request->getPost('password'),
                            ]);
        
                        }

                        $log_activities = new LogActivities();
                        $log_data = [
                            'tables_name' => 'users',
                            'description' => 'Update data user pengawas',
                            'before' => '',
                            'after' => $id,
                            'create_date' => date('Y-m-d H:i:s'),
                            'create_by' => $this->session->get('user_id'),
                            'active' => 1
                        ];
                
                        $log_activities->insert_log($log_data);
                        if ($this->session->get('level')==3) {
                            return redirect('master/users/list');        
                        }else{
                            return redirect('master/users/profile');        

                        }
                    }
                }
            }else{
                $user->update($id,[
                    "username" => $this->request->getPost('val-username'),
                    "fullname" => $this->request->getPost('val-fullname'),
                    "email" => $this->request->getPost('val-email'),
                    "level" => $this->request->getPost('val-level'),
                    "school_id" => 0,
                    "nip" => $this->request->getPost('val-nip'),
                    "golongan" => $this->request->getPost('val-gol'),
                    "jabatan" => $this->request->getPost('val-jabatan'),

                ]);

                if ($this->request->getPost('password') != '') {
                    $hashed_password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                    $user->update($id,[
                        "password" => $hashed_password,
                        "decrypted_password" => $this->request->getPost('password'),
                    ]);

                }

                $log_activities = new LogActivities();
                $log_data = [
                    'tables_name' => 'users',
                    'description' => 'Update data user kepala sekolah',
                    'before' => '',
                    'after' => $id,
                    'create_date' => date('Y-m-d H:i:s'),
                    'create_by' => $this->session->get('user_id'),
                    'active' => 1
                ];
        
                $log_activities->insert_log($log_data);

                if ($this->session->get('level')==3) {
                    return redirect('master/users/list');        
                }else{
                    return redirect('master/users/profile');        

                }

            }

        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->edit($id,$errorMessage);

    }


    public function delete($id){
        $user = new Users();
        $user->delete($id);
        $data['code'] = 200;
        $data['message'] = 'success';

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'users',
            'description' => 'Delete data user',
            'before' => '',
            'after' => $id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return json_encode($data);
    }
}
