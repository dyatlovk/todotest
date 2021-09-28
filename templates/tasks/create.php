<?php $this->start(); ?>Create<?php $this->end('title'); ?>
<?php $this->start(); ?>
<div class="container">
    <form name="<?php echo $formName ?>" class="row g-3" action="/task/create" method="POST">
        <?php $usernameErrorText = (isset($formErrors['children']['username'])) ? $formErrors['children']['username']: null ?>
        <?php $emailErrorText = (isset($formErrors['children']['email'])) ? $formErrors['children']['email']: null ?>
        <?php $textErrorText = (isset($formErrors['children']['text'])) ? $formErrors['children']['text']: null ?>
        <?php $statusErrorText = (isset($formErrors['children']['status'])) ? $formErrors['children']['status']: null ?>
        <div class="row md-3">
            <div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input name="task[username]" type="text" class="form-control <?php echo (!is_null($usernameErrorText)) ? 'is-invalid':'' ?>" id="username" value="<?php echo $usernameData['username'];?>">
                <div class="invalid-feedback"><?php echo $usernameErrorText ;?></div>
            </div>
        </div>
        <div class="row md-3">
            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input name="task[email]" type="text" class="form-control <?php echo (!is_null($emailErrorText)) ? 'is-invalid':'' ?>" id="email" value="<?php echo $emailData['email'];?>">
                <div class="invalid-feedback"><?php echo $emailErrorText ;?></div>
            </div>
        </div>
        <div class="row md-3">
            <div class="col-md-8">
                <label for="text" class="form-label">Text</label>
                <textarea name="task[text]" class="form-control <?php echo (!is_null($textErrorText)) ? 'is-invalid':'' ?>" id="text" rows="8"></textarea>
                <div class="invalid-feedback"><?php echo $textErrorText ;?></div>
            </div>
        </div>
        <div class="col-md-3">
            <label for="inputState" class="form-label">State</label>
                <select name="task[status]" id="inputState" class="form-select <?php echo (!is_null($statusErrorText)) ? 'is-invalid':'' ?>">
                    <?php foreach ($statuses as $status) : ?>
                        <option <?php echo ($status['isSelected']) ? 'selected' : ''; ?> value="<?php echo $status['value']; ?>"><?php echo $status['name']; ?></option>
                    <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?php echo $statusErrorText ;?></div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/" class="btn btn-link">Cancel</a>
        </div>
    </form>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
