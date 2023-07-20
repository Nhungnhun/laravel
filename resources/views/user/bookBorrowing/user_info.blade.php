@extends('layouts.master')

@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">User Info</h5>
                                <p class="text-center small">Enter your personal details to borrow book</p>
                            </div>

                            @if (session('success'))
                                <div id="flash-message" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form class="row g-3" novalidate action="{{ route('borrow.info') }}" method="POST">
                                @csrf
                                <input type="hidden" name="bookId" value="{{ $bookId }}">
                                <div class="col-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">

                                    @error('name')
                                        <span class="text-error-notify" style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">

                                    @error('email')
                                        <span class="text-error-notify" style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="code" class="form-label">Citizen Identity Card</label>
                                    <input type="text" name="code" class="form-control" id="code">

                                    @error('code')
                                        <span class="text-error-notify" style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="returnDate" class="form-label">Expected return date</label>
                                    <input type="date" name="returnDate" class="form-control" id="returnDate">

                                    @error('returnDate')
                                        <span class="text-error-notify" style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Register</button>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary w-100" onclick="window.location.href = '{{ route('borrow.search') }}'">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="{{ asset('assets/user/js/base.js') }}"></script>
@endpush