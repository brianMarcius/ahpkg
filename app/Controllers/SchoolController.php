<?php

namespace App\Controllers;
use \App\Models\Schools;
use \App\Models\SchoolDatatable;
use App\Models\LogActivities;

use App\Controllers\BaseController;
use Config\Services;

class SchoolController extends BaseController
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
            'tables_name' => 'schools',
            'description' => 'Access menu school',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('masters/school/school_list');

    }

    public function create($errorMessage = '')
    {
        $data['pengawas'] = $this->db->table('users')->where('level',1)->get()->getResult();
        $data['error_message'] = $errorMessage;
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'schools',
            'description' => 'Access form school',
            'before' => '',
            'after' => '',
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return view('masters/school/school_form',$data);

    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $image_validation =  \Config\Services::validation();
        $school = new Schools();
        $validation->setRules(['val-schoolname' => 'required', 'val-npsn' => 'required', 'val-address' => 'required','val-pengawas' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }

        $upload = $this->request->getFile('val-logo');
        $validated = true;
        if ($upload->isFile()) {
            $validated = $this->validate([
                'val-logo' => [
                    'uploaded[val-logo]',
                    'mime_in[val-logo,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[val-logo,4096]',
                ],
            ]);
            if (!$validated) {
                $errorMessage = 'Image does not comply requirement';
            }
        }


        $checkSchoolName = $school->where('schoolname',$this->request->getPost('val-schoolname'))->countAllResults();
        $isSchoolNameUnique = 1;
        if ($checkSchoolName > 0) {
            $errorMessage = 'School Name is already taken';
            $isSchoolNameUnique = 0;
        }


        $chechNpsn = $school->where('npsn',$this->request->getPost('val-npsn'))->countAllResults();
        $isNpsnUniquer = 1;
        if ($chechNpsn > 0) {
            $errorMessage = 'NPSN is already taken';
            $isNpsnUniquer = 0;
        }


        // jika data valid, simpan ke database
        if($isDataValid && $isSchoolNameUnique && $isNpsnUniquer && $validated){

            if ($upload->isFile()) {

                $mime = $upload->getClientExtension();
                $upload->move(WRITEPATH . '../public/assets/images/schools/',$this->request->getPost('val-schoolname').'.'.$mime);

                $school->insert([
                    "schoolname" => $this->request->getPost('val-schoolname'),
                    "npsn" => $this->request->getPost('val-npsn'),
                    "address" => $this->request->getPost('val-address'),
                    "telp" => $this->request->getPost('val-telp'),
                    "logo" => $upload->getName(),
                ]);

            }else{
                // dd('engga');
                $school->insert([
                    "schoolname" => $this->request->getPost('val-schoolname'),
                    "npsn" => $this->request->getPost('val-npsn'),
                    "address" => $this->request->getPost('val-address'),
                    "telp" => $this->request->getPost('val-telp'),
                ]);
            }

            $school_id = $school->getInsertID();

            $this->db->table('bookmarks')->insert([
                'user_id' => $this->request->getPost('val-pengawas'),
                'school_id' => $school_id,
            ]);

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'schools',
                'description' => 'Insert data school',
                'before' => '',
                'after' => $school_id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
    

            return redirect('master/school/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->create($errorMessage);

    }

    public function getData(){
        $request = Services::request();
        $datatable = new SchoolDatatable($request);
        $user_id = $this->session->get("user_id");
        $level = $this->session->get('level');


        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $pengawas = $this->db->table('bookmarks')->join('users','bookmarks.user_id = users.id')->where('bookmarks.school_id',$list->id)->get()->getResult();
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->schoolname;
                $row[] = $list->npsn;
                $row[] = $list->address;
                $row[] = $list->telp;
                $row[] = $list->fullname;
                $row[] = $pengawas[0]->fullname ?? '-';

                $bookmark_button = '';
                $delete_button = '';
                $edit_button = '';
                if ($level == 1) {
                    if ($list->bookmarked != '') {
                        $bookmark_button =  '<button type="button" class="btn btn-sm btn-warning text-white" onclick="unbookmark('.$list->bookmarked.')"><i class="fa fa-star"></i></button>';
                    }else{
                        $bookmark_button =  '<button type="button" class="btn btn-sm btn-outline-warning" onclick="bookmark('.$user_id.','.$list->id.')"><i class="fa fa-star"></i></button>';
                    }    

                }

                if ($level == 3 || $level == 2) {
                    $edit_button = '<a type="button" class="btn btn-sm btn-info text-white" href="/master/school/edit/'.$list->id.'"><i class="fa fa-pencil"></i></a>';
                }

                if($level == 3){
                    $delete_button = '<a type="button" class="btn btn-sm btn-danger text-white" onclick="confirmDelete('.$list->id.')"><i class="fa fa-trash"></i></a>';
                }


                $row[] = '<div class="btn-group">
                            <a type="button" class="btn btn-sm btn-primary text-white" onclick="viewDetail('.$list->id.')"><i class="fa fa-eye"></i></a>
                            '.$bookmark_button.'
                            '.$edit_button.'
                            '.$delete_button.'
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
        $school = new Schools();
        $data['school'] = $school->find($id);
        $data['pengawas'] = $this->db->table('users')->where('level',1)->get()->getResult();
        $data['pengawas_sekolah'] = $this->db->table('bookmarks')->where('school_id',$data['school']['id'])->limit(1)->get()->getResult();
        $data['error_message'] = $errorMessage;
        $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'schools',
                'description' => 'Access form edit school',
                'before' => '',
                'after' => $id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);
        return view('masters/school/school_form_edit',$data);

    }

    public function update()
    {
        $validation =  \Config\Services::validation();
        $school = new Schools();
        $validation->setRules(['val-id' => 'required', 'val-schoolname' => 'required', 'val-npsn' => 'required', 'val-address' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
        }
        $id = $this->request->getPost('val-id');

        $checkSchoolName = $school->where('schoolname',$this->request->getPost('val-schoolname'))->where('id !=',$id)->countAllResults();
        $isSchoolNameUnique = 1;
        if ($checkSchoolName > 0) {
            $errorMessage = 'School Name is already taken';
            $isSchoolNameUnique = 0;
        }


        $chechNpsn = $school->where('npsn',$this->request->getPost('val-npsn'))->where('id !=',$id)->countAllResults();
        $isNpsnUniquer = 1;
        if ($chechNpsn > 0) {
            $errorMessage = 'NPSN is already taken';
            $isNpsnUniquer = 0;
        }

        $upload = $this->request->getFile('val-logo');
        // dd($upload->isFile());
        $validated = true;
        if ($upload->isFile()) {
            $validated = $this->validate([
                'val-logo' => [
                    'uploaded[val-logo]',
                    'mime_in[val-logo,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[val-logo,4096]',
                ],
            ]);
            if (!$validated) {
                $errorMessage = 'Image does not comply requirement';
            }
        }



        // jika data valid, simpan ke database
        if($isDataValid && $isSchoolNameUnique && $isNpsnUniquer){
            if ($upload->isFile()) {
                $logo = $school->select('logo')->find($id);
                if ($logo['logo']!=='') {
                    if (file_exists('../public/assets/images/schools/'.$logo['logo'])) {
                        unlink('../public/assets/images/schools/'.$logo['logo']);
                    }
                }

                $mime = $upload->getClientExtension();
                $upload->move(WRITEPATH . '../public/assets/images/schools/',$this->request->getPost('val-schoolname').'.'.$mime);

                $school->update($id,[
                    "schoolname" => $this->request->getPost('val-schoolname'),
                    "npsn" => $this->request->getPost('val-npsn'),
                    "address" => $this->request->getPost('val-address'),
                    "telp" => $this->request->getPost('val-telp'),
                    "logo" => $upload->getName()
                ]);

            }else{
                $school->update($id,[
                        "schoolname" => $this->request->getPost('val-schoolname'),
                        "npsn" => $this->request->getPost('val-npsn'),
                        "address" => $this->request->getPost('val-address'),
                        "telp" => $this->request->getPost('val-telp')
                    ]);
            }

            $this->db->table('bookmarks')->where('school_id',$id)->delete();


            $this->db->table('bookmarks')->insert([
                'user_id' => $this->request->getPost('val-pengawas'),
                'school_id' => $id,
            ]);

            $log_activities = new LogActivities();
            $log_data = [
                'tables_name' => 'schools',
                'description' => 'Update data school',
                'before' => '',
                'after' => $id,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $this->session->get('user_id'),
                'active' => 1
            ];
    
            $log_activities->insert_log($log_data);

                return redirect('master/school/list');        
        }
		
        // tampilkan form create
        // echo view('admin_create_news');

        return $this->edit($id,$errorMessage);

    }


    public function delete($id){
        $school = new Schools();
        $school->delete($id);
        $data['code'] = 200;
        $data['message'] = 'success';
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'schools',
            'description' => 'Delete data school',
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
        $school = new Schools();
        $data['data']['school'] = $school->join('users','schools.id = users.school_id','left')->find($id);
        $data['data']['pengawas'] = $this->db->table('bookmarks')->join('users','bookmarks.user_id = users.id')->where('bookmarks.school_id',$id)->limit(1)->get()->getResult();
        $data['data']['last_evaluation'] = $this->db->table('evaluations as e')->join('criterias as c','e.criteria_id=c.id')->select('e.id, e.date, e.score, c.notes')->where('school_id',$id)->orderBy('date','desc')->limit(1)->get()->getResult();
        $data['code'] = 200;
        $data['message'] = 'success';
        if (!file_exists('../public/assets/images/schools/'.$data['data']['school']['logo'])||$data['data']['school']['logo']=='') {
            $data['data']['school']['logo'] = 'profile-placeholder.png';
        }

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'schools',
            'description' => 'View data school',
            'before' => '',
            'after' => $id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        return json_encode($data);
    }


    public function bookmark(){
        $validation =  \Config\Services::validation();
        $validation->setRules(['user_id' => 'required', 'school_id' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        $errorMessage = "school successfully bookmarked";
        $code = 200;
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
            $code = 500;
        }

        $user_id = $this->request->getPost('user_id');
        $school_id = $this->request->getPost('school_id');

        $cekData = $this->db->table('bookmarks')->where('school_id',$school_id)->countAllResults();

        if($isDataValid && $cekData==0){
            $insert = $this->db->table('bookmarks')->insert([
                "user_id" => $this->request->getPost('user_id'),
                "school_id" => $this->request->getPost('school_id'),
            ]);

            $code = ($this->db->affectedRows() != 1) ? 500 : 200;
            if ($code == 500) {
                $errorMessage = "Failed to insert";
            }
        }else{
            $code = 500;
            $errorMessage = "School already have supervisor";
        }
        $data['code'] = $code;
        $data['message'] = $errorMessage;
        $bookmark_id = $this->db->insertID();
        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'bookmarks',
            'description' => 'Bookmark school',
            'before' => '',
            'after' => $bookmark_id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);


        return json_encode($data);
    }


    public function unbookmark(){
        $validation =  \Config\Services::validation();
        $validation->setRules(['bookmark_id' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        $errorMessage = "School unbookmarked";
        $code = 200;
        if (!$isDataValid) {
            $errorMessage = 'Input is Required';
            $code = 500;
        }

        $bookmark_id = $this->request->getPost('bookmark_id');

        if($isDataValid){
            $delete = $this->db->table('bookmarks')->where('id',$bookmark_id)->delete();

            $code = ($this->db->affectedRows() != 1) ? 500 : 200;
            if ($code == 500) {
                $errorMessage = "Failed to insert";
            }
        }

        $log_activities = new LogActivities();
        $log_data = [
            'tables_name' => 'bookmarks',
            'description' => 'Delete Bookmark school',
            'before' => '',
            'after' => $bookmark_id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_by' => $this->session->get('user_id'),
            'active' => 1
        ];

        $log_activities->insert_log($log_data);

        $data['code'] = $code;
        $data['message'] = $errorMessage;
        return json_encode($data);
    }



}
