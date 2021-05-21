<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Edit Sample
        <small>Add, Edit, Delete</small>
        <div id="music-player-div"></div>
        
      </h1>
    </section>
    
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                <?php 
                   $thumimage_url = $sample['thumb'] == ""? base_url()."assets/thumbimages/no_img.png":base_url().'assets/thumbimages/'.$sample['thumb'];
                 ?>
                 <img src="<?=$thumimage_url?>" style="width: 100px;float: left;margin-right: 10px;">
                    <h3 class="box-title"><?=$sample['name']?></h3><p><?=$sample['description']?></p>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                    <!--   <th>Drum</th>
                      <th>Bass</th>
                      <th>Piano</th>
                      <th>Rhodes</th>
                      <th>Organ</th>
                      <th>Synth</th>
                      <th>Guitar</th>   -->             
                      <th>Loop</th>
                      <th>Drums</th>
                      <th>Bass</th>
                      <th>Keys</th>
                      <th>Aux</th>
                      <th>BGV</th>
                      <th>Guitar</th>  
                      
                    </tr>
                    <?php for($i = 1; $i<=9; $i++)
                    {
                      //var_dump($sample['key_item_'.$i]);
                      ?>
                      <tr data-item-id="<?=$sample['key_item_'.$i][0]['id']?>" data-key-no="<?=$i?>">
                      <th><?=$i?></th>
                      <th class="sync8-cell-name" style="cursor: pointer;text-decoration: underline;"><?=$sample['key_item_'.$i][0]['name']?></th>
                      <th data-key="1">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_1']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="2">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_2']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="3">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_3']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="4">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_4']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="5">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_5']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="6">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_6']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                      <th data-key="7">
                        <span class="btn btn-sm btn-success listen-music-btn" data-music-url="<?=$sample['key_item_'.$i][0]['player_7']?>"><i class="fa fa-headphones"></i></span>
                        <span class="btn btn-sm btn-info edit-music-btn"><i class="fa fa-pencil"></i></span>
                        <span class="btn btn-sm btn-danger remove-music-btn"><i class="fa fa-trash"></i></span>
                      </th>
                     
                      
                    </tr>
                      <?php
                    }
                    ?>

                  </table>
                  
                  <form action="<?=base_url()?>index.php/sync8-upload-music" role="form" enctype='multipart/form-data' id='sync8-upload-form' method="post" style="display: none;">
                    <input type="hidden" name="sync8-cell-id" id="sync8-cell-id" value="">
                    <input type="hidden" name="sync8-music-no" id="sync8-music-no">
                    <input type="hidden" name="sync8-id" value="<?=$sample['id']?>">
                    <input type="hidden" name="sync8-cell-no" id="sync8-cell-no">
                    <input type="file" name="sync8-music-file" id="sync8-music-file" accept="audio/*">
                  </form>

                </div>
              </div>
            </div>
        </div>

    </section>
</div>



<div id="deletemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?=base_url()?>index.php/deletesync8musicfile" method="post">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Sample</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="sync8-cell-id" id="sync8-cell-del-id">
            <input type="hidden" name="sync8-cell-no" id="sync8-cell-del-no">
            <input type="hidden" name="sync8-id" value="<?=$sample['id']?>">
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

<div id="editmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?=base_url()?>index.php/editsync8name" method="post">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Sync8 Name</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="sync8-cell-id" id="sync8-cell-edit-id">
            <input class="form-control" type="text" name="sync8-cell-name" id="sync8-cell-edit-val" required="" placeholder="Please Input Sync8 Name">
            <input type="hidden" name="sync8-id" value="<?=$sample['id']?>">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Change</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
    </form>
  </div>
</div>


<div id="listen-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Listen Music</h4>
          </div>
          <div class="modal-body listen-modal-body">
            <img src="<?=base_url()?>assets/images/loading.gif" style="width: 100%">
          
          </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-default listen-close-btn" data-dismiss="modal">Close</button>
          </div>
        </div>
    </form>
  </div>
</div>


<script type="text/javascript">
var baseURL = '<?=base_url()?>';
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/audiojs/audio.min.js" charset="utf-8"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/editItems.js" charset="utf-8"></script> -->

<script type="text/javascript">

  function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 5; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  $('.listen-music-btn').each(function(){
    var me = $(this);
    var music_url = me.data('music-url');
    if (music_url=="") {
      me.removeClass('btn-success');
      me.addClass('btn-default');
      me.attr('disabled',true);
      me.siblings('.remove-music-btn').attr('disabled',true);
    }
  });

  $('.listen-music-btn').click(function(){
    var me = $(this);
    var music_url = baseURL+"assets/sync8-musicfiles/"+me.data('music-url')+"?"+makeid();
    // caches.open('v1').then(function(cache) {
      // caches.delete(music_url).then(function(response) {
        
      // });
    // })
    var append_html='';
    append_html+='<p><audio style="width:100%;" controls> <source src="'+music_url+'" type="audio/ogg"></audio></p><br>';
    $('.listen-modal-body').html(append_html);
    $("#listen-modal").modal({
        backdrop:'static',
        keyboar:false
      });
  });

  // $('.listen-close-btn').click(function(){
  //   $('.listen-modal-body').html("");
  // });

  $("#listen-modal").on('hidden.bs.modal',function () {
    $('.listen-modal-body').html("");
  });

  $(".edit-music-btn").click(function(){
    $("#sync8-upload-form").closest('form').get(0).reset();
    var me = $(this);
    var p_th = me.parent();
    var pp_tr = me.parent().parent();
    var cell_id = pp_tr.attr('data-item-id');
    var cell_item_no = p_th.attr('data-key');
    var cell_no = pp_tr.data('key-no');
    $("#sync8-cell-id").val(cell_id);
    $("#sync8-music-no").val(cell_item_no);
    $("#sync8-cell-no").val(cell_no);
    $("#sync8-music-file").trigger('click');
  });

  $("#sync8-music-file").change(function(){
    if(!this.files[0]){
      //alert("file no selected");
      return;
    }
    //alert("file selected");
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = musicFileLoaded;
    reader.readAsDataURL(this.files[0]);
  });

  function musicFileLoaded(e)
  {
    $("#sync8-upload-form").submit();
  }

  $(".remove-music-btn").click(function(){
    $("#deletemodal").modal('show');
    var me = $(this);
    var p_th = me.parent();
    var pp_tr = me.parent().parent();
    var cell_id = pp_tr.attr('data-item-id');
    var cell_item_no = p_th.attr('data-key');
    
    $("#sync8-cell-del-id").val(cell_id);
    $("#sync8-cell-del-no").val(cell_item_no);

  });

  $(".sync8-cell-name").click(function(){
    var me = $(this);
   
    var pp_tr = me.parent();
    var cell_id = pp_tr.data('item-id');
    // alert(cell_id);
    $("#sync8-cell-edit-id").val(cell_id);
    $("#sync8-cell-edit-val").val(me.html());
    $("#editmodal").modal('show');
  });
</script>

<style type="text/css">
  .add-music-form-group{
    display: inherit!important;

  }
  .add-music-label{
    width: 10%;
  }
  .del-music-title{
    width: 30%;
  }
  .del-item{
    width: 50%;
  }
  .remove-music-one-file{
    float: right;
  }
</style>
