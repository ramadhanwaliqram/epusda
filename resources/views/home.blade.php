@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                
                <div class="card-body">
                    @if (session()->has('verified'))
                        <div class="alert alert-success" role="alert">
                            Your email address has been successfully verified.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
