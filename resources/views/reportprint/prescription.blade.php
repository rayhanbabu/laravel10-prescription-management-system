<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Test Report </title>
  <style>
    
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 20px;
      box-sizing: border-box;
      /* background-color: #f0f4f7; */
    }

    .container {
      margin: 0 auto;
      height: 850px;
      padding: 20px;
      background-color: #fff;
      /* border: 1px solid #ddd;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); */
      font-size: 12px;
    }

  

    .header h1 {
      margin: 0;
      font-size: 24px;
      text-transform: uppercase;
    }


    /* Added border below the patient and doctor info */
    .border-row {
      border-top: 1px solid #ddd;
      padding: 10px 0;
    }

    .data-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #ddd;
    }

    .content {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      margin: 0 30px;
    }

    .column {
      width: 100%;
      margin-top: 20px;
    }

    .column h3 {
      margin-bottom: 10px;
      font-size: 14px;
      font-weight: normal;
      text-transform: none;
      text-decoration: underline;
      font-family: 'Verdana', sans-serif;
      color: #555;
    }

    .column ul {
      list-style-type: none;
      padding: 0;
    }

    .column ul li {
      margin-bottom: 6px;
      font-family: 'Tahoma', sans-serif;
    }

    .rx {
      text-align: left;
    }

    .rx h3 {
      font-size: 15px;
      font-weight: bold;
      font-family: 'Arial', sans-serif;
    }

    .rx table {
      width: 100%;
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    .rx th, .rx td {
      padding: 8px;
      font-family: 'Verdana', sans-serif;
    }

    .rx tr {
      border-top: 1px dotted #000;
    }

    .rx th {
      text-align: left;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 12px;
      color: #666;
      font-family: 'Verdana', sans-serif;
    }

   
  
    .column {
      margin-top: 0px;
    }

    /* New spacing around left and right column */
   

 
    .header_table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Centers the table */
            border: 1px solid gray;
        }
        .header_table th {
            border: 1px solid gray;
            padding: 5px;
            text-align: left;
        }
        .header_table th {
            background-color: #f2f2f2;
        }

        .header_table td {
            padding: 5px;
            text-align: left;
        }

    
   	

     .signature_left {
       position: absolute;
       left:455px;
       top:790px;
       z-index: -1;
     }	


     .rayhan_footer {
       position: absolute;
       left:50px;
       top:840px;
       z-index: -1;
       opacity:1;
     }	
     
     
     .visit_day {
       position: absolute;
       left:280px;
       top:838px;
       z-index: -1;
       opacity:1;
     }	   

  </style>
</head>
<body>



  <div class="container">

       <div class="rayhan_header">
          <img src="{{ public_path('/uploads/admin/'.$data->header)}}" style="width:600px"/>
       </div>

       <div class="rayhan_footer">
          <img src="{{ public_path('/uploads/admin/'.$data->footer)}}" style="width:600px"/>
       </div>

       <div class="visit_day">
             <b> {{ $data->visit_day }}  </b>
       </div>


    <table class="header_table">
       <thead>
         <tr>
            <th colspan="3"> Patient Information </th>
           
          </tr>
       </thead>
    <tbody>

          <tr>
              <td style="width: 60%;"> Appointment Id: <b>  {{ $data->id }} </b> </td>
              <td colspan="2"> Date :<b> {{ $data->date }}  </b> </td>
          </tr>

           <tr>
             <td style="width: 60%;"> Name: <b>  {{$data->member_name}}  </b> </td>
             <td style="width: 20%;"> Sex : <b> {{ $data->gender }}  </b> </td>
             <td style="width: 20%;"> Age : <b> {{ $data->age }} Year </b>  </td>
          </tr>

          
    </tbody>
</table>
       
   
    <div class="content">
        <div class="column rx">
                   <h3>Rx</h3>
           <table>   
            <tr>
                 <td style="width: 5%;"> <b> SL  </b> </td>
                 <td style="width: 45%;"> <b> Medicine Name  </b> </td>
                 <td style="width: 10%;"> <b> Dosage  </b> </td>
                 <td style="width: 20%;"> <b>  Timing   </b> </td>
                 <td style="width: 20%;"> <b>  Duration   </b> </td>
              
            </tr>

            @php
                $counter = 1;
            @endphp

          @foreach($medicine_provide as $row)   
            <tr>
                 <td> {{ $counter++ }} </td>
                 <td> <b> {{ $row->medicine_name }} </b> <br> {{ $row->generic_name }} </td>
                 <td>  {{ $row->eating_time }}  </td>
                 <td> {{ $row->eating_status }} </td>
                 <td> {{ $row->total_day }} Day </td>
            </tr>
           @endforeach


           @foreach($medicine_out as $row)   
            <tr>
                 <td> {{ $counter++ }} </td>
                 <td> <b> {{ $row->medicine_name }} </b>  </td>
                 <td>  {{ $row->eating_time }}  </td>
                 <td> {{ $row->eating_status }} </td>
                 <td> {{ $row->total_day }} Day </td>
            </tr>
           @endforeach

         
        </table>
      </div>
    </div>


    <br><br>
    <div class="content">
        <div class="column rx">
           <table>   
             <tr>
                 <td style="width: 20%;"> <b> Investigations </b> </td>
                 <td style="width: 80%;"> 
                 @foreach($testprovide as $invest)
                 <li>{{$invest->test_name}} </li>
                   @endforeach
                    
                 </td>  
              
            </tr>

          

            <tr>
                  <td > <b> Advice </b> </td>
                  <td  colspan="3"> {{ $data->advice }}  </td>
            </tr>

           
          


          
         
        </table>
      </div>
    </div>





    <div class="signature_left">
        <p><strong> {{$data->admin_name}} </strong></p>
     
    </div>

   
  </div>

  
  
  

</body>
</html>
