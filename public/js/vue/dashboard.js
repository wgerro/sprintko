
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector("meta[name=csrf-token]").getAttribute('content');
// define
$('.alert').addClass('do_ukrycia');
$('.tabela').addClass('pokaz_tabele');
var ctx = document.getElementById("myChart");
var ctx2 = document.getElementById("myChart2");

	new Vue({
	  	el: '#app',
	  	data: {
		    visits: [],
		    getmonth: [],
		    getLabelsMonth: [],
		    getDataMonth: [],
		    getyear: [],
		    getLabelsYear: [],
		    getDataYear: [],
		    countDay: 0,
			countMonth: 0,
			countYear: 0,
	  	},
	  	methods: {
	  		getVisits: function(){

                this.$http.get('admin/json').then(function (response) {
            			this.getmonth = response.body.month;
            			this.getyear = response.body.year;
            			this.countDay = response.body.countDay;
	  					this.countMonth = response.body.countMonth;
	  					this.countYear = response.body.countYear;
            			this.getMonth();
            			this.getYears();
				  }, function (response) {
				    
				});
                $('#ukryj').hide();
            },
            setMonthChart: function(){
            	myChart = new Chart(ctx, {
				    type: 'bar',
				    data: {
				        labels: this.getLabelsMonth,
				        datasets: [{
				            label: 'count',
				            data: this.getDataMonth,
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				            ],
				            borderColor: [
				                'rgba(255,99,132,1)',
				                'rgba(54, 162, 235, 1)',
				                'rgba(255, 206, 86, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(153, 102, 255, 1)',
				                'rgba(255, 159, 64, 1)',
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				        scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});
            },
            getMonth: function(){
            	visits = this.getmonth;
            	console.log(visits);
            	for(i=0; i<visits.length; i++)
            	{
            		this.getLabelsMonth.push(visits[i].year_month);
            		this.getDataMonth.push(visits[i].numbers);
            	}
            	this.setMonthChart();
	  		},
	  		setYearChart: function(){
	  			myChart2 = new Chart(ctx2, {
				    type: 'bar',
				    data: {
				        labels: this.getLabelsYear,
				        datasets: [{
				            label: 'count',
				            data: this.getDataYear,
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				            ],
				            borderColor: [
				                'rgba(255,99,132,1)',
				                'rgba(54, 162, 235, 1)',
				                'rgba(255, 206, 86, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(153, 102, 255, 1)',
				                'rgba(255, 159, 64, 1)',
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)',
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				        scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});
	  		},
	  		getYears: function(){
	  			visits = this.getyear;
            	for(i=0; i<visits.length; i++)
            	{
            		this.getLabelsYear.push(visits[i].year);
            		this.getDataYear.push(visits[i].numbers);
            	}
            	this.setYearChart();
	  		}
            
	  	},

		ready: function(){
			this.getVisits();
		}
	});






