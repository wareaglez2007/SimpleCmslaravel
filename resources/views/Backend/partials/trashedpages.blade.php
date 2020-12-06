<div class="tab-pane" id="trashed" role="tabpanel" aria-labelledby="trashed-tab">
    <!--This is the main pages view which will have a table that will show Trashed pages.-->
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Create At</th>
                <th scope="col">Deleted At</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($trashed != 0)


                @foreach ($deleted_pages as $k => $page)
                    <tr id="tid{{ $page->id }}">
                        <th>{{ $page->id }}</th>
                        <td>{{ $page->title }}</td>
                        <td>{{ date_format($page->created_at, 'n/j/Y') }}</td>
                        <td>{{ date_format($page->deleted_at, 'n/j/Y') }}</td>
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
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <!--Restore action-->
                                    <a href="javascript:void(0)"
                                        onclick="RestorePage({{ $page->id }})"
                                        class="dropdown-item">Restore</a>
                                    <!--Perm DELETE action-->
                                    <a href="javascript:void(0)"
                                        onclick="PermDeletePage({{ $page->id }}, {{ $page->page_parent_id }})"
                                        class="dropdown-item">Permanent Delete</a>
                                </div>

                            </div>

                        </td>
                    </tr>

                @endforeach
            @else
            <tr id="notrashpages">
                <th class="text-muted">There is no item here yer.</th>
            </tr>
            @endif
        </tbody>

    </table>
</div>
</div>
