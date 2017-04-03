
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    contents: [],
		    content: 0,
		    key: 0,
		    status: 0,
		    status_desc: 0,
		    status_p_c: 0,
		    status_desc_p_c: 0,
		    pages: [],
		    page: {contents: {id:0} },
	  	},
	  	methods: {
	  		getContents: function(){
	  			this.$http.get('contents/json').then(function (response) {
	  				this.contents = response.body.contents;
	  				this.pages = response.body.pages;
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.ukryj').hide();
				    $('.alert').fadeIn('fast');
				}, function (response) {
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				});
	  		},
	  		show: function(content, key){
	  			this.content = content;
	  			this.key = key;
	  			console.log(this.key);
	  		},
	  		showSecond: function(page, key){
	  			this.page = page;
	  			this.key = key;
	  			console.log(this.key);
	  		},
	  		add: function(){
	  			formData = new FormData($('#form-create')[0]);
	  			action = $('#form-create').attr('action');
	  			
	  			this.$http.post(action, formData, {emulateHTTP:true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		this.contents.push(response.body.contents);
            		$('#add-content').modal('hide');
            		$('#form-create')[0].reset();
            		$('.alert').fadeIn('fast');
            		setTimeout(function() {
						$('.alert').fadeOut('slow');}, 3000
					);
				  }, function (response) {
				  	this.status = 'not';
				  	this.status_desc = response.body.name;
				    console.log(response.body);
				    $('.alert').fadeIn('fast');
				    $('#add-content').modal('hide');
				});
				
	  		},
	  		edit: function(){
	  			formData = new FormData($('#form-edit')[0]);
	  			action = $('#form-edit').attr('action');
	  			
	  			this.$http.put(action, formData, {emulateHTTP:true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		//this.getPages();
            		this.contents.$set(this.key, response.body.contents);
            		$('#edit-content').modal('hide');
            		$('#form-edit')[0].reset();
            		$('.alert').fadeIn('fast');
            		setTimeout(function() {
						$('.alert').fadeOut('slow');}, 3000
					);
				  }, function (response) {
				    console.log(response.body);
				    this.status = 'not';
				  	this.status_desc = response.body.name;
				    $('.alert').fadeIn('fast');
				    $('#edit-content').modal('hide');
				});
				
	  		},
	  		onDelete: function(content){
	  			this.$http.get('contents/delete/'+content.id).then(function (response) {
				    this.contents.$remove(content);
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc + content.name;
				    $('.alert').fadeIn('fast');
				}, function (response) {
				    this.status = response.body.status;
				    this.status_desc = response.body.status_desc;
				    $('.alert').fadeIn('fast');
				});
		 		$('#delete-content').modal('hide');
		 		setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		edit_p_c: function(){
	  			formData = new FormData($('#form-edit-p-c')[0]);
	  			action = $('#form-edit-p-c').attr('action');
	  			
	  			this.$http.post(action, formData, {emulateHTTP:true}).then(function (response) {
            		this.status_p_c = response.body.status;
            		this.status_desc_p_c = response.body.status_desc;
            		console.log(response.body.contents);
            		//this.getPages();
            		this.pages.$set(this.key, response.body.contents);
            		$('#edit-page-content').modal('hide');
            		$('#form-edit')[0].reset();
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    console.log(response.body);
				    $('.alert').fadeIn('fast');
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		//PAGES CONTENTS
			checkContent: function(id_content){
	  			contents = this.page.contents;
	  			for(i=0; i< contents.length; i++)
	  			{
	  				if(contents[i].content_id == id_content)
	  				{
	  					return true;
	  				}
	  			}

	  			return false;
	  		}
	  	},
	  	computed: {
	  		
	  	},
		ready: function(){
			this.getContents();
		}
	});






