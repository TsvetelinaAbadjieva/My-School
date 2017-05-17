
<?php
$redirect='';

$page='';

$currentURL=PATH.'homeController/getMainPage';
$activeSubject=isset($_SESSION['active_subject'])?$_SESSION['active_subject']:'';
$profile=isset($_GET['profile'])?$_GET['profile']:$activeSubject;

?>


<script type="text/javascript">
    document.getElementById('profile').value = "<?php echo $_GET['profile'];?>";
    <?php echo $_GET['profile']; ?>
</script>


<div class="row">
    <div class="col-md-12 container-fluid">
        <ul class="nav nav-pills goleft">
            <i for="" ></i>
            <li role="presentation" class="" style="float:left"><a href="#" class="glyphicon glyphicon-user"><?php echo (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1)? " ".$_SESSION['username']:''; ?></a></li>
            <li role="presentation">
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && $_SESSION['role']=='teacher' && (!empty($_SESSION['profile']))) {?>
                    <form action="<?php if (isset($_POST['submit'])) { $_SESSION['active_subject']=$profile; echo $currentURL."?profile={$_SESSION['active_subject']}&id=''";} ?>" method="get">
                    <select class="dropdown-toggle profile navdesign " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  name="profile" id="profile" value="<?php echo $_GET['profile']; $_SESSION['active_subject']=$_GET['profile']; ?>"  onchange="this.form.submit()">Добавяне
                        <?php foreach($_SESSION['profile'] as $subject): ?>
                        <option value="<?php echo $subject; ?>"<?php if ($profile==$subject){ echo'selected'; $_SESSION['active_subject']=$profile;} else echo''; ?>>
                           <?php echo $subject; ?></option>
                        <?php endforeach; ?>
                    </select>
                        <button type="submit" name="submit" value="select" class="glyphicon glyphicon-refresh btn btn-default btn1">
                    </form>
                <?php } ?>
            </li>

        </ul>




        <ul class="nav nav-pills navbar-collapse navdesign">

            <li role="presentation" name="add" class="">
              <form method ="post" action="<?php  echo(isset($_POST['options'])&& $_POST['options']!='options')? base_url().$_POST['options']:base_url()."/homeController/getMainPage";?>" >
                  <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && $_SESSION['role']=='admin') {?>
                    <select class="dropdown-toggle profile navdesign " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="options" id="options"onchange="this.form.submit()">
                            <option name="options[]" value="/homeController/getMainPage" selected><a class="navdesign" href=""<?php echo site_url('homeController/getMainPage'); $page='getMainPage'; ?>>Добави</a></option></li>
                            <option name="options[]" value="/homeController/addTeacher"><a class="navdesign" href="<?php echo site_url('homeController/addTeacher'); $page='addTeacher';?>">Добави Учител</a></option>
                            <option name="options[]" value="/homeController/getTeachersList"><a href="<?php echo site_url('homeController/getEditTeacher'); $page='getEditTeacher'; ?>">Редактирай Учител</a></option>
                            <option name="options[]" value="/homeController/addStudent"><a href="<?php echo site_url('homeController/addStudent'); $page='addStudent';?>">Добави Ученик</a></option>
                            <option name="options[]" value="/homeController/getStudentsList"><a href="<?php echo site_url('homeController/addTeacher');$page='addTeacher'; ?>">Редактирай Ученик</a></option>

                    </select>
                    <?php } ?>
              </form>
            </li>


            <li role="presentation" name="add" class="">
                <form action="<?php echo(isset($_POST['general'])&& $_POST['general']!='general')? base_url().$_POST['general']:base_url()."/homeController/getMainPage"; ?>" method="post">

                    <select name="general" id="general" class="navdesign dropdown-toggle profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onchange="this.form.submit()">Информация
                        <span><label for=""><i class="profile glyphicon glyphicon-list-alt" >Информация</i></label></span>
                    <option name="general[]" value="general" selected><a href="">Информация</a></option>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && $_SESSION['role']=='admin') {?>

                    <option name="general[]" value="/homeController/getTeachersList"><a href="">Списък Учители</a></option>
                        <?php } if ($_SESSION['role']=='admin'||$_SESSION['role']=='teacher'){?>
                    <option name="general[]" value="/homeController/getStudentsList"><a href="">Списък Ученици</a></option>
                        <?php } ?>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && $_SESSION['role']=='guest') {?>
                        <option name="general[]" value="<?php echo "/homeController/getJurnal?id={$this->session->userdata('person_id')}"; ?>"><a href="">Списък Ученици</a></option>
                    <?php } ?>
                    </select>
                </form>
            </li>
            <?php if($_SESSION['role']=='teacher') {?>
            <li role="presentation"><a href="<?php echo base_url()."homeController/getJurnal?id=''"; ?>" class="glyphicon glyphicon-book"> Дневник</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && $_SESSION['role']=='teacher' && isset($_SESSION['mydegree'])) {?>
            <li role="presentation"><a href="<?php echo base_url()."homeController/getMyClass"; ?>">Моя клас</a></li>
            <?php } ?>

                <li role="presentation"><a href="<?php echo base_url()."homeController/getStudentsNotes?profile={$_SESSION['active_subject']}"; ?>">Оценки</a></li>
            <?php } ?>
            <li role="presentation"><a href="<?php echo base_url()."homeController/logout"; ?>">Изход</a></li>
        </ul>
    </div>
</div>