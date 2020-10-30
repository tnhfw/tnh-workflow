
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name = "keywords" content = "tnh, framework, php, HTML, Javascript, CSS3" />
    <meta name="description" content="A simple PHP framework using HMVC architecture">
    <meta name="author" content="Tony NGUEREZA">
    <title>Authentification</title>
    <link href="<?php echo get_instance()->assets->css('bootstrap.min');?>" rel="stylesheet" type = "text/css" >
    <link href="<?php echo get_instance()->assets->css('fontawesome-all.min');?>" rel="stylesheet" type = "text/css" >
    <link href="<?php echo get_instance()->assets->css('app');?>" rel="stylesheet" type = "text/css" >
    <link rel="icon" href="<?php echo get_instance()->assets->img('favicon.ico');?>">
   </head>
  <body class="bg-light">
    <div class="container h-100">
            <br />
            <br />
            <br />
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
        <div class="row h-50 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        Authentification
                    </div>
                    <div class="card-body">
                        <?php echo Form::open(get_instance()->url->current(), array('class' => 'form-horizontal'), 'POST');?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <?php echo Form::text('username', Form::value('username'), array('required' => true, 'placeholder' => 'Please enter your username', 'class' => 'form-control'));?>
                                <span class="ferror"><?php echo Form::error('username');?></span>
                            </div>
                            <div class="row">
                                <div class="col pr-2">
                                    <button type="submit" class="btn btn-block btn-primary">Login</button>
                                </div>
                            </div>
                        <?php echo Form::close();?>
                    </div>
                </div>
            </div>
        </div> 
    </div> <!-- /container -->
	<script src="<?php echo get_instance()->assets->js('jquery.min');?>"></script>
    <script src="<?php echo get_instance()->assets->js('bootstrap.bundle.min');?>"></script>
    <script src="<?php echo get_instance()->assets->js('mermaid.min');?>"></script>
    <script src="<?php echo get_instance()->assets->js('app');?>"></script>
  </body>
</html>
