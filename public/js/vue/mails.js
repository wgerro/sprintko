
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
var config = {};
			config.minHeight = 200;
			config.maxHeight = null;
			config.toolbar =  [
			        ['style', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
			        ['para', ['ul', 'ol', 'paragraph']],
			        ['height', ['height']]
			]; // watever toolbar you need..
			$('#content-1').summernote(config);
			$('#content-2').summernote(config);
			$('#content-3').summernote(config);
	new Vue({
	  	el: '#app',
	  	data: {
		    mails: [],
		    mail: [],
		    url_widgets: '',
		    url: '',
		    gallery_id: 0,
		    status: 0,
		    status_desc: 0,
		    edit_position: 0,
		    edit_active: 0,
		    index: 0,

	  	},
	  	methods: {
	  		getMails: function(){
	  			$.getJSON('/admin/mails/json/', function(data){
	  				this.mail = data;
	  				$('#ukryj').hide();
	  			}.bind(this));
	  		},
	  		edit: function(form){
	  			formData = new FormData($('#form-edit-'+form)[0]);
	  			action = $('#form-edit-'+form).attr('action');
	  			$('#edit').modal('hide');
	  			this.$http.put(action, formData, {emulateHTTP: true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    $('.alert').fadeIn('fast');
				});
	  			setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		show: function(mail){
	  			this.mail = mail;
	  		},
	  		send: function(){
	  			formData = new FormData($('#form-send')[0]);
	  			action = $('#form-send').attr('action');
	  			$('#edit').modal('hide');
	  			this.$http.post(action, formData, {emulateHTTP: true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		$('.alert').fadeIn('fast');
            		$('#form-send')[0].reset();
            		$('#content-3').summernote('reset');
				  }, function (response) {
				    $('.alert').fadeIn('fast');
				});
	  			setTimeout(function() {
					$('.alert').fadeOut('slow');}, 5000
				);
	  		}
	  	},
		ready: function(){
			this.getMails();
			
		}
	});






