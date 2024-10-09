<?php

namespace App\Controllers;


use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
    }

    public function index()
    {
        $level = $this->session->get('level');
        $school_id = $this->session->get('school_id');
        if ($level==1 || $level==3) {
            $data['schools_count'] = $this->db->table('schools')->countAll();
            $data['users_count'] = $this->db->table('users')->countAll();
            $data['evaluations_count'] = $this->db->table('evaluations')->countAll();
            $data['top_ten_schools'] = $this->db->table('evaluations')
                                        ->join('schools','schools.id=evaluations.school_id')
                                        ->join('users','users.school_id = schools.id')
                                        ->select('max(evaluations.id) id,schools.schoolname,users.fullname,max(evaluations.date) date, max(evaluations.score) as score')
                                        ->groupBy('evaluations.school_id')
                                        ->orderBy('score','desc')->limit(10)->get()->getResult();
        }else{
            $data['latest_score'] = $this->db->table('evaluations')->where('school_id',$school_id)->orderBy('id','desc')->limit(1)->get()->getResult();
            $data['max_score'] = $this->db->table('evaluations')->where('school_id',$school_id)->selectMax('score')->select('date')->get()->getResult();
            $data['detail'] = $this->db->table('evaluation_details')->where('evaluation_id',$data['latest_score'][0]->id ?? 0)->get()->getResult();
            $data['question'] = $this->db->table('questions')->get()->getResult();

            $data['evaluations_count'] = $this->db->table('evaluations')->where('school_id',$school_id)->countAllResults();
        }
        return view('dashboard',$data);
    }

    public function getdata()
    {
        $school_id = $this->session->get('school_id');
        // dd($end_date);

        $eveluations = $this->db->table('evaluations')->where('school_id',$school_id)->limit(1)->orderBy('date','desc')->get()->getResult();

        $id = $eveluations[0]->id ?? 0;
        $data = $this->db->table('evaluation_details')->where('evaluation_id',$id)->get()->getResult();

        echo json_encode($data);
    }
}
