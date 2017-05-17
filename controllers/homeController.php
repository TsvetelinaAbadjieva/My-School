<?php


class HomeController extends CI_Controller{

    const PATH = 'http://mylocal.dev/MyPHP_files/school/index.php/';
    const IMAGE_PATH = "http://mylocal.dev/MyPHP_files/school/index.php/application/assets/uploads/images/";
    private $path;
    private $image_path;
    public $model=null;
    public function __construct()
    {
        parent::__construct();
        $model=$this->load->model('Models','model');
        $this->model= Models::getInstance();
        $path=self::PATH;
        $image_path=self::IMAGE_PATH;
    }

    public function index(){

       // _autoload();
       return $this->load->view('homepage');

   }

   public function getHomePage(){
       return $this->load->view('homepage');
   }
    public function postHomePage(){

       //unlink($this->image_path."44f9925502c8517e43b1215e067b96ebde842459.jpg");
        $user=[];
        $userdata=[
            'username' =>'',
            'password'=>'',
            'person_id'=>'',
            'role'=>'',
            'logged_in'=>0,
            'student_id'=>0,
            'profile'=>[],
            'subject'=>[],
            'active_subject'=>'',
            'degree'=>[],
            'class'=>[],
            'mydegree'=>0,
            'myclass'=>''
        ];
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation']);

        $this->form_validation->set_message("required","Полето е задължително");
        $this->form_validation->set_message('min_length[5]',"Полето трябва да е поне 5 символа");
        $this->form_validation->set_message('max_length[255]',"Полето трябва да е не повече от 255 символа");
        $this-> form_validation->set_message('valid_email',"Невалиден формат за имейл");
        $this->form_validation->set_message('checkUserCredentials',"Невалидни потребителски данни");
        $this->form_validation->set_message('username_check',"Невалидни потребителски данни");

        $user['username']=$this->input->post('username');
        $user['password']=$this->input->post('password');

        $username=htmlspecialchars(trim($user['username']),ENT_QUOTES,'UTF-8');
        $password=htmlspecialchars(trim($user['password']),ENT_QUOTES,'UTF-8');


        $this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[255]|valid_email|callback_username_check["$username"]');//
        $this->form_validation->set_rules('password','Password','trim|required|min_length[5]|max_length[255]');//|callback_checkUserCredentials["$username", "$password"]

        if($this->form_validation->run()===false){

                $this->load->view('homepage');
        }
        else {
            $this->load->model('Models', 'model');
            if (!$this->model->checkUserCredentials($username, $password))
                $this->load->view('homepage');
            else {

                $userdata= $this->model->getUserDetails($username);
                $userdata['logged_in']=1;
                $this->session->set_userdata($userdata);
                $this->session->unset_userdata('password');

                echo $this->session->set_flashdata('success',"$username, Вие влязохте успешно в системата! ");
                echo "<span class='alert-success'><h3>.{$this->session->flashdata('success')}.</h3></span>";

                if($this->session->userdata('role')=='guest'){
                    $civilnum=sha1($password);

                    $id=$this->model->getStudentByCivilnum($civilnum);
                    //$this->getMainPage();
                }

                $this->session->unset_userdata('password');
                return $this->getMainPage();
            }

        }
    }
    function loadMainPage()
    {
      return  $this->load->view('mainpage');
    }
    function username_check($username){
        $this->load->model('Models', 'model');
        if($this->model->checkExistingUser($username))
           return true;
        else

           return false;

    }
    public function getMainPage(){
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1)
            return   $this->getHomePage();
        return $this->load->view('mainpage');
    }

    public function addTeacher(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1 || $this->session->userdata('role')!='admin')
            return   $this->getHomePage();

        else {
           // $this->load->view('mainpage');
           return $this->load->view('add');
        }
    }

    public function getEditTeacher()//извлича цялата информация за учител от базата
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return  $this->getHomePage();

        $subjects=[];

        $classes_subject =[
            'first_subj'=>[],
            'second_subj'=>[]
        ];
        $data['data'] =[
            'id'=>0,
            'civilnum'=>0,
            'first_name'=>'',
            'middle_name'=>'',
            'last_name'=>'',
            'address'=>'',
            'tel'=>'',
            'email'=>'',
            'date_of_birth'=>'',
            'subject'=>'',
            'subject2'=>'',
            'subjects'=> '', // предметите от профила на учителя, без повторения
            'first_subj_deg'=> [], //степените, в които се преподава първи предмет
            'first_subj_class'=> [],//паралелките, в които се преподава първи  предмет
            'second_subj_deg'=> [],//степените, в които се преподава втори предмет от профила на учител, ако има такъв
            'second_subj_class'=>[],//паралелките, в които се преподава втори предмет от профила на учител, ако има такъв
            'responsible_deg'=>0,// калсно ръководство- степен
            'responsible_class'=>''// калсно ръководство- паралелка
        ];
        $id=isset($_GET['id'])?$_GET['id']:1;
        $id=htmlspecialchars((int)$id,ENT_QUOTES);
        if($id<=0)
            $this->load->view('teachersList');

        $this->load->model("Models",'model');

        if($this->model->getTeacherById($id)) {
            $teacher=$this->model->getTeacherbyId($id);
            $classes=$this->model->getTeachersClassesById($id);
            $i=0;
            for($i=0;$i<count($classes);$i++) {
                $subjects[]= $classes[$i]['subject'];
                if($classes[$i]['responsible']==1){
                    $degree=$classes[$i]['degree'];
                    $class=$classes[$i]['class'];
                }

            }

            $subjects=array_unique($subjects);
            foreach($subjects as $key =>$subject)
                $subj[]=$subject;

                $classes_subject=[
                    'first_subj'=>[
                        'degree'=>[],
                        'class'=>[],
                    ],
                    'second_subj'=>[
                        'degree'=>[],
                        'class'=>[],
                    ],
                ];

                $classes_subject=$this->model->getClassesById_Subject($id,$subj);// взема класовете с преподаване на конкретен предмет
                if(empty($classes_subject)){
                    $classes_subject['first_subj']=[];
                    $classes_subject['second_subj']=[];
                }
                else
               // $classes_subject['second_subject']=$this->model->getClassesById_Subject($id,$subjects)['second_subject'];
            $data['data'] =[
                'id'=>$teacher[0]['teacher_id'],
                'civilnum'=>$teacher[0]['civilnum'],
                'first_name'=>$teacher[0]['first_name'],
                'middle_name'=>$teacher[0]['middle_name'],
                'last_name'=>$teacher[0]['last_name'],
                'address'=>$teacher[0]['address'],
                'tel'=>$teacher[0]['tel'],
                'email'=>$teacher[0]['email'],
                'date_of_birth'=>$teacher[0]['date_of_birth'],
                'subject'=>$teacher[0]['subject'],
                'subject2'=>$teacher[0]['subject2'],
                'subjects'=> $subj, // предметите от профила на учителя
                'first_subj_deg'=> $classes_subject['first_subj']['degree'], //паралелките, в които се преподава даден предмет
                'first_subj_class'=> $classes_subject['first_subj']['class'],
                'second_subj_deg'=> $classes_subject['second_subj']['degree'],
                'second_subj_class'=> $classes_subject['second_subj']['class'],
                'responsible_deg'=>$degree,
                'responsible_class'=>$class


            ];

            return $this->load->view('editTeacher', $data);
        }
        else{
            return $this->getTeachersList(0);
        }
    }


        public function retrieveTeacherData()//извлича информация за учител и паралелки за detailview
        {
            $subjects=[];

            $classes_subject =[
                'first_subj'=>[],
                'second_subj'=>[]
            ];
            $data['data'] =[
                'id'=>0,
                'civilnum'=>0,
                'first_name'=>'',
                'middle_name'=>'',
                'last_name'=>'',
                'address'=>'',
                'tel'=>'',
                'email'=>'',
                'date_of_birth'=>'',
                'subject'=>'',
                'subject2'=>'',
                'subjects'=> '', // предметите от профила на учителя, без повторения
                'first_subj_deg'=> [], //степените, в които се преподава първи предмет
                'first_subj_class'=> [],//паралелките, в които се преподава първи  предмет
                'second_subj_deg'=> [],//степените, в които се преподава втори предмет от профила на учител, ако има такъв
                'second_subj_class'=>[],//паралелките, в които се преподава втори предмет от профила на учител, ако има такъв
                'responsible_deg'=>0,// калсно ръководство- степен
                'responsible_class'=>''// калсно ръководство- паралелка
            ];
            $degree='';
            $class='';
            $id=htmlspecialchars((int)$_GET['id'],ENT_QUOTES);
            if($id<=0)
                $this->load->view('teachersList');

            $this->load->model("Models",'model');

            if($this->model->getTeacherById($id)) {
                $teacher=$this->model->getTeacherbyId($id);
                $classes=$this->model->getTeachersClassesById($id);

                $i=0;
                for($i=0;$i<count($classes);$i++) {
                    $subjects[]= $classes[$i]['subject'];
                    if($classes[$i]['responsible']==1){
                        $degree=$classes[$i]['degree'];
                        $class=$classes[$i]['class'];
                    }

                }

                $subjects=array_unique($subjects);
                foreach($subjects as $key =>$subject)
                    $subj[]=$subject;

                $classes_subject['first_subj']['degree']=[];
                $classes_subject['first_subj']['class']=[];

                $classes_subject['second_subj']['degree']=[];
                $classes_subject['second_subj']['class']=[];

                $classes_subject=$this->model->getClassesById_Subject($id,$subj);

                if(empty($classes_subject)){
                    $classes_subject['first_subj']['degree']=[];
                    $classes_subject['first_subj']['class']=[];

                    $classes_subject['second_subj']['degree']=[];
                    $classes_subject['second_subj']['class']=[];

                }
                else
                    $data['data'] =[
                        'id'=>$teacher[0]['teacher_id'],
                        'civilnum'=>$teacher[0]['civilnum'],
                        'first_name'=>$teacher[0]['first_name'],
                        'middle_name'=>$teacher[0]['middle_name'],
                        'last_name'=>$teacher[0]['last_name'],
                        'address'=>$teacher[0]['address'],
                        'tel'=>$teacher[0]['tel'],
                        'email'=>$teacher[0]['email'],
                        'date_of_birth'=>$teacher[0]['date_of_birth'],
                        'subject'=>$teacher[0]['subject'],
                        'subject2'=>$teacher[0]['subject2'],
                        'subjects'=> $subj, // предметите от профила на учителя
                        'first_subj_deg'=> ($classes_subject['first_subj']!=null)?$classes_subject['first_subj']['degree']:[], //паралелките, в които се преподава даден предмет
                        'first_subj_class'=> ($classes_subject['first_subj']!=null)?$classes_subject['first_subj']['class']:[],
                        'second_subj_deg'=> ($classes_subject['second_subj']!=null)?$classes_subject['second_subj']['degree']:[],
                        'second_subj_class'=> ($classes_subject['second_subj']!=null)?$classes_subject['second_subj']['class']:[],
                        'responsible_deg'=>$degree,
                        'responsible_class'=>$class


                    ];

                return $data;
            }
            else
                return false;

        }

    public function getTeacherDetails(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            $this->getHomePage();

        $id=htmlspecialchars((int)$_GET['id'],ENT_QUOTES);
        if($id<=0)
            $this->load->view('teachersList');

            if(!$data=$this->retrieveTeacherData())
                return $this->getTeachersList(0);
            else
                $this->load->view('teacherDetails',$data);

    }

    public function getTeachersFormForEdit()// извлича информацията за учител по id  и извиква формата
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return   $this->getHomePage();

        $id=htmlspecialchars((int)$_GET['id'],ENT_QUOTES);
        if($id<=0)
            $this->load->view('teachersList');

        if(! $data=$this->retrieveTeacherData())
            return $this->getTeachersList(0);
        else {

            $this->load->view('editTeacherDetails', $data);
        }

    }

    public function editTeacher()// прави update в базата по данните от формата
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return  $this->getHomePage();

        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation']);

        $id = htmlspecialchars((int)$_GET['id'], ENT_QUOTES);
        if ($id <= 0)
            $this->load->view('teachersList');

        $classes[] = [
            'degree' => 0,
            'class' => '',
            'subject' => '',
            'responsible' => 0,

        ];
        $responsible=[];
        $responsible_deg=0;
        $responsible_class='';
        $isResponsible=0;


        if (!empty($this->input->post('responsible')) && $this->input->post('responsible')!= "--") {
            $responsible = explode(" ", $this->input->post('responsible'));
            $responsible_deg=$responsible[0];
            $responsible_class=$responsible[1];
            $isResponsible=1;

        }


        $first_subj_deg=[];
        $first_subj_class=[];
        $second_subj_deg=[];
        $second_subj_class=[];

        $count=0;
        $subject=htmlspecialchars(trim($this->input->post('subject')), ENT_QUOTES);
        $subject2=htmlspecialchars(trim($this->input->post('subject2')), ENT_QUOTES);
        if (!empty($this->input->post('first_class')))
            foreach ($this->input->post('first_class') as $class) {
                $exploded=[];
                $exploded=explode(" ", $class);
                $classes[$count]['degree']=$exploded[0];
                $classes[$count]['class']=$exploded[1];
                $classes[$count] ['subject']=$subject;// към базата

                $first_subj_deg[]=$exploded[0];//към вюто
                 $first_subj_class[]=$exploded[1];
                if($exploded[0]==$responsible_deg && $exploded[1]==$responsible_class)
                    $classes[$count]['responsible']=1;
                else $classes[$count]['responsible']=0;
                $count++;

            }

        //$count=0;
        if (!( empty($this->input->post('second_class'))&& empty($subject2) ))

            foreach ($this->input->post('second_class') as $class) {
                    $exploded=[];
                    $exploded=explode(" ", $class);
                    $classes[$count]['degree']=$exploded[0];
                    $classes[$count]['class']=$exploded[1];
                    $classes[$count] ['subject']=$subject2;
                    $second_subj_deg[]=$exploded[0];
                    $second_subj_class[]=$exploded[1];
                    if($exploded[0]== $responsible_deg && $exploded[1]==$responsible_class)
                        $classes[$count]['responsible']=1;
                    else $classes[$count]['responsible']=0;
                    $count++;
                }
           // $classes[$count]['responsible']=$isResponsible;


        $data['data'] = [
            'id'=>$id,
            'teacher_id'=>$id,
            'civilnum' => htmlspecialchars(trim($this->input->post('civilnum')), ENT_QUOTES),
            'first_name' => htmlspecialchars(trim($this->input->post('first_name')), ENT_QUOTES),
            'middle_name' => htmlspecialchars(trim($this->input->post('middle_name')), ENT_QUOTES),
            'last_name' => htmlspecialchars(trim($this->input->post('last_name')), ENT_QUOTES),
            'address' => htmlspecialchars(trim($this->input->post('address')), ENT_QUOTES),
            'date_of_birth' => htmlspecialchars(trim($this->input->post('date_of_birth')), ENT_QUOTES),
            //'position' => 'учител',
            'tel' => htmlspecialchars(trim($this->input->post('tel')), ENT_QUOTES),
            'email' => htmlspecialchars(trim($this->input->post('email')), ENT_QUOTES),
            // 'is_deleted' => 0,
            'subject' => htmlspecialchars(trim($this->input->post('subject')), ENT_QUOTES),
            'subject2' => htmlspecialchars(trim($this->input->post('subject2')), ENT_QUOTES),
            'subjects'=>[htmlspecialchars(trim($this->input->post('subject')), ENT_QUOTES),htmlspecialchars(trim($this->input->post('subject2')), ENT_QUOTES)],
            'responsible_deg'=>$responsible_deg,
            'responsible_class'=>$responsible_class,
            'first_subj_deg'=> $first_subj_deg,
            'first_subj_class'=> $first_subj_class,
            'second_subj_deg'=>$second_subj_deg,
            'second_subj_class'=>$second_subj_class

        ];

        $baseInfo=[
            'id'=>$id,
            'teacher_id'=>$id,
            'civilnum' => htmlspecialchars(trim($this->input->post('civilnum')), ENT_QUOTES),
            'first_name' => htmlspecialchars(trim($this->input->post('first_name')), ENT_QUOTES),
            'middle_name' => htmlspecialchars(trim($this->input->post('middle_name')), ENT_QUOTES),
            'last_name' => htmlspecialchars(trim($this->input->post('last_name')), ENT_QUOTES),
            'address' => htmlspecialchars(trim($this->input->post('address')), ENT_QUOTES),
            'date_of_birth' => htmlspecialchars(trim($this->input->post('date_of_birth')), ENT_QUOTES),
            //'position' => 'учител',
            'tel' => htmlspecialchars(trim($this->input->post('tel')), ENT_QUOTES),
            'email' => htmlspecialchars(trim($this->input->post('email')), ENT_QUOTES),
            // 'is_deleted' => 0,
            'subject' => htmlspecialchars(trim($this->input->post('subject')), ENT_QUOTES),
            'subject2' => htmlspecialchars(trim($this->input->post('subject2')), ENT_QUOTES)

        ];

        if ($this->validateTeacherData()) {
            $this->load->model('Models', 'model');
                $flag=true;
                if(!$this->model->updateBaseInfo($id,$baseInfo)) $flag=false;
                $this->load->model('Models', 'model');
                if(!$this->model->updateClasses($id, $classes)) $flag=false;
                if($flag){
                $this->showMessage('success',"Промяната е направена!");
                return $this->getTeachersList(0);
            }else {
                //$data['data']=$data;
                $this->showMessage('danger',"Промяната НЕ Е направена!");
               // $data['data']=$data;
                return  $this->load->view('editTeacherDetails',$data);
            }

        }else  {
                    //$data['data']=$data;
                    $this->showMessage('danger',"Промяната НЕ Е направена!");
                   return $this->load->view('editTeacherDetails',$data);
        }
    }

    public function postTeacher()
        //записва нов учител в БД без да създава паралелки (само обща инфо-в таблици person, teacher, user)
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return $this->getHomePage();

        $data=[
            'civilnum'=>    htmlspecialchars(trim($this->input->post('civilnum')),ENT_QUOTES),
            'first_name'=>  htmlspecialchars(trim($this->input->post('first_name')),ENT_QUOTES),
            'middle_name'=> htmlspecialchars(trim($this->input->post('middle_name')),ENT_QUOTES),
            'last_name'=>   htmlspecialchars(trim($this->input->post('last_name')),ENT_QUOTES),
            'address'=>     htmlspecialchars(trim($this->input->post('address')),ENT_QUOTES),
            'date_of_birth'=>htmlspecialchars(trim($this->input->post('date_of_birth')),ENT_QUOTES),
            'position'=>    'учител',
            'tel'=>         htmlspecialchars(trim($this->input->post('tel')),ENT_QUOTES),
            'email'=>       htmlspecialchars(trim($this->input->post('email')),ENT_QUOTES),
            'is_deleted'=>  0,
            'subject'=>    htmlspecialchars(trim($this->input->post('subject')),ENT_QUOTES),
            'subject2'=>    htmlspecialchars(trim($this->input->post('subject2')),ENT_QUOTES),
            'username'=>   htmlspecialchars(trim($this->input->post('email')),ENT_QUOTES),
            'password'=>    sha1($this->randomPassword()),
            'role'=>        'учител'
        ];
        if($this->validateTeacherData()) {
            $this->load->model('Models','model');

            if($this->model->checkExistingPerson($data)) {

                $this->model->insertTeacher($data);

                $this->session->set_flashdata('success',"Записът е успешно добавен в системата! ");
                echo "<span class='alert-success'><h3>{$this->session->flashdata('success')}</h3></span>";
                $this->addTeacher();
            }
            else {
                $this->session->set_flashdata("error","Записът съществува в Базата Данни!");
                echo "<span class='alert-danger'><h3>{$this->session->flashdata('error')}</h3></span>";
                $this->load->view('add');
            }
        }
            else $this->load->view('add');
    }

    public function validateTeacherData()
    {
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation']);

        $this->form_validation->set_message("required","Полето е задължително");
        $this->form_validation->set_message('min_length[2]',"Полето трябва да е поне 3 символа");
        $this->form_validation->set_message('max_length[255]',"Полето трябва да е не повече от 255 символа");
        $this-> form_validation->set_message('valid_email',"Невалиден формат за имейл");
        $this->form_validation->set_message('integer',"Очакват се числови данни данни");
        $this->form_validation->set_message('exact_length[10]',"Невалидно ЕГН");
        $this->form_validation->set_message('username_check',"Невалидни потребителски данни");

        $this->form_validation->set_rules('civilnum','Civilnum','trim|required|integer|exact_length[10]');
        $this->form_validation->set_rules('first_name','First_name','trim|required|min_length[2]|max_length[255]');
        $this->form_validation->set_rules('middle_name','Middle_name','trim|required|min_length[2]|max_length[255]');
        $this->form_validation->set_rules('last_name','Last_name','trim|required|min_length[2]|max_length[255]');
        $this->form_validation->set_rules('address','Address','trim|required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('date_of_birth','Date_of_birth','trim|required','valid_date');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[5]|valid_email|max_length[255]');
        $this->form_validation->set_rules('tel','Tel','trim|required|min_length[5]|max_length[20]');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[5]|valid_email|max_length[255]');
        $this->form_validation->set_rules('subject','Subject','trim|required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('subject2','Subject2','trim|min_length[5]|max_length[255]');

        if($this->form_validation->run()===false){

            return false;
        }
        else return true;
    }

    public function validateStudentData()
    {
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation','upload']);
        //$this->load->library('upload');

        $this->form_validation->set_message("required","Полето е задължително");
        $this->form_validation->set_message('min_length[2]',"Полето трябва да е поне 3 символа");
        $this->form_validation->set_message('max_length[255]',"Полето трябва да е не повече от 255 символа");
        $this->form_validation->set_message('valid_email',"Невалиден формат за имейл");
        $this->form_validation->set_message('integer',"Очакват се числови данни данни");
        $this->form_validation->set_message('exact_length[10]',"Невалидно ЕГН");
        $this->form_validation->set_message('username_check',"Невалидни потребителски данни");
        $this->form_validation->set_message('username_check',"Невалидни потребителски данни");
        $this->form_validation->set_message('is_unique',"Този файл вече съществува");

        if($this->input->post('class')=="Клас"){
            $this->form_validation->set_message('required_class',"Не е избран Клас");
            $this->form_validation->set_rules('class','Class','required_class');
        }
        if($this->input->post('number')=="Номер"){
            $this->form_validation->set_message('required_number',"Не е избран Номер");
            $this->form_validation->set_rules('number','Number','required_number');
        }



        $this->form_validation->set_rules('civilnum','Civilnum','trim|required|integer|exact_length[10]');
        $this->form_validation->set_rules('first_name','First_name','trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('middle_name','Middle_name','trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('last_name','Last_name','trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('address','Address','trim|required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('date_of_birth','Date_of_birth','trim|required','valid_date');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email|max_length[255]');
        $this->form_validation->set_rules('tel','Tel','trim|required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('email','Email','trim|required|min_length[4]|valid_email|max_length[255]');

        $this->form_validation->set_rules('p_first_name','P_First_name','trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('p_last_name','P_last_name','trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('p_email','Email','trim|required|min_length[4]|valid_email|max_length[255]');
        $this->form_validation->set_rules('p_tel','Tel','trim|required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('p_address','Address','trim|required|min_length[5]|max_length[255]');


        if($this->form_validation->run()===false){

            return false;
        }
        elseif(!empty(array_filter($this->fileUploadValidation()))){
            $errors['upload']=$this->fileUploadValidation();
            $this->load->view('addStudent',$errors);
            return false;
        }

        else return true;
    }
/*
    public function validateUpload(){

        $path=__DIR__."/../assets/uploads/images/";
        if(!is_dir($path))
            mkdir($path);
        $config['upload_path']=$path;
        $config['max_size']=100*1025;
        $config['allowed_types']='png|jpg|jpeg|gif';
        $config['overwrite']=false;
        //$config['encrypt_name']=true;
       // $this->load->library('form_validation');
        $this->load->library('upload',$config);


        if(isset($_FILES['file_img']) && strlen($_FILES['file_img']['name'])>0) {
          // $_FILES['file_img']['name'] = sha1(htmlspecialchars(trim( $_FILES['file_img']['name']),ENT_QUOTES));
           if(!$this->upload->do_upload('file_img')){
               $this->form_validation->set_message('upload_path',"Файлът е прекалено голям");

               $this->form_validation->set_message('max_size',"Файлът е прекалено голям");
               $this->form_validation->set_message('allowed_types',"Типът на файла не отговаря -png, jpg, jpeg,gif");
              // $this->form_validation->set_message('overwrite',"Файлът съществува");
               $this->form_validation->set_rules('file_img','FileFormat','trim|max_size|allowed_type|overwrite|upload_path');

echo '<pre>';
var_dump($this->upload->display_errors());
echo '</pre>';
               $this->form_validation->set_message('file_img',$this->upload->display_errors());
               $this->form_validation->set_rules('file_img','FileUpload','file_img');

               return false;
           }
            else {
                $this->upload->do_upload('file_img');
                return true;
            }


        }
        else {
            $this->form_validation->set_message('empty',"Не е избран файл");
            $this->form_validation->set_rules('file_img','Empty','empty');
            return false;
        }

    }
*/

    public function fileUploadValidation(){

        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');

        if($this->input->post('edit')!=null)
            $notRequired=true;
        else $notRequired=false;

        $errors['upload']=[];

        $this->form_validation->set_rules('file_img','Upload','max_size|alowed_types|empty');
        if(isset($_FILES['file_img']) && strlen($_FILES['file_img']['name'])>0){

            $fname_ext=explode('.',htmlspecialchars(trim($_FILES['file_img']['name']),ENT_QUOTES));
            $ext=strtolower(end($fname_ext));


            if($_FILES['file_img']['size']> 150*1024){
                $this->form_validation->set_message('max_size',"Размерър на файла е над допустимия");
                $this->form_validation->set_rules('file_img','Upload','max_size');
                $errors['upload']="Размерът на файла е над допустимия";
                //return false;
            }
            if(!in_array($ext,['jpg','jpeg','png','gif'])){
                $this->form_validation->set_message('allowed_types',"Допустими разширения са jpg, jpeg, png, gif");
                $this->form_validation->set_rules('file_img','Upload','allowed_types');
                $errors['upload']="Допустими разширения са jpg, jpeg, png, gif";
                //return false;
            }
            if($_FILES['file_img']['size']==0){
                $this->form_validation->set_message('empty',"Файлът е празен");
                $this->form_validation->set_rules('file_img','Upload','empty');
                $errors['upload']="Файлът е празен";
                //return false;
            }
            //return true;

        }
        else{
            if($notRequired) return $errors;
            else {
                $this->form_validation->set_message('empty_field', "Липсва прикачен файл");
                $this->form_validation->set_rules('file_img', 'Upload', 'empty_field');
                $errors['upload'] = "Липсва прикачен файл";
                //return false;
            }
        }
        return $errors;
    }

    public function prepareImageForInsert(){

       //unlink($path)-Изтрива физически снимка от файловата система на компютъра

       $dir=__DIR__."/../assets/uploads/images/";
      //  if($this->validateUpload()){

            if(!is_dir($dir))
               mkdir($dir);

            $fname_ext=explode('.',htmlspecialchars(trim(strtolower($_FILES['file_img']['name'])),ENT_QUOTES));
            $ext=strtolower(end($fname_ext));
            $file_name=sha1(time());
            $full_file_name=$file_name.".".$ext;
            move_uploaded_file($_FILES['file_img']['tmp_name'],$dir.$full_file_name);
            return $full_file_name;
      //  }
       // else return false;

    }
public function postStudent(){

        if($this->input->post('class')!='Клас'){
            $a=explode(" ",$this->input->post('class'));
            $degree=$a[0];
            $class=end($a);
        }
        else{
            $degree=0;
            $class='';
        }
    if($this->input->post('number')!='номер')
        $number=$this->input->post('number');


    $data=[
        'civilnum'      =>  htmlspecialchars(trim($this->input->post('civilnum')),ENT_QUOTES),
        'first_name'    =>  htmlspecialchars(trim($this->input->post('first_name')),ENT_QUOTES),
        'middle_name'   =>  htmlspecialchars(trim($this->input->post('middle_name')),ENT_QUOTES),
        'last_name'     =>  htmlspecialchars(trim($this->input->post('last_name')),ENT_QUOTES),
        'address'       =>  htmlspecialchars(trim($this->input->post('address')),ENT_QUOTES),
        'date_of_birth'=>   htmlspecialchars(trim($this->input->post('date_of_birth')),ENT_QUOTES),
        'position'      =>  'ученик',
        'tel'           =>  htmlspecialchars(trim($this->input->post('tel')),ENT_QUOTES),
        'email'         =>  htmlspecialchars(trim($this->input->post('email')),ENT_QUOTES),
        'file_img'      =>  htmlspecialchars(trim($this->input->post('file_img')),ENT_QUOTES),
        'degree'        =>  $degree,
        'class'         =>  $class,
        'number'        =>  $number,
        'is_deleted'    =>  0,
        'p_first_name'   =>  htmlspecialchars(trim($this->input->post('p_first_name')),ENT_QUOTES),
        'p_last_name'   =>  htmlspecialchars(trim($this->input->post('p_last_name')),ENT_QUOTES),
        'p_email'       =>  htmlspecialchars(trim($this->input->post('p_email')),ENT_QUOTES),
        'p_tel'         =>  htmlspecialchars(trim($this->input->post('p_tel')),ENT_QUOTES),
        'p_address'     =>  htmlspecialchars(trim($this->input->post('p_address')),ENT_QUOTES),
        'username'      =>  htmlspecialchars(trim($this->input->post('p_email')),ENT_QUOTES),
        'password'      =>  sha1(htmlspecialchars(trim($this->input->post('civilnum')),ENT_QUOTES)),
        'role'          =>  'guest'
    ];
    if($this->validateStudentData()) {

        $data['file_img']=$this->prepareImageForInsert();
        $this->load->model('Models','model');

        if($this->model->checkExistingPerson($data)) {

            $this->model->insertStudent($data);

            $this->session->set_flashdata('success',"Записът е успешно добавен в системата! ");
            echo "<span class='alert-success'><h3>{$this->session->flashdata('success')}</h3></span>";
            $this->addStudent();
        }
        else {
            $this->session->set_flashdata("error","Записът съществува в Базата Данни!");
            echo "<span class='alert-danger'><h3>{$this->session->flashdata('error')}</h3></span>";
            $this->load->view('addStudent',$data);
        }
    }
    else {
        $this->showMessage('error','Невалидни данни!');
        $this->load->view('addStudent',$data);
    }

}
    public function getStudentForEdit(){

    if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||($this->session->userdata('role')!='admin'&& $this->session->userdata('role')!='teacher'))
        return $this->getHomePage();

        $id = htmlspecialchars((int)$_GET['id'], ENT_QUOTES);
        if ($id <= 0)
            $this->load->view('studentsList');

        $data=$this->model->getStudentById($id);
        $data[0]['file_img']=$data[0]['picture'];

        $this->load->view('addStudent',$data[0]);
    }

    public function dispatchPostEditStudent()
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||($this->session->userdata('role')!='admin'&& $this->session->userdata('role')!='teacher'))
            return $this->getHomePage();



        if($this->input->post('submit')!=null)
           return $this->postStudent();

        $id = htmlspecialchars((int)$_GET['id'], ENT_QUOTES);
        if ($id <= 0)
            $this->load->view('studentsList');
        elseif($this->input->post('edit')!=null)
            return $this->editStudent($id);
    }
    public function editStudent($id){

         if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||($this->session->userdata('role')!='admin'&& $this->session->userdata('role')!='teacher'))
           return $this->getHomePage();

        $id = htmlspecialchars((int)$_GET['id'], ENT_QUOTES);
        if ($id <= 0)
            $this->load->view('studentsList');

        if($this->input->post('class')!='Клас'){
            $a=explode(" ",$this->input->post('class'));
            $degree=$a[0];
            $class=end($a);
        }
        else{
            $degree=0;
            $class='';
        }
        if($this->input->post('number')!='номер')
            $number=$this->input->post('number');


        $data=[
            'id'            =>$id,
            'student_id'    =>$id,
            'civilnum'      =>  htmlspecialchars(trim($this->input->post('civilnum')),ENT_QUOTES),
            'first_name'    =>  htmlspecialchars(trim($this->input->post('first_name')),ENT_QUOTES),
            'middle_name'   =>  htmlspecialchars(trim($this->input->post('middle_name')),ENT_QUOTES),
            'last_name'     =>  htmlspecialchars(trim($this->input->post('last_name')),ENT_QUOTES),
            'address'       =>  htmlspecialchars(trim($this->input->post('address')),ENT_QUOTES),
            'date_of_birth'=>   htmlspecialchars(trim($this->input->post('date_of_birth')),ENT_QUOTES),
            'position'      =>  'ученик',
            'tel'           =>  htmlspecialchars(trim($this->input->post('tel')),ENT_QUOTES),
            'email'         =>  htmlspecialchars(trim($this->input->post('email')),ENT_QUOTES),
            'file_img'      =>  htmlspecialchars(trim($_FILES['file_img']['name']),ENT_QUOTES),
            'degree'        =>  $degree,
            'class'         =>  $class,
            'number'        =>  $number,
            'is_deleted'    =>  0,
            'p_first_name'   =>  htmlspecialchars(trim($this->input->post('p_first_name')),ENT_QUOTES),
            'p_last_name'   =>  htmlspecialchars(trim($this->input->post('p_last_name')),ENT_QUOTES),
            'p_email'       =>  htmlspecialchars(trim($this->input->post('p_email')),ENT_QUOTES),
            'p_tel'         =>  htmlspecialchars(trim($this->input->post('p_tel')),ENT_QUOTES),
            'p_address'     =>  htmlspecialchars(trim($this->input->post('p_address')),ENT_QUOTES),
            'username'      =>  htmlspecialchars(trim($this->input->post('p_email')),ENT_QUOTES),
            'password'      =>  sha1(htmlspecialchars(trim($this->input->post('civilnum')),ENT_QUOTES)),
            'role'          =>  'guest'
        ];
        if($this->validateStudentData()) {

            if($data['file_img']!='' && $data['file_img']!=null) {
                $image=$this->model->getImageFile($id)[0]['picture'];
                if(file_exists("IMAGE_PATH.$image"))
                    unlink("IMAGE_PATH.$image");
                $data['file_img'] = $this->prepareImageForInsert();
            }

          //  $this->load->model('Models','model');

            $this->model->editStudent($id,$data);
            $this->showMessage('success','Промяната е направена!');
            $this->getStudentsList();

        }
        else {
            $this->showMessage('error','Невалидни данни!');
            $this->load->view('addStudent',$data);
        }


    }
    public function deleteTeacher(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
           return $this->getHomePage();

        $id=$_GET['id'];
        $id=htmlspecialchars(trim((int)$id),ENT_QUOTES);
        if((int)$id<=0)
            $this->getTeachersList(0);
        $this->load->model('Models','model');
        if($this->model->deleteTeacherById($id)) {
            $this->session->set_flashdata('success','Записът е изтрит!');
            echo "<span class='alert-success'><h3>{$this->session->flashdata('success')}</h3></span>";
            $this->getTeachersList(0);
        }
        else {
            $this->session->set_flashdata('danger','Записът НЕ МОЖЕ ДА БЪДЕ ИЗТРИТ!');
            echo "<span class='alert-danger'><h3>{$this->session->flashdata('danger')}</h3></span>";
            $this->session->unset_flashdata('danger');
            $this->getTeachersList(0);
        }

    }
    public function deleteStudent(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return $this->getHomePage();

        $id=$_GET['id'];
        $id=htmlspecialchars(trim((int)$id),ENT_QUOTES);
        if((int)$id<=0)
            $this->getTeachersList(0);
        $this->load->model('Models','model');
        $image=$this->model->getImageFile($id)[0]['picture'];
        if(file_exists("IMAGE_PATH.$image"))
        unlink("IMAGE_PATH.$image");

        if($this->model->deleteStudentById($id)) {
            $this->showMessage('success','Записът е изтрит от Базата данни!');
            $this->getStudentsList(0);
        }
        else {
            $this->showMessage('danger','Записът НЕ МОЖЕ ДА БЪДЕ ИЗТРИТ!');
            $this->getStudentsList(0);
        }

    }
  public  function search(){

        $this->session->unset_userdata('search');
        $search=$this->input->get_post('search',true);

            $search = htmlspecialchars(trim($this->input->post('search')));// ВРЪЩА МАСИВ!!!

       return $search;

    }
/*Извлича общия списък с учители - общата информация*/
    public function getTeachersList()
    {
        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='admin')
            return $this->getHomePage();

        $search='';
        $search=isset($_GET['search'])?$_GET['search']:'';
        $search=htmlspecialchars(trim($search),3);

        $data['data']=[
            'id'=>0,
            'first_name'=>'',
            'middle_name'=>'',
            'last_name'=>'',
            'civilnum'=>0,
            'address'=>'',
            'tel'=>'',
            'email'=>'',
            'date_of_birth'=>'',
            'subject'=>'',
            'subject2'=>''
        ];
        $rows_per_page=($this->input->get('rows_per_page')!=null)?(int)$this->input->get('rows_per_page'):5;
        $rows_per_page=(int)htmlspecialchars((trim($rows_per_page)),3);
        $total_rows=0;
        $total_pages=0;

        $page=isset($_GET['page'])?$_GET['page']:1;
        $page=(int)htmlspecialchars((trim($page)),3);
        if((int)$page<=0)
            $page = 1;





        $this->load->model('Models','model');
        $data['data']=$this->model->getTeacherslist(null,null,$search);
        $total_rows=count($data['data']);
        $data['data']=$this->model->getTeacherslist($page,$rows_per_page,$search);
        $total_pages=ceil($total_rows/$rows_per_page);

            $data['active_page']=$page;
            $data['search']= $search;
            $data['total_pages']=$total_pages;
            $data['rows_per_page']=$rows_per_page;

         $this->load->view('teachersList',$data);
        // $pagination= new Pagination($data['active_page'], $data['total_pages'],$data['currentURL'], $data['rows_per_page'],$data['search']);
        // $pagination->create();
        //$this->session->unset_userdata('search');
    }
    public function getStudentsList(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||($this->session->userdata('role')!='admin'&&$this->session->userdata('role')!='teacher' ))
            return $this->getHomePage();

        $search='';
        $search=isset($_GET['search'])?$_GET['search']:'';
        $search=str_replace('  ',' ',$search);
        $search=htmlspecialchars(trim($search),3);

        $data['data']=[
            'id'=>0,
            'first_name'=>'',
            'last_name'=>'',
            'degree'=>'',
            'class'=>'',
            'number'=>0,
            'notes'=>'',

        ];
        $rows_per_page=10;
        $total_rows=0;
        $total_pages=0;

        $page=isset($_GET['page'])?$_GET['page']:1;
        $page=htmlspecialchars((trim($page)),3);
        if((int)$page<=0)
            $page = 1;

        $rows_per_page=($this->input->get('rows_per_page')!=null)?(int)$this->input->get('rows_per_page'):5;
        $rows_per_page=htmlspecialchars((trim($rows_per_page)),3);



        $this->load->model('Models','model');
        $data['data']=$this->model->getStudentsList(null,null,$search);
        $total_rows=count($data['data']);
        $data['data']=$this->model->getStudentsList($page,$rows_per_page,$search);

        $total_pages=ceil($total_rows/$rows_per_page);

        $data['active_page']=$page;
        $data['search']= $search;
        $data['total_pages']=$total_pages;
        $data['rows_per_page']=$rows_per_page;

        $this->load->view('studentsList',$data);

    }

    public function getStudentsNotes(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='teacher')
            return $this->getHomePage();

        $id=isset($_GET['id'])? htmlspecialchars($_GET['id'],ENT_QUOTES):'';
        if((int)$id<=0) $id='';

        $search='';
        $search=isset($_GET['search'])?$_GET['search']:'';
        $search=htmlspecialchars((trim($search)),3);

        $data['data']=[
            'id'=>0,
            'first_name' =>'',
            'middle_name'=>'',
            'last_name'  =>'',
            'degree'    =>'',
            'class'     =>'',
            'picture'   =>'',
            'number'    =>0,
            'subject'   =>'',
            'notes'     =>''
        ];
        $rows_per_page=($this->input->get('rows_per_page')!=null)? (int)$this->input->get('rows_per_page'):5;
        $rows_per_page=htmlspecialchars((trim($rows_per_page)),3);

        $total_rows=0;
        $total_pages=0;

        $page=isset($_GET['page'])?htmlspecialchars(trim($_GET['page']),3):1;
        $page=htmlspecialchars((trim($page)),3);
        if((int)$page<=0)
            $page = 1;
        $subject=($this->input->get('profile')!=null)? htmlspecialchars(trim($this->input->get('profile')),3):  $this->session->userdata('active_subject');
       // $subject=$this->input->get('profile');
        $this->session->set_userdata('active_subject',$subject);
       // $subject=$this->session->userdata('active_subject');
        if(strpos($subject,' ')>0){
            $subject=strtolower(explode(' ',$subject)[0]);
        }

        $this->load->model('Models','model');
        $data['data']=$this->model->getStudentsNotes(null,null,$search,$subject);//$id
        $total_rows=count($data['data']);

        $data['data']=$this->model->getStudentsNotes($page,$rows_per_page,$search,$subject);//$id


        $total_pages=ceil($total_rows/$rows_per_page);

        $data['active_page']=$page;
        $data['search']= $search;
        $data['total_pages']=$total_pages;
        $data['rows_per_page']=$rows_per_page;
        $data['profile']=$subject;

        $this->load->view('getStudentsNotes',$data);

    }

    public function insertNote(){
    if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='teacher')
        return $this->getHomePage();
    $subject=htmlspecialchars(trim($this->uri->segment(4)),ENT_QUOTES);
   // $subject= $this->session->set_userdata('active_subject',$subject);

    $id=$this->input->get('id');
    $id=htmlspecialchars(trim((int)$id),ENT_QUOTES);
        if((int)$id<=0)
            $this->getStudentsNotes();

    $note=($this->input->post('note')!=null) ? htmlspecialchars(trim($this->input->post('note')),ENT_QUOTES):'';
    $discipline=($this->input->post('discipline')!=null) ? htmlspecialchars(trim($this->input->post('discipline')),ENT_QUOTES):'';
    $data=[
        'student_id'=>(int)$id,
        'teacher_id'=>$this->session->userdata('person_id'),
        'note'=>$note,
        'discipline'=>$discipline,
        'type_note'=>$this->input->post('type_note')[0],
        'abscence'=>$this->input->post('abscence')[0],
        'subject'=>$_SESSION['active_subject'],
        'date'=> date("Y-m-d H:i:s")
    ];
    if($this->notesValidation()){

        $this->model->insertNote($id,$data);
        $data['data']=$data;
        return $this->getStudentsNotes($data);

    }else {
        $data['data']=$data;
        return $this->getStudentsNotes($data);
    }

}

