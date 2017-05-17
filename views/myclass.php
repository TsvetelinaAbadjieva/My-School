<?php require_once "header.php"?>
<ol class="breadcrumb">
    <li><a href="<?php echo site_url('homeController/getMainPage'); ?>">Начало</a></li>
    <li class="active">Моя Клас</li>
</ol>
<?php require_once "navbar.php"?>
<?php $currentURL=base_url().'/homeController/getMyClass';
$url=PATH.'/homeController/updateAbscences';?>

<?php $note='';  $discipline=''; $id=0;?>

<div class="row">
    <div class="col-md-12">
        <div>
            <h2><i class="glyphicon glyphicon-education"></i>   Обработка на Отсъствия</h2>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <input type="text" value="<?php echo "Дата  ".date("Y-m-d H:i:s"); ?>" readonly class="form-control" style="color:white; background-color: transparent; margin-top: 35px">
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
                <?php if(!empty($names[0]))
                    for ($i=0;$i<count($names);$i++){ ?>

            <div class="col-md-12">
                <table class="table table-hover mytable1">
                    <tr>
                        <th>Снимка</th>
                        <th>Номер</th>
                        <th>Клас</th>
                        <th>Име</th>
                        <th>Общ брой извинени</th>
                        <th>Общ брой неизвинени</th>
                        <th>В това число закъснения</th>
                        <th>Необработени</th>
                    </tr>

                    <tr>
                        <td><img src="<?php echo IMAGE_PATH.$names[$i]['Снимка'];?>"; alt="" style="width:80px; height: 80px;"> </td>
                        <td><?php echo $names[$i]['Номер']; ?></td>
                        <td><?php echo $names[$i]['Клас']; ?></td>
                        <td><?php echo $names[$i]['Име']; ?></td>
                        <td><?php echo isset($abscences[$i]['Извинени'])?$abscences[$i]['Извинени']:'0'; ?></td>
                        <td><?php echo isset($abscences[$i]['Неизвинени'])?$abscences[$i]['Неизвинени']:'0'; ?></td>
                        <td><?php echo isset($abscences[$i]['Закъснения'])?$abscences[$i]['Закъснения']:'0'; ?></td>
                        <td><?php echo isset($abscences[$i]['Текущи'])?$abscences[$i]['Текущи']:'0'; ?></td>
                    </tr>
                </table>


                <table class="table table-hover mytable">
                    <?php
                    $count=0;
                    $abs=array_values($abscences[$i]);

                    if(!empty(array_values($abs)) && count($abscences[$i])>0) {
                      //  while ($count < count($actual_abs[$i])){
                            if($actual_abs[$i]!==false ) { ?>
                             <!--   if(!empty($actual_abs[$i]) && !empty(array_values($actual_abs[$i]))) { ?>-->

                                <tr>

                                    <th class="mytable">Дата</th>
                                    <th class="mytable">Предмет</th>
                                    <th class="mytable">Текущи отсъствия</th>
                                    <th class="mytable">Закъснения</th>
                                    <th class="mytable">Обработи като:</th>

                                </tr>


                                <?php for ($j = 0; $j < count($actual_abs[$i]); $j++){?>

                                        <tr>
                                            <td><?php echo $actual_abs[$i][$j]['Дата']; ?></td>
                                            <td><?php echo $actual_abs[$i][$j]['Предмет']; ?></td>
                                            <td><?php echo $actual_abs[$i][$j]['Текущи']; ?></td>
                                            <td><?php echo $actual_abs[$i][$j]['Закъснения']; ?></td>
                                            <form action="<?php echo "{$url}?id={$actual_abs[$i][$j]['id']}"; ?>" method="post">
                                            <td style="width:260px">
                                                <input type="radio" name="abs[]" value="1"><label for="radio[]"
                                                                                                  style="font-size: 12px">Извинено</label>
                                                <input type="radio" name="abs[]" value="2"><label for="radio[]"
                                                                                                  style="font-size: 12px">Неизвинено</label>
                                                <input type="radio" name="abs[]" value="3" checked><label for="radio[]"
                                                                                                          style="font-size: 12px">Изчисти</label>
                                            </td>
                                            <td><?php $id= $actual_abs[$i][$j]['id'];?>
                                                <button href="<?php echo "{$url}?id={$id}&abs={$abs[0]}&page={$active_page}"; ?>"
                                                        type="submit" name="submit" value="Запис" class="btn editbtn">
                                                    <span class="glyphicon glyphicon-floppy-disk"
                                                          aria-hidden="false"></span></button>
                                            </td>
                                            </form>
                                        </tr>
                                    <?php }//endFor
                                }// endIf?>


                            <?php // $count++; }?>
                        <?php } ?>
                </table>
            </div>
                 <?php } else echo "<td colspan=\"10\"><span><h3 style='color:orange; margin-right:-40px; margin-top:35px;'>\"Няма съвпадащи записи!\"</h3></span></td>"; ?><!-- end for-->




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
