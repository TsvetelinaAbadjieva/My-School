<?php require_once "header.php"?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Информация</a></li>
    <li><a href="<?php echo site_url('homeController/getStudentsList'); ?>" class="active">Списък Ученици</a></li>
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