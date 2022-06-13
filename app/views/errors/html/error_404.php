<?php
	$base_url = load_class('Config')->config['base_url'];
?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" >
    <meta name="description" content="404 Page Not Found">
    <title>404 Page Not Found</title>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    
    <!-- Core -->
    <link href="<?php echo $base_url; ?>assets/css/core.css" rel="stylesheet">
    <script src="<?php echo $base_url; ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
    <style>
    	body{
		  background: #fff;
		}
		section.page-404{
		  padding: 50px 100px 100px; 
		}
		section.page-404 .content .title{
		  color: #ff740d;
		  font-family: 'Arvo', serif;
		}

		section.page-404 .content .note{
		  padding-bottom: 30px;
		}
		section.page-404 .btn-go-home{
		  margin-left: 15px;
		  height: 40px;
		  color: #fff;
		  text-transform: uppercase;
		  background-image: -webkit-linear-gradient(left, #ff700b 0%, #ffb62c 51%, #ff720c 100%);
		  background-image: -o-linear-gradient(left, #ff700b 0%, #ffb62c 51%, #ff720c 100%);
		  background-image: linear-gradient(to left, #ff700b 0%, #ffb62c 51%, #ff720c 100%);
		}

		.btn-gradient {
		  text-align: center;
		  transition: 0.5s;
		  background-size: 200% auto;
		  text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
		  box-shadow: 0 0 20px #eee;
		}
		.btn-gradient:hover {
		  background-position: right center;
		}
    </style>

  </head>
  <body>

	<section class="page-404 text-center">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-5">
					<div class="box-image">
						<a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>assets/images/no_result.gif" alt="404 error page"></a>
					</div>
					<div class="content">
						<div class="title">
							<h1>404 Error, Seems you get lost</h1>
						</div>
						<div class="note text-muted">We are so sorry for the inconvenience, the page you were trying to access has been deleted or never even exist</div>
						<div class="go-back">
			              <a href="<?php echo $base_url; ?>" class="btn btn-pill btn-gradient btn-go-home btn-min-width mr-1 mb-1"><span><i class="fe fe-arrow-left"></i></span> Back to Home Page</a>
			            </div>
					</div>
				</div>
			</div>
		</div>
	</section>
  </body>
</html>

