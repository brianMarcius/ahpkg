<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;

use CodeIgniter\Model;

class EvaluationDatatable extends Model
{
    protected $table = 'evaluations';
    protected $column_order = ['evaluations.id', 'schools.schoolname', 'users.fullname','evaluations.date','criterias.notes','evaluations.year'];
    protected $column_search = ['schools.schoolname', 'users.fullname','evaluations.date','criterias.notes','evaluations.year'];
    protected $order = ['evaluations.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        $this->session->start();
        $user_id = $this->session->get("user_id");
        $school_id = $this->session->get("school_id");

        $this->db = db_connect();
        $this->request = $request;
        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }else{
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id and schools.id=$school_id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }
    }

    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $school_id = $this->session->get("school_id");

        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }else{
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id and schools.id=$school_id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $school_id = $this->session->get("school_id");

        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }else{
            $this->dt = $this->db->table('evaluations')->join('schools',"evaluations.school_id=schools.id and schools.id=$school_id")->join('users','evaluations.user_id=users.id')->join('criterias','evaluations.criteria_id=criterias.id')->select('evaluations.id, evaluations.school_id, evaluations.user_id, evaluations.date, evaluations.score, evaluations.criteria_id, schools.schoolname, users.fullname, criterias.notes, evaluations.year');
        }
        $this->getDatatablesQuery();
        return $this->dt->countAll();
    }
}
