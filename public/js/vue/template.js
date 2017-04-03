
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    templates: [],
		    url_template: '',
		    url: '',
		    post_id: '',
		    template: [],
		    index: '',
		    position: '',
		    subject: '',
		    edit_position: '',
		    status: '',
		    status_desc: '',
		    id_template: 0
	  	},
	  	methods: {
	  		getPosts: function(){
	  			$.getJSON('templates/json', function(data){
                    this.templates = data;
                }.bind(this));
                $('#ukryj').hide();
            },
            show: function(template, index){
            	this.template = template;
            	this.index = index;
            },
            add: function(){
            	formData = new FormData($('#form-create')[0]);
            	action = $('#form-create').attr('action');
            	this.$http.post(action, formData ,{emulateHTTP: true}).then(function (response) {
            		$('#create').modal('hide');
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		if(response.body.status != 'not')
            		{
            			this.templates.push(response.body.template);
            		}
            		$('#form-create')[0].reset();
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
            },
            edit: function(){
            	formData = new FormData($('#form-edit')[0]);
	  			action = $('#form-edit').attr('action');
	  			$('#edit').modal('hide');
	  			this.$http.put(action, formData,{emulateHTTP:true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		this.id_template = response.body.id_template;
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    $('.alert').fadeIn('fast');
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		onDelete: function(id,template){
	  			this.$http.get('templates/delete/'+id).then(function (response) {
				    this.templates.$remove(template);
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
			this.getPosts();
			
		}
	});






