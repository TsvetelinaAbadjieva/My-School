<?php require_once "header.php"?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li><a href="<?php echo site_url('homeController/getJurnal'); ?>">Дневник</a></li>
    <li class="active">Детайли за ученик</li>
</ol>
<?php require_once "navbar.php"?>
<?php $currentURL="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getJurnal"; ?>

<div class="row">

        <div class="col-md-12">
            <h2><i class="glyphicon glyphicon-education"></i>   Данни за ученик</h2>
        </div>
        <div class="col-md-12">
            <div class="col-md-2">
                <label for="" style="margin-left:15px; margin-top:20px"><h5 class="first_h5">Име на ученик:</h5></label>
            </div>
            <div class="col-md-9">
                <label for=""><h3 class="name"><?php echo $names[0]['first_name'].' '.$names[0]['middle_name'].' '.$names[0]['last_name']; ?></h3></label>
            </div>
        </div>

</div>
<div class="row">
        <div class="col-md-12">

            <div class="col-md-8">
                <div class="form-group col-md-3">
                    <label for="" style="margin-top:40px"><h5>Отсъствия към дата:</h5></label>
                </div>
                <div class="form-group col-md-5">
                    <input type="text" value="<?php echo "Дата  ".date("Y-m-d H:i:s"); ?>" readonly class="form-control" style="color:white; background-color: transparent; margin-top: 35px">
                </div>
            <table class="table table-hover mytable">
                <tr>
                    <th>Общ брой извинени</th>
                    <th>Общ брой неизвинени</th>
                    <th>В това число закъснения</th>
                    <th>Необработени</th>
                </tr>
                <tr>
                    <td><?php echo $abscences[0]['Извинени']; ?></td>
                    <td><?php echo $abscences[0]['Неизвинени']; ?></td>
                    <td><?php echo $abscences[0]['Закъснения']; ?></td>
                    <td><?php echo $abscences[0]['Текущи']; ?></td>
                </tr>
            </table>
                <label for=""><h5>Бележки върху поведението:</h5></label>
            <table class="table table-hover mytable">
                <th>Забележки</th>
                <th>Учебен Предмет</th>
                <th>Дата</th>


                    <?php for($i=0;$i<count($discipline);$i++)
                        if (isset($discipline[$i]['Бележки'])){?>
                        <tr>
                            <td><?php echo $discipline[$i]['Бележки']; ?></td>
                            <td><?php echo $discipline[$i]['Предмет']; ?></td>
                            <td><?php echo $discipline[$i]['Дата']; ?></td>
                        </tr>
                    <?php } ?>


            </table>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-3">
        <label for=""><h5>Резултати от обучение:</h5></label>
        </div>
        <table class="table table-hover mytable">
            <?php
            $count=0;
            if($data!=null && count($data)>0) {
                while ($count < count($data)) { ?>
                    <?php if ($count == 0) { ?>
                        <tr>
                            <?php $i = 0;
                            foreach ($data[$i] as $key => $value){ ?>

                                <th class="mytable" style="font-size: small">
                                    <?php

                                    $key=(strpos($key,'_')>0)? str_replace('_',' ',$key):$key;
                                    if (!is_array($value) && $key != 'student id') echo $key;
                                    elseif(is_array($value)) echo $value['Предмет'];
                                    $i++;?>
                                </th>

                            <?php }  ?>

                        </tr>
                    <?php } ?>

                    <tr>

                        <?php foreach ($data[$count] as $key => $value) {?>
                        <form action="<?php echo "{$currentURL}"; ?>" method="post">

                            <?php  if(!is_array($value)&& $key =='Снимка'){?>
                                <td><img src="<?php echo IMAGE_PATH.$value;?>"; alt="" style="width:80px; height: 80px;"> </td>
                            <?php }

                            else {?>
                                <td style="<?php if ($key=='Номер'|| $key=='Степен'||$key=='Паралелка') echo "width:10px"; ?>"><?php if  ($key != 'student_id'&& !is_array($value)) echo $value; else if (is_array($value)) echo $value['Оценки']; ?></td>
                            <?php } ?>
                            <?php } ?>
                            <td>
                                <?php if(isset($_SESSION['role']) && $this->session->userdata('role')=='teacher') {?>
                                <button href="<?php echo "{$currentURL}?profile={$_SESSION['active_subject']}"; ?>" type="submit" name="details" value="Деатйли" class="btn editbtn">
                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="false"></span></button>
                                    <?php } ?>
                            </td>
                    </tr>

                    <?php $count++; ?>
                    </form>
                <?php }// end while
            }//endif
            else echo "<td colspan=\"10\"><span><h3>\"Няма съвпадащи записи!\"</h3></span></td>";?>

        </table>

    </div>
</div>


<?php require_once "footer.php"?>
