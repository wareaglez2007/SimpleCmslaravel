@include('Backend.partials.ckeditor')
@extends('Backend.layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create new page!') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="alert alert-success" style="display:none"></div>
                        This will be the sction to add new pages.
                        <div class="container">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <!---------------CREATE PAGE FORM BEGINS----------------------->

                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="">Page Tile</label>
                                    <input type="text" name="title" id="page_title" class="form-control"
                                        placeholder="Page Tile" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">This will be the name of your from i.e Home,
                                        About, etc.</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Subtitle</label>
                                    <input type="text" name="subtitle" id="page_subtitle" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="">Page Parent</label>
                                    <select class="form-control" name="page_parent" id="page_parent">
                                        <option value="0">None</option>
                                        @foreach ($pageslist as $page)
                                            <option value="{{ $page->id }}">{{ $page->title }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" id="page_slug" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted">This will be used for the link in the front end.
                                        i.e. www.donain.com/about-us</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Page Owner</label>
                                    <input type="text" name="owner" id="page_owner" class="form-control"
                                        placeholder="Page Subtitle" aria-describedby="helpId">
                                </div>
                                <div class="form-group">
                                    <label for="">Page Content</label>
                                    <textarea name="description" id="editor" cols="30" rows="10"
                                        class="description_editor"></textarea>
                                    <script>

                                        CKEDITOR.replace('editor');

                                    </script>

                                </div>

                                <button type="submit" class="btn btn-primary" id="ajaxSubmit">Submit</button>
                                <a href="{{ route('Backend.Pages.index') }}" class="btn btn-dark">See all pages</a>
                            </form>

                        </div>
                        <script src="http://code.jquery.com/jquery-3.3.1.min.js"
                            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
                        </script>
                        <script>
                            var data = CKEDITOR.instances.editor.getData();

                            jQuery(document).ready(function() {
                                jQuery('#ajaxSubmit').click(function(e) {
                                    e.preventDefault();
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    });
                                    jQuery.ajax({
                                        url: "{{ url('/admin/pages') }}",
                                        method: 'post',
                                        data: {
                                            title: jQuery('#page_title').val(),
                                            subtitle: jQuery('#page_subtitle').val(),
                                            description: CKEDITOR.instances.editor.getData(),
                                            parent_page_id:jQuery('select#page_parent').val(),
                                            owner: jQuery('#page_owner').val(),

                                        },

                                        success: function(result) {
                                            jQuery('.alert').show();
                                            jQuery('.alert').html(result.success)
                                            console.log(data);
                                        }
                                    });
                                });
                            });

                        </script>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
