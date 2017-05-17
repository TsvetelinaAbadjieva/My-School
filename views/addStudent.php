<?php require_once "header.php"?>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Добави</a></li>
        <li><a href="<?php echo site_url('homeController/addStudent'); ?>" class="active">Добави ученик</a></li>
    </ol>
<?php $path=''; ?>
<?php require_once "navbar.php"?>




    <div class="row-fluid container-fluid addform">
        <div class="col-md-12">
            <div class="">


                <form class="form" method="post" enctype="multipart/form-data" action="<?php echo isset($id)? site_url("homeController/dispatchPostEditStudent?id={$student_id}"):site_url("homeController/dispatchPostEditStudent?id=''");
                //if(isset($_POST['submit'])) echo site_url('homeController/postStudent');
                  //  elseif(isset($_POST['edit'])) echo isset($id)? site_url('homeController/editStudent?id=').$id:'';?>">

                    <div class="col-md-12">
                        <label for=""><h2>Данни за учeник</h2></label>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('first_name'))?'has-error':''; ?>">
                            <label for="first_name"><h4>Име<h4></label>
                            <input name="first_name" type="text" class="form-control formfield" id="first_name" value="<?php echo isset($first_name)?set_value("first_name",$first_name):set_value("first_name"); ?>" placeholder="Име">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("first_name");?></span>
                        </div>
                        <div class="form-group col-md-4 <?php echo (form_error('middle_name'))?'has-error':''; ?>">
                            <label for="middle_name"><h4>Презиме<h4></label>
                            <input name="middle_name" type="text" class="form-control formfield" id="middle_name" value="<?php echo isset($middle_name)? set_value('middle_name',$middle_name):set_value('middle_name'); ?>" placeholder="Презиме">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("middle_name");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error("last_name"))?'has-error':''; ?>">
                            <label for="last_name"><h4>Фамилия<h4></label>
                            <input  name="last_name" type="text" class="form-control formfield" id="last_name"  value="<?php echo isset($last_name)? set_value('last_name',$last_name): set_value('last_name'); ?>" placeholder="Фамилия">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("last_name");?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('civilnum'))?'has-error':''; ?>">
                        <span><label for="civilnum"><h4>ЕГН<h4></label>
                        <input name="civilnum" type="text" class="form-control formfield" id="civilnum" value="<?php echo isset($civilnum)? set_value('civilnum',$civilnum):set_value('civilnum'); ?>" placeholder="ЕГН">
                        </span>
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("civilnum");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('address'))?'has-error':''; ?>">
                            <label for="address"><h4>Адрес<h4></label>
                            <input name="address" type="text" class="form-control formfield" id="address" value="<?php echo isset($address)?set_value('address',$address):set_value('address'); ?>" placeholder="Адрес">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("address");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('tel'))?'has-error':''; ?>">
                            <label for="tel"><h4>Телефон<h4></label>
                            <input name="tel" type="text" class="form-control formfield" id="tel" value="<?php echo isset($tel)?set_value('tel',$tel): set_value('tel'); ?>" placeholder="Тел.">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("tel");?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 <?php echo (form_error('email'))?'has-error':''; ?>">
                            <label for="email"><h4>Имейл<h4></label>
                            <input name="email" type="email" class="form-control formfield" id="email" value="<?php echo isset ($email)? set_value('email', $email):set_value('email'); ?>" placeholder="Имейл">
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("email");?></span>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('date_of_birth'))?'has-error':''; ?>">
                            <label for="date_of_birth"><h4>Дата на раждане<h4></label>
                            <input name="date_of_birth" type="date" class="form-control formfield" id="date_of_birth" value="<?php echo isset($date_of_birth)?set_value('date_of_birth',$date_of_birth): set_value('date_of_birth'); ?>" placeholder="Дата на раждане">
                        </div>


                        <div class="form-group col-md-4 <?php echo (!empty($upload))?'has-error':''; ?>">
                            <label for="file_img"><h4>Снимка<h4></label>
                            <input name="file_img" type="file" class="form-control formfield" id="file_img" value="<?php echo isset($file_img)?set_value('file_img',$file_img): set_value('file_img'); ?>" placeholder="Дата на раждане">
                            <?php if (!empty($upload))foreach ($upload as $error): ?>
                            <span class="alert-danger" aria-hidden="true"><?php echo $error;?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="form-group col-md-4 <?php echo (form_error('class'))?'has-error':''; ?>">
                            <label for="class"><h4>Клас<h4></label>
                            <select name="class" id="class" id=""class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <ul class="dropdown-menu">
                                <li><option name="class[]" value="Клас" selected ><a href="">Kлас</a></option></li>
                                <?php  $alpha="ABVGDE";
                                        for($i=8;$i<13;$i++)
                                            for($j=0;$j<6;$j++){?>
                                    <li><option name="class[]" value="<?php echo $i." ".$alpha[$j]; ?>"<?php echo (isset($degree)&& isset($class)&& $degree.' '.$class==$i.' '.$alpha[$j])? 'selected':''; ?> ><a href=""> <?php echo $i." ".$alpha[$j];?></a></option></li>
                                <?php } ?>
                                </ul>
                            </select>
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("class");?></span>
                        </div>
                        <div class="form-group col-md-4 <?php echo (form_error('number'))?'has-error':''; ?>">
                            <label for="num"><h4>Номер<h4></label>
                            <select name="number" id="number" id="number"class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <ul class="dropdown-menu">
                                    <li><option name="number[]" value="Номер" selected ><a href="">Номер</a></option></li>
                                    <?php for($i=1;$i<31;$i++) {?>
                                            <li><option name="number[]" value="<?php echo $i; ?>"<?php echo (isset($number)&& $number==$i)?'selected':''; ?> ><a href=""> <?php echo $i;?></a></option></li>
                                    <?php } ?>
                                </ul>
                            </select>
                            <span class="alert-danger" aria-hidden="true"><?php echo form_error("number");?></span>
                        </div>


                    </div>



