<?php $pageTitle = "Profile"; ?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/parseProfile.php'; ?>

<div class="container">
    <div class="row">
        <?php if ( !isset( $_SESSION['username'] ) ) : ?>

            <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
            <div class="col .col-xs-12 .col-sm-6 .col-md-6 col-lg-6 main white well">
                <p class="lead page-link">You are not authorized to view this page <a href="login.php">Login</a> Not yet a member? <a href="signup.php">Signup</a></p>
            </div>
            <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
 
        <?php else: ?>

        <div class="col .col-xs-12 .col-sm-12 .col-md-12 col-lg-12 white">
            <h3 class="text-primary">Profile</h3><hr>
            <div class="clearfix profile-img">
            	<div class="row">
            		<div class="col-sm-2">
            			<img src="<?php if ( isset( $profile_picture ) ) echo $profile_picture; ?>" alt="" class="img-responsive">
            		</div>
            	</div>
            </div>
            <table class="table table-bordered table-condensed">
            	<tr><th>Username: </th><td><?php if( isset( $username ) ) echo $username; ?></td></tr>
            	<tr><th>Email: </th><td><?php if( isset( $email ) ) echo $email; ?></td></tr>
            	<tr><th>Date Joined: </th><td><?php if( isset( $date_joined ) ) echo $date_joined; ?></td></tr>
            	<tr><th></th><td>
                    <a href="edit-profile.php?user_identity=<?php if( isset( $encode_id ) ) echo $encode_id; ?>"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a> &nbsp; &nbsp;
                    <a href="change-password.php?user_identity=<?php if( isset( $encode_id ) ) echo $encode_id; ?>"><span class="glyphicon glyphicon-edit"></span> Change Password</a> &nbsp; &nbsp;
                    <a href="deactivate-account.php?user_identity=<?php if( isset( $encode_id ) ) echo $encode_id; ?>" class="pull-right"><span class="glyphicon glyphicon-trash"></span> Deacitvate Account</a>
                    </td></tr>
            </table>
        </div> 

        <?php endif; ?>

    </div>
</div>

<?php include_once 'partials/footer.php'; ?>