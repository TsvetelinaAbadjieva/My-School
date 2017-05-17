<?php require_once "header.php"?>
<?php
$errors=[
    'username' =>'',
    'password'=>''
];

?>

<div class="row-fluid body">
<div class="col-md-12">
    <div class="login">

        <div class="row">
            <div class="">
                <form class="form" method="post" action="http://mylocal.dev/MyPHP_files/school/homeController/postHomePage">

                    <div class="form-group ">
                        <label for="exampleInputEmail1"><h4>Потребителско име<h4></label>
                        <div class="error">

                            <div class="textfield <?php echo(strlen(form_error('password'))>0)?'has-error glyphicon glyphicon-exclamation-sign':''; ?>">
                                <input type="email"  name="username" class="form-control -align-center fieldcontent" id="username" placeholder="Username" value="<?php echo set_value('username'); ?>"/>
                                <span class="alert-danger" aria-hidden="true"><?php echo form_error("username");?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1"><h4>Парола<h4></label>
                        <div class="error">

                             <div class="textfield <?php echo(strlen(form_error('password'))>0)?'has-error glyphicon glyphicon-exclamation-sign':''; ?>">
                                  <input type="password" class="form-control -align-center fieldcontent" id="password" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                                 <span class="alert-danger" aria-hidden="true"><?php echo form_error("password");?></span>
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Вход" class="btn bt-lg btn-block submitbtn"></input>
                        <span class="alert-danger" aria-hidden="true"><?php echo form_error("submit");?></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>


<?php require "footer.php"?>
<div class="row container-fluid ">
    <div class="col-md-12">

        <div class="contact-form">
            <form class="form" method="post" action="">
                <div class="row -align-center titlecontact"><h3>Контактна форма</h3></div>
                <div class="col-md-4">
                    <div class="form-group">
                         <label for="exampleInputName2"><h5>Име</h5></label>
                        <input type="text" class="form-control fieldcontent -align-center" id="exampleInputName2" placeholder="Jane Doe">
                    </div>
                    <div class="form-group">
                         <label for="exampleInputEmail2"><h5>Имейл</h5></label>
                        <input type="email" class="form-control fieldcontent" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                     </div>
                    <button type="submit" class="btn form-control submitbtn">Изпрати</button>
                </div>
                <div class="col-md-5 list-inline">
                    <div class="form-group">
                         <label for="exampleInputEmail2"><h5>Текст</h5></label>
                         <textarea class="form-control fieldcontent" rows="8" cols="40"></textarea>
                    </div>
                </div>

                <div class="row col-md-1">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/Lmspic.png" class="picture" alt="">

                </div>
               
            </form>
        </div>
    </div>

</div>








