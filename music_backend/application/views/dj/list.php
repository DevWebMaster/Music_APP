<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Customer Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary add-dj" href="javascript:;"><i class="fa fa-plus"></i> Add New Customer</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Customer List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>djsListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Avatar</th>
                                <th>Cover</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <!-- <th>Description</th> -->
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                            if(!empty($djsRecords))
                            {
                                $count = 1;
                                foreach($djsRecords as $record)
                                {
                                    ?>
                                    <tr>
                                        <td class="dj_id" data-id="<?php echo $record->id ?>"><?php echo $count++ ?></td>
                                        <td><img src="<?php echo base_url() . $record->avatar_url ?>" alt="<?php echo $record->name ?>" width="50"></td>
                                        <td><img src="<?php echo base_url() . $record->profile_cover ?>" alt="<?php echo $record->name ?>" width="50"></td>
                                        <td class="dj_name"><?php echo $record->name ?></td>
                                        <td class="dj_email"><?php echo $record->email ?></td>
                                        <td class="dj_mobile"><?php echo $record->mobile ?></td>
                                        <!-- <td class="dj_description"></td> -->
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info editGenre" href="javascript:;" data-userid="<?php echo $record->id; ?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger deleteGenre" href="javascript:;" data-userid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<div id="addmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url('index.php/addNewDJ')?>" method="post" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add DJ</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <lable for="genre_name">DJ Name : </lable>
                                <input type="text" name="name" id="genre_name" class="form-control required" maxlength="128" required aria-required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" class="form-control required email" id="email"  name="email" maxlength="128">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" class="form-control required digits" id="mobile" name="mobile" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea  rows="4" class="form-control decription" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">DJ Avatar</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="avatar" class="form-control"  accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">Profile Cover Image</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="cover" class="form-control"  accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="editmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url('index.php/editDJ')?>" method="post" enctype="multipart/form-data">
            <!-- Modal content-->
            <input type="hidden" name="djId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit DJ</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <lable for="genre_name">DJ Name : </lable>
                                <input type="text" name="name" id="genre_name" class="form-control required" maxlength="128" required aria-required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" class="form-control required email" id="email"  name="email" maxlength="128">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" class="form-control required digits" id="mobile" name="mobile" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea  rows="4" class="form-control decription" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">DJ Avatar</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="avatar" class="form-control"  accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="mobile">Profile Cover Image</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="cover" class="form-control"  accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="deletemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?=base_url()?>index.php/deleteDJ" method="post">
            <!-- Modal content-->
            <input type="hidden" name="djId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Genre</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sync4-no" id="sample-id-hidden">
                    <h2>Confirm Delete</h2>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "djsListing/" + value);
            jQuery("#searchList").submit();
        });

        $(".add-dj").click(function(){
            $("#addmodal").modal('show');
        });

        $(".editGenre").click(function(){
            var id = $(this).parent().parent().find('.dj_id').data('id');
            var name = $(this).parent().parent().find('.dj_name').html();
            var email = $(this).parent().parent().find('.dj_email').html();
            var mobile = $(this).parent().parent().find('.dj_mobile').html();
            var description = $(this).parent().parent().find('.dj_description').html();

            $("#editmodal input[name='djId']").val(id);
            $("#editmodal input[name='name']").val(name);
            $("#editmodal input[name='email']").val(email);
            $("#editmodal input[name='mobile']").val(mobile);
            $("#editmodal textarea[name='description']").val(description);
            $("#editmodal").modal('show');
        });

        $(".deleteGenre").click(function(){
            var id = $(this).parent().parent().find('.dj_id').data('id');
            $("#deletemodal input[name='djId']").val(id);
            $("#deletemodal").modal('show');
        });

    });
</script>
