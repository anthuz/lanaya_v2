<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<?php if(getTitle()): ?>
		<title><?=getTitle()?></title>
	<?php endif; ?>
	
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Andreas Thuresson">
	
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<link rel='stylesheet' type='text/css' href='style.php' />
	<link rel='stylesheet' href='<?=theme_url($stylesheet)?>'/>
	<?php if(isset($inline_style)): ?><style><?=$inline_style?></style><?php endif; ?>
	
	<script type="text/javascript">
     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
       var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
       ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();
   </script>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
       			<div class="nav-collapse" id="nav">
          			<?php if(region_has_content('nav')): ?>
      					<?=render_views('nav')?>
      				<?php endif; ?>
          			<ul class="nav pull-right" id="main-menu-right">
          				<?=login_bootstrap_menu()?>
          			</ul>
       			</div>
     		</div>
   		</div>
 	</div>
	<br/>
    <div class="container" >
    	<br/><br/>
    	<header class="jumbotron subhead">
  			<div class="row">
    			<div class="span6" id="header">
      				<h1><?=render_views('header')?></h1>
    			</div>
  			</div>
		</header>
    
		<section id="page">
			<div class="row">
				<div id="div-content" class="span8">
					<?=@$main?>
      				<?=render_views()?>
      				<?=render_views('content')?>
      			</div>
      			<?php if(region_has_content('sidebar')): ?>
      			<div id="div-sidebar" class="span4" >
					<?=@$sidebar?>
					<?=render_views('sidebar')?>
      			</div>
      			<?php endif; ?>
			</div>
		</section>
		
		<br/><br/>
      	<hr>
      	
		<footer id="footer">
			<p class="pull-right"><a href="#">Back to top</a></p>
			<?=$footer?>
			<?=render_views('footer')?>
        	<?=get_debug()?>
      	</footer>	
	</div>
</body>
</html>