    /*
    * create: Krystian OziembaĹa 
    * url: www.krystianoziembala.pl
    */
    /* wiekszy niz tel */

                /* slider lewy sidebar */
                $(function(){
                    $('#header-ko-icon').on('click', function(){

                        $('#left-ko').toggle('slide', { direction: 'left' }, 500);
                        $('#content-ko').animate({
                            'margin-left' : $('#content-ko').css('margin-left') == '0px' ? '230px' : '0px'
                        },500);
                    });
                });

                $('.lista_li_open1').hide();
                $('.lista_li_open2').hide();
                i = 0;
                a = 0;
                $('.ko-dropdown1').click(function(e) {
                    e.preventDefault();
                    i=i+1;
                    $('.lista_li_open1').toggle('blind');
                    if(i%2)
                    {
                        $('.ko-iko1').addClass('fa-angle-down');
                    }else{
                        $('.ko-iko1').removeClass('fa-angle-down');
                    }
                });

                 $('.ko-dropdown2').click(function(e) {
                    e.preventDefault();
                    a=a+1;
                    $('.lista_li_open2').toggle('blind');
                    if(a%2)
                    {
                        $('.ko-iko2').addClass('fa-angle-down');
                    }else{
                        $('.ko-iko2').removeClass('fa-angle-down');
                    }
                });