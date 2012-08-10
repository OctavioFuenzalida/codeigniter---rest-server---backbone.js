<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Codeigniter 3.0 + REST + Backbone.js</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="CI3REST" />
        <meta name="author" content="phreeze builder | phreeze.com" />

        <!-- Le styles -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.css" rel="stylesheet" />

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png" />

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/libs/LAB.min.js"></script>
        <script type="text/javascript">
            $LAB
            .script("//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js").wait()
            .script("assets/js/bootstrap.min.js").wait()
            .script("assets/js/bootstrap-datepicker.js")
            .script("assets/js/libs/underscore-min.js").wait()
            .script("assets/js/libs/underscore.date.min.js")
            .script("assets/js/libs/backbone-min.js")
            <?php
if (isset($script) AND !empty($script)) {
    if (is_array($script)) {
        foreach ($script as $sc) {
            ?>
                            .script("<?php echo $sc; ?>")
            <?php
        }
    } else {
        ?>
                    .script("<?php echo $script; ?>")
        <?php
    }
}
?>
            .script("assets/js/libs/jquery.scrollIntoView.min.js");
            

        </script>

    </head>
    <body>
        <?php
        if (!isset($nav) OR empty($nav)) {
            $nav = "portada";
        }
        ?>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="./">Codeigniter 3.0</a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            <li <?php if ($nav == 'portada') { ?> class="active" <?php } ?>><a href="<?php echo site_url(); ?>">Portada</a></li>
                            <li <?php if ($nav == 'blog') { ?> class="active" <?php } ?>><a href="<?php echo site_url("blog"); ?>">Blog</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">

            <h1>CI3REST</h1>
            <?php
            if (isset($content) AND !empty($content)) {
                echo $content;
            } else {
                $this->load->view("portada/portada_view");
            }
            ?>
            <hr>

            <footer>
                <p>&copy; Codeigniter 3.0</p>
            </footer>

        </div> <!-- /container -->
    </body>
</html>