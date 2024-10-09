<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \App\Models\Users;
use \App\Models\UserDatatable;
use Config\Services;
use App\Models\LogActivities;
use App\Models\LogActivityDatatable;

class ProfileController extends BaseController
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
            'description' => 'Access profile page',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);
        $users = new Users();
        $data['user'] =  $users->join('levels','users.level=levels.id')->join('schools','users.school_id=schools.id','left')->select('users.fullname,users.id,users.email,users.level as level_id,levels.level,users.username,users.school_id,schools.schoolname,schools.logo,schools.address,schools.telp,schools.npsn')->find($this->session->get('user_id'));

        return view('masters/users/user_profile',$data);

    }



    public function getLogActivity(){
        $request = Services::request();
        $datatable = new LogActivityDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->tables_name;
                $row[] = $list->description;
                $row[] = $list->after;
                $row[] = $list->create_date;
                $row[] = $list->fullname;
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


}
