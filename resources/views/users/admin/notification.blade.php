@extends('users.admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group">
              <div class="card">
                  <div class="card-header">
                      {{ __('Admin Notification') }}
                      <div class="float-right">
                          <button type="button" class="btn btn-outline-danger btn-sm" id="btn-form">Create Notification</button>
                      </div>
                  </div>  
              </div>
            </div>

            <div id="notification-admin">
              @php
                $last_id = "";
              @endphp
              @forelse($notifications as $notification)
                @php
                  $data = json_decode($notification->data, true);
                  
                @endphp  
                @if($last_id === $data['batch_id'])
                  
                @else
                  <div class="form-group">
                    <div class="card">
                        <div class="card-header">
                          @php
                            print_r($data['title']);
                            $last_id = $data['batch_id'];
                          @endphp
                            <div class="float-right">
                                <button type="button" class="btn btn-outline-danger btn-sm">Delete</button>
                            </div>
                        </div>

                        <div class="card-body">
                            @php
                              print_r($data['description']);
                            @endphp
                        </div>
                    </div>
                  </div>
                @endif

              @empty
                No Notification!
              @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Notification</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="notificationForm" name="notificationForm" class="form-horizontal" novalidate="">
          <div class="col-md-12">
            <div class="form-group">
              <label for="title">Enter title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Enter title">

              <span class="invalid-feedback" role="alert">
                  <strong id="title-error-message"></strong>
              </span>
            </div>

            <div class="form-group">
              <label for="description">Enter description</label>
              <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description"></textarea>

              <span class="invalid-feedback" role="alert">
                <strong id="description-error-message"></strong>
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="role">Select role</label>
              <select class="form-control" id="role" name="role">
                <option value="candidate">Candidate</option>
                <option value="recruiter">Recruiter</option>
                <option value="team leader">Team Leader</option>
                <option value="branch manager">Branch Manager</option>
                <option value="manager">Manager</option>
                <option value="accountant">Accountant</option>
                <option value="admin">Admin</option>
              </select>

              <span class="invalid-feedback" role="alert">
                <strong id="role-error-message"></strong>
              </span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" id="btn-create-notification" name="btn-create-notification" class="btn btn-outline-danger btn-sm">Create Notification</button>
      </div>
    </div>
  </div>
</div>
@endsection
