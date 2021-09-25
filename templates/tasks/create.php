<?php $this->start(); ?>Create<?php $this->end('title'); ?>
<?php $this->start(); ?>
<div class="container">
    <form name="<?php echo $formName ?>" class="row g-3" action="/task/create" method="POST">
        <?php $titleErrorText = (isset($formErrors['children']['title'])) ? $formErrors['children']['title']: null ?>
        <?php $textErrorText = (isset($formErrors['children']['text'])) ? $formErrors['children']['text']: null ?>
        <?php $statusErrorText = (isset($formErrors['children']['status'])) ? $formErrors['children']['status']: null ?>
        <div class="row md-3">
            <div class="col-md-4">
                <label for="title" class="form-label">Title</label>
                <input name="task[title]" type="text" class="form-control <?php echo (!is_null($titleErrorText)) ? 'is-invalid':'' ?>" id="title" value="<?php echo $formData['title'];?>">
                <div class="invalid-feedback"><?php echo $titleErrorText ;?></div>
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
