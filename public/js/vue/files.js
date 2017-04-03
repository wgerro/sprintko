
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    files: [],
		    file: [],
		    url_files: '',
		    url: '',
		    gallery_id: 0,
		    status: 0,
		    status_desc: 0,
		    index: 0,
		    option:0,
	  	},
	  	methods: {
	  		getFiles: function(id){
	  			$.getJSON('/admin/media-albums/files/json/'+id+'/'+this.option, function(data){
	  				this.files = data;
	  				$('#ukryj').hide();
	  				this.$nextTick(function(){
						this.aktualizujAudio();						
	  				});
	  			}.bind(this));
	  		},
	  		show: function(file, index){
	  			this.file = file;
	  			this.index = index;
	  		},
	  		add: function()
	  		{
	  			progressBar = $('.progress-bar');
	  			formData = new FormData($('#form-create')[0]);
            	action = $('#form-create').attr('action');
            	this.$http.post(action, formData ,{emulateHTTP: true, progress: function(data){
		  				var percentAll = (data.loaded/data.total) * 100;
		  				progressBar.animate({width: percentAll +"%"}, 100);
	            	}}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		if(response.body.status != 'not')
            		{
            			array = response.body.file;
            			for(i=0;i<array.length ;i++)
            			{
            				console.log(array[i]);
            				this.files.push(array[i]);
            			}
            		}
            		$('#form-create')[0].reset();
            		$('.alert').fadeIn('fast');
            		this.$nextTick(function(){
						this.aktualizujAudio();						
	  				});
				  }, function (response) {
				    console.log(response.body);
				});
	            setTimeout(function(){
		         	$('#create').modal('hide');
		        },1000);
				setTimeout(function() {
					$('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		edit: function(){
	  			action = $('#form-edit').attr('action');
		 		formData = new FormData($('#form-edit')[0]);
		 		this.$http.put(action, formData,{emulateHTTP: true})
		 		.then(function (response) {
		 			$('#edit').modal('hide');
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		this.files.$set(this.index, response.body.file);
            		$('#form-edit')[0].reset();
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    
				});
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		onDelete: function(file){
		 		this.$http.get('/admin/media-albums/files/delete/'+file.id).then(function (response) {
				    this.files.$remove(file);
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeOut('fast');
				}, function (response) {
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeOut('fast');
				});
		 		$('#delete').modal('hide');
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
		 	},
		 	aktualizujAudio: function(){
				$("audio").each(function(){
				  $(this).bind("play",stopAll);
				});
				function stopAll(e){
				    var currentElementId=$(e.currentTarget).attr("id");
				    $("audio").each(function(){
				        var $this=$(this);
				        var elementId=$this.attr("id");
				        if(elementId!=currentElementId){
				            $this[0].pause();
				        }
				    });
				}
		 	}
	  		
	  	},
		ready: function(){
			this.getFiles(this.gallery_id);
			
		}
	});






