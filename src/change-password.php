<?php $pageTitle = "Profile"; ?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/parseProfile.php'; ?>
<?php include_once 'partials/parseChangePassword.php'; ?>

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
                    <h3 class="text-primary">Change Password</h3><hr>

                    <?php if( isset( $result ) ) echo $result; ?>
                    <?php if( !empty( $form_errors )) echo show_errors( $form_errors ); ?>

                    <form class="row" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="password" class="control-label">Current Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="new_password" class="control-label">New Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="new_password" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="confirm_password" class="control-label">Confirm New Password</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-sm-12">
                                <input type="hidden" name="hidden_id" value="<?php if( isset( $id ) ) echo $id; ?>">
                                <input type="hidden" name="token" value="<?php if ( function_exists( '_token' ) ) echo _token(); ?>">
                                <button type="submit" class="btn btn-default pull-right" name="changePasswordBtn">Change Password</button>
                            </div>  
                        </div>
                    </form>
                </div>

            <?php endif; ?>

        </div>
    </div>

<?php include_once 'partials/footer.php'; ?>