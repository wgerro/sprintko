
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    pages: [],
		    url_pages: '',
		    url: '',
		    page_name: '',
		    page_id: '',
		    page_position: '',
		    page: [],
		    edit_position: 0,
		    index: '',
		    status: '',
		    status_desc: '',
		    check_prev_page: 0,
		    check_next_page: 0,
		    next_page_url: 0,
		    prev_page_url: 0,
		    per_page: 0,
		    total: 0,
		    numery: 0,
	  	},
	  	methods: {
	  		getPages: function(url){
	  			if(url != null)
	  			{
		  			$.getJSON(url, function(data){
		  				this.pages = data.data;
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
	  		show: function(id, name, position, page, index){
	  			this.page_name = name;
	  			this.page_id = id;
	  			this.page_position = position;
	  			this.page = page;
	  			this.index = index;
	  		},
	  		editPosition: function(){
	  			action = $('#form-position').attr('action');
	  			$('#position').modal('hide');
	  			this.$http.put(action, {position: this.edit_position}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		this.pages.$set(this.index, response.body.page);
            		$('.alert').fadeOut('fast');
				  }, function (response) {
				    console.log(response.body);
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		onDelete: function(id, page){
	  			this.$http.get('pages/delete/'+id).then(function (response) {
				    this.pages.$remove(page);

				    if(response.body.ids.length > 0)
				    {
				    	console.log('ilosc response body = ' + response.body.ids.length);

				    	for(a=0; a<response.body.ids.length; a++)
				    	{
				    		for(i=0; i<this.pages.length; i++)
					    	{
					    		if(this.pages[i].id == response.body.ids[a])
					    		{

					    			this.pages[i].sub = null;
					    		}
					    	}
				    	}
				    	
				    }

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
	  		editModulePosition: function(){
	  			formData = new FormData($('#form-position-module')[0]);
	  			action = $('#form-position-module').attr('action');
	  			$('#modules-position').modal('hide');
	  			this.$http.put(action, formData, {emulateHTTP: true}).then(function (response) {
            		this.status = response.body.status;
            		console.log(this.status);
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		console.log(response.body.page);
            		this.pages.$set(this.index, response.body.page);
            		$('.alert').fadeOut('fast');
				  }, function (response) {
				    console.log(response.body);
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
                
	  		},
	  	},
		ready: function(){
			this.getPages(this.url_pages+'/json');
		}
	});






