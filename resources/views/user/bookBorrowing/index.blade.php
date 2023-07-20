@extends('user.layout.guest')

@section('content')
       
    <div class="text-center">
        <h1 class="mt-4">Book Borrowing</h1>
        <br><br>
        <h6>Type book title or book code to search</h6>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center align-items-center">
                <form class="row g-12 d-flex justify-content-center" action="{{ route('borrow.search') }}" method="get">
                    <div class="col-md-15 d-flex justify-content-end">
                        <div class="me-2">
                            <input type="text" name="search" placeholder="Search" title="Type search keyword" class="form-control" value="{{ !empty($search) ? $search : '' }}">
                        </div>
                        <div class="btn-two-button d-flex">
                            <button id="btn-save" title="Click search keyword" type="submit" class="btn btn-primary me-1">
                                <i class="bi bi-search"></i>
                            </button>
                            <button id="btn-loading" class="btn btn-primary" type="submit" disabled style="margin-right:4px; display:none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-15">
                <div class="mt-4 mb-4">
                    @if (session()->has('msg'))
                        <div id="flash-message" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <div>
                                {{ session('msg') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
            
                    @if (session()->has('error'))
                        <div id="flash-message" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <div>
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>        
        
        <br>
        <div class="col-lg-12">
            @if ($isSearchSubmitted)
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <table width="100%" class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="6%" scope="col">No</th>
                                    <th width="17%" scope="col" class="text-start">Name</th>
                                    <th width="22%" scope="col" class="text-start">Code book</th>
                                    <th width="20%" scope="col" class="text-start">Description</th>
                                    <th width="20%" scope="col" class="text-start">Image</th>
                                    <th width="15%" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $index => $items)
                                    <tr>
                                        <th scope="row">{{ $startIndex + $index + 1 }}</th>
                                        <td class="text-start">{{ $items->name }}</td>
                                        <td class="text-start">{{ $items->code }}</td>
                                        <td class="text-start">{{ $items->description }}</td>
                                        <td class="text-start">
                                            <img src="{{ asset('storage/admin/books/' . $items->image) }}" alt="Book Image" style="width: 100px;">
                                        </td>
                                        <td scope="col">
                                            <button type="button" class="btn btn-primary" onclick="continueModal('{{ $items->id }}', '{{ $items->name }}', '{{ $items->code }}', '{{ $items->description }}', '{{ route('borrow.book', ['bookId' => $items->id]) }}');">Borrow</button>
                                            <div id="modal"></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                {{ $books->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        </div>        
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/user/js/base.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
