<div class="tab-pane active" id="published" role="tabpanel">
    <!--This is the main pages view which will have a table that will show available pages.-->
    <table class="table table-hover" id="publishedpages">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Create At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Actions</th>
            </tr>

        </thead>
        <tbody>



            @if ($publishcount != 0)

                @foreach ($pageslist as $k => $page)
                    <tr id="activeid{{ $page->id }}">
                        <th scope="row"><a href="{{ route('Backend.Pages.edit', $page->id) }}"
                                class="text-muted">{{ $page->id }}</a></th>
                        <td><a href="{{ route('Backend.Pages.edit', $page->id) }}"
                                class="text-muted">{{ $page->title }}</a></td>
                        <td><a href="{{ route('Backend.Pages.edit', $page->id) }}"
                                class="text-muted">{{ date_format($page->created_at, 'n/j/Y') }}</a>
                        </td>
                        <td><a href="{{ route('Backend.Pages.edit', $page->id) }}"
                                class="text-muted">{{ date_format($page->updated_at, 'n/j/Y') }}</a>
                        </td>
                        <td style="text-align: center">
                            <div class="dropdown show">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                        class="bi bi-toggle-off" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M11 4a4 4 0 0 1 0 8H8a4.992 4.992 0 0 0 2-4 4.992 4.992 0 0 0-2-4h3zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zM0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5z" />
                                    </svg>
                                </a>
                                <!--Edit action-->
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <!--Published page actions-->
                                    <!--Edit action -->
                                    <a href="javascript:void(0)"
                                        onclick="EditActivePage({{ $page->id }})"
                                        class="dropdown-item">Edit</a>
                                    <!--Delete action-->
                                    <a href="javascript:void(0)"
                                        onclick="DeleteActivePage({{ $page->id }},{{ $page->parent_page_id }})"
                                        class="dropdown-item">Delete</a>
                                    <!--Unbublish action-->
                                    <a href="javascript:void(0)"
                                        onclick="UnPublishPage({{ $page->id }})"
                                        class="dropdown-item">Unpublish</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <th><a href="{{ route('Backend.Pages.create') }}" class="text-muted"
                            id="nopublishedpages">There is no
                            item here yer.</a></th>
                </tr>

            @endif
        </tbody>
    </table>


</div>
