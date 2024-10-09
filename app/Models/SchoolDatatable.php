<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use Config\Services;
use CodeIgniter\Model;

class SchoolDatatable extends Model
{
    protected $table = 'schools';
    protected $column_order = ['schools.id', 'schools.schoolname', 'schools.npsn', 'schools.address','schools.telp','users.fullname','bookmarks.user_id'];
    protected $column_search = ['schools.schoolname', 'schools.npsn', 'schools.address','schools.telp','users.fullname','bookmarks.user_id'];
    protected $order = ['bookmarks.id' => 'DESC', 'schools.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        $this->session = \Config\Services::session();
        $this->session->start();

        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $user_id = $this->session->get("user_id");
        $school_id = $this->session->get("school_id");
        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas');
        }else{
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas')->where('schools.id',$school_id);
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
        $user_id = $this->session->get("user_id");
        $school_id = $this->session->get("school_id");
        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas');
        }else{
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas')->where('schools.id',$school_id);
        }

        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $user_id = $this->session->get("user_id");
        $school_id = $this->session->get("school_id");
        $level = $this->session->get("level");
        if ($level == 1 || $level==3) {
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas');
        }else{
            $this->dt = $this->db->table('schools')->join('users','schools.id=users.school_id','left')->join("bookmarks","schools.id=bookmarks.school_id and bookmarks.user_id=$user_id", "left")->select('schools.id, schools.schoolname,schools.npsn,schools.address, schools.telp, schools.logo, users.fullname, users.id as user_id, bookmarks.id as bookmarked, bookmarks.user_id as pengawas')->where('schools.id',$school_id);
        }
        
        $this->getDatatablesQuery();
        return $this->dt->countAll();
    }
}
