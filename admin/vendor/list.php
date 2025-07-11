<?php if($_settings->chk_flashdata('success')): ?>
<script>
alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
</script>
<?php endif;?>
<style>
.user-avatar {
    width: 3rem;
    height: 3rem;
    object-fit: scale-down;
    object-position: center center;
}
</style>
<div class="card card-outline rounded-0 card-teal">
    <div class="card-header">
        <h3 class="card-title">List of Vendors</h3>
        <div class="card-tools">
            <a href="./?page=vendor/manage_vendor" id="create_new" class="btn btn-flat bg-teal"><span
                    class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped table-bordered" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Updated</th>
                        <th>Vendor Name</th>
                        <th>Gst No</th>
                        <th>Contact Person</th>
                        <th>Phone No</th>
                        <th>Address</th>
                        <th>Vendor Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `vendor_list` ORDER BY `date_updated` DESC");
						while($row = $qry->fetch_assoc()):
					?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($row['date_updated'])) ?></td>
                        <td> <a href="?page=vendor/vendor_item&vendor_id=<?= $row['id'] ?>">
                                <?php echo $row['vendor_name']; ?>
                            </a></td>
                        <td><?php echo $row['gst_no'] ?></td>
                        <td><?php echo $row['contacr_person'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['address'] ?></td>
                        <td><?php echo $row['vendor_type'] ?></td>
                        <td align="center">
                            <button type="button"
                                class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="./?page=vendor/manage_vendor&id=<?= $row['id'] ?>"><span
                                        class="fa fa-edit text-dark"></span> Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
                                    Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.delete_data').click(function() {
        _conf("Are you sure to delete this Vendor permanently?", "delete_vendor", [$(this).attr(
            'data-id')])
    })
    $('.table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: [6]
        }],
        order: [0, 'asc']
    });
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
})

function delete_vendor($id) {
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Vendors.php?f=delete",
        method: "POST",
        data: {
            id: $id
        },
        error: err => {
            console.log(err)
            alert_toast("An error occured.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (resp == 1) {
                location.reload();
            } else {
                alert_toast("An error occured.", 'error');
                end_loader();
            }
        }
    })
}
</script>