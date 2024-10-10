<?php
include('../include/header.php');
$form = 'Contact';
$form_plural = 'Contacts';
?>

<div class="container bg-light rounded">
    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-primary"><?= $form_plural ?></h4>
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal">Add
                New<?= $form ?></button>
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
                        <input type="text" name="firstname" class="form-control" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastname" class="form-control" placeholder="Last name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required> 
                    </div>
                    <div class="form-group">               
                        <input type="tel" name="phone" class="form-control" placeholder="Phone" required> 
                    </div>
                    <div class="form-group">               
                        <input type="submit" name="insert" id="insert" value="Add <?= $form ?>" class="btn btn-danger btn-block">
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
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required> 
                    </div>
                    <div class="form-group">               
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required> 
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
            $.ajax({
                url: "action.php",
                type: "POST",
                data: { action: "view" },
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
                            title: '<?= $form ?> added successfully!',
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

        // Edit 
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
                    $("#firstname").val(data.firstname);
                    $("#lastname").val(data.lastname);
                    $("#email").val(data.email);
                    $("#phone").val(data.phone);                    
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
                            title: '<?= $form ?> updated successfully!',
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

    });
</script>
<?php
include('../include/footer.php');