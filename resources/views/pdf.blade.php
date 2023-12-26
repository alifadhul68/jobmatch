<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .job-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 20px;
            color: #333;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .section-content {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="job-title">{{ $listing->title }}</h1>
        <p class="company-name">{{ $listing->profile->name }}</p>
    </div>

    <div>
        <h2 class="section-title">Job Description</h2>
        <p class="section-content">{{ $listing->description }}</p>
    </div>

    <div>
        <h2 class="section-title">Roles and Responsibilities</h2>
        <p class="section-content">{{ $listing->roles }}</p>
    </div>

    <div>
        <h2 class="section-title">Compensation</h2>
        <p class="section-content">${{ number_format($listing->salary, 2) }}</p>
    </div>

    <div>
        <h2 class="section-title">Job Type</h2>
        <p class="section-content">
            @if ($listing->job_type == 'fulltime')
                Full Time
            @elseif ($listing->job_type == 'remote')
                Remote
            @elseif ($listing->job_type == 'parttime')
                Part Time
            @endif
        </p>
    </div>

    <div>
        <h2 class="section-title">Application Due Date</h2>
        <p class="section-content">{{ $listing->application_close_date }}</p>
    </div>

    <div class="footer">
        <p>For more inquiries, please contact us at: {{ $listing->profile->email }}</p>
    </div>
</div>
</body>
</html>
