<?php $this->start(); ?>Home<?php $this->end('title'); ?>

<?php $this->start(); ?>
<div class="container-fluid">
    <table class="table table-bordered">
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
         <?php for ($i = 1; $i <= 7; ++$i) { ?>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>Otto</td>
                <td>Closed</td>
                <td>
                    <a href="/task/<?php echo $i; ?>/edit">Edit</a>
                    <a href="/task/<?php echo $i; ?>/show">Show</a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
<?php $this->end('content'); ?>

<?php $this->extend('layout/base.php'); ?>
