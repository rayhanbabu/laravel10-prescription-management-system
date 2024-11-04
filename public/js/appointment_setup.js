var loop_count=2;
function add_more() {
loop_count++;
var html = '<div class="row shadow p-2" id="inmedicine_attr_' + loop_count + '">\
         <input id="inmedicineid" name="inmedicineid[]" type="hidden">';

var medicine_html = jQuery('#medicine_id').html();   
medicine_html = medicine_html.replace("selected", "");
                 
html += '<div class="col-md-8 p-2">\
             <select class="form-control js-example-disabled-results" name="medicine_id[]" >' + medicine_html + '</select>\
         </div>';                

html += '<div class="col-md-4 p-2">\
             <input type="text" id="total_day" name="total_day[]" placeholder="Quantity" class="form-control form-control-sm" >\
         </div>';                  
                                      
var eating_time_html = jQuery('#eating_time').html();   
eating_time_html = eating_time_html.replace("selected", "");
                
  html += '<div class="col-md-6 p-2">\
             <select class="form-control" name="eating_time[]" >' + eating_time_html + '</select>\
         </div>'; 
              
    var eating_status_html = jQuery('#eating_status').html();   
     eating_status_html = eating_status_html.replace("selected", "");
                
    html += '<div class="col-md-4 p-2">\
             <select class="form-control" name="eating_status[]" >' + eating_status_html + '</select>\
         </div>';         
 
     html += '<div class="col-md-2 p-2">\
             <button type="button" onclick=remove_more("' + loop_count + '") class="btn btn-danger">\
                 <i class="fa fa-minus"></i></button>\
         </div>';   

    html += '</div>';                   
       jQuery('#inmedicine_attr_box').append(html);
       jQuery('.js-example-disabled-results').select2();
  }

     function remove_more(loop_count){
           jQuery('#inmedicine_attr_'+loop_count).remove();
      //alert(loop_count);
        }



    var moloop_count=2;
   function moadd_more() {
       moloop_count++;
     var html = '<div class="row shadow p-2" id="outmedicine_attr_' + moloop_count + '">\
                       <input id="outmedicineid" name="outmedicineid[]" type="hidden">';

    html += '<div class="col-md-8 p-2">\
         <input type="text" id="medicine_name" name="medicine_name[]" placeholder="Medicine name" class="form-control form-control-sm" >\
     </div>';    
               

   html += '<div class="col-md-4 p-2">\
             <input type="text" id="total_day" name="total_day[]" placeholder="Day" class="form-control form-control-sm" >\
         </div>';                  
                                      
 var outeating_time_html = jQuery('#outeating_time').html();   
   outeating_time_html = outeating_time_html.replace("selected", "");
                
     html += '<div class="col-md-6 p-2">\
             <select class="form-control" name="outeating_time[]" >' + outeating_time_html + '</select>\
         </div>'; 
              
   var outeating_status_html = jQuery('#outeating_status').html();   
   outeating_status_html = outeating_status_html.replace("selected", "");
                
   html += '<div class="col-md-4 p-2">\
             <select class="form-control" name="outeating_status[]" >' + outeating_status_html + '</select>\
         </div>';         
 
   html += '<div class="col-md-2 p-2">\
             <button type="button" onclick=moremove_more("' + moloop_count + '") class="btn btn-danger">\
                 <i class="fa fa-minus"></i></button>\
         </div>';   

   html += '</div>';
   jQuery('#outmedicine_attr_box').append(html);        
  }


   function moremove_more(moloop_count){
     jQuery('#outmedicine_attr_'+moloop_count).remove();
     //alert(loop_count);
    }


      var tiloop_count=2;
   function tiadd_more() {
       tiloop_count++;
    var html = '<div class="row shadow p-2" id="intest_attr_'+tiloop_count+'">\
              <input id="intestid" name="intestid[]" type="hidden">';

      var test_html = jQuery('#test_id').html();   
       test_html = test_html.replace("selected", "");
                 
         html += '<div class="col-md-9 p-2">\
             <select class="form-control js-example-disabled-results" name="test_id[]" >'+test_html+'</select>\
         </div>';                
           
         html += '<div class="col-md-3 p-2">\
             <button type="button" onclick=tiremove_more("'+tiloop_count+'") class="btn btn-danger">\
                 <i class="fa fa-minus"></i></button>\
         </div>';   

      html += '</div>';
                   
        jQuery('#intest_attr_box').append(html);
        jQuery('.js-example-disabled-results').select2();
    }

      function tiremove_more(tiloop_count){
            jQuery('#intest_attr_'+tiloop_count).remove();
            //alert(tiloop_count);
       }

  var toloop_count=2;
 function toadd_more(){
      toloop_count++;
      var html = '<div class="row shadow p-2" id="outtest_attr_'+toloop_count+'">\
                 <input id="outtestid" name="outtestid[]" type="hidden">';

      html += '<div class="col-md-9 p-2">\
              <input type="text" id="test_name" name="test_name[]" placeholder="Test name" class="form-control form-control-sm" >\
        </div>';                        
        
      html += '<div class="col-md-3 p-2">\
             <button type="button" onclick=toremove_more("'+ toloop_count + '") class="btn btn-danger">\
                 <i class="fa fa-minus"></i></button>\
         </div>';   

      html += '</div>';
                   
       jQuery('#outtest_attr_box').append(html);
       jQuery('.js-example-disabled-results').select2();
  }

     function toremove_more(toloop_count){
           jQuery('#outtest_attr_'+toloop_count).remove();
          //alert(toloop_count);
      }



   $(document).ready(function(){ 
       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

       $("#edit_appointment_setup_form").submit(function(e) {
        e.preventDefault();
         const fd = new FormData(this);
  
        
    
        
        $.ajax({
           type: 'POST',
           url: '/admin/appointment/setup/update',
           data: fd,
           cache: false,
           contentType: false,
           processData: false,
           dataType: 'json',
          beforeSend: function() {
            $('.loader').show();
            $("#edit_appointment_btn").prop('disabled', true);
          },
          success: function(response) {
            $("#edit_appointment_btn").prop('disabled', false);
            if (response.status == "success") {
                console.log(response);
                Swal.fire("Success",response.message, "success");
                 location.reload();
            } else if (response.status == 400) {
                $('.edit_error_registration').text(response.message.registration);
                $('.edit_error_phone').text(response.message.phone);
                $('.edit_error_email').text(response.message.email);
                $('.edit_error_member_name').text(response.message.member_name);
            }
  
            $('.loader').hide();
          }
  
        });
  

      });




 });