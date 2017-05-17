<?php require_once "header.php"?>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
        <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Добави</a></li>
        <li class="active">Добави учител</li>
    </ol>

<?php require_once "navbar.php"?>




    <div class="row-fluid container-fluid addform">
        <div class="col-md-12">
            <div class="">


                <form class="form" method="post" action="<?php echo base_url().'/homecontroller/postTeacher'; ?>">

                    <div class="col-md-12">
                        <label for=""><h2>Данни за учител</h2></label>
                    </div>
                <div class="row">
                    <div class="form-group col-md-4 <?php echo (form_error('first_name'))?'has-error':''; ?>">
                        <label for="first_name"><h4>Име<h4></label>
                        <input name="first_name" type="text" class="form-control formfield" id="first_name" value="<?php echo set_value("first_name"); ?>" placeholder="Име">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("first_name");?></span>
                    </div>
                    <div class="form-group col-md-4 <?php echo (form_error('middle_name'))?'has-error':''; ?>">
                        <label for="middle_name"><h4>Презиме<h4></label>
                        <input name="middle_name" type="text" class="form-control formfield" id="middle_name" value="<?php echo set_value('middle_name'); ?>" placeholder="Презиме">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("middle_name");?></span>
                    </div>

                    <div class="form-group col-md-4 <?php echo (form_error("last_name"))?'has-error':''; ?>">
                        <label for="last_name"><h4>Фамилия<h4></label>
                        <input  name="last_name" type="text" class="form-control formfield" id="last_name"  value="<?php echo set_value('last_name'); ?>" placeholder="Фамилия">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("last_name");?></span>
                    </div>


                </div>

                <div class="row">
                    <div class="form-group col-md-4 <?php echo (form_error('civilnum'))?'has-error':''; ?>">
                        <span><label for="civilnum"><h4>ЕГН<h4></label>
                        <input name="civilnum" type="text" class="form-control formfield" id="civilnum" value="<?php echo set_value('civilnum'); ?>" placeholder="ЕГН">
                        </span>
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("civilnum");?></span>
                    </div>

                    <div class="form-group col-md-4 <?php echo (form_error('address'))?'has-error':''; ?>">
                        <label for="address"><h4>Адрес<h4></label>
                        <input name="address" type="text" class="form-control formfield" id="address" value="<?php echo set_value('address'); ?>" placeholder="Адрес">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("address");?></span>
                    </div>

                    <div class="form-group col-md-4 <?php echo (form_error('tel'))?'has-error':''; ?>">
                        <label for="tel"><h4>Телефон<h4></label>
                        <input name="tel" type="text" class="form-control formfield" id="tel" value="<?php echo set_value('tel'); ?>" placeholder="Тел.">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("tel");?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4 <?php echo (form_error('email'))?'has-error':''; ?>">
                        <label for="email"><h4>Имейл<h4></label>
                        <input name="email" type="email" class="form-control formfield" id="email" value="<?php echo set_value('email'); ?>" placeholder="Имейл">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("email");?></span>
                    </div>

                    <div class="form-group col-md-4 <?php echo (form_error('date_of_birth'))?'has-error':''; ?>">
                        <label for="date_of_birth"><h4>Дата на раждане<h4></label>
                        <input name="date_of_birth" type="date" class="form-control formfield" id="date_of_birth" value="<?php echo set_value('date_of_birth'); ?>" placeholder="Дата на раждане">
                    </div>

                    <div class="col-md-2">
                        <input type="submit" href="<?php echo site_url('homecontroller/postTeacher') ?>" name="addTeacher" value="Въведи" class="btn btn-primary" style="width:150px; float:right; margin-top:40px;"></input>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-4 <?php echo (form_error('subject'))?'has-error':''; ?>">
                        <label for="subject"><h4>Учебен премет</h4></label>
                        <input name="subject" type="text" class="form-control formfield" id="subject" value="<?php echo set_value('subject'); ?>" placeholder="Учебен предмет">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("subject");?></span>
                    </div>

                    <div class="form-group col-md-4 <?php echo (form_error('subject2'))?'has-error':''; ?>">
                        <label for="subject2"><h4>Втори учебен предмет</h4></label>
                        <input name="subject2" type="text" class="form-control formfield" id="subject2" value="<?php echo set_value('subject2'); ?>" placeholder="Втори предмет">
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("subject2");?></span>
                    </div>



                    <div class="col-md-2">
                        <a type="submit" href="<?php echo site_url('homecontroller/getTeachersList') ?>" name="teachersList" value="Списък" class="btn btn-primary form-group" style="width:150px; float:right; margin-top:40px;">Списък</a>
                    </div>


                </div>


                </form>
            </div>
        </div>
    </div>

<div class="container-fluid back">

</div>
<?php require_once "footer.php"?>