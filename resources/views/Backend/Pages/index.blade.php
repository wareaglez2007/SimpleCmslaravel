@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('Backend.layouts.dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif


                <div class="card">
                    <div class="card-header ">

                        <ul class="nav nav-tabs card-header-tabs" id="backend-pages" role="tablist">
                            <li class="nav-item">

                                <a class="nav-link active" href="#published" role="tab" aria-controls="published"
                                    aria-selected="true" id="pubcount">Published <span
                                        class="text-muted">({{ $publishcount }}) </a>


                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#draft" role="tab" aria-controls="draft" aria-selected="false"
                                    id="draftcount">Draft
                                    ({{ $draftcount }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false"
                                    id="trashcount">Trashed
                                    ({{ $trashed }})</a>
                            </li>
                            <li class="nav-item" >
                                <form action="{{ route('Backend.Pages.create') }}">
                                    <button class="btn btn-success" style="height: 35px; line-height: 33px; padding: 0 25px; background: #1d9f3c; border-radius: 2px; margin-left:25px;">Add new</button>
                                </form>

                            </li>
                        </ul>

                    </div>


                    <div class="card-body">
                        <div class="tab-content mt-3">
                            <!----Tabs--->
                            <!---Published pages--->
                            @include('Backend.partials.publishedpage')
                            <!---tab1 ends-->

                            <!---Draft page section-->
                            @include('Backend.partials.draftpages')
                            <!--tab2 ends-->
                            <!---TRASHED-->
                            @include('backend.partials.trashedpages')
                            <!--tab3 ends-->
                        </div>
                        <script>
                            $('#backend-pages a').on('click', function(e) {
                                e.preventDefault()
                                $(this).tab('show')
                            })

                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!---Call AJAX FUNCTIONS HERE-->
        <script src="{{ asset('js/ajax/ajaxcalls.js') }}" defer></script>
    @endsection
