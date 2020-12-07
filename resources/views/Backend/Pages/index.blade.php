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

                                <a class="nav-link text-muted active" href="#published" role="tab" aria-controls="published"
                                    aria-selected="true" id="pubcount"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                      </svg> Published
                                      ({{ $publishcount }}) </a>


                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#draft" role="tab" aria-controls="draft" aria-selected="false"
                                    id="draftcount"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                        <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z"/>
                                        <path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
                                      </svg> Draft
                                    ({{ $draftcount }})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#trashed" role="tab" aria-controls="trashed" aria-selected="false"
                                    id="trashcount"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                      </svg> Trashed
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
