<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? if(isset($this->description)): ?>
    <meta name="description" content="<?=$this->description?>">
    <? endif; ?>
    <meta name="author" content="">

    <link href="<?=URL?>css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?=URL?>css/datepicker.css" rel="stylesheet" media="screen">
    <link href="<?=URL?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=URL?>css/main.css" rel="stylesheet" media="screen"/>   
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js"></script>
    <script src="<?=URL?>js/bootstrap.js"></script>
    <script src="<?=URL?>js/bootstrap-datepicker.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>
    <script src="<?=URL?>js/jquery.timeago.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/file-uploader/3.1.1/fineuploader.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/file-uploader/3.1.1/jquery.fineuploader.min.js"></script>
    <script src="<?=URL?>js/lazyload.js"></script>
    <link href="<?=URL?>css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?=URL?>js/bootstrap-editable.js"></script>
    <script type="text/javascript" src="<?=URL?>js/main.js"></script>
    <style type="text/css">
      @media (min-width: 980px) { 
        .move-down {
          padding-top: 60px;
          padding-bottom: 40px;
        }
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <!--
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    -->
    <link rel="shortcut icon" href="<?=URL?>img/favicon.ico">

    <?php
    if (isset($this->js)) {
        foreach ($this->js as $js){
            echo '<script type="text/javascript" src="'.URL.'view/'.$js.'"></script>';
        }
    }
    ?>
</head>

<?php session::init(); ?>

<body>
    
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="<?=URL?>">bobpattersonjr bootstrap mvc</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav_bold">Dropdown<b class="caret"></b></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?=URL?>">Test</a></li>
            </ul>
          </li>
        </ul>
        <div class="nav pull-right">
          <div class="nav">
          <form class="navbar-search">
            <input id="search_bar" type="text" data-provide="typeahead" data-minLength='1' class="search-query" placeholder="Search">
          </form>
          </div>
          <div class="nav">
            <? if (!auth::logged_in()):?>
            <a class="btn nav_bold" data-toggle="modal" href="#login_modal" ><i class="icon-signin"></i> Login/Sign Up</a>
            <? endif; ?> 
            <? if (auth::logged_in()):?>
            <li><a class="nav_bold" href="<?=URL?>account">My Account</a></li>
            <a class="btn nav_bold" href="<?=URL?>/account/logout" ><i class="icon-signout"></i>Log Out</a>
            <? endif; ?> 
          </div>
        </div>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#dob').datepicker();
});
</script>

<?=require 'view/login_modal.php';?>

<div class="container move-down">
    