<?php if($_settings->chk_flashdata('success')): ?>
<script>
alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
</script>
<?php endif;?>
<style>
.category-img {
    width: 3em;
    height: 3em;
    object-fit: cover;
    object-position: center center;
}

/* Mobile styles for tables */
@media (max-width: 768px) {
    .table-responsive {
        margin-bottom: 0;
        border: none;
    }
    
    .table {
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    /* Hide footer on mobile */
    .chakra-footer {
        display: none !important;
    }
    
    /* Better dropdown placement */
    .dropdown-menu {
        left: auto;
        right: 0;
    }
}
</style>
<div class="card card-outline rounded-0 card-teal">
    <div class="card-header">
        <h3 class="card-title">List of Departments</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat bg-teal"><span
                    class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" id="list">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="25%">
                        <col width="35%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						$i = 1;
                        $qry = $conn->query("SELECT * FROM `department_list` WHERE `delete_flag` = 0 ORDER BY `date_created` DESC");
                        while($row = $qry->fetch_assoc()):
						?>
                        <tr>
                            <td class="text-center serial-number"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d ",strtotime($row['date_created'])) ?></td>
                            <td class=""><?= $row['name'] ?></td>
                            <td class="">
                                <p class="mb-0 truncate-1"><?= strip_tags(htmlspecialchars_decode($row['description'])) ?>
                                </p>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button"
                                    class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <!-- <a class="dropdown-item view-data" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span>
                                        View</a> -->
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a class="dropdown-item edit-data" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>
                                        Edit</a>
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
</div>
<script>
$(document).ready(function() {
    // Add data-table-page class to body to hide footer on mobile
    $('body').addClass('data-table-page');
    
    $('.delete_data').click(function() {
        _conf("Are you sure to delete this Department permanently?", "delete_department", [$(this).attr(
            'data-id')])
    })
    $('#create_new').click(function() {
        uni_modal("<i class='far fa-plus-square'></i> Add New Department ",
            "department/manage_department.php")
    })
    $('.edit-data').click(function() {
        uni_modal("<i class='fa fa-edit'></i> Edit Department ",
            "department/manage_department.php?id=" +
            $(this).attr('data-id'))
    })
    $('.view-data').click(function() {
        uni_modal("<i class='fa fa-edit'></i> View Department ",
            "department/manage_department.php?id=" +
            $(this).attr('data-id'))
    })
    $('.table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: [5]
        }],
        order: [0, 'asc']
    });
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
})

function delete_department($id) {
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Master.php?f=delete_department",
        method: "POST",
        data: {
            id: $id
        },
        dataType: "json",
        error: err => {
            console.log(err)
            alert_toast("An error occured.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occured.", 'error');
                end_loader();
            }
        }
    })
}

// Function to update serial numbers after reordering
function updateSerialNumbers() {
    $('.serial-number').each(function(index) {
        $(this).text(index + 1);
    });
}

// Listen for reordering event and update serial numbers
$('#list').on('order.dt', function() {
    updateSerialNumbers();
});
</script>
