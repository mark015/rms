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
            <input type="text" id="searchInput" class="form-control" placeholder="Search documents..." />
        </div>
        <div class="col-md-2 text-end" id="addBtn">
            
        </div>
    </div>
    
    <table id="documentTable" class="table table-striped">
        <thead>
            <tr>
                <th>Document Number</th>
                <th>Document Title</th>
                <th>Date Received</th>
                <th>Date Released</th>
                <th>Status</th>
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
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="addDocumentForm">
                    <!-- Hidden Input for Document ID -->
                    <input type="text" id="documentId" name="documentId" hidden />
                    <!-- Hidden Input for Status -->
                    <input type="text" id="status" name="status" hidden />
                    <div class="mb-3">
                        <label for="documentNumber" class="form-label">Document Number</label>
                        <input type="text" class="form-control" id="documentNumber" name="documentNumber" required />
                    </div>
                    <div class="mb-3">
                        <label for="documentTitle" class="form-label">Document Title</label>
                        <input type="text" class="form-control" id="documentTitle" name="documentTitle" required />
                    </div>
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Attach File</label>
                        <input type="file" class="form-control" id="documentFile" name="documentFile" required/>
                        <div class="mb-3" id="filePreview"></div>

                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer" id="footerModal">
                
            </div>
        </div>
    </div>
</div>