<div class="row">
    <div class="col-md-12">
        <label for=""><h2>Данни за родител</h2></label>
    </div>
</div>

                        <div class="row">
                            <div class="form-group col-md-4 <?php echo (form_error('p_first_name'))?'has-error':''; ?>">
                                <label for="p_first_name"><h4>Име<h4></label>
                                <input name="p_first_name" type="text" class="form-control formfield" id="p_first_name" value="<?php echo isset($p_first_name)? set_value('p_first_name',$p_first_name): set_value("p_first_name"); ?>" placeholder="Име">
                                <span class="alert-danger" aria-hidden="true"><?php echo form_error("p_first_name");?></span>
                            </div>

                            <div class="form-group col-md-4 <?php echo (form_error("p_last_name"))?'has-error':''; ?>">
                                <label for="p_last_name"><h4>Фамилия<h4></label>
                                <input  name="p_last_name" type="text" class="form-control formfield" id="p_last_name"  value="<?php echo isset($p_last_name)?set_value('p_last_name',$p_last_name): set_value('p_last_name'); ?>" placeholder="Фамилия">
                                <span class="alert-danger" aria-hidden="true"><?php echo form_error("p_last_name");?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 <?php echo (form_error('p_email'))?'has-error':''; ?>">
                                <label for="p_email"><h4>Имейл<h4></label>
                                <input name="p_email" type="email" class="form-control formfield" id="p_email" value="<?php echo isset($p_email)? set_value('p_email',$p_email): set_value('p_email'); ?>" placeholder="Имейл">
                                <span class="alert-danger" aria-hidden="true"><?php echo  form_error("p_email");?></span>
                            </div>
                            <div class="form-group col-md-4 <?php echo (form_error('p_address'))?'has-error':''; ?>">
                                <label for="p_address"><h4>Адрес<h4></label>
                                <input name="p_address" type="text" class="form-control formfield" id="p_address" value="<?php echo isset($p_address)? set_value('p_address',$p_address) : set_value('p_address'); ?>" placeholder="Адрес">
                                <span class="alert-danger" aria-hidden="true"><?php echo form_error("p_address");?></span>
                            </div>

                            <div class="form-group col-md-4 <?php echo (form_error('p_tel'))?'has-error':''; ?>">
                                <label for="p_tel"><h4>Телефон<h4></label>
                                <input name="p_tel" type="text" class="form-control formfield" id="p_tel" value="<?php echo isset($p_tel)? set_value('p_tel',$p_tel) : set_value('p_tel'); ?>" placeholder="Тел.">
                                <span class="alert-danger" aria-hidden="true"><?php echo form_error("p_tel");?></span>
                            </div>
                        </div>





                        <div class="form-group col-md-4">
                            <div class="list-group-item list-group-item1" style="width:200px float:right margin-left:300px">
                              <?php  if ($_SESSION['logged_in']==1 && $_SESSION['role']=='admin'){?>
                                <input type="submit" value="Въведи" name="submit" class="btn list-group-item glyphicon glyphicon-th-list editbtn1"><?php isset($POST['submit'])? $path='homeController/postStudent':''; ?>
                               <?php } ?>
                                <input type="submit" value="Промяна" name="edit" class="btn list-group-item glyphicon glyphicon-th-list editbtn1"><?php isset($POST['edit'])? $path="homeController/editStudent?id={$student_id}":''; ?>
                                <a href="<?php echo site_url("homeController/getStudentsList?"); ?>" class="btn list-group-item editbtn1" name="list" value="list" type="submit">Списък<span class="glyphicon glyphicon-th-list form-control-feedback" aria-hidden="false"></a>
                                <?php if ($this->session->userdata('role')=='teacher'){ ?>
                                <a href="<?php echo site_url("homeController/getJurnal"); ?>" class="btn list-group-item editbtn1" name="list" value="list" type="submit">Дневник<span class="glyphicon glyphicon-th-list form-control-feedback" aria-hidden="false"></a>
                            <?php } ?>
                            </div>
                        </div>


                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid back">
        <a href=""> Назад</a>
    </div>
<?php require_once "footer.php"?>