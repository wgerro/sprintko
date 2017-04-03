
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    albums: [],
		    album: [],
		    url_albums: '',
		    url: '',
		    album_id: '',
		    album_name: '',
		    album_image: '',
		    page_position: '',
		    page: [],
		    edit_position: 0,
		    index: '',
		    status: '',
		    status_desc: '',
		    edit_name: '',
		    edit_image: '',
		    edit_active: '',
		    edit_category: '',
		    show_modal: false,
		    file: 0,
		    check_prev_page: 0,
		    check_next_page: 0,
		    next_page_url: 0,
		    prev_page_url: 0,
		    per_page: 0,
		    total: 0,
		    paginate_url: "admin/albums/json?page=1",
		    numery: 0,
	  	},
	  	methods: {
	  		getAlbums: function(url){
	  			if(url != null)
	  			{
		  			$.getJSON(url, function(data){
		  				this.albums = data.data;
		  				this.numery = data.from;
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
            		if(response.body.status != 'not')
            		{
            			this.albums.push(response.body.album);
            		}
            		$('#form-create')[0].reset();
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				  	$('#create').modal('hide');
				    this.status = 'not';
				    this.status_desc = 'Name can not be the same as another';
				});
				setTimeout(function(){
		         	$('#create').modal('hide');
		        },1000);
				setTimeout(function() {
					$('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
					$('.alert').fadeOut('slow');}, 3000
				);
            	
            },
	  		show: function(id, name, image, album, index)
	  		{
	  			this.album_id = id;
	  			this.album_name = name;
	  			this.album_image = image;
	  			this.album = album;
	  			this.index = index;
	  			this.show_modal = true;
	  		},
	  		edit: function(){
	  			
		 		action = $('#form-edit').attr('action');
		 		formData = new FormData($('#form-edit')[0]);
		 		this.$http.put('media-albums/edit/'+this.album_id, formData,{emulateHTTP: true})
		 		.then(function (response) {
		 			$('#edit').modal('hide');
            		this.status = response.body.status;
            		$('#filebutton123').val("");
            		this.status_desc = response.body.status_desc;
            		this.albums.$set(this.index, response.body.album);
            		$('.alert').fadeIn('fast');
            		$('#form-edit')[0].reset();
				  }, function (response) {
				  	$('#edit').modal('hide');
				    this.status = 'not';
				    this.status_desc = 'Name can not be the same as another';
				});
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);

		 	},
	  		onDelete: function(id,album){
		 		this.$http.get('media-albums/delete/'+id).then(function (response) {
				    this.albums.$remove(album);
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				}, function (response) {
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
		 		$('#delete').modal('hide');
		 	},
		 	attachFile(e) {
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;

            this.file = files[0];
        	},
	  		
	  	},
		ready: function(){
			this.getAlbums('/admin/media-albums/json');
			
		}
	});






