<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listing and Applicants</title>
    <style>
        /* Define your PDF styles here */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>{{$listing->title}}</h1>
<h3>Job Posted at: {{$listing->created_at->format('Y-m-d')}}</h3>
<table>
    <thead>
    <tr>
        <th>Applicant Name</th>
        <th>Email</th>
        <th>Application Date</th>
        <th>Shortlisted</th>
        <th>Coverletter</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listing->users as $applicant)
        <tr>
            <td>{{$applicant->name}}</td>
            <td>{{$applicant->email}}</td>
            <td>{{$applicant->pivot->created_at->format('Y-m-d')}}</td>
            <td>{{$applicant->pivot->is_shortlisted == '1' ? 'Yes' : 'No'}}</td>
            <td>{{$applicant->pivot->cover_letter ? 'Yes' : 'No'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
