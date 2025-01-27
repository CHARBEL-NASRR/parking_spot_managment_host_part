@extends('layouts.app')

@section('title', 'User Profile')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <style>
        .profile-user-img {
            cursor: pointer;
        }
        .btn-custom {
            background-color: #0bc2a2;
            border-color: #0bc2a2;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0aa28b;
            border-color: #0aa28b;
        }
    </style>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <iframe class="profile-user-img img-fluid img-circle"
                   src="{{ $profilePictureUrl }}"
                   alt="User profile picture" data-toggle="modal" data-target="#profileImageModal" allow="autoplay">
                  </iframe>
            </div>
            <h3 class="profile-username text-center">{{ $user->first_name }}</h3>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Accepted bookings</b> <a class="float-right">{{ $acceptedBookings }}</a>
              </li>
              <li class="list-group-item">
                <b>Rating</b> <a class="float-right">{{ number_format($averageRating, 2) }}</a>
              </li>
              <li class="list-group-item">
                <b>Wallet</b> <a class="float-right">{{ number_format($walletBalance, 2) }}</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Send Ticket</a></li>
              <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Change Password</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" id="profileForm" action="{{ route('profile.update') }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label for="inputFirstName" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputFirstName" name="first_name" value="{{ $user->first_name }}" placeholder="First Name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputLastName" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputLastName" name="last_name" value="{{ $user->last_name }}" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPhoneNumber" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputPhoneNumber" name="phone_number" value="{{ $user->phone_number }}" placeholder="Phone Number">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" name="email" value="{{ $user->email }}" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-custom">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="timeline">
                <form class="form-horizontal" id="ticketForm" method="POST" action="{{ route('tickets.store') }}">
                  @csrf
                  <div class="form-group row">
                    <label for="ticketType" class="col-sm-2 col-form-label">Ticket Type</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="ticketType" name="type" required>
                        <option value="">Select Ticket Type</option>
                        <option value="bug">Bug</option>
                        <option value="feature_request">Feature Request</option>
                        <option value="general_inquiry">General Inquiry</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ticketTitle" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="ticketTitle" name="title" placeholder="Enter Ticket Title" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="ticketDescription" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="ticketDescription" name="description" rows="4" placeholder="Describe the issue or request in detail" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-custom">Submit Ticket</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="change-password">
                <form class="form-horizontal" id="changePasswordForm" action="{{ route('profile.change-password') }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label for="oldPassword" class="col-sm-2 col-form-label">Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="Old Password" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="newPassword" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="New Password" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="confirmNewPassword" class="col-sm-2 col-form-label">Confirm New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="confirmNewPassword" name="new_password_confirmation" placeholder="Confirm New Password" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-custom">Change Password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Profile Image Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1" role="dialog" aria-labelledby="profileImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileImageModalLabel">Profile Picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ $profilePictureUrl }}" class="img-fluid" alt="Profile Picture">
        <form id="changeProfilePictureForm" action="{{ route('profile.change-picture') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group mt-3">
            <label for="profilePicture">Change Profile Picture</label>
            <input type="file" class="form-control-file" id="profilePicture" name="profile_picture" accept="image/*" required>
          </div>
          <button type="submit" class="btn btn-custom">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#profilePicture').change(function() {
      $('#changeProfilePictureForm').submit();
    });
  });
</script>
@endsection