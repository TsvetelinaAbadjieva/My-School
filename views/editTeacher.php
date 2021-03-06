<?php require_once "header.php"?>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Информация</a></li>
        <li><a href="<?php echo site_url('homeController/getTeachersList'); ?>">Списък Учители</a></li>
        <li class="active">Редактирай Учител</li>
    </ol>
<?php require_once "navbar.php"?>


<?php
$index='';
$index1 ='first_subj_deg';  $index2='first_subj_class';
$number=0;
$classes1=[];
$clas='';
$resp='';
$passdata=[
    'id'=>$data['id'],
    'first_subject'=>$data['subject'],
    'second_subject'=>$data['subject2'],
    'classes'=>$classes1,
    'responsible'=>$resp
];

?>

    <div class="row-fluid container-fluid addform">
        <div class="col-md-12">
            <div class="">

                <form class="form" method="post" action="<?php  echo  site_url("homeController/postTeacherClasses?id=").$data['id']; ?>">

                    <div class="col-md-12">
                        <label for=""><h2>Данни за учител</h2></label>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('first_name'))?'has-error':''; ?>">
                            <label for="first_name"><h4>Име<h4></label>
                            <input name="first_name" type="text" class="form-control formfield" id="first_name" value="<?php echo $data["first_name"]; ?>" placeholder="Име">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("first_name");?></span>
                        </div>
                        <div class="form-group col-md-4 <?php echo (form_error('middle_name'))?'has-error':''; ?>">
                            <label for="middle_name"><h4>Презиме<h4></label>
                            <input name="middle_name" type="text" class="form-control formfield" id="middle_name" value="<?php echo $data['middle_name']; ?>" placeholder="Презиме">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("middle_name");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error("last_name"))?'has-error':''; ?>">
                            <label for="last_name"><h4>Фамилия<h4></label>
                            <input  name="last_name" type="text" class="form-control formfield" id="last_name"  value="<?php echo $data['last_name']; ?>" placeholder="Фамилия">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("last_name");?></span>
                        </div>


                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('civilnum'))?'has-error':''; ?>">
                        <span><label for="civilnum"><h4>ЕГН<h4></label>
                        <input name="civilnum" type="text" class="form-control formfield" id="civilnum" value="<?php echo $data['civilnum']; ?>" placeholder="ЕГН">
                        </span>
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("civilnum");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('address'))?'has-error':''; ?>">
                            <label for="address"><h4>Адрес<h4></label>
                            <input name="address" type="text" class="form-control formfield" id="address" value="<?php echo $data['address']; ?>" placeholder="Адрес">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("address");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('tel'))?'has-error':''; ?>">
                            <label for="tel"><h4>Телефон<h4></label>
                            <input name="tel" type="text" class="form-control formfield" id="tel" value="<?php echo $data['tel']; ?>" placeholder="Тел.">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("tel");?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('email'))?'has-error':''; ?>">
                            <label for="email"><h4>Имейл<h4></label>
                            <input name="email" type="email" class="form-control formfield" id="email" value="<?php echo $data['email']; ?>" placeholder="Имейл">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("email");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('date_of_birth'))?'has-error':''; ?>">
                            <label for="date_of_birth"><h4>Дата на раждане<h4></label>
                            <input name="date_of_birth" type="date" class="form-control formfield" id="date_of_birth" value="<?php echo $data['date_of_birth']; ?>" placeholder="Дата на раждане">
                        </div>


                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('subject'))?'has-error':''; ?>">
                            <label for="subject"><h4>Учебен премет</h4></label>
                            <input name="subject" type="text" class="form-control formfield" id="subject" value="<?php echo $data['subject']; ?>" placeholder="Учебен предмет">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("subject");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('subject2'))?'has-error':''; ?>">
                            <label for="subject2"><h4>Втори учебен предмет</h4></label>
                            <input name="subject2" type="text" class="form-control formfield" id="subject2" value="<?php echo $data['subject2']; ?>" placeholder="Втори предмет">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("subject2");?></span>
                        </div>


                    </div>


                    <div class="row">
                    <nav class="list-group-item col-md-12">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">


                                    <label for="" class="h4label"><h4  class="h4label">Паралелки</h4></label>
                                    <label for="" class="labels">Учебен предмет</label>
                                    <select name="subject" id=""class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                       <ul class="dropdown-menu"> <?php $count=0; if(!empty($data['subjects'][0])) foreach($data['subjects'] as $key=> $subject) {?>
                                           <li><option name="subject[]" value="<?php echo $count; $count++;?>"<?php echo (isset($_POST['subject'])&&  $_POST['subject']==$key)?'selected':''; ?>><?php echo $subject;?></option></li>
                                            <li role="separator" class="divider"></li>
                                        <?php } else{?>
                                           <li><option name="subject[]" value="0" selected ><?php echo $data['subject']; $index1='first_subj_deg';  $index2='first_subj_class'; $number=count($data['first_subj_deg']);?></option></li>
                                           <li><option name="subject[]" value="1" ><?php echo isset($data['subject2'])?$data['subject2']:''; $index1='second_subj_deg';  $index2='second_subj_class'; $number=count($data['second_subj_deg'])?></option></li>

                                           <?php echo "subject= ".$_POST['subject']; } ?>
                                       </ul>
                                    </select>

                                    <label for="classes" class="labels">Класно ръководство</label>
                                    <select name="responsible" id=""class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <ul class="dropdown-menu">
                                                <li><option name="responsible[]" value="--" selected>----</option>
                                                    <a href="">--</a></li>
                                                <li role="separator" class="divider"></li>
                                            <?php $alpha="ABVGDE";
                                                for($i=8;$i<13;$i++)
                                                    for($j=0;$j<6;$j++){ ?>
                                                <li><option name="responsible[]" value="<?php echo $i." ".$alpha[$j];?>" <?php echo ($i." ".$alpha[$j]== $data['responsible_deg']." ".$data['responsible_class'])? 'selected':$i.$alpha[$j];
                                                    isset($_POST['responsible'])? $resp=$i." ".$alpha[$j]:''; ?>>
                                                        <a href=""> <?php echo $i." ".$alpha[$j];?></a></option></li>
                                                <li role="separator" class="divider"></li>
                                                <?php } ?>
                                        </ul>
                                    </select>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-8">

                            <?php
                            if(isset($_POST['refresh'])&& isset($_POST['subject'])&& $_POST['subject']== 0)
                              {
                                    $index1='first_subj_deg';
                                    $index2='first_subj_class';
                                    $number=count($data['first_subj_deg']);
                                }
                            elseif(isset($_POST['refresh'])&& isset($_POST['subject'])&& $_POST['subject']== 1){
                                    $index1='second_subj_deg';
                                    $index2='second_subj_class';
                                    $number=count($data['second_subj_deg']);
                                }
                            else{ if(isset($_POST['subject'])&& $_POST['subject']== 0){
                                    $index1='first_subj_deg';
                                    $index2='first_subj_class';
                                    $number=count($data['first_subj_deg']);

                                    }
                                    elseif (isset($_POST['subject'])&& $_POST['subject']== 1){
                                    $index1='second_subj_deg';
                                    $index2='second_subj_class';
                                    $number=count($data['second_subj_deg']);

                                    }
                                }?>

                                <table class="table classes">
                                    <?php $i=8; for($i=8;$i<13;$i++){?>
                                <tr>
                                    <?php $alpha="ABVGDE";  for($j=0;$j<6;$j++){ ?>

                                    <td><label for="class" class="h4label"><?php echo $i.$alpha[$j]; ?></label><input type="checkbox" name="class[]" id="class[]" value="<?php echo set_checkbox('class[]', $i." ".$alpha[$j]); ?>"
                                        <?php if(isset($_POST['class'])){
                                        echo set_checkbox('class[]', $i." ".$alpha[$j]);
                                        $classes1[]=$i." ".$alpha[$j];
                                        } ?>
                                            <?php if(!empty($data['subjects'][0]))foreach($data[$index1] as $key => $degree) echo ($degree." ".$data[$index2][$key]== $i." ".$alpha[$j])?'checked':''; ?> style="margin-left: 10px"/></td>
                                     <?php  } ?>
                                </tr>
                                    <?php  } ?>


                                </table>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="list-group-item list-group-item1">
                                    <a href="<?php  echo site_url("homeController/postTeacherClasses?id=").$data['id']; ?>" class="btn list-group-item editbtn1" name="classes" value="classes" type="submit" onchange="this.form.submit()">Запис паралелки<span class="glyphicon glyphicon-floppy-saved form-control-feedback" aria-hidden="false"></a>
                </form>
                                    <a href="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getEditTeacher?id=<?php echo $data['id']; ?>" type="submit" name="refresh" value="refresh" class="btn list-group-item active editbtn1">Обновяване<span class="glyphicon glyphicon-refresh form-control-feedback" aria-hidden="false"></a>
                                    <a href="<?php echo site_url('homeController/postEditTeacher?id='.$data['id']); ?>" class="btn list-group-item editbtn1" name="postForm" value="postForm" type="submit">Запис форма<span class="glyphicon glyphicon-floppy-disk form-control-feedback" aria-hidden="false"></a>
                                    <a href="<?php echo site_url('homeController/deleteTeacher?id='.$data['id']); ?>"class="btn list-group-item editbtn1" onclick="javascript: return confirm('Сигурни ли сте, че желатете да изтриете записа?')" name="delete" value="delte" type="submit">Изтриване<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="false"></span></a>
                                    <a href="<?php echo site_url("homeController/getTeachersList?id={$data['id']}"); ?>" class="btn list-group-item editbtn1" name="list" value="list" type="submit">Списък<span class="glyphicon glyphicon-th-list form-control-feedback" aria-hidden="false"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                <!--/form-->

            </div>
        </div>
    </div>

    <div class="container-fluid back">
        <a href=""> Назад</a>
    </div>
<?php require_once "footer.php"?>