function notesValidation(){

    $this->load->helper(['form', 'url']);
    $this->load->library(['form_validation']);

    $this->form_validation->set_message('integer',"Очакват се целочислени данни");
    $this->form_validation->set_message('min_length[4]',"Очакват се поне 4 символа");
    $this->form_validation->set_message('max_length[255]',"Допустими са до 255 символа");


    $note=(int)$this->input->post('note');
    if(!is_numeric($note) || $note<2 || $note>6) {
        $this->form_validation->set_message('grater_than[1]', "Оценка извън интервала от 2 до 6");
        $this->form_validation->set_message('less_than[7]', "Оценка извън интервала от 2 до 6");
    }
    if(((int)$note!=0 && $this->input->post('type_note')[0]==null)||((int)$note==0 && $this->input->post('type_note')[0]!=null)) {
        $this->form_validation->set_message('typenote', "Не е избран тип оценка или оценка");
        $this->form_validation->set_rules('type_note','Type','typenote');
    }


    $this->form_validation->set_message('exact_length[1]',"Въвежда се САМО 1 оценка");

    $this->form_validation->set_rules('note','Note','trim|integer|exact_length[1]|less_than[7]|greater_than[1]');
    $this->form_validation->set_rules('discipline','Discipline','trim|min_length[5]|max_length[255]');

    if($this->form_validation->run()===false){

        return false;
    }
    else return true;

}
    public function addStudent(){

        if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||($this->session->userdata('role')!='admin'&& $this->session->userdata('role')!='teacher' ))
            return $this->getHomePage();
        return $this->load->view('addStudent');
    }
    public function showMessage($type,$message){
    if($type=='alert'){
        $this->session->set_flashdata('danger',$message);
        echo "<span class='alert-danger'><h3>{$this->session->flashdata('danger')}</h3></span>";
        $this->session->unset_flashdata('danger');
    }
    if($type=='success'){
        $this->session->set_flashdata('success',$message);
        echo "<span class='alert-success'><h3>{$this->session->flashdata('success')}</h3></span>";
       // $this->session->unset_flashdata('success');
    }

}
    public function getJurnal($ids=null){

        if(!isset($_GET['id'])) $_GET['id']='';

   if($_GET['id'] == '')
    if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1|| ($this->session->userdata('role')!='admin'&& $this->session->userdata('role')!='teacher' ))
        return $this->getHomePage();

    $id=isset($_GET['id'])? htmlspecialchars(trim($_GET['id']),ENT_QUOTES):$ids;
    if((int)$id<=0 || empty($id)) $id='';

    $search='';
    $search=isset($_GET['search'])?$_GET['search']:'';
    $search=htmlspecialchars(trim(str_replace('  ',' ',$search)),3);
    $search=str_replace('  ',' ',$search);

        $rows_per_page=($this->input->get('rows_per_page')!=null)?(int)$this->input->get('rows_per_page'):5;
        $rows_per_page=htmlspecialchars((trim($rows_per_page)),3);
    $total_rows=0;
    $total_pages=0;

    $page=isset($_GET['page'])?$_GET['page']:1;
    $page=htmlspecialchars((trim($page)),3);
    if((int)$page<=0)
        $page = 1;

    $data['data']=$this->model->getJurnal(null,null,$search,$id);
    $total_rows=count($data['data']);

    $data['data']=$this->model->getJurnal($page,$rows_per_page,$search,$id);

    $total_pages=ceil($total_rows/$rows_per_page);

    $data['active_page']=$page;
    $data['search']= $search;
    $data['total_pages']=$total_pages;
    $data['rows_per_page']=$rows_per_page;
    if(!empty($id)) {
        $data['names']=$this->model->getStudentNames($id);
        $data['abscences'] = $this->model->getAbscences($id);
        $data['discipline'] = $this->model->getDiscipline($id);
    }
    if(empty($id))
        $this->load->view('getJurnal',$data);
    else {
       $this->load->view('studentDetails',$data);
    }

}

