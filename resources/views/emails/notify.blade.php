<x-mail::message>
# Introduction

Congratulations! You are now a paid member.
<p>Your purchase details:</p>
<p>Plan: {{$plan}}</p>
<p>Your new plan ends on: {{$billing}}</p>
<x-mail::button :url="''">
    Post a Job
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
