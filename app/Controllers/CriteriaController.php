<?php

namespace App\Controllers;

use \App\Models\Criterias;
use \App\Models\CriteriaDatatable;
use Config\Services;
use App\Models\LogActivities;

use App\Controllers\BaseController;

class CriteriaController extends BaseController
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
            'tables_name' => 'criterias',
            'description' => 'Access menu criteria',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/criteria/criteria_list');

    }

    public function create($errorMessage = '')
    {
        $data['error_message'] = $errorMessage;
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'criterias',
            'description' => 'Access form criteria',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/criteria/criteria_form',$data);

    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $criteria = new Criterias();
        $validation->setRules(['val-criteria' => 'required', 'val-notes' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }


        // jika data valid, simpan ke database
        if($isDataValid){
            // $hashed_password = password_hash($this->request->getPost('val-password'), PASSWORD_DEFAULT);
            $criteria->insert([
                "criteria" => $this->request->getPost('val-criteria'),
                "notes" => $this->request->getPost('val-notes'),
            ]);

            $criteria_id = $criteria->getInsertID();


            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'criterias',
                'description' => 'Insert new data criteria',
                'before' => '',
                'after' => $criteria_id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
    
            return redirect('setting/criteria/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->create($errorMessage);

    }

    public function getData(){
        $request = Services::request();
        $datatable = new CriteriaDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->criteria;
                $row[] = $list->notes;
                $row[] = '<div class="btn-group">
                            <a type="button" class="btn btn-sm btn-info text-white" href="/setting/criteria/edit/'.$list->id.'"><i class="fa fa-pencil"></i></a>
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
        $criteria = new Criterias();
        $data['criteria'] = $criteria->find($id);
        $data['error_message'] = $errorMessage;
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'criterias',
            'description' => 'Access form edit criteria',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/criteria/criteria_form_edit',$data);

    }

    public function update()
    {
        $validation =  \Config\Services::validation();
        $criteria = new Criterias();
        $validation->setRules(['val-id' => 'required', 'val-criteria' => 'required', 'val-notes' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }
        $id = $this->request->getPost('val-id');


        // jika data valid, simpan ke database
        if($isDataValid){
            $criteria->update($id,[
                "criteria" => $this->request->getPost('val-criteria'),
                "notes" => $this->request->getPost('val-notes'),
            ]);

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'criterias',
                'description' => 'Update data criteria',
                'before' => '',
                'after' => $id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
    
            return redirect('setting/criteria/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->edit($id,$errorMessage);

    }


    public function delete($id){
        $criteria = new Criterias();
        $criteria->delete($id);
        $data['code'] = 200;
        $data['message'] = 'success';
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'criterias',
            'description' => 'Delete data criteria',
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
