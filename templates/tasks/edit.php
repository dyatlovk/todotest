<?php $this->start(); ?>Edit<?php $this->end('title'); ?>

<?php $this->start(); ?>
<div class="container-fluid">
    <form class="row g-3" method="POST">
        <div class="row md-3">
            <div class="col-md-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" value="<?php echo $task['task_title']; ?>">
            </div>
        </div>
        <div class="row md-3">
            <div class="col-md-8">
                <label for="text" class="form-label">Text</label>
                <textarea class="form-control" id="text" rows="8"><?php echo $task['task_text']; ?></textarea>
            </div>
        </div>
        <div class="col-md-3">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-select">
                <?php foreach ($statuses as $status) : ?>
                    <option <?php echo ($status['isSelected']) ? 'selected' : ''; ?> value="<?php echo $status['value']; ?>"><?php echo $status['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/" class="btn btn-link">Cancel</a>
        </div>
    </form>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
