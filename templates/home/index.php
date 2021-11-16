<?php $this->start(); ?>Home<?php $this->end('title'); ?>

<?php $this->start(); ?>
   <script src="/js/main.js"></script>
<?php $this->end('js'); ?>

<?php $this->start(); ?>
<?php $form->start(); ?>
    <div class="row g-3">
        <div class="col-sm-6">
            <?php $form->renderLabel('name'); ?>
            <?php $form->renderField('name', 'form-control'); ?>
            <?php $form->renderError('name'); ?>
        </div>
        <div class="col-sm-6">
            <?php $form->renderLabel('email'); ?>
            <?php $form->renderField('email', 'form-control'); ?>
            <?php $form->renderError('email'); ?>
        </div>
        <div class="col-sm-3">
            <?php $form->renderField('radio', 'form-check-input'); ?>
            <?php $form->renderError('radio'); ?>
        </div>
        <div class="col-sm-9">
            <?php $form->renderLabel('textarea'); ?>
            <?php $form->renderField('textarea', 'form-control'); ?>
            <?php $form->renderError('textarea'); ?>
        </div>
        <div class="col-sm-6">
            <?php $form->renderLabel('checkbox'); ?>
            <?php $form->renderField('checkbox', 'form-check-input'); ?>
            <?php $form->renderError('checkbox'); ?>
        </div>
        <div class="col-sm-6">
            <?php $form->renderLabel('select'); ?>
            <?php $form->renderField('select', 'form-select'); ?>
            <?php $form->renderError('select'); ?>
        </div>
        <?php $form->renderField('token'); ?>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
    <?php $form->end(); ?>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
