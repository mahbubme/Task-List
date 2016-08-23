<?php $pageTitle = "Account Activation"; ?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/parseSignup.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 white well">
            <h3 class="text-primary">Account Activation</h3><hr>
            <?php if(isset($result)) echo $result; ?>
        </div> 
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>