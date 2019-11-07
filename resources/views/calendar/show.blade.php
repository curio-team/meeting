@extends('layouts.app')

@push('head')

	<link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.min.css') }}">
	<link href="{{ asset('fullcalendar/fullcalendar.print.min.css') }}" rel="stylesheet" media="print" />
	<script src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
	<script src="{{ asset('fullcalendar/lib/jquery.min.js') }}"></script>
	<script src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('fullcalendar/locale/nl.js') }}"></script>

@endpush

@section('buttons-right')
    <a class="btn btn-outline-light" href="{{ route('schoolyears.show', App\Schoolyear::current()) }}">
        <i class="fas fa-plus"></i> Toevoegen
    </a>
    <a class="btn btn-outline-light" href="{{ route('schoolyears.index') }}">
        <i class="far fa-folder"></i> Alle jaren
    </a>
    <a class="btn btn-outline-light" href="{{ route('suggestions.index') }}">
        <i class="far fa-lightbulb"></i> Suggesties
    </a>
@endsection

@section('content')

    <div id="calendar-container">
    	<div id="calendar"></div>
    </div>
    <script>
    $(document).ready(function(){
        $('#calendar').fullCalendar({
    		"events": "{{ route('calendar.json') }}",
    		"header":
    		{
    			"left": "",
                "center": "prev title next",
    			"right": "today"
    		},
    		"eventLimit": true,
    		"firstDay": 1,
            "height": "parent",
            "themeSystem": "bootstrap4",
    		"weekends": false,
    		"eventRender": 
    			function (event, element) {
            		if (event.rendering == 'background')
            		{
            			element.append("<span>" + event.title + "</span>");
            		}
            	},
        });
    });    
</script>


@endsection