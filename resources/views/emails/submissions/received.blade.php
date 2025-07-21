{{-- resources/views/emails/submissions/received.blade.php --}}

<x-mail::message>
# Submission Received!

Dear {{ $artistName }},

Thank you for submitting your song "**{{ $songTitle }}**" to Artistt!

We've successfully received your submission and it is now in our review queue. We typically review submissions within 5-7 business days. We will notify you via email once there is an update on its status.

In the meantime, feel free to explore our approved tracks on the platform:
<x-mail::button :url="route('public.songs.index')">
Explore Approved Songs
</x-mail::button>

Thanks,<br>
The Artistt Team
</x-mail::message>