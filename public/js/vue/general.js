
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    general: {},
		    apis: [
			    {name: 'sprintko'},
			    {name: 'facebook'},
			    {name: 'disqus'},
		    ],
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
		   	url_general: '',
	  	},
	  	methods: {
	  		getGeneral: function(){
	  			$.getJSON('general/json', function(data){
                    this.general = data;
                }.bind(this));
                $('#ukryj').hide();
            },
            
		 	edit: function(slug){
		 		formData = new FormData($('#form-edit'+slug)[0]);
	  			action = $('#form-edit'+slug).attr('action');
	  			$('#edit').modal('hide');
	  			this.$http.put(action, formData,{emulateHTTP:true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		this.general.logo = response.body.logo;
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
			this.getGeneral();
		}
	});






