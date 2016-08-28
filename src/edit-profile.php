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

                <div class="col .col-xs-12 .col-sm-12 .col-md-12 col-lg-12 main white">
                    <h3 class="text-primary">Edit Profile</h3><hr>
                    
                    <?php if( isset( $result ) ) echo $result; ?>
                    <?php if( !empty( $form_errors )) echo show_errors( $form_errors ); ?>
                    <form class="row" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">    
                            <div class="col-sm-1">
                                <label for="username" class="control-label">Username</label>
                            </div>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1">
                                <label for="email" class="control-label">Email</label>
                            </div>
                            <div class="col-sm-11">
                                <input type="email" class="form-control" id="email" name="email" value="<?php if( isset( $email ) ) echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group">    
                            <div class="col-sm-1">
                                <label for="avatar" class="control-label">Avatar</label>
                            </div>
                            <div class="col-sm-11">
                                <input type="file" class="form-control" id="fileField" name="avatar">
                                <input type="text" readonly="" class="form-control" placeholder="Browse">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <p class="pull-left page-link"><a href="profile.php"><i class="fa fa-eye-slash"></i> View Profile</a></p>
                                <input type="hidden" name="hidden_id" value="<?php if( isset( $id ) ) echo $id; ?>">
                                <input type="hidden" name="token" value="<?php if ( function_exists( '_token' ) ) echo _token(); ?>">
                                <button type="submit" class="btn btn-default pull-right" name="updateProfileBtn">Update Profile</button> 
                            </div>  
                        </div>
                    </form>
                </div>

            <?php endif; ?>

        </div>
    </div>

<?php include_once 'partials/footer.php'; ?>