<?php
use App\Model\Tasks;

$this->start(); ?>Home<?php $this->end('title'); ?>

<?php $this->start(); ?>
<div class="container-fluid">
    <a href="/task/add">Create</a>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><a href="/<?php echo $orderQuery['username']; ?>">User</a></th>
                <th scope="col"><a href="/<?php echo $orderQuery['email']; ?>">Email</a></th>
                <th scope="col">Text</th>
                <th scope="col"><a href="/<?php echo $orderQuery['status']; ?>">Status</a></th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
         <?php foreach ($taskList as $taskItem): ?>
            <tr>
                <th scope="row"><?php echo $taskItem['task_id']; ?></th>
                <td><?php echo $taskItem['user_name']; ?></td>
                <td><?php echo $taskItem['user_email']; ?></td>
                <td><?php echo $taskItem['task_text']; ?></td>
                <td><?php echo Tasks::STATUSES[$taskItem['task_status']]; ?> <?php if($taskItem['modified_by']):?>(Admin edited)<?php endif; ?></td>
                <td>
                    <a href="/task/<?php echo $taskItem['task_id']; ?>/edit">Edit</a>
                    <a href="/task/<?php echo $taskItem['task_id']; ?>/show">Show</a>
                    <a href="/task/<?php echo $taskItem['task_id']; ?>/delete">Delete</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<div class="container-fluid">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <?php foreach($pageQuery as $key => $link): ?>
            <li class="page-item"><a class="page-link" href="/<?php echo $link; ?>"><?php echo $key; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
