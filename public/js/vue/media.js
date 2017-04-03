
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
$('.file-view').addClass('.pokaz-view');

	new Vue({
	  	el: '#app',
	  	data: {
		    medias: [],
		    media: [],
		    status: '',
		    status_desc: '',
		    message: 'ąęó',
		    url: '',
		    progressActual: 0,
	  	},
	  	methods: {
	  		getMedia: function(){
	  			this.$http.get('media/json').then(function (response) {
            		this.medias = response.body;
            		$('.ukryj').hide();
				  }, function (response) {
				    
				});
	  		},
	  		send: function(){
	  			
	  			progressBar = $('.progress-bar');
	  			
		  			formData = new FormData($('#form-create')[0]);
	            	action = $('#form-create').attr('action');
	            	this.$http.post(action, formData ,{emulateHTTP: true, progress: function(data){
		  				var percentAll = (data.loaded/data.total) * 100;
		  				progressBar.animate({width: percentAll +"%"}, 100);
	            	}}).then(function (response) {
	            		this.status = response.body.status;
	            		this.status_desc = response.body.status_desc;
	            		$('.alert').fadeIn('fast');
	            		$('#form-create')[0].reset();

	            		this.medias.push({name: response.body.name ,type: response.body.type });
	            		setTimeout(function(){
		            		$('#create').modal('hide');
		            	},1000);
		            	setTimeout(function() {
							$('.alert').fadeOut('slow'); 
							$('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
						}, 3000
						);
					  }, function (response) {
					});
					
	  		},
	  		show: function(media){
	  			this.media = media;
	  		},
	  		onDelete: function(media){
	  			this.$http.get('media/delete/'+media.name).then(function (response) {
				    this.medias.$remove(media);
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				}, function (response) {
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				});
		 		$('#delete').modal('hide');
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		}

	  	},
		ready: function(){
			this.getMedia();

		}
	});



