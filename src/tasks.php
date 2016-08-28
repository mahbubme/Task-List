<?php $pageTitle = "Manage Task"; ?>

<?php include_once 'partials/header.php'; ?>

<div class="container-fluid">
    <div class="row">
    	<?php if ( !isset( $_SESSION['username'] ) ) : ?>
            <?php redirectTo( 'index' ); ?>
        <?php else: ?>
	    	<div class="col .col-xs-12 .col-sm-6 .col-md-8 col-lg-12 main">
		        <h3 class="text-primary">Manage Task </h3><hr>

		        <table class="table table-striped table-bordered table-responsive">
		            <thead>
		            <tr><th>Name</th><th>Description</th><th>Status</th><th>Created</th><th>Action</th></tr>
		            </thead>
		            
		            <tbody id="task-list"></tbody>
		        </table>
	        </div>
    	<?php endif; ?>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>