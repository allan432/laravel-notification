@extends('users.admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Admin Notification') }}
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#notificationModal">Create Notification</button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('admin.notifications.store') }}">
          @csrf
          <div class="form-group">
            <label for="message">Enter message</label>
            <input type="text" class="form-control" id="message" name="message" aria-describedby="message" placeholder="Enter message">

            @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary btn-sm">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
