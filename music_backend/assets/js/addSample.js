$(document).ready(function(){
	
	var addUserForm = $("#addSampleSet");
	
	var validator = addUserForm.validate({
		
		rules:{
			sname :{ required : true },
			sdescription : { required : true},
		},
		messages:{
			sname :{ required : "This field is required" },
			sdescription : { required : "This field is required"},			
		}
	});

	//$( "#short-seq" ).sortable();
    // $( "#short-seq" ).disableSelection();
    // $( "#long-seq" ).sortable();
    // $( "#long-seq" ).disableSelection();

	$(".sort-seq-undo").click(function() {
	  location.reload();
	});

	$(".short-change-btn").click(function(){
		var data = $('#short-seq').sortable('toArray', { attribute: 'predmet-id' });	
		var post_data = {
			order : data.toString(),
			sample_id : $("#sid").val(),
			type:'order_short'
		};

		$.ajax({
			url : baseURL+"index.php/update_order",
			type: 'POST',
			data: post_data,
			dataType: 'json',
			success: function(data){
				alert('change successed!');
				location.reload();
			},
			fail: function(err){
				alert(err);
				location.reload();
			}
		});
	});

	$(".long-change-btn").click(function(){
		var data = $('#long-seq').sortable('toArray', { attribute: 'predmet-id' });	
		var post_data = {
			order : data.toString(),
			sample_id : $("#sid").val(),
			type:'order_long'
		};

		$.ajax({
			url : baseURL+"index.php/update_order",
			type: 'POST',
			data: post_data,
			dataType: 'json',
			success: function(data){
				alert('change successed!');
				location.reload();
			},
			fail: function(err){
				alert(err);
				location.reload();
			}
		});
	});

	 $('#sfree').change(function() {
	 	if($(this).is(':checked')){
	 		$('#sprice').prop('disabled',true);
	 		$('#sprice').val(0);
	 	}
	 	else{
	 		$('#sprice').prop('disabled',false);

	 	}
	 });

	 $('#sprice').change(function(){
	 	if($(this).val() == "")
	 	{
	 		$(this).val(0);
	 	}
	 });

	 $('.switch-short-btn').click(function(){
	 	var me = $(this);
	 	var long_btn = $('.switch-long-btn');
	 	var short_panel = $('.short-panel');
	 	var long_panel = $('.long-panel');

	 	short_panel.removeClass('hide');
	 	long_panel.addClass('hide');
	 	me.addClass("btn-success");
	 	me.removeClass("btn-default");
	 	long_btn.removeClass('btn-success');
	 	long_btn.addClass('btn-default');

	 });
	$('.switch-long-btn').click(function(){
	 	var me = $(this);
	 	var short_btn = $('.switch-short-btn');
	 	var short_panel = $('.short-panel');
	 	var long_panel = $('.long-panel');
	 	short_panel.addClass('hide');
	 	long_panel.removeClass('hide');

	 	me.addClass("btn-success");
	 	me.removeClass("btn-default");
	 	short_btn.removeClass('btn-success');
	 	short_btn.addClass('btn-default');
	 });

	$( ".draggable-short" ).draggable({
      connectToSortable: "#short-seq",
      helper: function() {
        	var helper = $(this).clone(); // Untested - I create my helper using other means...
        	// jquery.ui.sortable will override width of class unless we set the style explicitly.
        	helper.css({'width': '100px', 'height': 'auto'});
        	return helper;
    	},
      revert: "invalid",
      stop: function() {
        //$(this).css({'width': '100%', 'height': 'auto'});
        $('#short-seq .draggable-short').removeAttr('style');
      }
    });
    $( "#short-seq" ).sortable({
      revert: true
    });
     $( "#short-seq" ).disableSelection();



     $( ".draggable-long" ).draggable({
      connectToSortable: "#long-seq",
      helper: function() {
        	var helper = $(this).clone(); // Untested - I create my helper using other means...
        	// jquery.ui.sortable will override width of class unless we set the style explicitly.
        	helper.css({'width': '100px', 'height': 'auto'});
        	return helper;
    	},
      revert: "invalid",
      stop: function() {
        //$(this).css({'width': '100%', 'height': 'auto'});
        $('#long-seq .draggable-long').removeAttr('style');
      }
    });
    $( "#long-seq" ).sortable({
      revert: true
    });
     $( "#long-seq" ).disableSelection();

     $('.drag-del').click(function(){
     	$(this).parent().remove();
     });





// Function to preview image after validation

$("#thumb").change(function()
 {

	var file = this.files[0];
	var imagefile = file.type;
	var match= ["image/jpeg","image/png","image/jpg"];
	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
	{
		$('#thubpreview').attr('src',baseURL+'assets/thubimages/no_img.png');
		return false;
	}
	else
	{
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
	}
});

function imageIsLoaded(e) 
{
	$('#thubpreview').attr('src', e.target.result);	
}

});


