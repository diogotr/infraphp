<?php
include('../include/header.php');
$form = 'User';
$form_plural = 'Users';
?>

<div class="container bg-light rounded">
    <div class="row">
        <div class="col-lg-6">
            <h4 class="mt-2 text-primary"><?= $form_plural ?></h4>
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

<script src="../js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.8/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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