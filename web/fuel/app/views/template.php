
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="http://localhost/miniblog/miniblog-lam.vy/web/" >
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $title;?></title>

    <!-- Bootstrap core CSS -->
    <?php echo Asset::css('bootstrap.css'); ?>

    <!-- Custom styles for this template -->
    <?php echo Asset::css('starter-template.css'); ?>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <?php echo Asset::js('ie-emulation-modes-warning.js'); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="#"><b style="font-size:30px">Mini Blog</b></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav pull-right">
            <li><a href="posts/index">Blog</a></li>
            <?php 
            	if (Session::get('token')) {
			?>
					<li class="dropdown">
              			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My account <span class="caret"></span></a>
						  <ul class="dropdown-menu" role="menu">
							<li><a href="users/update">Edit profile</a></li>
							<li><a href="users/password">Change password</a></li>
							<li><a href="posts/manage">Manage post</a></li>
							 <div class="divider"></div>
							<li><a href="users/logout">Logout</a></li>
							
						  </ul>
            		</li>
			<?php 	            		
	
            	} else {
            ?>
            		
            		<li><a href="users/register">Register</a></li>
            		<li><a href="users/login">Login</a></li>
			<?php 
            	}
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="container">
	<div class="container">

      <div class="row">
        <div class="col-md-6">
		  <div class="form-search">
			<form class="navbar-form">
				<div class="form-group">
				  <input type="text" placeholder="Enter username, last-first name" class="form-control" size="40" name="keyword" >
				</div>
				
				<button type="submit" class="btn btn-success" name="submit">Search</button>
            </form>
          
		  </div>
		  <div class="row">
				<div class="col-lg-12">
					<ul class="breadcrumb">
						<li><a href="index"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						
						<?php echo $breadcrumbs;?>
					</ul>
				</div>
            </div>
		</div>
	 </div>	
	</div>
   <!-- /.container -->
   <?php echo $content ;?>
	<div class="container">
		<div class="row">
			<footer class="footer">
			<p>&copy; Company 2015</p>
			</footer>
		</div>
	</div>
</div>	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?php echo Asset::js('bootstrap.min.js'); 
   	     echo Asset::js('ie10-viewport-bug-workaround.js');
   ?>
  </body>
</html>
