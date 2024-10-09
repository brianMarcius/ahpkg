<?php

namespace App\Controllers;

use \App\Models\Evaluations;
use \App\Models\Questions;
use \App\Models\Options;
use \App\Models\EvaluationDatatable;
use App\Models\LogActivities;

use App\Controllers\BaseController;
use Config\Services;

class EvaluationController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = db_connect();
        $this->session->set('first_login',0);
    }

    public function index()
    {
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'evaluations',
            'description' => 'Access menu Evaluation',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('transactions/evaluation/evaluation_list');

    }

    public function create($errorMessage = '')
    {
        $data['error_message'] = $errorMessage;
        $questions = $this->db->table('questions')->get()->getResult();
        $data['questions'] = array();
        foreach ($questions as $key) {
            $new_array = array();
            $new_array['id'] = $key->id;
            $new_array['question'] = $key->question;
            $new_array['options'] = $this->db->table('options')->where('question_id',$key->id)->get()->getResult();
            $data['questions'][] = $new_array;
        }

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'evaluations',
            'description' => 'Access form Evaluation',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);


        return view('transactions/evaluation/evaluation_form',$data);

    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $evaluation = new Evaluations();
        $question = new Questions();
        $option_model = new Options();
        $user_id = $this->session->get("user_id");
        $school_id = $this->session->get("school_id");
        $date = date('Y-m-d H:i:s');

        $validation->setRules(["data" => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        // dd($isDataValid);
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }

        // dd($this->request->getPost("data"));
        $data = $this->request->getPost("data");
        for ($i=0; $i < count($data); $i++) { 
            $validate_data = count($data[$i]);
            if ($validate_data <2) {
                $errorMessage = 'You have to answer all the question';
                $isDataValid = false;
                break;
            }
        }

        $pengawas = $this->db->table('bookmarks')->join('users','bookmarks.user_id = users.id')->where('bookmarks.school_id',$school_id)->get()->getResult();
        // dd($pengawas[0]->user_id);

        $id_pengawas = $pengawas[0]->user_id ?? 0;

        // jika data valid, simpan ke database
        if($isDataValid){
            $evaluation->insert([
                'user_id' => $user_id,
                'school_id' => $school_id,
                'date' => $date,
                'link_drive' => $this->request->getPost('link_drive'),
                'year' => $this->request->getPost('tahun'),
                'pengawas' => $id_pengawas,
            ]);
            $evaluation_id = $evaluation->getInsertID();

            $total_score = 0;
            $total_max_score = 0;

            for ($i=0; $i < count($data); $i++) { 
                $j = 0;
                foreach ($data[$i] as $key) {
                    if ($j == 0) {
                        $question_id = $key;
                    }else{
                        $option_id = $key;
                    }
                    $j++;
                }         

                $question_query = $question->find($question_id);
                $question_text = $question_query['question'];
                $option_score = $option_model->find($option_id);
                $score = $option_score['score'];
                $notes = $option_score['notes'];
                $option_text = $option_score['option'];
                $query_max_score = $option_model->where('question_id',$question_id)->selectMax('score')->first();
                $max_score = $query_max_score['score'];

                $total_score += $score;
                $total_max_score += $max_score;

                $insert_detail = [
                    "evaluation_id" => $evaluation_id,
                    "question_id" => $question_id,
                    "question_text" => $question_text,
                    "option_id" => $option_id,
                    "option_text" => $option_text,
                    "score" => $score,
                    "max_score" => $max_score,
                    "notes" => $notes,
                ];

                $insert_detail = $this->db->table('evaluation_details')->insert($insert_detail);

            }

            $score_persentase = round(($total_score/$total_max_score) * 100);

            $criteria_score = $this->db->table('criterias')->get()->getResult();
            // dd($criteria_score);
            foreach ($criteria_score as $crt) {
                if ($score_persentase >= $crt->criteria) {
                    $crt_id = $crt->id;
                }
            }


            $update_evaluation = $evaluation->update($evaluation_id,[
                "score" => $score_persentase,
                "criteria_id" => $crt_id
            ]);

            // dd($score_persentase);

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'evaluations',
                'description' => 'Submit Evaluation',
                'before' => '',
                'after' => $evaluation_id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
    



            return redirect('evaluation/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->create($errorMessage);

    }

    public function getData(){
        $request = Services::request();
        $datatable = new EvaluationDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $pengawas = $this->db->table('bookmarks')->join('users','bookmarks.user_id = users.id')->where('bookmarks.school_id',$list->school_id)->get()->getResult();
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->schoolname;
                $row[] = $list->fullname;
                $row[] = $list->date;
                $row[] = $list->year;
                $row[] = $pengawas[0]->fullname ?? '-';
                // $row[] = $list->score;
                // $row[] = $list->notes;
                $row[] = '<div class="btn-group">
                    <a type="button" class="btn btn-sm btn-info text-white" href="/evaluation/view/'.$list->id.'"><i class="fa fa-eye"></i></a>
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

    public function view($id, $errorMessage = ''){
        $data['error_message'] = $errorMessage;
        $evaluation = new Evaluations();

        $data['evaluation_header'] = $evaluation->join('criterias','evaluations.criteria_id=criterias.id')->join('schools','evaluations.school_id=schools.id')->join('users','evaluations.user_id=users.id')->find($id);
        $data['evaluation_detail'] = $this->db->table('evaluation_details as a')->where('a.evaluation_id',$id)->get()->getResult();
        $school_id = $data['evaluation_header']['school_id'];
        // dd($data['evaluation_header']['school_id']);
        $data['pengawas'] = $this->db->table('bookmarks')->join('users','bookmarks.user_id = users.id')->where('bookmarks.school_id',$school_id)->get()->getResult();

        $data['id'] = $id;
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'evaluations',
            'description' => 'View Evaluation',
            'before' => '',
            'after' => $id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('transactions/evaluation/evaluation_form_edit',$data);

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
                    'score' => $this->request->getPost("val-option['score'][$i]")
                ]);
            }

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
        return json_encode($data);
    }

    // public function view($id){
    //     $question = new Questions();
    //     $options = new Options();
    //     $data['data']['question'] = $question->find($id);
    //     $data['data']['options'] = $options->where('question_id',$id)->get()->getResult();
    //     $data['code'] = 200;
    //     $data['message'] = 'success';
    //     return json_encode($data);
    // }

    public function getdataChart()
    {

        $id = $this->request->getGet('id');
        $data = $this->db->table('evaluation_details')->where('evaluation_id',$id)->get()->getResult();

        echo json_encode($data);
    }

}
