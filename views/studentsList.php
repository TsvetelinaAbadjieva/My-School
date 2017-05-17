<?php require_once "header.php"?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Информация</a></li>
    <li class="active">Списък Ученици</li>
</ol>
<?php require_once "navbar.php"?>
<?php $currentURL=PATH."/homeController/getStudentsList"; ?>

<div class="row">
    <div class="col-md-12">
        <div>
            <h2><i class="glyphicon glyphicon-education"></i>   Списък ученици</h2>
        </div>

        <div class="col-md-5 search">
            <form class="navbar-form navbar-left" role="search" action="<?php  echo isset($_POST['search'])&& isset($_POST['submit'])? "{$currentURL}?page={$active_page}&search={$search}&rows_per_page={$rows_per_page}": "{$currentURL}?page={$active_page}&rows_per_page={$rows_per_page}";?>" method="get">
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
                <button href="<?php  echo isset($_POST['search'])? "{$currentURL}?page={$active_page}&search=".$search : "{$currentURL}?page={$active_page}";  ?>" type="submit" name="submit" value="submit" class="btn btn-default glyphicon glyphicon-search btn1" style="margin-top:10px"></button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
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
                                    <th class="mytable">Опции</th>
                                </tr>
                            <?php } ?>

                            <tr>

                                <?php foreach ($data[$count] as $key => $value) {
                                    if($key =='Снимка'){?>
                                    <td><img src="<?php echo IMAGE_PATH.$value;?>"; alt="" style="width:80px; height: 80px;"> </td>
                                        <?php }
                                        else { ?>
                                    <td style="<?php if ($key=='Номер'|| $key=='Степен'||$key=='Паралелка') echo "width:10px"; ?>"><?php  echo ($key != 'id') ? $value : ''; ?></td>
                                        <?php } ?>
                                <?php } ?>
                                <td>
                                    <a href="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getStudentsList?id=<?php echo $data[$count]['id']; ?>"
                                       type="submit" name="details" value="Детайли" class="btn editbtn"><span
                                                class="glyphicon glyphicon-list-alt" aria-hidden="false"></a>
                                    <a href="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getStudentForEdit?id=<?php echo $data[$count]['id']; ?>"
                                       type="submit" name="edit" value="" class="btn editbtn"><span
                                                class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="http://mylocal.dev/MyPHP_files/school/index.php/homeController/getJurnal?id=<?php echo $data[$count]['id']; ?>"
                                       type="submit" name="edit" value="" class="btn editbtn"><span
                                                class="glyphicon glyphicon-list" aria-hidden="true"></span></a>
                                <?php  if ($_SESSION['logged_in']==1 && $_SESSION['role']=='admin'){?>
                                    <a href="http://mylocal.dev/MyPHP_files/school/index.php/homeController/deleteStudent?id=<?php echo $data[$count]['id']; ?>"
                                       type="submit" name="delete" value="Изтриване" class="btn editbtn"><span
                                                class="glyphicon glyphicon-trash" aria-hidden="true"
                                                onclick='javascript:return confirm("Сигурни ли сте, че желаете да изтриете този запис?")'></a>
                              <?php } ?>
                            </td>
                            </tr>

                            <?php $count++; ?>

                        <?php }// end while
                    }//endif
                    else echo "Няма съвпадащи записи!"?>
                </table>
            </div>
        </div>

        <div class="row">
            <nav aria-label="...">
                <ul class="pager">
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page=1&search={$search}&rows_per_page={$rows_per_page}"; ?>"><i class="glyphicon glyphicon-step-backward"></i></a></li>

                    <li><a name="pager[]" href="<?php  ($active_page >3) ? $page=$active_page-1 :$page=1; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}"; ?>"><i class="glyphicon glyphicon-backward"></i></a></li>
                    <?php  if($active_page-1<=1){$j=1; $active_page=1;} else {$j=$active_page-1;} for ($i=$j; $i<$j+3;$i++) {?>
                        <li class="<?php echo($i<=$total_pages)?'active':'disabled'; ?>"><a name="pager[]" href="<?php   echo ($i-1<$total_pages)? "{$currentURL}?page={$i}&search={$search}&rows_per_page={$rows_per_page}": "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}"; ?>"><?php echo $i; ?><span class="sr-only">(current)</span></a></li>
                    <?php  }?>

                    <li><a name="pager[]" href="<?php ( $active_page< $total_pages) ? $page=$active_page+1 :$page=$total_pages; echo "{$currentURL}?page={$page}&search={$search}&rows_per_page={$rows_per_page}"; ?>"><i class="glyphicon glyphicon-forward"></i></a></li>
                    <li><a name="pager[]" href="<?php  echo "{$currentURL}?page={$total_pages}&search={$search}&rows_per_page={$rows_per_page}"; ?>"><i class="glyphicon glyphicon-step-forward"></i></a></li>
                </ul>
            </nav>
        </div>


    </div>
</div>


<?php require_once "footer.php"?>
