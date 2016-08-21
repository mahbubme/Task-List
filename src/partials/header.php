<?php include_once 'includes/session.php'; ?>
<?php include_once 'includes/database.php'; ?>
<?php include_once 'includes/functions.php'; ?>

<!DOCTYPE html>

<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php if ( isset( $pageTitle ) ) echo $pageTitle; ?></title>

        <link rel="stylesheet" href="assets/stylesheets/app.css">

        <!-- Sweetalert JavaScript -->
        <script src="assets/js/sweetalert.min.js"></script>

        <!-- Sweetalert CSS -->
		<link rel="stylesheet" href="assets/stylesheets/sweetalert.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
    
        <!-- Navigation -->
        <div class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Task List</a>
                </div>
                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <i class="hide"><?php echo guard(); ?></i>
                        <?php if ( ( isset( $_SESSION['username'] ) || isCookieValid( $conn ) ) ) : ?>
                            <li><a href="index.php"><i class="fa fa-plus"></i>&nbsp; Create Task</a></li>
                            <li><a href="tasks.php"><i class="fa fa-eye-slash"></i>&nbsp; View Tasks</a></li>
                            <li><a href="profile.php"><i class="fa fa-user"></i>&nbsp; My Profile</a></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp; Logout</a></li>
                        <?php else: ?>
                            <li><a href="about.php"></i>&nbsp; About</a></li>
                            <li><a href="contact.php"></i>&nbsp; Contact</a></li>
                            <li><a href="signup.php"><i class="fa fa-user"></i>&nbsp; Sign Up</a></li>
                            <li><a href="login.php"><i class="fa fa-sign-in"></i>&nbsp; Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- App Alert-->
        <div id="ajax_msg" class="alert alert-success"></div>