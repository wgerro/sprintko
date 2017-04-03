
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
	  		
	  	},
	  	computed: {
	  		getText: function(){
	  			return this.name_menu.trim().replace(/\s/g,'-');
	  		}
	  	},
		ready: function(){
			
		}
	});

