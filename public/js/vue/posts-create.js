
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define

$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
	new Vue({
	  	el: '#app',
	  	data: {
		   	name_menu: '',
		    slug: '',
	  	},
	  	methods: {
	  		uploadImage: function(image){
	  			action = '/admin/posts/upload';
	  			var data = new FormData();
			    data.append("file", image);
	  			this.$http.post(action, data ,{emulateHTTP: true}).then(function (response) {
	  				console.log(response.body);
            		var image = $('<img>').attr('src', response.body);
			            $('#description').summernote("insertNode", image[0]);
				  }, function (response) {
				    console.log(data);
				});
	  		},
	  		removeImage: function(image){
	  			przycisk = $('.note-remove')
	  		}
	  	},
	  	
		ready: function(){
			const pokaz = this;
			$('#description').summernote({
				minHeight: 400,
				maxHeight: null,
				callbacks: {
				    onImageUpload: function(image) {
				      // upload image to server and create imgNode...
				      //$('#description').summernote('insertNode', imgNode);
				      pokaz.uploadImage(image[0]);

				    },
				  }
			});
		}
	});
