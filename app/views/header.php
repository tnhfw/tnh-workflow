<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "keywords" content = "tnh, framework, php, HTML, Javascript, CSS3" />
    <meta name="description" content="A simple PHP framework using HMVC architecture">
    <meta name="author" content="Tony NGUEREZA">
    <title>Workflow app</title>
    <link href="<?php echo get_instance()->assets->css('bootstrap.min');?>" rel="stylesheet" type = "text/css" >
    <link href="<?php echo get_instance()->assets->css('fontawesome-all.min');?>" rel="stylesheet" type = "text/css" >
    <link href="<?php echo get_instance()->assets->css('app');?>" rel="stylesheet" type = "text/css" >
    <link rel="icon" href="<?php echo get_instance()->assets->img('favicon.ico');?>">
    </head>
  <body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
        <?php echo Html::anchor(null, 'Workflow app', array('class' => 'navbar-brand'));?>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" id="lang" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i> Langue</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lang">
                        <?php 
                            $langs = get_languages();
                            $current = $this->lang->getCurrent();
                         ?>
                        <?php foreach($langs as $k => $v): ?>
                            <?php if($k == $current): ?>
                                <?php echo Html::anchor('set_lang/'.$k, ucwords($v).' *', array('class' => 'dropdown-item'));?>
                            <?php else: ?>
                                <?php echo Html::anchor('set_lang/'.$k, ucwords($v), array('class' => 'dropdown-item'));?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ' <b>'.auth_get_params('login').'</b>'; ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                        <?php echo Html::anchor('users/logout', 'Logout', array('class' => 'dropdown-item'));?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="d-flex">
      <div class="sidebar sidebar-dark bg-dark">
        <ul class="list-unstyled">
            <li><?php echo Html::anchor(null, '<i class = "fa fa-fw fa-home"></i> Home');?></li>
            <li><?php echo Html::anchor('leave', '<i class = "fa fa-fw fa-th"></i> '.__tr('leav_menu'));?></li>
            <li><?php echo Html::anchor('workflow', '<i class = "fa fa-fw fa-cogs"></i> '.__tr('wf_menu_workflow_config'));?></li>
            <li>
                <a href="#wfv" data-toggle="collapse">
                    <i class="fa fa-fw fa-check"></i> <?php echo __tr('wf_menu_workflow_validation'); ?>
                </a>
                <ul id="wfv" class="list-unstyled collapse">
                    <li><?php echo Html::anchor('workflow_validation_leave', __tr('wf_menu_workflow_validation_instances'));?></li>
                    <li><?php echo Html::anchor('workflow_validation_leave/my_task', __tr('wf_menu_workflow_validation_my_task'));?></li>
                </ul>
            </li>
            </ul>
    </div>
    <div class="content p-4">
        <?php if(hfsuccess()):?>
            <p class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo fsuccess() ?></p>
        <?php endif;?>
        <?php if(hfwarning()):?>
            <p class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> <?php echo fwarning() ?></p>
        <?php endif;?>
        <?php if(hferror()):?>
            <p class="alert alert-danger"><i class="fa fa-times-circle"></i> <?php echo ferror() ?></p>
        <?php endif;?>
        <?php if(hfinfo()):?>
            <p class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo finfo() ?></p>
        <?php endif;?>
        <br />




