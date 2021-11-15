<?php $this->start(); ?>Home<?php $this->end('title'); ?>

<?php $this->start(); ?>
   <script src="/js/main.js"></script>
<?php $this->end('js'); ?>

<?php $this->start(); ?>
    <?php $form->start(); ?>
        <div class="form-group">
            <?php $form->renderField('name'); ?>
            <?php $form->renderError('name'); ?>
        </div>
        <div class="form-group">
            <?php $form->renderField('email'); ?>
            <?php $form->renderError('email'); ?>
        </div>
        <div class="form-group">
            <?php $form->renderField('radio'); ?>
            <?php $form->renderError('radio'); ?>
        </div>
        <div class="form-group">
            <?php $form->renderField('textarea'); ?>
            <?php $form->renderError('textarea'); ?>
        </div>
        <div class="form-group">
            <?php $form->renderField('checkbox'); ?>
            <?php $form->renderError('checkbox'); ?>
        </div>
        <?php $form->renderField('token'); ?>
        <button type="submit">Submit</button>
    <?php $form->end(); ?>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