public function getMyClass(){

    if (!$this->session->userdata('logged_in')|| $this->session->userdata('logged_in')!=1||$this->session->userdata('role')!='teacher' )
        return $this->getHomePage();

    $search=isset($_GET['search'])?$_GET['search']:'';
    $search=htmlspecialchars(trim(str_replace('  ',' ',$search)),3);
   // if($rows_per_page==null)
     //   $rows_per_page=1;
    $rows_per_page=($this->input->get('rows_per_page')!=null)?(int)$this->input->get('rows_per_page'):5;
    $rows_per_page=htmlspecialchars((trim($rows_per_page)),3);

    $page=isset($_GET['page'])?$_GET['page']:1;
    $page=htmlspecialchars((trim($page)),3);
    if((int)$page<=0)
        $page = 1;


    if(!$this->model->getMyClassIds(null,null,$search)) {
        $total_rows=0;
        $data['names'][]=[];
        $data['abscences'][]=[];
        $data['actual_abs'][]=[];
        echo '<pre>';
        var_dump($data);
        echo '</pre>';


    }
    else {
        $ids = $this->model->getMyClassIds(null, null, $search);
        $total_rows = count($ids);
    }
    $offset=($page-1)*$rows_per_page;
    $upper_limit=$offset+$rows_per_page;
    if($upper_limit>=$total_rows)
        $upper_limit=$total_rows;


   // $ids =$this->model->getMyClassIds(null,null);


    $total_pages=ceil($total_rows/$rows_per_page);

    $data['active_page']=$page;
    $data['search']= $search;
    $data['total_pages']=$total_pages;
    $data['rows_per_page']=$rows_per_page;


    for($i=$offset;$i<$upper_limit;$i++) {
        $id=$ids[$i]['student_id'];
        $data['names'][]=$this->model->getNumberClass($id,null)[0];
        $data['abscences'][]=$this->model->getAbscences($id)[0];
        $count=count($this->model->getActualAbscences($id));
        $data['actual_abs'][]=$this->model->getActualAbscences($id);

    }

    $this->load->view('myClass',$data);
}

