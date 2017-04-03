
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    category: [],
		    cat: [],
		    url: '',
		    url_category: '',
		    id_category: 0,
		    name: 0,
		    description: 0,
		    status: 0,
		    status_desc: '',
		    create_name: '',
		    create_description: '',
		    edit_name: '',
		   	edit_description: '',
		   	index: '',
		   	check_prev_page: 0,
		    check_next_page: 0,
		    next_page_url: 0,
		    prev_page_url: 0,
		    per_page: 0,
		    total: 0,
		    numery: 0,
	  	},
	  	methods: {
	  		getCategory: function(url){
	  			if(url != null)
	  			{
		  			$.getJSON(url, function(data){
	                    this.category = data.data;
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
	                }.bind(this));
	                $('#ukryj').hide();
	            }
            },
            add: function(){
            	action = $('#form-create').attr('action');
            	this.$http.post(action, {name: this.create_name, description: this.create_description}).then(function (response){
            		$('#create').modal('hide');
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;

            		if(response.body.status != 'not')
            		{
            			this.category.push(response.body.category);
            		}
            		this.create_name = '';
            		this.create_description = '';
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    console.log(response.body);
				});
            	setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
            },
            show: function(id, name, description, cat, index){
            	this.name = name;
            	this.id_category = id;
            	this.description = description;
            	this.cat = cat;
            	this.index = index;
            },
		 	edit: function(){
		 		action = $('#form-edit').attr('action');
		 		this.$http.put(action, {name: this.edit_name, description: this.edit_description}).then(function (response) {
		 			$('#edit').modal('hide');
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		this.category.$set(this.index, response.body.category);
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
		 	},
		 	onDelete: function(id,cat){
		 		this.$http.get('category/delete/'+id).then(function (response) {
				    this.category.$remove(cat);
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
			this.getCategory(this.url_category+'/json');
			
		}
	});






