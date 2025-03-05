<div class="col-md-10 offset-md-1">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title">User Profile</h3>
        </div>
        <div class="card-body">

            <form accept-charset="UTF-8" role="form" method="post" action="/profile/upload" enctype="multipart/form-data">
                <fieldset>

                    <div class="input-group has-validation mb-4">
                        <div class="text-center w-100">
                            <img id="profile-preview" 
                                 src="<?= $user->profile_image ? '/upload_image/' . $user->profile_image : '/images/default-avatar.png' ?>" 
                                 class="img-thumbnail rounded-circle mb-2" 
                                 style="width: 150px; height: 150px;"
                                 alt="Profile Image">
                            <input type="file" 
                                   class="form-control <?= $form_errors->has('profile_image') ? 'is-invalid' : '' ?>" 
                                   name="profile_image" 
                                   id="profile_image" 
                                   accept="image/*"
                                   onchange="document.getElementById('profile-preview').src = window.URL.createObjectURL(this.files[0])">
                            <?php if ($form_errors->has('profile_image')): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $form_errors->getErrorMsg('profile_image') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary">Update Profile Image</button>
                    </div>
                </fieldset>
            </form>

            <div class="input-group has-validation">
                <label class="input-group-text">Login ID</label>
                <input class="form-control" value="<?= $user->username ?>" readonly>
            </div>

            <div class="input-group has-validation mt-3">
                <label class="input-group-text">Nick Name</label>
                <input class="form-control" value="<?= $user->nick_name ?>" readonly>
            </div>

            <div class="input-group has-validation mt-3">
                <label class="input-group-text">Email</label>
                <input class="form-control" value="<?= $user->email ?>" readonly>
            </div>

            <div class="input-group has-validation mt-3">
                <label class="input-group-text">Account Type</label>
                <input class="form-control" value="<?= ucfirst($user->type) ?>" readonly>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profile_image').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('profile-preview').src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
});
</script>