<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NETS-X | <?php echo $title_for_layout; ?></title>
<link href="<?php e($html->url('/')); ?>css/base.css" type="text/css" rel="stylesheet" />
<link href="<?php e($html->url('/').'css/style.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php e($html->url('/').'css/links.css') ?>" type="text/css" rel="stylesheet" />
<?php if(Configure::read() == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause?>;url=<?php echo $url?>"/>
<?php } ?>
</head>

<body>

<div id="mainLayer">
    <!-- BEGIN HEADER AREA -->
    <div id="headerLayer">
        <div id="tabs" class="tabmenu">
            <?php echo $this->renderElement('mainmenu'); ?>
        </div>
    </div>
    <div id="logoLayer">
        <?php
        $debugLevel = Configure::read('debug');
        if ($debugLevel==0){
           $logo = 'logo.jpg';  
           $logoTitle = "NETS-X: Network Security X-perience";
        } else {
           $logo = 'logo_debug.jpg';
           $logoTitle = "debug level ".$debugLevel;
        }
        print $html->image($logo , array('alt'=>$logoTitle, 'title'=>$logoTitle)); ?>
    </div>
    <!-- END HEADER AREA -->


    <!-- BEGIN CONTENT AREA -->
    <div id="contentLayer">
        <div id="flashLayer" class="container" align="center">
        <div style="position:absolute;width:720px;top:50%;text-align:center;">
            <a class="flash" href="<?php print $url; ?>">
                <?php print $message; ?>
            </a>
        </div>
        </div>	
    </div>
    <!-- END CONTENT AREA -->


    <!-- BEGIN FOOTER AREA -->
    <div class="footer">
        <div class="footerLogo"><img src="<?php e($html->url('/')); ?>img/footer-logo.png" alt="SHiNE - Security &amp;&amp; Hacking in Network Enviroments" width="211" height="45" /></div>
    </div>
    <!-- END FOOTER AREA -->

</div>

</body>
</html>