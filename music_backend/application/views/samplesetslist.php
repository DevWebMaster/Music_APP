<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Triggerz Muti List
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">

                <div class="form-group">
                    <a href="<?=base_url()?>index.php/sample-sets-list" class="tab-kind-triggers tab-kind-triggers-active">Triggerz Multi</a>
                    <a href="<?=base_url()?>index.php/sync4-lists" class="tab-kind-triggers">Triggerz Sync4</a>
                    <a href="<?=base_url()?>index.php/sync8-lists" class="tab-kind-triggers">Triggerz Sync8</a>
                    <a href="<?=base_url()?>index.php/images" class="tab-kind-triggers">Images</a>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/addnewsampleset"><i class="fa fa-plus"></i> Add New Sample Set</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Triggerz Muti List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>index.php/searchsample" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?=$search?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
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
                      <th>Id</th>
                      <th>Thumb</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Free</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php for($i = 1; $i<=count($samples); $i++)
                    {
                        $sample = $samples[$i-1];
                      ?>
                      <tr>
                      <th><?=$i?></th>
                      <?php 
                       $thumimage_url = $sample['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$sample['thumb'];
                      ?>
                      <th><img src="<?=$thumimage_url?>" style="width: 100px;"></th>
                      <th><?=$sample['name']?></th>
                      <th><?=$sample['description']?></th>
                      <th><?php echo $sample['is_free'] == "yes"?"-":$sample['price']?></th>
                      <th><?=$sample['is_free']?></th>
                      <th class="text-center">
                        <a class="btn btn-sm btn-success" href="<?=base_url()?>index.php/editsampleset/<?=$sample['id']?>" alt="edit sample"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-sm btn-info" href="<?=base_url()?>index.php/editsamplesets/<?=$sample['id']?>" alt="view sample set"><i class="fa fa-table"></i></a>
                        <span class="btn btn-sm btn-danger remove-sample-btn" data-sample-id="<?=$sample['id']?>" alt="delete sample"><i class="fa fa-trash"></i></span>
                        <span class="btn btn-sm btn-success noti-sample-btn" data-sample-name="<?=$sample['name']?>" data-sample-id="<?=$sample['id']?>" alt="notification"><i class="fa fa-bell"></i></span>
                      </th>
                    </tr>
                      <?php
                    }
                    ?>

                  </table>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>

<div id="deletemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?=base_url()?>index.php/deletesampleset" method="post">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Sample</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="sample-no" id="sample-id-hidden">
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sampleset.js"></script>