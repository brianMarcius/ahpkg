<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use Config\Services;
use CodeIgniter\Model;

class LogActivityDatatable extends Model
{
    protected $table = 'log_activities';
    protected $column_order = ['log_activities.id', 'log_activities.tables_name', 'log_activities.description', 'log_activities.after','log_activities.create_date','users.fullname'];
    protected $column_search = ['log_activities.tables_name', 'log_activities.description', 'log_activities.after','log_activities.create_date','users.fullname'];
    protected $order = ['log_activities.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->session = \Config\Services::session();
        $this->session->start();
        $user_id = $this->session->get("user_id");


        $this->dt = $this->db->table('log_activities')->join('users',"users.id=log_activities.create_by")->select('log_activities.id, log_activities.tables_name, log_activities.description, log_activities.after,log_activities.create_date,users.fullname')->where('log_activities.create_by',$user_id);

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
        $this->dt = $this->db->table('log_activities')->join('users',"users.id=log_activities.create_by")->select('log_activities.id, log_activities.tables_name, log_activities.description, log_activities.after,log_activities.create_date,users.fullname')->where('log_activities.create_by',$user_id);
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $user_id = $this->session->get("user_id");
        $tbl_storage = $this->db->table($this->table)->where('log_activities.create_by',$user_id);
        return $tbl_storage->countAllResults();
    }
}
