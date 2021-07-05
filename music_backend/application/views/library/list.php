<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Library Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary add-image" href="javascript:;"><i class="fa fa-plus"></i> Add New Library</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Library List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>libraryListing" method="POST" id="searchList">
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
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                            if(!empty($libraryRecords))
                            {
                                $count = 1;
                                foreach($libraryRecords as $record)
                                {
                                    ?>
                                    <tr>
                                        <td class="library_id" data-id="<?php echo $record->id ?>"><?php echo $count++ ?></td>
                                        <td class="library_thumb"><img src="<?php echo base_url() . $record->thumb_img ?>" alt="<?php echo $record->name ?>" style="width: 100px;" ></td>
                                        <td class="library_name"><?php echo $record->name ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info editLibrary" href="javascript:;" data-userid="<?php echo $record->id; ?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger deleteLibrary" href="javascript:;" data-userid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
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
        <form action="<?=base_url('index.php/addNewLibrary')?>" method="post" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Library</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <lable for="library_name">Library Name : </lable>
                                <input type="text" name="name" id="library_name" required aria-required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="file" name="thumbimg" id="file"/><br/>
                            </div>
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
        <form action="<?=base_url('index.php/editLibrary')?>" method="post" enctype="multipart/form-data">
            <!-- Modal content-->
            <input type="hidden" name="libraryId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Library</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <lable for="library_name">Library Name : </lable>
                                <input type="text" name="name" id="library_name" class="library_name" required aria-required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="file" name="thumbimg" id="file"/><br/>
                            </div>
                        </div>
                    </div>
                    <div id="filediv">


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
        <form action="<?=base_url()?>index.php/deleteLibrary" method="post">
            <!-- Modal content-->
            <input type="hidden" name="libraryId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Library</h4>
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
            jQuery("#searchList").attr("action", baseURL + "libraryListing/" + value);
            jQuery("#searchList").submit();
        });

        $(".add-image").click(function(){
            $("#addmodal").modal('show');
        });

        $(".editLibrary").click(function(){
            var id = $(this).parent().parent().find('.library_id').data('id');
            var name = $(this).parent().parent().find('.library_name').html();

            $("#editmodal input[name='libraryId']").val(id);
            $("#editmodal input[name='name']").val(name);
            $("#editmodal").modal('show');
        });

        $(".deleteLibrary").click(function(){
            var id = $(this).parent().parent().find('.library_id').data('id');
            $("#deletemodal input[name='libraryId']").val(id);
            $("#deletemodal").modal('show');
        });

    });
</script>
