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
                <th scope="col">User</th>
                <th scope="col">Email</th>
                <th scope="col">Text</th>
                <th scope="col">Status</th>
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
                <td><?php echo Tasks::STATUSES[$taskItem['task_status']]; ?></td>
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
        <?php for($i = 1; $i <= $pages; ++$i): ?>
            <li class="page-item"><a class="page-link" href="/?p=<?php echo $i?>"><?php echo $i ?></a></li>
        <?php endfor; ?>
      </ul>
    </nav>
</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
