<?php

namespace App\Controllers;
use \App\Models\Questions;
use \App\Models\Options;
use \App\Models\QuestionDatatable;
use Config\Services;
use App\Models\LogActivities;

use App\Controllers\BaseController;

class QuestionController extends BaseController
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
            'tables_name' => 'questions',
            'description' => 'Access menu question',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/question/question_list');

    }

    public function create($errorMessage = '')
    {
        $data['error_message'] = $errorMessage;
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'questions',
            'description' => 'Access form question',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/question/question_form',$data);

    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $question = new Questions();
        $option_model = new Options();
        $validation->setRules(['val-question' => 'required', 'val-option' => 'required']);
        // dd($this->request->getPost('val-option'));
        $isDataValid = $validation->withRequest($this->request)->run();
        // dd($isDataValid);
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }


        // jika data valid, simpan ke database
        if($isDataValid){
            $question->insert([
                "question" => $this->request->getPost('val-question')
            ]);
            $question_id = $question->getInsertID();
            $options = $this->request->getPost("val-option['option']");
            for ($i=0; $i<count($options); $i++ ){
                $option_model->insert([
                    'question_id' => $question_id,
                    'option' => $this->request->getPost("val-option['option'][$i]"),
                    'score' => $this->request->getPost("val-option['score'][$i]"),
                    'notes' => $this->request->getPost("val-option['notes'][$i]"),
                ]);
            }

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'questions',
                'description' => 'Insert data question',
                'before' => '',
                'after' => $question_id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];

            $log_activities->insert_log($log_data);

    
            return redirect('setting/question/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->create($errorMessage);

    }

    public function getData(){
        $request = Services::request();
        $datatable = new QuestionDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->question;
                $row[] = '<div class="btn-group">
                            <a type="button" class="btn btn-sm btn-primary text-white" onclick="viewDetail('.$list->id.')"><i class="fa fa-eye"></i></a>
                            <a type="button" class="btn btn-sm btn-info text-white" href="/setting/question/edit/'.$list->id.'"><i class="fa fa-pencil"></i></a>
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
        $question = new Questions();
        $options = new Options();
        $data['question'] = $question->find($id);
        $data['options'] = $options->where('question_id',$id)->get()->getResult();
        $data['error_message'] = $errorMessage;

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'questions',
            'description' => 'Access Edit form question',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('setting/question/question_form_edit',$data);

    }

    public function update()
    {
        $validation =  \Config\Services::validation();
        $question = new Questions();
        $option_model = new Options();
        $validation->setRules(['val-id' => 'required', 'val-question' => 'required', 'val-option' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }
        $id = $this->request->getPost('val-id');


        // jika data valid, simpan ke database
        if($isDataValid){
            $question->update($id,[
                "question" => $this->request->getPost('val-question'),
            ]);
            $option_model->where('question_id',$id)->delete();
            $options = $this->request->getPost("val-option['option']");
            for ($i=0; $i<count($options); $i++ ){
                $option_model->insert([
                    'question_id' => $id,
                    'option' => $this->request->getPost("val-option['option'][$i]"),
                    'score' => $this->request->getPost("val-option['score'][$i]"),
                    'notes' => $this->request->getPost("val-option['notes'][$i]"),
                ]);
            }

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'questions',
                'description' => 'Update data question',
                'before' => '',
                'after' => $id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
    
    
            return redirect('setting/question/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->edit($id,$errorMessage);

    }


    public function delete($id){
        $question = new Questions();
        $options = new Options();
        $question->delete($id);
        $options->where('question_id',$id)->delete();
        $data['code'] = 200;
        $data['message'] = 'success';

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'questions',
            'description' => 'Delete data question',
            'before' => '',
            'after' => $id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return json_encode($data);
    }

    public function view($id){
        $question = new Questions();
        $options = new Options();
        $data['data']['question'] = $question->find($id);
        $data['data']['options'] = $options->where('question_id',$id)->get()->getResult();
        $data['code'] = 200;
        $data['message'] = 'success';

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'questions',
            'description' => 'View data question',
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
