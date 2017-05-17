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
