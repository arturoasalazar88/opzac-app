(function($){
  $(function(){

    $('.modalCheck').modal();



    $('.sidenav').sidenav();
    //$(".dropdown-trigger").dropdown();
    $(".dropdown-trigger").dropdown({
      coverTrigger: false,
    });

    $(document).ready(function(){
        $('.collapsible').collapsible();
    });

    //initialize all the selects views
    //unless the screen size is to little
    if ( $( window ).width() > 600) {
        $('.input-field select').formSelect();
    }else{
        $('select').addClass('browser-default');
    }

    //$('select').formSelect();

    //timepicker
    $('.timepicker').timepicker({
      defaultTime: '14:00',
      twelveHour: false
    });

    //Date timepicker
    $('.exclude-dates').datepicker({
      format: 'yyyy-mm-dd',
      defaultDate: new Date(),
      setDefaultDate: true,
      minDate: new Date(),
      i18n: {
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
            }
    });

    $('.full-dates').datepicker({
        format: 'yyyy-mm-dd',
        defaultDate: new Date(),
        setDefaultDate: true,
        i18n: {
                  months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                  monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                  weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                  weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                  weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
              }
    });

  }); // end of document ready
})(jQuery); // end of jQuery name space
