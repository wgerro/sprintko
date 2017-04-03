
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		    widgets: [],
		    widget: [],
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
	  		getWidgets: function(){
	  			$.getJSON('/admin/widgets/json/', function(data){
	  				this.widgets = data;
	  				$('#ukryj').hide();

	  			}.bind(this));
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
            			this.widgets.push(response.body.widget);
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
	  			this.$http.put(action, formData, {emulateHTTP: true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		this.widgets.$set(this.index, response.body.widget);
            		$('#form-edit')[0].reset();
            		console.log(response.body.widget.active);
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    $('.alert').fadeIn('fast');
				});
	  			setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		},
	  		show: function(widget, index){
	  			this.widget = widget;
	  			this.index = index;

	  		},
	  		onDelete: function(widget){
		 		this.$http.get('/admin/widgets/delete/'+widget.id).then(function (response) {
				    this.widgets.$remove(widget);
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
			this.getWidgets();
			
		}
	});






