$(document).ready(function(){

	 function makeid() {
	    var text = "";
	    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	    for (var i = 0; i < 5; i++)
	      text += possible.charAt(Math.floor(Math.random() * possible.length));

	    return text;
	  }

	$('.edit-music-btn').click(function(){
		document.getElementById("music-upload-form").reset();
		var me = $(this);
		var p_th = me.parent();
		var pp_tr = me.parent().parent();
		var item_no = pp_tr.attr('data-item-id');
		var field_name = p_th.attr('data-key');
		var key_no = pp_tr.attr('data-key-no');
		
		var listen_btn = me.prev('.listen-music-btn');
		var is_disabled = listen_btn.attr('disabled');
		$('#music-item-no').val(item_no);
		$('#music-field-name').val(field_name);
		$('#music-key-no').val(key_no);
		if(is_disabled =='disabled')
		{
			$('#editmodal').modal({
				backdrop:'static',
				keyboar:false
			});
			for (var i = 1; i <= 7; i++) {
				$('.uploaded-'+i).addClass('hide');
			}
		}
		else{
				var music_url = listen_btn.data('music-url');
				$.ajax({
					url : baseURL+'index.php/getmusicfiles/'+music_url,
					//data : {cell_id: music_url},
					type : 'GET',
					dataType : 'JSON',
					success: function(data){
						if(data.success == 0)
						{
							data.player_1=="" ? $('.uploaded-1').addClass('hide') : $('.uploaded-1').removeClass('hide');
							data.player_2=="" ? $('.uploaded-2').addClass('hide') : $('.uploaded-2').removeClass('hide');
							data.player_3=="" ? $('.uploaded-3').addClass('hide') : $('.uploaded-3').removeClass('hide');
							data.player_4=="" ? $('.uploaded-4').addClass('hide') : $('.uploaded-4').removeClass('hide');
							data.player_5=="" ? $('.uploaded-5').addClass('hide') : $('.uploaded-5').removeClass('hide');
							data.player_6=="" ? $('.uploaded-6').addClass('hide') : $('.uploaded-6').removeClass('hide');
							data.player_7=="" ? $('.uploaded-7').addClass('hide') : $('.uploaded-7').removeClass('hide');
							$('#editmodal').modal({
								backdrop:'static',
								keyboar:false
							});
						}
						else{
								$('#editmodal').modal({
									backdrop:'static',
									keyboar:false
								});
						}
					},
					fail: function(err){

					}
				});

		}
	});

	$('.remove-music-btn').click(function(){
		var me = $(this);
		var p_th = me.parent();
		var pp_tr = me.parent().parent();
		var item_no = pp_tr.attr('data-item-id');
		var field_name = p_th.attr('data-key');
		$('#del-music-item-no').val(item_no);
		$('#del-music-field-name').val(field_name);
		$('#deletemodal').modal({
				backdrop:'static',
				keyboar:false
			});

		$('.del-items-loading').removeClass('hide');
		$('.del-items-div').addClass('hide');
		var listen_btn = me.siblings('.listen-music-btn');
		music_url =listen_btn.data('music-url');
		$.ajax({
			url : baseURL+'index.php/getmusicfiles/'+music_url,
			//data : {cell_id: music_url},
			type : 'GET',
			dataType : 'JSON',
			success: function(data){
				if(data.success == 0)
				{
					$('.del-items-loading').addClass('hide');
					$('.del-items-div').removeClass('hide');
					data.player_1=="" ? $('.remove-music-one-file-1').attr('disabled',true) :$('.remove-music-one-file-1').attr('disabled',false) ;
					data.player_2=="" ? $('.remove-music-one-file-2').attr('disabled',true) :$('.remove-music-one-file-2').attr('disabled',false) ;
					data.player_3=="" ? $('.remove-music-one-file-3').attr('disabled',true) :$('.remove-music-one-file-3').attr('disabled',false) ;
					data.player_4=="" ? $('.remove-music-one-file-4').attr('disabled',true) :$('.remove-music-one-file-4').attr('disabled',false) ;
					data.player_5=="" ? $('.remove-music-one-file-5').attr('disabled',true) :$('.remove-music-one-file-5').attr('disabled',false) ;
					data.player_6=="" ? $('.remove-music-one-file-6').attr('disabled',true) :$('.remove-music-one-file-6').attr('disabled',false) ;
					data.player_7=="" ? $('.remove-music-one-file-7').attr('disabled',true) :$('.remove-music-one-file-7').attr('disabled',false) ;
				}
				else{

				}
			},
			fail:function(err)
			{
				alert(err);
			}
		});

	});

	$('.listen-music-btn').click(function(){
		var music_url = $(this).data('music-url');
		// $('#music-player-div').html('<audio src="" preload="auto" id="music-player" >');
		// $('#music-player').attr('src',baseURL+'/assets/music-sample/'+music_url);
		// audiojs.events.ready(function(){
		// 	var as = audiojs.createAll();
		// });
		$('.listen-modal-body').html('<img src="'+baseURL+'assets/images/loading.gif" style="width: 100%">');
		$.ajax({
			url : baseURL+'index.php/getmusicfiles/'+music_url,
			//data : {cell_id: music_url},
			type : 'GET',
			dataType : 'JSON',
			success: function(data){
				if(data.success == 0)
				{
					//window.temp_music_data = data;
					var append_html='';
					append_html+='<p><b style="float:left;">Drum : </b><audio style="float:right;" controls> <source src="'+data.player_1+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Bass : </b><audio style="float:right;" controls> <source src="'+data.player_2+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Piano : </b><audio style="float:right;" controls> <source src="'+data.player_3+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Rhodes : </b><audio style="float:right;" controls> <source src="'+data.player_4+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Organ : </b><audio style="float:right;" controls> <source src="'+data.player_5+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Synth : </b><audio style="float:right;" controls> <source src="'+data.player_6+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					append_html+='<p><b style="float:left;">Guitar  : </b><audio style="float:right;" controls> <source src="'+data.player_7+"?"+makeid()+'" type="audio/ogg"></audio></p><br>';
					
					$('.listen-modal-body').html(append_html);

					$('.listen-close-btn').click(function(){
					 	var audios = document.getElementsByTagName('audio');
						for(i=0;i<audios.length;i++)
						{
							audios[i].pause();
						}
					});
					
				}
				else{
					$('.listen-modal-body').html('<h1>'+data.message+'</h1>');
					alert(error);
				}
			} ,
			fail : function(err)
			{
				$("#listen-modal").modal('hide');
				alert(err);
			}
		});
		
		$("#listen-modal").modal({
				backdrop:'static',
				keyboar:false
			});
		
	});


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

	$('.remove-music-one-file').click(function(){
		var me = $(this);
		var post_data = {
			item_no 	: $('#del-music-item-no').val(),
			field_name 	: $('#del-music-field-name').val(),
			sample_no 	: $('#sample-no').val(),
			player_no 	: me.data('player')
		};

		$.ajax({
			url: baseURL+"index.php/deletemusiconefile",
			type:'post',
			data:post_data,
			dataType: 'json',
			success: function(data){
				if(data.success == 0)
				{
					me.attr('disabled',true);
					alert("file is deleted successfully!");
				}
				else{
					alert("erro");
				}
			},
			fail: function(err){
				alert(err);
			}
		});
	});

});

