<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm">
                <div class="modal-body row g-3">
                    <input type="hidden" id="userId">

                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First name</label>
                        <input type="text" class="form-control" name="first_name" id="firstName" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last name</label>
                        <input type="text" class="form-control" name="last_name" id="lastName" required>
                    </div>
                    <div class="col-12 form-check form-switch ms-3">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                        <label class="form-check-label" for="statusSwitch">Active Status</label>
                    </div>
                    <div class="col-12">
                        <label for="userRole" class="form-label">Role</label>
                        <select id="userRole" class="form-select" name="role">
                            <option value="2" selected>User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/createAndEditUser.js"></script>