<?php
use App\Model\Tasks;
use App\Notify;

$notify = Notify::catch();

$this->start(); ?>Home<?php $this->end('title'); ?>

<?php $this->start(); ?>
   <script src="/js/main.js"></script>
<?php $this->end('js'); ?>

<?php $this->start(); ?>
<div class="container-fluid">
    <?php if ($notify): ?>
        <div id="notify" class="row p-3">
             <div class="alert col-4 alert-success alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <strong><?php echo $notify; ?></strong>
                <button type="button" class="btn-close notify-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="row p-3">
        <div class="col">
            <a class="btn btn-primary" href="/task/add">Create</a>
        </div>
    </div>

    <div class="row p-3">
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

    <div class="row">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <?php foreach($pageQuery as $key => $link): ?>
                <li class="page-item"><a class="page-link" href="/<?php echo $link; ?>"><?php echo $key; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
    </div>

</div>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
