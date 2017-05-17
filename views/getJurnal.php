<?php require_once "header.php"?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li class="active">Девник</li>
</ol>

<?php require_once "navbar.php"?>
<?php $currentURL="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getJurnal";

$activeSubject=isset($_SESSION['active_subject'])?$_SESSION['active_subject']:'';
$profile=isset($_GET['profile'])?$_GET['profile']:$activeSubject;
/*
$search= isset($_POST['search'])?$_POST['search']:'';
if (!isset($_SESSION['search']))
    $_SESSION['search']='';

$search=isset($_POST['submit'])?$_SESSION['search']=$_POST['search']:$_SESSION['search'];
*/
    $_SESSION['rows_per_page']='5';



?>
<?php $note='';  $discipline='';?>

<div class="row">
    <div class="col-md-12">
        <div>
            <h2><i class="glyphicon glyphicon-education"></i>   Дневник оценки</h2>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="form-group col-md-4">
                    <input type="text" value="<?php echo "Дата  ".date("Y-m-d H:i:s"); ?>" readonly class="form-control" style="color:white; background-color: transparent; margin-top: 35px">
                </div>

                <div class="col-md-5 search">
                    <form class="navbar-form navbar-left" role="search" action="<?php  echo isset($_POST['search'])&& isset($_POST['submit'])? "{$currentURL}?page={$active_page}&search={$search}&rows_per_page={$rows_per_page}&id=''": "{$currentURL}?page={$active_page}&search={$search}&rows_per_page={$rows_per_page}&id=''";?>" method="get">
                        <div class="form-group">
                            <select name="rows_per_page" id="rows_per_page"  class="btn btn-default dropdown-toggle btn1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:7px">
                                <option  value="5" selected>Резултати на стр.</option>
                                <option value="10" <?php echo (isset($rows_per_page) && ($rows_per_page=='10'))?'selected':''; ?>>10</option>
                                <option  value="15" <?php echo (isset($rows_per_page) && ($rows_per_page=='15'))?'selected':''; ?>>15</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="text" name="search" value="<?php echo isset($_POST['search'])?$_POST['search']:'';//isset($_POST['search'])?$this->session->set_userdata('search'):$this->session->userdata('search'); ?>" class="form-control" placeholder="Search" style="margin-top:10px">
                        </div>
                        <button href="<?php  echo isset($_POST['search'])? "{$currentURL}?page={$active_page}&search=".$search : "{$currentURL}?page={$active_page}&id=''";  ?>" type="submit" name="submit" value="submit" class="btn btn-default glyphicon glyphicon-search btn1" style="margin-top:10px"></button>
                    </form>
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
                                <form action="<?php echo "{$currentURL}?id={$data[$count]['student_id']}"; ?>" method="post">

                                    <?php  if(!is_array($value)&& $key =='Снимка'){?>
                                        <td><img src="<?php echo IMAGE_PATH.$value;?>"; alt="" style="width:80px; height: 80px;"> </td>
                                    <?php }

                                        else {?>
                                            <td style="<?php if ($key=='Номер'|| $key=='Степен'||$key=='Паралелка') echo "width:10px"; ?>"><?php if  ($key != 'student_id'&& !is_array($value)) echo $value; else if (is_array($value)) echo $value['Оценки']; ?></td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td>
                                        <a href="<?php echo "{$currentURL}?id={$data[$count]['student_id']}&profile={$_SESSION['active_subject']}"; ?>" type="submit" name="details" value="Деатйли" class="btn editbtn">
                                            <span class="glyphicon glyphicon-list-alt" aria-hidden="false"></span></a>
                                        <a href="<?php echo PATH."/homeController/getStudentForEdit?id={$data[$count]['student_id']}"; ?>" type="submit" name="edit" value="edit" class="btn editbtn">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="false"></span></a>
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

        <div class="row">
            <nav aria-label="...">
                <ul class="pager">
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page=1&search={$search}&rows_per_page={$rows_per_page}&id=''"; ?>"><i class="glyphicon glyphicon-step-backward"></i></a></li>

                    <li><a name="pager[]" href="<?php  ($active_page >3) ? $page=$active_page-1 :$page=1; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}&id=''"; ?>"><i class="glyphicon glyphicon-backward"></i></a></li>
                    <?php  if($active_page-1<=1){$j=1; $active_page=1;} else {$j=$active_page-1;} for ($i=$j; $i<$j+3;$i++) {?>
                        <li class="<?php echo($i<=$total_pages)?'active':'disabled'; ?>"><a name="pager[]" href="<?php   echo ($i-1<$total_pages)? "{$currentURL}?page={$i}&search={$search}&rows_per_page={$rows_per_page}&id=''": "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}&id=''"; ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                    <?php  }?>

                    <li><a name="pager[]" href="<?php ( $active_page< $total_pages) ? $page=$active_page+1 :$page=$total_pages; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}&id=''"; ?>"><i class="glyphicon glyphicon-forward"></i></a></li>
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}&id=''"; ?>"><i class="glyphicon glyphicon-step-forward"></i></a></li>
                </ul>
            </nav>
        </div>


    </div>
</div>


<?php require_once "footer.php"?>
