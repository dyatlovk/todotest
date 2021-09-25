<?php $this->start(); ?>Login<?php $this->end('title'); ?>
<?php $this->start(); ?>class="login-page"<?php $this->end('body_attr'); ?>

<?php $this->start(); ?>
<div class="form-signin">
    <form name="<?php echo $formName; ?>" method="POST" action="/login/check">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
        <input name="<?php echo $formName; ?>[email]" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input name="<?php echo $formName;?>[password]" type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <div class="col-12">
            <p class="invalid">
                <?php echo $authError; ?>
            </p>
        </div>
    </form>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
