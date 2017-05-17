<?php

class Models extends  CI_Model
{
    const DB_HOST     = 'mylocal.dev';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_NAME     ='school';

   // public $connection = null;
    private $connection = null;
    private static $instance = null;

    public $teacher = [
        'civilnum' => 7812149087,
        'first_name' => 'Maria',
        'middle_name' => 'Nikolova',
        'last_name' => 'marinova',
        'adress' => 'bul. Svoboda 29',
        'position' => 'учител',
        'date_of_birth' => '1978-12-14',
        'is_deleted' => 0,
        'subject' => 'Maths',
        'subject2' => 'IT',
        'username' => 'maria@abv.bg',
        'password' => 'password'

    ];

    public function __construct()
    {
        parent::__construct();
      //  $connection = mysqli_connect('mylocal.dev', 'root', '', 'school') or die(mysqli_connect_error() . "  Cannot connect to database");
        $connection = mysqli_connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DB_NAME) or die(mysqli_connect_error() . "  Cannot connect to database");
        if ($connection != null) {
            $this->connection = $connection;
            mysqli_set_charset($connection, "utf8");
        }
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof Models) {
            self::$instance= new Models();
        }
        return self::$instance;
    }


    public function insertEmployee($data)
    {
        {
            $this->db->insert('school', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    function validateTeacher(array $teacher)
    {

    }

    function validateStudent(array $student)
    {

    }


    function checkExistingUser($username)//проверява дали има такова потребителско име
    {
        $username=$this->db->escape_str($username);
        $this->db->where('username',$username);
        $query=$this->db->get('users');

        if($query->num_rows()>0) return true;
        else return false;
    }

    function checkUserCredentials($username,$password)// сверява креденшълите
    {
        $username=$this->db->escape_str($username);
        $password=$this->db->escape_str($password);
        $this->db->where('username',$username);
        $this->db->where('password',sha1($password));
        $query=$this->db->get('users');

        if($query->num_rows()==1) {
            return true;
        }
        else {
            return false;
        }


    }
 function getUserDetails($username)
     //извлича данни за потребителя, ролята, правата му и зарежда сесията с изключение на logged_in, което се задава в контролера
 {
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

        $username=$this->db->escape_str($username);
        $this->db->where('username',$username);
        $query=$this->db->get('users',1);
        if($query->num_rows()==1) {
            $user = $query->result_array();
            $userdata = [
                'username' => $username,
                'password'=> sha1($user[0]['password']),
                'person_id'=>$user[0]['person_id'],
                'role'=>$user[0]['role'],

            ];
            switch ($user[0]['role']){
                case 'teacher':{
                    $this->db->where('teacher_id',$user[0]['person_id']);
                    $query=$this->db->get('teacher')->result_array();
                    if(!empty(array_values($query))){
                        $userdata['profile'][] = $query[0]['subject'];
                        $userdata['active_subject']=$query[0]['subject'];
                    }

                    if(!empty($query[0]['subject2'])) {
                        $userdata['profile'][] = $query[0]['subject2'];
                    }

                    $this->db->where('teacher_id',$user[0]['person_id']);
                    $query=$this->db->get('class')->result_array();

                    $count=0;

                    if(!empty(array_values($query))) {// проверява дали таблицата има редове
                        foreach ($query as $item[$count]) {//$query е таблица от редове, а item[$count]е един табличен ред
                            $userdata['degree'][] = $item[$count]['degree'];
                            $userdata['class'][] = $item[$count]['class'];
                            $userdata['subject'][] = $item[$count]['subject'];
                            if ($item[$count]['responsible']) {
                                $userdata['mydegree'] = $item[$count]['degree'];
                                $userdata['myclass'] = $item[$count]['class'];
                            }
                            $count++;

                        }
                        $userdata['profile'] = array_unique(array_values($userdata['subject']));
                        $userdata['active_subject']= $userdata['profile'][0];

                    }
                    else echo "Записът не е намерен!";
                    break;
                }

                case 'guest':{
                    $this->db->where('civilnum',$user[0]['password']);
                    $query=$this->db->get('person',1)->result_array();
                    if(!empty(array_values($query))){
                        $userdata['student_id']=$query[0]['id'];

                        break;
                    }
                    else echo "Записът не е намерен!";
                }
            }
            return $userdata;
        } else return false;

 }// търси по потребителско име цялата информация за инициализиране на сесията на потребителя според ролята му

    function getTeachersList($page=null,$rows_per_page=null,$search)// извежда общите данни за учител и предмети, по които преподава без паралелките
    {
        if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $search_expression="AND (LOWER(person.first_name) LIKE '%{$search}%'
            
            OR LOWER(person.middle_name) LIKE '%{$search}%'
            OR LOWER(person.last_name) LIKE '%{$search}%'
            OR LOWER(person.civilnum) LIKE '%{$search}%'
            OR LOWER(person.address) LIKE '%{$search}%'
            OR LOWER(person.tel) LIKE '%{$search}%'
            OR LOWER(person.email) LIKE '%{$search}%'
            OR LOWER(person.date_of_birth) LIKE '%{$search}%'
            OR LOWER(teacher.subject) LIKE '%{$search}%'
            OR LOWER(teacher.subject2) LIKE '%{$search}%')";
        }
        else {
            $search='';
            $search_expression='';

        }


    //$page=2; $rows_per_page=2;
     if ($page==null && $rows_per_page==null){
         $offset=0;
         $expression='';
     }

     else {
         $offset=($page-1)*$rows_per_page;
         $expression="limit {$offset}, {$rows_per_page}";
     }

    // $offset=$page*10;
     $data=['person.id'=>0,
         'person.first_name'=>'',
         'person.middle_name'=>'',
         'person.last_name'=>'',
         'person.civilnum'=>0,
         'person.address'=>'',
         'person.tel'=>'',
         'person.email'=>'',
         'person.date_of_birth'=>'',
         'subject'=>'',
         'subject2'=>''
     ];
     $tables=['person','teacher'];
     $columns=[
         'person.id',
         'person.first_name',
         'person.middle_name',
         'person.last_name',
         'person.civilnum',
         'person.address',
         'person.tel',
         'person.email',
         'person.date_of_birth',
         'teacher.subject',
         'teacher.subject2'
     ];
        $query=$this->db->query("SELECT DISTINCT 
          person.id as id,
         person.first_name as Име,
         person.middle_name as Презиме,
         person.last_name as Фамилия,
         person.civilnum as ЕГН,
         person.address as Адрес,
         person.tel as Тел,
         person.email as Имейл,
         person.date_of_birth as Рожденна_дата,
         teacher.subject as Профил,
         teacher.subject2 as Профил_2
         FROM school.person, school.teacher
         where person.id=teacher.teacher_id  {$search_expression} ORDER BY  person.first_name,  person.middle_name, person.last_name ASC 
         {$expression};");
        $data=$query->result_array();
        


     if($query->num_rows()>0 )
         return $data;
     else return false;
    }

    function getTeacherById($id)
    {
        $id=$this->db->escape_str($id);
        $query=$this->db->select('*')->from('person')->join('teacher','person.id = teacher.teacher_id')->where('person.id',$id)->get();
        $data=$query->result_array();

        if($query->num_rows()>0)
            return $data;
        return false;

    }
function getTeachersClassesById($id)//връща класовете и паралелките, в които влиза учителя
{
    $data=null;
    $id=$this->db->escape_str($id);
    $query=$this->db->get_where('class',['class.teacher_id ='=> $id]);

    if($query->num_rows()>0) {
        $data = $query->result_array();
        return $data;
    }

    return false;

}

function getClassesById_Subject($id,$subjects)// връща паралелките, в които се преподава конкретен предмет
{
    $data = [
        'first_subj' => [],
        'second_subj' => []
    ];
    $id = $this->db->escape_str($id);
    $count =1;//назовава първи или втори предмет от профила на учителя
    if (empty($subjects)) return false;
    try {
        foreach($subjects as $subject){
            $query = $this->db->get_where('class', ['class.teacher_id =' => $id, 'subject =' => $subject]);

        if ($query->num_rows() > 0)

                if($count==1) {
                    foreach ($query->result_array() as $row) {
                    $data['first_subj']['degree'][] = $row['degree'];
                    $data['first_subj']['class'][] = $row['class'];
                    }
                    $count++;
                }
                elseif($count==2){
                    foreach ($query->result_array() as $row) {
                        $data['second_subj']['degree'][] = $row['degree'];
                        $data['second_subj']['class'][] = $row['class'];
                    }
                }
            }


    } catch (Exception $e)
        { echo "Липсват данни".$e->getMessage().'\n';
        }

        return $data;
}

function updateClasses($id,$classes)
// update паралелките, в които преподава учителя, ако не преподава на посочените- ги добавя,
    // ако преподава - ги променя с новите
{

    if(!empty(array_values($classes))){
        $query=$this->db->where('class.teacher_id',$id)->get('class');
        if($query->num_rows()==0){
            foreach ($classes as  $class){
                $row['teacher_id']=$id;
                $row['subject']=$class['subject'];
                $row['responsible']=$class['responsible'];
                $row['degree']=$class['degree'];
                $row['class']=$class['class'];
                $this->db->insert('class',$row);
            }
        if($this->db->affected_rows()==0) return false;
         return true;
        }
        else {

            $this->db->where('class.teacher_id', $id)->delete('class');

            foreach ($classes as  $class) {
                $row['teacher_id'] = $id;
                $row['subject'] = $class['subject'];
                $row['responsible'] = $class['responsible'];
                $row['degree'] = $class['degree'];
                $row['class'] = $class['class'];
                $this->db->insert('class', $row);
            }
            if ($this->db->affected_rows() == 0) return false;

        } return true;

    }return true;
}

 function updateBaseInfo($id,$data)// променя основната информация за учител
 {

    $data=$this->escapeData($data);

    $this->db
        ->set('id',$data['id'])
        ->set('first_name',$data['first_name'])
        ->set('middle_name',$data['middle_name'])
        ->set('last_name',$data['last_name'])
        ->set('civilnum',$data['civilnum'])
        ->set('date_of_birth',$data['date_of_birth'])
        ->set('email',$data['email'])
        ->set('address',$data['address'])
        ->set('tel',$data['tel'])
        ->where('person.id',$id)
        ->update('person');

        $this->db
            ->set('subject',$data['subject'])
            ->set('subject2',$data['subject2'])
            ->where('teacher.teacher_id',$id)
            ->update('teacher');
     if($this->db->affected_rows()>0) return true;

    return false;
 }

 function escapeData($data){
     if(!empty($data)) {
         foreach ($data as $key => $value)
             $data[$key]=$this->db->escape_str($value);
         return $data;
     }return false;
 }

function deleteTeacherById($id)// изтрива цялата информация за учител във всички таблици
{

    $id=$this->db->escape_str($id);
    $tables=['class','users','teacher','person'];
   // $where=['teacher_id ='=>$id,'person_id ='=>$id,'teacher_id ='=>$id,'id ='=>$id];
    $this->db->trans_begin();
    $this->db->where('class.teacher_id',$id);
    $this->db->delete('class');

    $this->db->where('users.person_id',$id);
    $this->db->delete('users');

    $this->db->where('teacher.teacher_id',$id);
    $this->db->delete('teacher');

    $this->db->where('person.id',$id);
    $this->db->delete('person');


    if($this->db->trans_status()=== FALSE)
        if($this->db->affected_rows()>0) {
            $this->db->trans_commit();
            return true;
        }
        else{
        $this->db->trans_rollback();
        return false;
        }
    else{
        $this->db->trans_commit();
        return true;
    }
}

    function checkExistingPerson($data)// проверява в базата дали има такава личност
    {

        $this->db->where('civilnum',$this->db->escape_str($data['civilnum']));
        $this->db->where('first_name',$this->db->escape_str($data['first_name']));
        $this->db->where('last_name',$this->db->escape_str($data['last_name']));
        $query=$this->db->get('person');

        if($query->num_rows()>0)
            return false;
            return true;
    }
    function insertTeacher($data)//въвежда учител в таблиците person, teacher, user
    {
        $person=[
            'civilnum'=>$this->db->escape_str($data['civilnum']),
            'first_name'=>$this->db->escape_str($data['first_name']),
            'middle_name'=>$this->db->escape_str($data['middle_name']),
            'last_name'=>$this->db->escape_str($data['last_name']),
            'address'=>$this->db->escape_str($data['address']),
            'date_of_birth'=>$this->db->escape_str($data['date_of_birth']),
            'position'=>$this->db->escape_str($data['position']),
            'tel'=>$this->db->escape_str($data['tel']),
            'email'=>$this->db->escape_str($data['email']),
            'is_deleted'=>0
        ];

        $teacher=[
            'teacher_id'=>0,
            'subject'=>$this->db->escape_str($data['subject']),
            'subject2'=>$this->db->escape_str($data['subject2'])
        ];

        $user=[
            'person_id'=>0,
            'username'=>$this->db->escape_str($data['email']),
            'password'=>$this->db->escape_str($data['password']),
            'role'=>'teacher'
        ];


        $this->db->trans_begin();

        $this->db->insert('person', $person);
        $id=$this->db->insert_id();
        $teacher['teacher_id']=$id;
        $user['person_id']=$id;
        $this->db->insert('teacher',$teacher);
        $this->db->insert('users',$user);


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
        }
        if ($this->db->affected_rows()==3)
            return true;
            return false;

    }

    function insertStudent($data)//въвежда учител в таблиците person, teacher, user
    {
        $data=$this->escapeData($data);

        $person=[
            'civilnum'=>$data['civilnum'],
            'first_name'=>$data['first_name'],
            'middle_name'=>$data['middle_name'],
            'last_name'=>$data['last_name'],
            'address'=>$data['address'],
            'date_of_birth'=>$data['date_of_birth'],
            'position'=>$data['position'],
            'tel'=>$data['tel'],
            'email'=>$data['email'],
            'is_deleted'=>0
        ];
        $student=[
            'degree'=>$data['degree'],
            'class'=>$data['class'],
            'picture'=>$data['file_img'],
            'number'=>$data['number']
        ];
        $parent=[
            'first_name'=>$data['p_first_name'],
            'last_name'=>$data['p_last_name'],
            'email'=>$data['p_email'],
            'tel'=> $data['p_tel'],
            'address'=>$data['p_address']
        ];

        $user=[
            'person_id'=>0,
            'username'=>$data['p_email'],
            'password'=>$data['password'],
            'role'=>'guest'
        ];



        $this->db->trans_begin();

        $this->db->insert('person', $person);
        $id=$this->db->insert_id();
        $student['student_id']=$id;
        $parent['student_id']=$id;
        $user['person_id']=$id;

        $this->db->insert('student',$student);
        $this->db->insert('parent',$parent);
        $this->db->insert('users',$user);


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
        }
        if ($this->db->affected_rows()==4)
            return true;
        return false;

    }
    function getStudentsList($page=null,$rows_per_page=null,$search)// извежда общите данни за учител и предмети, по които преподава без паралелките
    {
        if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $search=str_replace("  ",' ',$search);


            $search_expression=" AND ( LOWER(person.first_name) LIKE '%{$search}%'
            
            OR LOWER(person.middle_name) LIKE '%{$search}%'
            OR LOWER(person.last_name) LIKE '%{$search}%'
            OR LOWER(person.civilnum) LIKE '%{$search}%'
            OR LOWER(person.address) LIKE '%{$search}%'
            OR LOWER(person.tel) LIKE '%{$search}%'
            OR LOWER(person.email) LIKE '%{$search}%'
            OR LOWER(person.date_of_birth) LIKE '%{$search}%'
            OR LOWER(concat(student.degree,' ',student.class)) LIKE '%{$search}%'
           
            OR LOWER(student.number) LIKE '%{$search}%'
            
            )";
        }
        else {
            $search='';
            $search_expression='';

        }


        if ($page==null && $rows_per_page==null){
            $offset=0;
            $expression='';
        }

        else {
            $offset=($page-1)*$rows_per_page;
            $expression="limit {$offset}, {$rows_per_page}";
        }

        $query=$this->db->query("SELECT DISTINCT 
         student.picture as Снимка,
         student.number as Номер,
         student.degree as Степен,
         student.class as Паралелка,
         person.id as id,
         person.first_name as Име,
         person.middle_name as Презиме,
         person.last_name as Фамилия,
         person.civilnum as ЕГН,
         person.address as Адрес,
         person.tel as Тел,
         person.email as Имейл,
         person.date_of_birth as Рожденна_дата         
         FROM school.person, school.student
         where person.id=student.student_id  {$search_expression} ORDER BY  person.first_name,  person.middle_name, person.last_name ASC 
         {$expression};");
        $data=$query->result_array();



        if($query->num_rows()>0 )
            return $data;
        else return false;
    }


    function insertNote($student_id, $data)
    {

        $data=$this->escapeData($data);
        $data['actual_abs']=0;
        $data['delays']=0;

        switch ($data['abscence']){
            case '1': $data['actual_abs']=1; break;
            case '2': $data['delays']=1; break;
            case '3': $data['actual_abs']=0; break;
        }

        unset($data['abscence']);
        $data['excused_abs']=0;
        $data['unexcused_abs']=0;
        if(($data['actual_abs']==0)&& ($data['delays']==0) && empty($data['note']) && empty($data['discipline'])|| empty($data['subject']))
            return false;
        $this->db->insert('notes',$data);
        if($this->db->affected_rows()>0){
            $data['abscence']=$data['actual_abs'];
            unset($data['actual_abs']);
            return $data;
        }

        return false;

    }
    function getStudentsNotes($page=null,$rows_per_page=null,$search,$subject){
        if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $page=(int)$this->db->escape_str($page);
            $rows_per_page=(int)$this->db->escape_str($rows_per_page);
            $search=str_replace("  ",' ',$search);

            $search_expression=" AND ( LOWER(person.first_name) LIKE '%{$search}%'
            
            OR LOWER(person.middle_name) LIKE '%{$search}%'
            OR LOWER(person.last_name) LIKE '%{$search}%'
            OR LOWER(concat(student.degree,' ',student.class)) LIKE '%{$search}%'
            OR LOWER(student.number) LIKE '%{$search}%'
            OR LOWER(notes.subject) LIKE '%{$search}%'
            )";
        }
        else {
            $search='';
            $search_expression='';

        }


        if ($page==null && $rows_per_page==null){
            $offset=0;
            $expression='';
        }

        else {
            $offset=($page-1)*$rows_per_page;
            $expression="limit {$offset}, {$rows_per_page}";
        }


       $data=[];

        $query=$this->db->query("SELECT DISTINCT
                student.number AS Номер,
                student.degree AS Степен,
                student.class AS Паралелка,
                person.id AS id,
                person.first_name AS Име,
                person.last_name AS Фамилия
            FROM
                school.person
                    LEFT JOIN
                school.student ON person.id = student.student_id
                    JOIN
                class ON CONCAT(student.degree, student.class) = CONCAT(class.degree, class.class)
                   LEFT JOIN
                school.notes ON student.student_id = notes.student_id 
         WHERE   LOWER(class.subject) LIKE LOWER ('%{$subject}%') AND class.teacher_id = {$_SESSION['person_id']} {$search_expression}
        
         ORDER BY class.degree, class.class, student.number ASC 
         {$expression};");

        $data1=$query->result_array();


        if($query->num_rows()>0 ){
            $count=count($data1);
            for($i=0;$i<$count;$i++) {
                $data[$i]['id']=$data1[$i]['id'];
                $data[$i]['Име'] = $data1[$i]['Име'];
                $data[$i]['Фамилия'] = $data1[$i]['Фамилия'];
                $data[$i]['Номер'] = $data1[$i]['Номер'];
                $data[$i]['id'] = $data1[$i]['id'];
                $data[$i]['Клас'] = $data1[$i]['Степен'] . " " . $data1[$i]['Паралелка'];
            }

        }else return false;

        $search_class="OR LOWER (concat(student.degree,' ',student.class)) LIKE LOWER ('%{$search}%')";
        for($i=0;$i<$count;$i++) {
            $id=$data[$i]['id'];
            $data[$i]['Оценки']='';
            $query = $this->db->query(
                "SELECT notes.note
                 FROM school.notes
                 where notes.student_id={$id} and notes.note > 0 AND LOWER(notes.subject) LIKE LOWER ('%{$subject}%');"); //{$expression}-премахнато

            if ($query->num_rows() > 0) {
                $data2 = $query->result_array();

                for ($j = 0; $j < count($data2); $j++)
                    if ($j < count($data2)-1)
                        $data[$i]['Оценки'] .= $data2[$j]['note'] . ",";
                    else $data[$i]['Оценки'] .= $data2[$j]['note'];
            }else $data[$i]['Оценки']='';
                //return false;

        }

            return $data;
    }


    function getJurnal($page=null,$rows_per_page=null,$search,$id){

   if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $search=str_replace("  ",' ',$search);
            $count=0;


   }
   else {
       $search='';
       $search_expression='';

   }
        $where='';
        $id=$this->db->escape_str($id);
        if($id==null) $id='';
        if($id !=null && $id!='' && $id !=0)
            $where=" notes.student_id={$id} ";

        else $where='1';

        if ($page==null && $rows_per_page==null){
            $expression='';
        }

        else {
            $offset=($page-1)*$rows_per_page;
            $expression="limit {$offset}, {$rows_per_page}";
        }

        $subjects=[];
        $query=$this->db->query("select subjects.subject from subjects");
        if($query->num_rows()>0)
            $subjects=$query->result_array();


        $ids=[];
        if($search=='') $search_expression='';
        else
            $search_expression=" AND (LOWER(person.first_name) LIKE '%{$search}%'
             OR LOWER(person.middle_name) LIKE '%{$search}%' 
             OR LOWER(person.last_name) LIKE '%{$search}%' 
             OR LOWER(notes.subject) LIKE '%{$search}%' 
             OR LOWER(notes.discipline) LIKE '%{$search}%' 
             OR LOWER(concat(student.degree,' ',student.class)) LIKE LOWER('%{$search}%'))";

        $query=$this->db->query("SELECT DISTINCT
                student.student_id 
            FROM
                school.person
                    LEFT JOIN
                school.student ON person.id = student.student_id
                    JOIN
                class ON CONCAT(student.degree, student.class) = CONCAT(class.degree, class.class)
                   LEFT JOIN
                school.notes ON student.student_id = notes.student_id 
                 where {$where} {$search_expression}  ORDER BY student.degree, student.class, student.number ASC  {$expression}");

       if($query->num_rows()>0)
            $ids=$query->result_array();




        $notes=[];
        $data=[];


        for($i=0;$i<count($ids);$i++) {

            $number_class_data = $this->getNumberClass($ids[$i]['student_id'],$search);

            $data[$i]['student_id'] = $ids[$i]['student_id'];
            $data[$i]['Снимка'] = $number_class_data[0]['Снимка'];
            $data[$i]['Номер'] = $number_class_data[0]['Номер'];
            $data[$i]['Клас'] = $number_class_data[0]['Клас'];


            for ($j = 0; $j < count($subjects); $j++) {
                $query = $this->db
                    ->query("SELECT notes.note  
                  FROM school.notes
                  where notes.subject LIKE '%{$subjects[$j]['subject']}%' and student_id={$ids[$i]['student_id']}  and notes.note>0 
                  order by notes.subject asc;");

                $notesToStr = '';
                if ($query->num_rows() > 0) {
                    $notes = $query->result_array();
                    $notesToStr = $this->concat_data($notes);
                }
                $data[$i][$j]['Предмет'] = $subjects[$j]['subject'];
                $data[$i][$j]['Оценки'] = $notesToStr;
            }

        }

      return $data;
    }

    function concat_data($data)
    {
        $str = '';
        if (!empty($data))
            for ($i = 0; $i < count($data); $i++) {
                if ($i == count($data) - 1)
                    $str .= $data[$i]['note'];
                else
                    $str .= $data[$i]['note'] . ', ';
            }
            return $str;
    }
    public function getMyClassIds($page=null,$rows_per_page=null,$search){

        if ($page==null || $rows_per_page==null){
            $offset=0;
            $expression='';
        }

        else {
            $offset=($page-1)*$rows_per_page;
            $expression="limit {$offset}, {$rows_per_page}";
        }


        if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $search=str_replace("  ",' ',$search);
            $search_expression=" AND  (LOWER(student.number) LIKE '%{$search}%' OR LOWER(concat(person.first_name,' ',person.last_name)) LIKE '%{$search}%')";

            $count=0;


        }
        else {
            $search='';
            $search_expression='';

        }


        $myDegree=$this->session->userdata('mydegree');
        $myClass=$this->session->userdata('myclass');
        $query=$this->db->query("SELECT  student.student_id, person.first_name, person.last_name 
            FROM school.student, school.person 
            WHERE student.degree={$myDegree} and student.class='{$myClass}' and student.student_id=person.id {$search_expression}
            ORDER BY  person.first_name, person.last_name ASC {$expression};
            ");
        if($query->num_rows()>0)
           return $studentInfo=$query->result_array();
        else return false;
    }

    public function getStudentNames($id){


        $id=$this->db->escape_str($id);
        $query=$this->db->select('first_name, middle_name, last_name')->from('person')->where('id',$id)->get();
        if($query->num_rows()>0)
            return $query->result_array();
        else return false;
}

public function getActualAbscences($id)
{

    $id = $this->db->escape_str($id);
    $mydegree=$this->session->userdata('mydegree');
    $myclass=$this->session->userdata('myclass');

    $query=$this->db->query("SELECT notes.id, notes.student_id, notes.date as Дата, notes.subject as Предмет, notes.actual_abs as Текущи, notes.delays as Закъснения
        FROM school.notes 
        JOIN school.student 
        ON student.student_id=notes.student_id 
        WHERE student.degree={$mydegree} 
        and student.class='{$myclass}' 
        and notes.student_id={$id} 
        and notes.actual_abs>0 
        order by date;");

    if ($query->num_rows() > 0) {
        return $query->result_array();

    }

    else return false;
}

 public function getAbscences($id){
        $data=[
            'Неизвинени'    =>0,
            'Закъснения'    =>0,
            'Извинени'      =>0,
            'Текущи'        =>0
        ];
        $id=$this->db->escape_str($id);


        $query=$this->db
            ->query("select  sum(excused_abs) as Извинени, sum(unexcused_abs)+sum(delays)div 3 as Неизвинени, sum(delays) as Закъснения, sum(actual_abs) as Текущи
                    from notes 
                    where student_id={$id}");
        if($query->num_rows()>0)
            $data=$query->result_array();
        return $data;
    }

    function getDiscipline($id){
        $data=[
            'Бележки'=>'',
            'Предмет',
            'Дата'   =>0
        ];

        $query=$this->db
            ->query("SELECT discipline as Бележки, subject as Предмет, date  as Дата
                    FROM school.notes 
                    where student_id={$id} and discipline <> '';" );
        if($query->num_rows()>0)
            $data=$query->result_array();
        return $data;

    }

    function getNumberClass($id, $search){

        $data=[
            'Снимка'    =>'',
            'Номер'     =>0,
            'Клас'      =>'',
            'Име'       =>''
        ];
        if(!empty($search))
            $search_expression=" AND (LOWER(concat(student.degree,' ',student.class)) LIKE '%{$search}%' OR LOWER(student.number) LIKE '%{$search}%' OR LOWER(concat(person.first_name,' ',person.last_name)) LIKE '%{$search}%')";
        else $search_expression='';
        $id=$this->db->escape_str($id);

        $query=$this->db
            ->query("SELECT picture as Снимка, number as Номер, concat(degree,' ',class)  as Клас, concat(person.first_name,' ',person.last_name) as Име
                    FROM school.student 
                    JOIN school.person
                    ON student.student_id=person.id
                    where student.student_id={$id} {$search_expression} ;" );
        if($query->num_rows()>0)
            $data=$query->result_array();

        return $data;
    }
function updateAbscences($id,$abs){

        if($abs==3) return true;

        switch ($abs){
            case '1': $excused=1;
                      $unexcused=0;
                      $actual=0;
                    break;

            case '2':$excused=0;
                     $unexcused=1;
                     $actual=0;
                    break;
        }

    $id=$this->db->escape_str($id);
    $query=$this->db
            ->set('excused_abs',$excused)
            ->set('unexcused_abs',$unexcused)
            ->set('actual_abs',$actual)
            ->where('notes.id',$id)
            ->update('notes');
    if($this->db->affected_rows()>0)
        return true;
    else return false;

}
    function search_expression_prepare($page=null, $rows_per_page=null,$search=null,$table_columns=[]){
        if(!empty($search)) {

            $search = strtolower($search);
            $search=$this->db->escape_str($search);
            $count=0;
            $search_expression='';
            if(!empty($tables_columns)) {
                foreach ($tables_columns as $table => $column)
                    if ($count == 0)
                        $search_expression = "AND (LOWER({$table}.{$column}) LIKE '%{$search}%'";
                    elseif ($count == count($tables_columns) - 1)
                        $search_expression .= "OR LOWER({$table}.{$column}) LIKE '%{$search}%')";
                    else $search_expression .= "OR LOWER({$table}.{$column}) LIKE '%{$search}%'";
                $count++;
            }
        }
        else {
            $search='';
            $search_expression='';

        }


        if ($page==null && $rows_per_page==null){
            $offset=0;
            $expression='';
        }

        else {
            $offset=($page-1)*$rows_per_page;
            $expression="limit {$offset}, {$rows_per_page}";
        }
        return $search_expression;

    }
    function getStudentById($id){


        $id=$this->db->escape_str($id);
        $query=$this->db->select('person.*,student.*,parent.first_name as p_first_name,parent.last_name as p_last_name,parent.tel as p_tel, parent.email as p_email, parent.address as p_address')->from('person')
            ->join('student','person.id = student.student_id')
            ->join('parent','person.id=parent.student_id')
            ->where('person.id',$id)->get();
        $data=$query->result_array();

        if($query->num_rows()>0)
            return $data;
        return false;


    }

    public function editStudent($id,$data){

        $data=$this->escapeData($data);

        $this->db
            ->set('id',$id)
            ->set('first_name',$data['first_name'])
            ->set('middle_name',$data['middle_name'])
            ->set('last_name',$data['last_name'])
            ->set('civilnum',$data['civilnum'])
            ->set('date_of_birth',$data['date_of_birth'])
            ->set('email',$data['email'])
            ->set('address',$data['address'])
            ->set('tel',$data['tel'])
            ->where('person.id',$id)
            ->update('person');
        if($data['file_img']=='' || $data['file_img']==null) {
            $this->db
                ->set('number', $data['number'])
                ->set('degree', $data['degree'])
                ->set('class', $data['class'])
                ->where('student.student_id', $id)
                ->update('student');
        }
        else {
            $this->db
                ->set('number', $data['number'])
                ->set('degree', $data['degree'])
                ->set('class', $data['class'])
                ->set('picture', $data['file_img'])
                ->where('student.student_id', $id)
                ->update('student');
        }
        $this->db
            ->set('first_name',$data['p_first_name'])
            ->set('last_name',$data['p_last_name'])
            ->set('email',$data['p_email'])
            ->set('address',$data['p_address'])
            ->set('tel',$data['p_tel'])
            ->where('parent.student_id',$id)
            ->update('parent');
        $this->db
            ->set('username',$data['username'])
            ->set('password',$data['password'])
            ->where('users.person_id',$id)
            ->update('users');


        if($this->db->affected_rows()>0) return true;

        return false;
    }

    public function getImageFile($id){
        $image='';
        $this->db->escape_str($id);
        $query=$this->db->select('student.picture')->from('student')->where('student.student_id=',$id)->get();
        if($query->num_rows()>0)
            $image=$query->result_array();
        return $image;
    }
    public function getStudentByCivilnum($civilnum){
            $civilnum=$this->db->escape_str($civilnum);

            $query=$this->db->select('person_id')->from('users')->where('password',$civilnum)->get();
            if($query->num_rows()>0)
                return $id=$query->result_array()[0];
                return false;
    }

    public function deleteStudentById($id){

        $id=$this->db->escape_str($id);

        $this->db->trans_begin();
        $this->db->where('parent.student_id',$id);
        $this->db->delete('parent');

        $this->db->where('users.person_id',$id);
        $this->db->delete('users');

        $this->db->where('notes.student_id',$id);
        $this->db->delete('notes');

        $this->db->where('student.student_id',$id);
        $this->db->delete('student');

        $this->db->where('person.id',$id);
        $this->db->delete('person');


        if($this->db->trans_status()=== FALSE)
            if($this->db->affected_rows()>0) {
                $this->db->trans_commit();
                return true;
            }
            else{
                $this->db->trans_rollback();
                return false;
            }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

}