public function updateAbscences()
{

    $id=htmlspecialchars(trim($this->input->get('id')),3);
    if((int)$id<=0)
        $this->getMyClass();
    else {
        if($this->input->post('abs')==null)
            $this->getMyClass();
        else
        $abs=$this->input->post('abs')[0];
        $this->model->updateAbscences($id,$abs);
        $this->getMyClass();
    }
}
    public function logout(){
        $userdata=[
            'username' =>'',
            'password'=>'',
            'person_id'=>'',
            'role'=>'',
            'profile'=>[],
            'logged_in'=>0,
            'student_id'=>0,
            'subject'=>[],
            'active_subject'=>'',
            'degree'=>[],
            'class'=>[],
            'mydegree'=>0,
            'myclass'=>''
        ];
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('person_id');
        $this->session->unset_userdata( 'role');
        $this->session->unset_userdata('profile');
        $this->session->unset_userdata( 'logged_in');
        $this->session->unset_userdata( 'subject');
        $this->session->unset_userdata( 'degree');
        $this->session->unset_userdata( 'class');
        $this->session->unset_userdata( 'mydegree');
        $this->session->unset_userdata( 'myclass');
        $this->session->unset_userdata( 'active_subject');
        //$this->load->view('homepage');
        redirect(base_url(). 'homeController/getHomePage');//извикваме не самата страница, а контролера, който да я достъпи

    }

    function randomPassword()
    {  $pass='';
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, count($alphabet)-1);
            $pass.= $alphabet[$n];
        }

        return $pass;
    }



}
