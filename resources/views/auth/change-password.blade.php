@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h5><i class="bi bi-key-fill me-2 text-primary"></i>Change Password</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('admin.profile.update-password') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label font-weight-bold">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label font-weight-bold">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password (min. 8 characters)" required>
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label font-weight-bold">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 12px 20px;">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px;">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
