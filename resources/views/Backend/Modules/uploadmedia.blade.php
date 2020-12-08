@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
@extends('Backend.layouts.dashboard')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" id="success_ajax" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="ajax_success">
                </div>
                <div id="ajax_errors">
                </div>


                <div class="card">
                    <div class="card-header ">

                        <ul class="nav nav-tabs card-header-tabs">

                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Upload Media</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-header" style="text-align: center">
                        <form enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="form-group">
                                <label for="image" class="custom-upload-btn" id="btnFileUpload">Add new</label>
                                <input type="file" class="form-control-file" name="image" id="image" placeholder=""
                                    aria-describedby="fileHelpId" style="display: none">
                                <small id="spnFilePath" class="form-text text-muted"></small>
                            </div>
                        </form>

                    </div>
                    <div class="card-body">

                        <div class="col-md-12">
                            <div class="row">
                                <!---IMAGE SECTION-->
                                <div class="col-md-8">
                                    <div class="row" id="images_row">
                                        @if (count($images) != 0)
                                            @foreach ($images as $image)
                                                <div class="col-lg-3">
                                                    <div class="card custom-card" id="image{{ $image->id }}">
                                                        <a href="#" class="">
                                                            <img src="{{ asset($image->path_to . $image->image_name) }}"
                                                                class="card-img-top" />

                                                            </a>
                                                                <div class="card-body">
                                                                    <p class="text-muted">{{$image->image_name}}</p>
                                                                    <a href="javascript:void(0)" onclick="DeleteImage({{$image->id}})" id="delimage">Delete</a>
                                                                </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else

                                            <p id="noimageyet">No Images yet</p>
                                        @endif
                                    </div>
                                </div>
                                <!-----Image INFORMATION SECTION-->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs">

                                                <li class="nav-item">
                                                    <a class="nav-link disabled" href="#" tabindex="-1"
                                                        aria-disabled="true">Image Information:</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>
                                <!---END OF IMAGE INFORMATION SECTION-->

                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

                            <!---IMAGE AJAX UPLOAD SECTION-->
                            <script src="{{ asset('js/ajax/uploadimage.js') }}" defer></script>
                            <!---END OF AJAX FOR UPLOAD -->

@endsection
