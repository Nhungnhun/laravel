@extends('admin.layout.master')

@section('title', 'List borrow book')

@section('content')
        <div class="pagetitle">
            <h1>Borrow</h1>
            <nav>
                <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Home</a>
                        </li>
                    <li class="breadcrumb-item active">Borrow</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center align-items-center">
                    <form class="row g-12 d-flex justify-content-center" action="{{ route('borrowlist.search') }}" method="get">
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
            @if (session()->has('msg'))
                        <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

            @if (session()->has('error'))
                <div id="flash-message" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <br>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <table width=100% class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">No</th>
                                    <th width="5%" scope="col">Code</th>
                                    <th width="15%" scope="col" class="text-start">Name</th>
                                    <th width="10%" scope="col" class="text-start">Image</th>
                                    <th width="15%" scope="col" class="text-start">Borrow Name</th>
                                    <th width="10%" scope="col" class="text-start">Date</th>
                                    <th width="10%" scope="col" class="text-start">Status</th>
                                    <th width="30%" scope="col">Action</th>

                                </tr>
                            </thead>
                            @foreach ($borrows as $index => $borrow)
                            <tr>
                                <td>{{ $startIndex + $index + 1 }}</td>
                                <td style="font-weight: bold;">{{$borrow->code}}</td>
                                <td>{{$borrow->book->name}}</td>
                                <td class="text-start">
                                    <img src="{{ asset('storage/admin/books/'.$borrow->book->image) }}" alt="Book Image" style="width: 100px;">
                                </td>
                                <td>{{$borrow->user->name}}</td>
                                <td class="text-start">{{ \Carbon\Carbon::parse($borrow->date)->format('m/d/Y') }}</td>
                                <td>
                                    <?php if ($borrow->status === 'Đã duyệt'): ?>
                                    <a style="color: green; font-weight: bold;">Đã duyệt</a>
                                    <?php elseif ($borrow->status === 'Đang mượn'): ?>
                                        <span style="color: blue;">Đang mượn</span>
                                    <?php else: ?>
                                        <span style="color: red;">Chưa duyệt</span>
                                    <?php endif; ?>
                                </td>
                                  
                                <td scope="col">
                                    <a title="Detail" href="{{ route('borrow.detail', ['id' => $borrow->id]) }}" type="button" class="btn btn-primary">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </a>


                                    <a title="Edit" href="{{ route('borrow.edit', ['id' => $borrow->id]) }}" type="button" class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                        
                                    @if ($borrow->status === 'Chưa duyệt')
                                        <button id="successButton" class="btn btn-success borrow-btn" data-id="{{ $borrow->id }}">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        
                                        <div id="confirmationBorrowModal{{ $borrow->id }}" class="modal">
                                            <div class="modal-content">
                                                <h3>Có muốn duyệt mượn sách không?</h3>
                                                <form action="{{ route('borrow', ['id' => $borrow->id]) }}" method="GET">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100 btn-block">Có</button>
                                                </form>
                                                <button id="cancelBorrowButton" class="btn btn-secondary w-100 btn-block cancel-borrow-btn" data-id="{{$borrow->id}}">Không</button>
                                            </div>
                                        </div>
                                    @else
                                        
                                    @endif

                                    @if ($borrow->status === 'Đang mượn')
                                        <button id="successButton" class="btn btn-secondary give-btn" data-id="{{ $borrow->id }}" onclick="giveModal('{{ $borrow->id }}', '{{ $borrow->user->name }}', '{{ $borrow->code }}', '{{ $borrow->book->name }}', '{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('m/d/Y') }}', '{{ \Carbon\Carbon::parse($date)->format('m/d/Y') }}', '{{ route('givebook', ['bookId' => $borrow->id]) }}')">
                                            <i class="bi bi-box-arrow-right"></i>
                                        </button>    
                                        @else
                                    @endif

                                    @if ($borrow->status === 'Đã duyệt')
                                        <!-- Button element -->
                                        <button id="successButton" class="btn btn-info approved-btn" data-id="{{ $borrow->id }}" onclick="continueModal('{{ $borrow->id }}', '{{ $borrow->user->name }}', '{{ $borrow->code }}', '{{ $borrow->book->name }}', '{{ route('borrowsucess', ['bookId' => $borrow->id]) }}')">
                                            <i class="bi bi-book"></i>
                                        </button>
                                        @else
                                    @endif

                                    <button title="Delete" class="btn btn-danger delete-btn" data-id="{{ $borrow->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    
                                    <div id="confirmationDeleteModal{{ $borrow->id }}" class="modal">
                                        <div class="modal-content">
                                            <h3>Có muốn xóa yêu cầu này không?</h3>
                                            <form action="{{ route('delete', ['id' => $borrow->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary w-100 btn-block">Có</button>
                                            </form>
                                            <button id="cancelDeleteButton" class="btn btn-secondary w-100 cancel-delete-btn" data-id="{{$borrow->id}}">Không</button>
                                        </div>
                                    </div>                 
                                    <div id="modal"></div>
                                </td>
                            </tr>
                        @endforeach
                        
                               
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                {{ $borrows->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/base.js') }}"></script>
    <script src="{{ asset('assets/admin/borrow/borrow.js') }}"></script>
@endpush