$(document).ready(function(){ 

       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
       fetchAll();

      function fetchAll() {
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('.data-table')) {
            $('.data-table').DataTable().destroy();
        }

        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/admin/appointment",
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                { data: 'member_name', name: 'member_name' },
                { data: 'phone', name: 'phone' },  
                { data: 'age', name: 'age' },  
                { data: 'chamber_name', name: 'chamber_name' },  
                { data: 'payment_amount', name: 'payment_amount' },  
                { data: 'disease_problem', name: 'disease_problem' },   
                { data: 'status', name: 'status' },
                { data: 'prescription', name: 'prescription', orderable: false, searchable: false },
                { data: 'setup', name: 'setup', orderable: false, searchable: false },
                { data: 'edit', name: 'edit', orderable: false, searchable: false },
                { data: 'delete', name: 'delete', orderable: false, searchable: false },
               
            ]
        });
    }
        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $.ajax({
              type:'POST',
              url:"/admin/appointment/insert",
              data: fd,
              cache: false,
              contentType: false,
              processData: false,
              dataType: 'json',
              beforeSend : function()
                   {
                   $('.loader').show();
                   $("#add_employee_btn").prop('disabled', true);
                   },
              success: function(response){
                $('.loader').hide();
                $("#add_employee_btn").prop('disabled', false);
                if(response.status==200){
                   $("#add_employee_form")[0].reset();
                   $("#addEmployeeModal").modal('hide');
                   $('#success_message').html("");
                   $('#success_message').addClass('alert alert-success');
                   $('#success_message').text(response.message);
                   $('.error_registration').text('');
                   $('.error_phone').text('');
                   $('.error_email').text('');
                   $('.error_member_name').text('');
                   fetchAll();
                  }else if(response.status == 400){
                    $('.error_registration').text(response.message.registration);
                    $('.error_phone').text(response.message.phone);
                    $('.error_email').text(response.message.email);
                    $('.error_member_name').text(response.message.member_name);
                  }
                
              }
            });
      
          });


        $(document).on('click', '.edit', function(e) {
            e.preventDefault();
            var view_id = $(this).data('id'); 
            $('#EditModal').modal('show');
               // console.log(view_id);         
            $.ajax({
              type: 'GET',
              url: '/admin/appointment_view/' + view_id,
              success: function(response) {
                //console.log(response);
                if (response.status == 404) {
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                } else {
                    $('#edit_id').val(response.value.id);
                    $('#edit_member_id').val(response.value.member_id);
                    $('#edit_chamber_id').val(response.value.chamber_id);
                    $('#edit_disease_problem').val(response.value.disease_problem);
                    $('#edit_payment_amount').val(response.value.payment_amount);

                }
              }
            });


          });

   
      // update employee ajax request
    $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
  
        const fd = new FormData(this);
  
        $.ajax({
          type: 'POST',
          url: '/admin/appointment/update',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
            $('.loader').show();
            $("#edit_employee_btn").prop('disabled', true);
          },
          success: function(response) {
            $("#edit_employee_btn").prop('disabled', false);
            if (response.status == 200) {
                $('#success_message').html("");
                $("#EditModal").modal('hide');
                $("#edit_employee_form")[0].reset();
                fetchAll();
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
  
      
           // delete employee ajax request
           $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); 
            Swal.fire({
              title: 'Are you sure?',
              text: "You want to delete this item!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url:'/admin/appointmnet/delete',
                  method:'delete',
                  data: {
                    id: id,
                  },
                   success: function(response) {
                      //console.log(response);
                     if(response.status == 400){
                        Swal.fire("Warning",response.message, "warning");
                     }else if(response.status == 200)
                        Swal.fire("Deleted",response.message, "success");
                       fetchAll();
                  }
                });
              }
            })
          });

});