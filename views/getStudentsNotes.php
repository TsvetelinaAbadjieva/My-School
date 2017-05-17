<?php require_once "header.php"?>
<?php $currentURL=base_url().'/homeController/getStudentsNotes'; ?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li class="active">Оценки</li>
</ol>
<?php require_once "navbar.php"?>
<?php $currentURL=base_url().'/homeController/getStudentsNotes'; ?>
<?php $note='';  $discipline='';
$active_subject=isset($_SESSION['active_subject'])?$_SESSION['active_subject']:'';
$profile= isset($_GET['profile'])?htmlspecialchars(trim($_GET['profile']),3): $active_subject;
?>

<div class="row">
    <div class="col-md-12">
        <div>
            <h2><i class="glyphicon glyphicon-education"></i>   Списък ученици</h2>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <input type="text" value="<?php echo "Дата  ".date("Y-m-d H:i:s"); ?>" readonly class="form-control" style="color:white; background-color: transparent; margin-top: 35px">
                </div>

                <div class="col-md-5 search">
                    <form class="navbar-form navbar-left" role="search" action="<?php  echo isset($_POST['search'])&& isset($_POST['submit'])? "{$currentURL}?page={$active_page}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}": "{$currentURL}?page={$active_page}&rows_per_page={$rows_per_page}&profile={$profile}";?>" method="get">
                        <div class="form-group">
                            <select name="rows_per_page" id="rows_per_page"  class="btn btn-default dropdown-toggle btn1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:7px">
                                <option  value="5" selected>Резултати на стр. - 5</option>
                                <option value="10" <?php echo (isset($rows_per_page) && ($rows_per_page=='10'))?'selected':''; ?>>10</option>
                                <option  value="15" <?php echo (isset($rows_per_page) && ($rows_per_page=='15'))?'selected':''; ?>>15</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <input type="text" name="search" value="<?php echo isset($_POST['search'])?$_POST['search']:'';//isset($_POST['search'])?$this->session->set_userdata('search'):$this->session->userdata('search'); ?>" class="form-control" placeholder="Search" style="margin-top:10px">
                        </div>
                        <button href="<?php  echo isset($_POST['search'])? "{$currentURL}?page={$active_page}&search={$search}&profile={$profile}" : "{$currentURL}?page={$active_page}&profile={$profile}";  ?>" type="submit" name="submit" value="submit" class="btn btn-default glyphicon glyphicon-search btn1" style="margin-top:10px"></button>
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

                                    <th class="mytable">
                                        <?php
                                        $key=(strpos($key,'_')>0)? str_replace('_',' ',$key):$key;
                                        echo ($key != 'id'&& $key!='Степен' && $key!='Паралелка') ? $key : '';
                                        echo ($key=='Паралелка')?'Клас':'';
                                        $i++;

                                        } ?>
                                    </th>
                                    <th class="mytable">Оценка</th>
                                    <th class="mytable">Вид</th>
                                    <th class="mytable">Отсъствия</th>
                                    <th class="mytable">Бележки</th>
                                    <th class="mytable">Запис</th>

                                </tr>
                            <?php } ?>

                            <tr>

                                <?php foreach ($data[$count] as $key => $value) {?>
                                    <form action="<?php echo PATH."homeController/insertNote?id={$data[$count]['id']}&profile={$profile}&page={$active_page}&search={$search}"; ?>" method="post">

                                 <?php  if($key =='Снимка'){?>
                                        <td><img src="<?php echo "../assets/uploads/images/{$value}";?>"; alt="" style="width:80px; height: 80px;"> </td>
                                    <?php }
                                    else { ?>
                                        <td style="<?php if ($key=='Номер'|| $key=='Степен'||$key=='Паралелка') echo "width:10px"; ?>"><?php  echo ($key != 'id') ? $value : ''; ?></td>
                                    <?php } ?>
                                <?php } ?>
                                <td>
                                    <div class="form-group col-md-4 <?php echo (form_error('note'))?'has-error':''; ?>">
                                    <input type="text" name="note" value="<?php  ?>" style="width:35px" class="form-control">
                                    <span class="alert-danger" aria-hidden="true"><?php echo form_error("note");?></span>

                                    </div>
                                </td>
                                <td style="width:220px">
                                    <input type="radio" name="type_note[]" value="1" checked><label for="radio[]" style="font-size: 12px">Текуща</label>
                                    <input type="radio" name="type_note[]" value="2"><label for="radio[]" style="font-size: 12px">Срочна</label>
                                    <input type="radio" name="type_note[]" value="3"><label for="radio[]" style="font-size: 12px">Годишна</label>

                                </td>
                                <td style="width:260px">
                                    <input type="radio" name="abscence[]" value="1"><label for="radio[]" style="font-size: 12px">Отсъствие</label>
                                    <input type="radio" name="abscence[]" value="2"><label for="radio[]" style="font-size: 12px">Закъснение</label>
                                    <input type="radio" name="abscence[]" value="3" checked><label for="radio[]" style="font-size: 12px">Изчисти</label>

                                </td>
                                <td>
                                    <div class="form-group col-md-4 <?php echo (form_error('discipline'))?'has-error':''; ?>"style="width:160px">

                                    <input type="text" name="discipline" id="discipline" class="form-control" value="" style="width:150px">
                                     <span class="alert-danger" aria-hidden="true"><?php echo form_error("discipline");?></span>
                                    </div>
                                </td>
                                <td>
                                    <button href="<?php echo PATH; ?>/homeController/getStudentsList?id=<?php echo $data[$count]['id']."&profile={$_SESSION['active_subject']}&page={$page}"; ?>" type="submit" name="submit" value="Запис" class="btn editbtn">
                                           <span class="glyphicon glyphicon-floppy-disk" aria-hidden="false"></span></button>
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
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page=1&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}"; ?>"><i class="glyphicon glyphicon-step-backward"></i></a></li>

                    <li><a name="pager[]" href="<?php  ($active_page >3) ? $page=$active_page-1 :$page=1; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}"; ?>"><i class="glyphicon glyphicon-backward"></i></a></li>
                    <?php  if($active_page-1<=1){$j=1; $active_page=1;} else {$j=$active_page-1;} for ($i=$j; $i<$j+3;$i++) {?>
                        <li class="<?php echo($i<=$total_pages)?'active':'disabled'; ?>"><a name="pager[]" href="<?php   echo ($i-1<$total_pages)? "{$currentURL}?page={$i}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}": "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}"; ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                    <?php  }?>

                    <li><a name="pager[]" href="<?php ( $active_page< $total_pages) ? $page=$active_page+1 :$page=$total_pages; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}"; ?>"><i class="glyphicon glyphicon-forward"></i></a></li>
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}&profile={$profile}"; ?>"><i class="glyphicon glyphicon-step-forward"></i></a></li>
                </ul>
            </nav>
        </div>


    </div>
</div>


<?php require_once "footer.php"?>
