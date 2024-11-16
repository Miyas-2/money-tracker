<div class="tab-pane fade" id="v-pills-settings" role="tabpanel">

    <div class="container">
        <h2 class="text-center my-5">Settings Your Profile</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header custom-bg-blue2 ">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../backend/controll.php" id="updateProfileForm"
                            enctype="multipart/form-data">
                            <input type="hidden" name="action" value="updateProfile">

                            <div class="profile-section text-center mb-4">
                                <div class="profile-photo-container position-relative d-inline-block">
                                    <?php if (!empty($_SESSION['user']['profile_photo'])): ?>
                                        <img src="../image/<?php echo htmlspecialchars($_SESSION['user']['profile_photo']); ?>"
                                            alt="Profile Photo" class="img-fluid rounded-circle profile-photo"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #60a3d9;">
                                    <?php else: ?>
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 150px; height: 150px; border: 2px dashed #6c757d;">
                                            <i class="bi bi-person-fill text-muted" style="font-size: 80px;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <label for="profile_photo"
                                        class="position-absolute bottom-0 end-0 btn custom-bg-blue4 btn-sm rounded-circle shadow"
                                        style="width: 40px; height: 40px; padding: 8px 0;">
                                        <i class="bi bi-camera"></i>
                                        <input type="file" class="d-none" id="profile_photo" name="profile_photo"
                                            accept="image/*" onchange="previewProfilePhoto(event)">
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">
                                        Username
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?php echo htmlspecialchars($_SESSION['user']['username']); ?>"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="button" class="btn custom-bg-blue2" data-bs-toggle="modal"
                                    data-bs-target="#updateProfileModal">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header custom-bg-blue2">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../backend/controll.php" id="changePasswordForm">
                            <input type="hidden" name="action" value="changePassword">

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <i class="bi bi-eye-fill" id="currentPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        minlength="8" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <i class="bi bi-eye-fill" id="newPasswordIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordStrength" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" minlength="8" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="bi bi-eye-fill" id="confirmPasswordIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordMatchStatus" class="mt-2"></div>
                            </div>

                            <button type="button" class="btn custom-bg-blue2" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body ">
                <button type="button" class="btn custom-bg-blue2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </div>
        </div>
    </div>

    <!-- Update Profile Confirmation Modal -->
    <div class="modal fade" id="updateProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-blue2">
                    <h5 class="modal-title">Confirm Profile Update</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to update your profile?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-bg-blue2"
                        onclick="document.getElementById('updateProfileForm').submit()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Confirmation Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-blue2">
                    <h5 class="modal-title">Confirm Password Change</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to change your password?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-bg-blue2"
                        onclick="document.getElementById('changePasswordForm').submit()">Change</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-blue2 text-white">
                    <h5 class="modal-title">Confirm Logout</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="../backend/logout.php" class="btn custom-bg-blue2">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>