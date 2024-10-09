<?php

namespace App\Models;

use CodeIgniter\Model;

class LogActivities extends Model
{
    protected $table = 'log_activities';
    protected $allowedFields = 
    [
        'tables_name', 'description', 'before', 'after', 'create_date', 'create_by', 'active'
    ];
 
    public function getLogActivities($id = '')
    {
        if ($id === '')
        {
            return $this->asObject()
                    ->where(['active' => '1'])
                    ->findAll();
        }
 
        return $this->asObject()
                    ->where(['id' => $id, 'active' => '1'])
                    ->first();
 
    }
     
    public function getLatestLogActivities()
    {
        return $this->asObject()
                    ->where(['active' => '1'])
                    ->orderBy('create_date', 'desc')
                    ->findAll(10);
 
    }
 
    public function make_query($create_date, $create_by)
    {
        $query = "
        SELECT * from log_activities
        WHERE active=1 
        ";
 
        if (isset($create_date) && $create_date !== '') {
            $query .= "
                AND create_date='".$create_date."'
            ";
        }
 
        if (isset($create_by)) {
            $create_by = substr($this->db->escape($create_by), 1, -1);
            $query .= "
                AND create_by like '%".$create_by."%'
            ";
        }
 
        return $query;
    }
 
    public function fetch_data($limit, $start, $create_date, $create_by)
    {
        $query = $this->make_query($create_date, $create_by);
        $query .= ' LIMIT '.$start.', '.$limit; 
        $data = $this->db->query($query);
        return $data->getResult();
    }
 
    public function count_all($create_date, $create_by)
    {
        $query = $this->make_query($create_date, $create_by);
        $data = $this->db->query($query);
 
        return count($data->getResultArray());
    }


    public function insert_log($data){
        $query = $this->insert($data);
    }

}
