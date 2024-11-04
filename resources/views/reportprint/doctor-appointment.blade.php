<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biochemical Blood Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .header {
            text-align: center;
        }

        .header h5,h3 {
            margin: 0;
        }

        .header p {
            margin: 0;
            font-size: 12px; }

        .report-title {
            text-align: center;
            margin: 10px 0;
        }

        .patient-info {
            width: 100%;
            border-radius: 20%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .patient-info td {
            padding: 5px;
            
        }

        .results {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        

       .results table, th, td {
            border: 0.5px solid gray;
            border-collapse: collapse; /* Ensures borders don't double up */
        }

        .results td {
            padding: 5px;
        }

        .footer {
            margin-top: 40px;
        }

        .footer .signature {
            margin-top: 60px;
        }

        .footer .signature div {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">

          <h3> Shahid Buddhijibi Dr. Muhammad Mortaza Medical Center </h3>
          <p> University of Dhaka, Dhaka-1000, Bangladesh. Phone: 9661900, Ex-4236 </p>

          <br>
          <h5 class="report-title"> Doctor Name : {{$appointment[0]?$appointment[0]['name']:""}} </h5>
          <p> Appointment Date : {{$data['date1']}} to {{$data['date2']}} </p>

        </div>

      <br>
    <table class="results">
        <thead>
            <tr>
                 <th> Appointment Id</th>
                 <th> Date</th>
                 <th> Patient Name</th>
                 <th> Reg/Employee Id</th>
                
            </tr>
        </thead>
        <tbody>
        @foreach($appointment as $row)
            <tr>
                 <td>{{$row->id}}</td>
                 <td>{{$row->date}} </td>
                 <td>{{$row->member_name}} </td>
                 <td>{{$row->registration}} </td>
            </tr>
         @endforeach
        </tbody>
    </table>

    
</body>

</html>
