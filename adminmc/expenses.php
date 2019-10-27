<?php 
require_once'addexpenses.php';
?>
<?php
include('includes/header.php');
include('includes/navbar.php');
?>
<?php
if(isset($_SESSION['message'])): ?>
<div class="alert alert-<?=$_SESSION['msg_type']; ?>">
    <?php
     echo $_SESSION['message'];
     unset($_SESSION['message']);
     ?>
</div>
<?php endif; ?>
<!-- CONNECT TO THE DATABASE -->
<?php
    $mysqli=new mysqli('localhost','root','','mce')or die(mysqli_error($mysqli));
    $result=$mysqli->query("SELECT expenseID,description,projectDescription,ebudget,edate FROM expensestable,projecttable WHERE expensestable.projectID=projecttable.projectID") or die(mysqli_error($mysqli));
    $select=$mysqli->query("SELECT * FROM projecttable") or die($mysqli->error());
    ?>
<!-- PROJECT ENTRY FORM  -->
<!-- IT'S A BOOTSTRAP MODAL THAT POPUPS THE ENTRY FORM WHEN THE BUTTON IS CLICKED -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expenses Entry Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" action="addexpenses.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control form-control-user" name="id"
                            value="<?php echo $expenseid; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" value="<?php echo $edesc;?>"
                            placeholder="Description" name="txtedesc">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="pid" name="pid">
                            <option value="">Contract Description</option>
                            <?php while($row=$select->fetch_array()): ?>
                            <option id="<?php echo $row['projectID']; ?>" value="<?php echo $row['projectID']; ?>">
                                <?php echo $row['projectDescription']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <!-- <input type="text" class="form-control form-control-user"  -->
                        <!-- aria-describedby="emailHelp" value="<?php //echo $pdesc; ?>" placeholder="Project Description" name="txtpdesc"> -->
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" placeholder="Enter Amount"
                            value="<?php echo $budget; ?>" name="txtbudget">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" value="<?php echo $date ?>" placeholder="yyyy-mm-dd"
                            name="txtdate">
                    </div>
                    <button type="submit" name="save" class="btn btn-primary btn-user btn-block">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- END OF MODAL AND END OF FORM -->
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800">Tables</h1>-->
    <div class="text-right mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            New Entry
        </button>
    </div>
    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Expenses DataTable</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-dark" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Project Description</td>
                            <th>Budget</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Description</th>
                            <th>Project Description</td>
                            <th>Budget</th>
                            <th>Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!--------------------SELECT QUERY FOR EMPLOYEE TABLE------------------------>
                        <?php
                        while ($row=$result->fetch_assoc()):?>
                        <tr>

                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['projectDescription'];?></td>
                            <td>SAR <?php echo $row['ebudget']; ?></td>
                            <td><?php echo $row['edate']; ?></td>
                            <td>
                                <form action="exupdate.php" method="POST">
                                    <input type="hidden" name="editID" value="<?php echo $row['expenseID']; ?>">
                                    <button type="submit" name="edit" class="btn btn-info">Edit</button>
                                </form>
                            </td>
                            <!-- <td><a href="empupdate.php?edit=<?php //echo $row['empID']; ?>" class="btn btn-info editbtn">Edit</a></td> -->
                            <td><a href="addmaterials.php?delete=<?php echo $row['expenseID']; ?>"
                                    class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->



<?php
include('includes/scripts.php');
include('includes/footer.php');
?>