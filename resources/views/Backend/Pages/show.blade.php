@extends('Backend.layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        This is the main pages view which will have a table that will show available pages.
                        @foreach ($pages as $page)

                            {!! html_entity_decode($page->description) !!}

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
