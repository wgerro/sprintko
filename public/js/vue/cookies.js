
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
var config = {};
			config.minHeight = 600;
			config.maxHeight = null;
			config.toolbar =  [
			        ['style', ['bold', 'italic', 'underline', 'clear']],
					['color', ['color']],
			        ['para', ['ul', 'ol', 'paragraph']],
			        ['height', ['height']]
			]; // watever toolbar you need..
			$('#content').summernote(config);
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
	  		edit: function(form){
	  			formData = new FormData($('#form-edit')[0]);
	  			action = $('#form-edit').attr('action');
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
	  		
	  	},
		ready: function(){
			
		}
	});






