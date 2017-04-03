
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
$('.file-view').addClass('.pokaz-view');
	new Vue({
	  	el: '#app',
	  	data: {
		    editors: [],
		    editor: [],
		    path: 0,
		    index: '',
		    status: '',
		    status_desc: '',
		    file_view: false,
		    file: '',
	  	},
	  	methods: {
	  		getEditors: function(){
	  			$.getJSON('editor-html/json', function(data){
	  				this.editors = data;
	  				$('.ukryj').hide();
	  			}.bind(this));
	  		},
	  		show_file: function(editor, path){
	  			this.editor = editor;
	  			this.path = path;
	  			this.getFile(editor,path);
	  			if(this.file_view)
	  			{
	  				$('.file-view').fadeOut('slow');
	  				$('.file-view').fadeIn('slow');
	  			}
	  			else{
	  				this.file_view = true;
	  				$('.file-view').fadeIn('slow');
	  			}
	  			szerokosc = $(window).width();
				if(szerokosc < 992)
				{
					console.log(szerokosc);
					target = $('.wyswietlenie-pliku');
			          
			            $('html,body').animate({
			              scrollTop: target.offset().top
			            }, 700);
			           
				}

	  		},
	  		getFile: function(editor, path){
	  			$.getJSON('editor-html/json/open/'+editor.name+'/'+path , function(data){
	  				this.file = data;
	  			}.bind(this));
	  		},
	  		send: function(){
	  			formData = new FormData($('#form-send')[0]);
            	action = $('#form-send').attr('action');
            	this.$http.post(action, formData ,{emulateHTTP: true}).then(function (response) {
            		this.status = response.body.status;
            		this.status_desc = response.body.status_desc;
            		$('.alert').fadeIn('fast');
				  }, function (response) {
				    console.log(response.body);
				});
				setTimeout(function() {
					$('.alert').fadeOut('slow');}, 3000
				);
	  		}	
	  	},
		ready: function(){
			this.getEditors();
		}
	});





