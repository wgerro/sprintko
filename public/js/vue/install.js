Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
$('.alert').addClass('pokaz');

	new Vue({
	  	el: '#app',

	  	data: {
			message: 'aaa',
			pokaz: false,
			status: 2,
			password: '',
			password_conf: '',
			email: '',
			login: '',
	  	},
	  	methods: {

	  		check: function(e){
	  			e.preventDefault();
	  			formData = new FormData($('#formularz')[0]);
	  			action = $('#formularz').attr('action');
	  			$('.fa-spinner').addClass('pokaz-fa');
	  			this.$http.post('install/check', formData,{emulateHTTP: true} ).then( function(response) {
	  				console.log(response.body.status);
	  				this.status = response.body.status;
	  				$('.fa-spinner').removeClass('pokaz-fa');
	  				$('#drugi-krok').addClass('pokaz-drugi-krok');
		  				$('.ukryj-drugi-krok-div').addClass('pokaz-drugi-krok-div');
				      $('html, body').animate({
				        scrollTop: $('#drugi-krok').offset().top
				      }, 700, function(){
				      });
	  			}, function (response) {
	  				$('.fa-spinner').removeClass('pokaz-fa');
	  				this.status = 0;
	  			});
	  		},
	  		
	  	},
	  	computed: {
	  		isEmailValid: function(){
	  			var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
   				return pattern.test(this.email);
	  		}
	  	},
		ready: function(){
			
		}
	});






