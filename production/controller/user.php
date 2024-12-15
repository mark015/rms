<style>
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    cursor: not-allowed;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
.w-50{
    width: 50%;
}
</style>


<div class="container mt-5">
    <h3>Document Management</h3>
    <div class="row mb-3 align-items-center">
        <div class="col-md-10">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Users..." />
        </div>
        <div class="col-md-2 text-end" id="addBtn">
            
        </div>
    </div>
    
    <table id="userTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>UserName</th>
                <th>role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be injected here -->
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-end" id="pagination">
            <!-- Pagination buttons will be injected here -->
        </ul>
    </nav>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" id="modalHeader">
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addDocumentForm">
                    <!-- Hidden Input for Document ID -->
                    <input type="text" id="userId" name="userId" hidden />
                    <div class="mb-3">
                        <label for="fname" class="form-label">Name: </label>
                        <input type="text" class="form-control" id="fName" name="fname" required />
                    </div>
                    <div class="mb-3">
                        <label for="fUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="fUsername" name="fUsername" required />
                    </div>
                    <div class="mb-3">
                        <label for="fUsername" class="form-label">Role</label>
                        <select name="fRole" class="form-control" id="fRole">
                            <option value="">Select Role</option>
                            <option value="User1">User 1</option>
                            <option value="User2">User 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fPass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="fPass" name="fPass" required/>
                    </div>
                    <div class="mb-3">
                        <label for="frePass" class="form-label">Re-type Password</label>
                        <input type="password" class="form-control" id="frePass" name="frePass" required/>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer" id="footerModal">
                
            </div>
        </div>
    </div>
</div>