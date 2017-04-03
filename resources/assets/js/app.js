
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('pages', require('./components/Pages.vue'));
Vue.component('category', require('./components/Category.vue'));
const app = new Vue({
    el: '#app',
    data: {
    	name_menu: '',
    	page_name: '',
    	page_position: '',
    	page_id: 0,
    	url_main: 0,
    	index_page: 0,
    	status_delete: 0,
        category_name: '',
        category_description: '',
        category_id: 0,
    },
    methods: {
    	modalPosPage: function(id,name,position,url1){
    		this.page_name = name;
    		this.page_id = id;
    		this.page_position = position;
    		this.url_main = url1;
    	},
    	modalDelPage: function(id,name,url1){
    		this.page_name = name;
    		this.page_id = id;
    		this.url_main = url1;
    	},
        modalCat: function(id,name,description, url1){
            this.category_name = name;
            this.category_id = id;
            this.category_description = description;
            this.url_main = url1;
        },

    }
});

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
$('#content-4').summernote(config);