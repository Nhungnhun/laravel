@extends('admin.layout.master')

@section('title', 'Detail borrow book')

@section('content')
    <style>

        .ck-editor__editable {
                height: 300px;
            }
    </style>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <form class="row g-3" id="form-category" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">No</label>
                                <input type="text" class="form-control input-field" name="no" id="no" value="{{ $borrows->id }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">CodeBook</label>
                                <input type="text" class="form-control input-field" name="code" id="code" value="{{ $borrows->book->code }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">BookName</label>
                                <input type="text" class="form-control input-field" name="bookname" id="bookname" value="{{ $borrows->book->name }}" readonly>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="image" class="form-label">Image <span class="text-error-notify">(*)</span></label>
                                <br>
                                <img width="200px" style="display:block" id="preview-image" src="{{ asset('storage/admin/books/' .  $borrows->book->image) }}" alt="preview-image">
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">BorrowName</label>
                                <input type="text" class="form-control input-field" name="borrowname" id="borrowname" value="{{ $borrows->user->name }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Email</label>
                                <input type="text" class="form-control input-field" name="email" id="email" value="{{ $borrows->user->email }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="inputDate" class="form-label">Imported day<span class="text-danger">&nbsp;(*)</span></label>
                                <input type="text" class="form-control" name="imported_at" value="{{ \Carbon\Carbon::parse($borrows->imported_at)->format('m/d/Y') }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Status</label>
                                <input type="text" class="form-control input-field" name="status" id="status" value="{{ $borrows->status }}" readonly
                                  style="color: {{ $borrows->status === 'Đã duyệt' ? 'green' : 'red' }};">
                            </div>
                            
                            <div class="col-md-12">
                                <div>
                                    </button>
                                        <a href="{{ route('borrow.list') }}" type="reset" class="btn btn-success">Xong</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/base.js') }}"></script>
@endpush
