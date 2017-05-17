<?php define('PATH','http://mylocal.dev/MyPHP_files/school/index.php/');
       define('IMAGE_PATH','http://mylocal.dev/MyPHP_files/school/application/assets/uploads/images/');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/jquery-3.2.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js" ></script>
    <link rel="stylesheet" href="school/application/css/style.css">

    <style>


        .border {
            border: 1px solid red;
        }
        .span-error {
            color:red;
            display: inline-block;
            margin-top: 4px;
        }
        .logo{
            width:60px;
            height:60px;
            display:inline-block;
        }

        h4{
            color:#5b79a0;

        }
        h1{
            color:#618c8c;
            color:rgba(143,150,173,1);
            margin-bottom:20px;
            margin-top:30px;
        }
        .h4label{
            color:#18447d;
            margin-right:5px;
        }
        h1{
            display:inline-block;
            width:550px;
            margin-left:30px;
        }
        h2{
            color:#fbd40a;
            padding-left:15px;
            font-size:30px;
        }
        h5{
            color:#4880ea;


        }
        .first_h5{
            color:#eeeff3;
        }
        .name{
            color:#ffee02;
            background-color:#122b40;
            opacity: 0.9;
            font-size: 20px;


        }
        h3{
            color:#073f5a;
            color:#9e7a11;
        }
        .login{
            width:20%;
            margin-left:40%;
            margin-top: 5%;
            border:blue;
            height:auto;
            position:absolute;
        }
        .header,.footer{
            height:100px;
            background-color:#FFFFFF;
        }
        .body{

            background: url("http://www.telegraph.co.uk/content/dam/news/2016/11/29/54277671_Alamy_ACBAX2-Teenage-girls-in-secondary-school-class-xlarge.jpg");
            background-repeat:no-repeat;
            background-size: cover ;
            width: 100%;
            height:500px;
        }
        .container-fluid{
            background-color:rgb(213,206,166) /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#d5cea6+0,c6ba77+72,b7ad70+100 */
            /* Old browsers */


        }


        .addform{
            background-color: white;
        }
        .intern-content{
            background-color: #f6f9f9;
            width:100%;
            /* IE10+ */
            background-image: -ms-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Mozilla Firefox */
            background-image: -moz-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Opera */
            background-image: -o-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Webkit (Safari/Chrome 10) */
            background-image: -webkit-gradient(linear, left top, right top, color-stop(0, #e4efc0), color-stop(100, #abbd73));

            /* Webkit (Chrome 11+) */
            background-image: -webkit-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* W3C Markup */
            background-image: linear-gradient(to right, #e4efc0 0%, #abbd73 100%);
            background: url("https://res.cloudinary.com/crunchbase-production/image/upload/v1405074633/jjivy9a0ndkmakz8l3hc.jpg");
            background-repeat: no-repeat;
            background-size:cover ;
            opacity: 1;

        }

        .intern-content1{
            background-color: #f6f9f9;
            width:100%;
            /* IE10+ */
            background-image: -ms-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Mozilla Firefox */
            background-image: -moz-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Opera */
            background-image: -o-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* Webkit (Safari/Chrome 10) */
            background-image: -webkit-gradient(linear, left top, right top, color-stop(0, #e4efc0), color-stop(100, #abbd73));

            /* Webkit (Chrome 11+) */
            background-image: -webkit-linear-gradient(left, #e4efc0 0%, #abbd73 100%);

            /* W3C Markup */
            background-image: linear-gradient(to right, #e4efc0 0%, #abbd73 100%);
            background-repeat: no-repeat;
            background-size:cover ;
            opacity: 1;

        }


        .contact-form{

            background-color: #b3a87f;
            margin-left:45%;
            display:inline;
        }
        .nav{
            float:right;

        }
        .search{
            float:right;
            margin-top:20px;

        }
        .mytable>tr>th{
            color:#a59751;
            font-size:16px;
            border-right-color: #9d9d9d;
        }
        .mytable{
            color:#9e2d09;
            background-color: #F6F9F9;
            font-size: 16px;

        }
        .mytable1{
            color: #596d73;
            background-color:  #F6F9F9;
            font-size: 16px;
            margin-top:15px;

        }
        .abscences{

        }
        .goleft{
            float:left;
            font-size: 16px;
            height: 60px;

            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#feffff+0,d2ebf9+99 */

        }
        .profile{
            margin-top:10px;
            width:130px;
            align-items: center;
            color:steelblue;
            background-color: transparent;
        }
        .back{
            height: 40px;
        }
        .error{
            color:#b30b0b;
            widht:500px;
        }
        .textfield, submitbtn{
            width:270px;

        }
        .fieldcontent{
            background-color:rgba(249,249, 249, 0.78);
        }
        .submitbtn{
            background-color:rgba(120,134,11,0.71);
            color:#e8c616;
            font-size: 16px;
            margin-bottom:2px;

        }
        .submitbtn:hover{
            background-color:rgba(240,210,44,0.86);
            color:#78860b;
        }

        .editbtn{
            background-color:rgba(202,217,222,0.71);
            color:#e8c616;
            font-size: 16px;
            margin-bottom:2px;

        }
        .editbtn:hover{
            background-color:rgba(166,185,185,0.86);
            color:#78860b;
        }
        .editbtn1:hover{
            background-color:rgba(166,185,185,0.86);
            color:#78860b;
        }
        .editbtn1{
            background-color:rgba(166,185,185,0.86);
            color:#78860b;
            width:330px;
            font-size:18px;
        }
        .btn1{
            background-color:rgba(202,217,222,0.71);
            color:steelblue;
            border-radius: 4px;
        }
        .list-group-item1{
            width:360px;
            margin-top: 20px;
            margin-left: 20px;
            color: color:#e8c616;
        }
        .list-group-item{
            color:#f5de31;
        }
        .picture{
            width:300px;
            height:175px;
            margin-top:40px;
        }
        .titlecontact{
            width: 250px;
            margin:0 auto;
            color:#675809;
        }
        .formfield{
            width:230px;
        }
        .alert-danger{
            font-size: 14px;
        }
        .classes{
            margin-top: 20px;
            margin-left:20px;
            padding-left: 10px;

        }
        .classes>td:nth-child(1),.classes>td:nth-child(2){

            padding-left: 25px;

        }
        .labels{
            color:#ec8415;
            font-size: small;
            margin-right:5px;
            margin-left:5px;
        }
        .list-group{
            float:right;
            width: 230px;
            margin-top: 20px;

        }
        .navdesign{
            font-size: 16px;
            color:#3e2890
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .navdesign:hover,.navdesign:active{
            color: #c15210;
            background-color: #d8ceaa;
        }
        .navdesign>li>a{
            font-size: 16px;
            color:#3e2890;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .navdesign>li>a:hover, .navdesign>li>a:active{
            color: #c15210;
            background-color: #d8ceaa;
        }
        .teacherpanel{
            background-color: #ffffff;
        }

        .article{
            background-color: white;
            width:600px;
            height: auto;

        }
        .image{
            margin-left:20px;
            margin-top:30px;
            width:550px;
            height:400px;
        }
        .description{
            padding:20px;
        }
        p:first-child{
            padding-top:15px;
            padding-right:20px;
            padding-left: 20px;
            padding-bottom: 20px;
            text-align: justify;
            color:grey;
        }
        p{

            padding-right:20px;
            padding-left: 20px;
            padding-bottom: 20px;
            text-align: justify;
            color:grey;
        }
        .title{
            padding-left: 20px;
            text-align: justify;
        }

        .title_section{
            font-size: 28px;
            font-family:SansSerif;
            color:#547079;
            text-align: center;
            vertical-align: center;
            height: 40px;
            background-color: #f4fbf8;
            width:1200px;
            margin-left:-15px;
            margin-top:-5px;

        }
        .container1{
            padding:30px;
            background-color:lightcyan;

        }
        .breadcrumb{
            height: 50px;
            margin-bottom: -5px;
        }
        .alert-danger{
            color:red;
        }
    </style>
    <title>Home page</title>
</head>
<body>
<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12">
            <img src="http://www.andysowards.com/blog/assets/geometric-logo-design.png" alt="" class="logo">
            <h1>Моето Училище<h1>
        </div>
    </div>

    <div class="intern-content">

