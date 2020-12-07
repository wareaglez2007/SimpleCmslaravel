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

                        <ul class="nav nav-tabs card-header-tabs">

                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Upload Media</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('Backend.Modules.imageupload') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Select Image:</label>
                                <input type="file" class="form-control-file" name="imagefile" id="image" placeholder=""
                                    aria-describedby="fileHelpId">
                                <small id="fileHelpId" class="form-text text-muted">Help text</small>
                            </div>
                            <input name="upload_image" id="upload_image" class="btn btn-primary" type="submit"
                                value="upload">
                        </form>
                    </div>



                    @if (count($images) != 0)
                        @foreach ($images as $image)

                <img src="{{asset('storage/uqdl1QHPezc1jNSiNpF7AsXqBBEYJxgJ1llwAUNN.jpeg')}}"/>

                        @endforeach
                    @else
                    <p>No Images yet</p>
                    @endif





                </div>
            </div>
        </div>
    </div>

@endsection
