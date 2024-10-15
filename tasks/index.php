<?php
include('../include/header.php');
$form = 'Task';
$form_plural = 'Tasks';
?>

<div class="container bg-light rounded">
    <div class="row">
        <div class="col-lg-4">
            <h4 class="mt-2 text-primary"><?= $form_plural ?></h4>
        </div>
        <div class="col-lg-8">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal"
                data-target="#addModal">Add
                New<?= $form ?></button>
        </div>
    </div>
    <div class="row mx-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="" value="A">
            <label class="form-check-label" for="status">All</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" value="O" checked>
            <label class="form-check-label" for="status">Open</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" value="C">
            <label class="form-check-label" for="status">Closed</label>
        </div>
    </div>
    <hr class="my-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showUser">
            </div>
        </div>
    </div>
</div>

<!-- Add New User Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New <?= $form ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="POST" id="form-data">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Description" required></textarea>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="department_id" aria-label="Department selection" required>
                            <option selected>Select the Department</option>
                            <option value="1">Administration</option>
                            <option value="2">I.T.</option>
                            <option value="3">Sales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="insert" id="insert" value="Add" class="btn btn-danger btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit <?= $form ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
                <form action="" method="POST" id="edit-form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <textarea name="description" id="description" class="form-control" placeholder="Description"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="department_id" id="department_id"
                            aria-label="Department selection" required>
                            <option selected>Select the Department</option>
                            <option value="1">Administration</option>
                            <option value="2">I.T.</option>
                            <option value="3">Sales</option>
                        </select>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="C" id="status" name="status">
                        <label class="form-check-label" for="status">Closed</label>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="update" id="update" value="Update Record"
                            class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        showAllUsers();

        function showAllUsers() {
            var selectedValue = $("input[type='radio'][name=status]:checked").val();

            $.ajax({
                url: "action.php",
                type: "POST",
                data: { action: "view", status: selectedValue },
                success: function (response) {
                    //console.log(response)
                    $("#showUser").html(response);
                    $("table").DataTable({ order: [0, 'desc'] });
                }
            });
        }
        // insert ajax request
        $("#insert").click(function (e) {
            if ($("#form-data")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: $("#form-data").serialize() + "&action=insert",
                    success: function (response) {
                        Swal.fire({
                            title: 'Task added successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#addModal").modal('hide');
                        $("#form-data")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });

        // Edit User
        $("body").on("click", ".editBtn", function (e) {
            e.preventDefault();
            edit_id = $(this).attr('id');
            $.ajax({
                url: "action.php",
                type: "POST",
                data: { edit_id: edit_id },
                success: function (response) {
                    data = JSON.parse(response);
                    $("#id").val(data.id);
                    $("#name").val(data.name);
                    $("textarea#description").val(data.description);
                    $("#department_id").val(data.department_id.toString());
                    if (data.status == 'C') {
                        $("#status").prop('checked', true);
                    }

                    // $("#status").val(data.status);
                }
            });
        });

        // Update ajax request
        $("#update").click(function (e) {
            if ($("#edit-form-data")[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: $("#edit-form-data").serialize() + "&action=update",
                    success: function (response) {
                        Swal.fire({
                            title: 'Task updated successfully!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#editModal").modal('hide');
                        $("#edit-form-data")[0].reset();
                        showAllUsers();
                    }
                });
            }
        });

        // Delete ajax request
        $("body").on("click", ".delBtn", function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            del_id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: { del_id: del_id },
                        success: function (response) {
                            tr.css('background-color', '#ff6666');
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your record has been deleted.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            })
                            showAllUsers();
                        }
                    });
                }
            });
        });


        $('input[name="status"]').change(function () {
            showAllUsers();
        });

    });
</script>
<?php
include('../include/footer.php');