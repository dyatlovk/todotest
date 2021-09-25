<?php $this->start(); ?>Show<?php $this->end('title'); ?>

<?php $this->start(); ?>
<div class="container-fluid">
    <div>
        <?php echo $task['task_id']; ?>
    </div>
    <div>
        <?php echo $task['task_title']; ?>
    </div>
    <div>
        <?php echo $task['task_text']; ?>
    </div>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
