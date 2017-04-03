
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    posts: [],
		    url_posts: '',
		    url: '',
		    post_id: '',
		    post: [],
		    index: '',
		    position: '',
		    subject: '',
		    edit_position: '',
		    status: '',
		    status_desc: '',
		    check_prev_page: 0,
		    check_next_page: 0,
		    next_page_url: 0,
		    prev_page_url: 0,
		    per_page: 0,
		    total: 0,
		    paginate_url: "http://cmsgerro.dev/admin/posts/json?page=1",
		    numery: 0,
	  	},
	  	methods: {
	  		getPosts: function(url){
	  			if(url != null)
	  			{
		  			$.getJSON(url, function(data){
	                    this.posts = data.data;
	                    console.log(data);
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


            show: function(id, subject, position, post, index){
            	this.post_id = id;
            	this.subject = subject;
            	this.position = position;
            	this.post = post;
            	this.index = index;
            },
            editPosition: function(){
	  			action = $('#form-position').attr('action');
	  			$('#position').modal('hide');
	  			this.$http.put(action, {position: this.edit_position}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		this.posts.$set(this.index, response.body.post);
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    console.log(response.body);
				    $('.alert').fadeIn('fast');
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		onDelete: function(id, post){
	  			this.$http.get('posts/delete/'+id).then(function (response) {
				    this.posts.$remove(post);
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
			this.getPosts('/admin/posts/json');
			
		}
	});






