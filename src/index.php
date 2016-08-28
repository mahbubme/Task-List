<?php $pageTitle = "Create Task"; ?>

<?php include_once 'partials/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php if ( !isset( $_SESSION['username'] ) ) : ?>
            <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
            <div class="col .col-xs-12 .col-sm-6 .col-md-6 col-lg-6 main white well">
                <p class="lead page-link">You are currently not signed in <a href="login.php">Login</a> Not yet a member? <a href="signup.php">Signup</a></p>
            </div>
            <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
        <?php else: ?>
            <div class="col .col-xs-12 .col-sm-6 .col-md-8 col-lg-6 white">
                <h3 class="text-primary">Create a new task </h3><hr>
                <form id="create-task" action="" method="post">
                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <input name="name" class="form-control" id="name" type="text" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-2 control-label">Description</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="description" id="description" required="required"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="createBtn" class="btn btn-default pull-right"> Create Task <i class="fa fa-plus"></i></button>
                    </div>
                </form>
            </div> 
        <?php endif; ?>
    </div>
</div>
<?php include_once 'partials/footer.php'; ?>