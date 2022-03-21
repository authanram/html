@props(['text', 'data' => []])

<span>{{ $text }}: {{ $slot }} -- {{ $data['foo'] }}</span>
