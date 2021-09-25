<?php $this->start(); ?>Login<?php $this->end('title'); ?>
<?php $this->start(); ?>class="login-page"<?php $this->end('body_attr'); ?>

<?php $this->start(); ?>
<div class="form-signin">
    <form name="<?php echo $formName; ?>" method="POST" action="/login/check">
        <?php $emailErrorText = (isset($formErrors['children']['email'])) ? $formErrors['children']['email']: null ?>
        <?php $passwordErrorText = (isset($formErrors['children']['password'])) ? $formErrors['children']['password']: null ?>
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
        <input name="<?php echo $formName; ?>[email]" type="email" class="form-control <?php echo (!is_null($emailErrorText)) ? 'is-invalid':'' ?>" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            <div class="invalid-feedback"><?php echo $emailErrorText ;?></div>
        </div>
        <div class="form-floating">
            <input name="<?php echo $formName;?>[password]" type="password" class="form-control <?php echo (!is_null($passwordErrorText)) ? 'is-invalid':'' ?>" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            <div class="invalid-feedback"><?php echo $passwordErrorText ;?></div>
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
