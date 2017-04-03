
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    media_singles: [],
		    media_single: [],
		    url_media_singles: '',
		    url: '',
		    status: 0,
		    status_desc: 0,
		    index:0,
		    check_prev_page: 0,
		    check_next_page: 0,
		    next_page_url: 0,
		    prev_page_url: 0,
		    per_page: 0,
		    total: 0,
		    paginate_url: "admin/media-single/json?page=1",
		    numery: 0,
		    edit_category: 0,
	  	},
	  	methods: {
	  		getMediaSingle: function(url){
	  			if(url != null)
	  			{
		  			$.getJSON(url, function(data){
		  				this.media_singles = data.data;
		  				this.numery = data.from == 0 ? 1 : data.from;
	                    if(data.prev_page_url == null)
	                    {
	                    	this.check_prev_page = false;
	                    	this.prev_page_url = null;
	                    }
	                    else
	                    {
	                    	this.check_prev_page = true;
	                    	this.prev_page_url = data.prev_page_url;
	                    }
	                    
	                    if(data.next_page_url != null)
	                    {
	                    	this.check_next_page = true;
	                    	this.next_page_url = data.next_page_url;
	                    }
	                    else
	                    {
	                    	this.check_next_page = false;
	                    	this.next_page_url = null;
	                    }
		  				$('#ukryj').hide();
		  			}.bind(this));
		  		}
	  		},
	  		add: function(){
	  			progressBar = $('.progress-bar');
	  			formData = new FormData($('#form-create')[0]);
            	action = $('#form-create').attr('action');
            	this.$http.post(action, formData ,{emulateHTTP: true, progress: function(data){
		  				var percentAll = (data.loaded/data.total) * 100;
		  				progressBar.animate({width: percentAll +"%"}, 100);
	            	}}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		console.log(response.body.media_single);
            		if(response.body.status != 'not')
            		{	
            			array = response.body.media_single;
            			for(i=0;i<array.length ;i++)
            			{
            				this.media_singles.push(array[i]);
            			}
            		}
            		$('#form-create')[0].reset();
            		$('.alert').fadeIn('fast');
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

            		this.media_singles.$set(this.index, response.body.media_single);
            		$('#form-edit')[0].reset();
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    
				});
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		show: function(media_single, index){
	  			this.media_single = media_single;
	  			this.index = index;
	  			console.log(media_single);
	  		},
	  		onDelete: function(media_single){ 
		 		this.$http.get('/admin/media-single/delete/'+media_single.id).then(function (response) {
		 			console.log(response.body);
				    this.media_singles.$remove(media_single);
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
		 	},
	  		
	  	},
		ready: function(){
			this.getMediaSingle('/admin/media-single/json');
			
		}
	});






