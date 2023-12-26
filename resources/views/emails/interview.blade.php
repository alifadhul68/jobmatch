<x-mail::message>
Congratulations, {{ $user->name }}!

Your interview for the position of '{{ $listing->title }}' has been scheduled. Please prepare yourself for the upcoming interview.

<strong>Interview Details:</strong>
<ul>
    <li>Job Title: {{ $listing->title }}</li>
    <li>Interview Time: {{ $interview->interview_date }}</li>
    <li>Interview Location: {{ $interview->location}}</li>
    @if (!empty($interview->notes))
        <li>Interview Notes: {{ $interview->notes }}</li>
    @endif
</ul>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
