<script>

$(document).ready(function () {
    let currentPage = 1;
    var role = "<?php echo $rowUser['role'];?>";    
    if(role === 'Admin'){
        $('#addBtn').html('<button class="btn btn-primary" id="addBtns" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus"></i></button>')
    
    }
                    
    // Function to fetch and display data
    function fetchDocuments(page = 1, search = "") {
        
    
        $.ajax({
            url: "data/fetch_documents.php",
            type: "GET",
            data: { page: page, search: search, role: role },
            dataType: "json",
            success: function (response) {
                let rows = "";
                response.data.forEach(function (doc) {
                    if(role === 'Admin'){
                        var deleteBtn =  `<button class="btn btn-danger btn-sm delete-btn" data-id="${doc.id}">Delete</button>`
                    }else {
                        var deleteBtn = '';
                    }

                    if(doc.status === 'pending'){
                        var status = `<td><span class="btn-danger btn-sm">${doc.status}</span></td>`;
                    }else if(doc.status === 'processing'){
                        var status = `<td><span class="btn-primary btn-sm">${doc.status}</span></td>`;
                    }else{
                        var status = `<td><span class="btn-success btn-sm">${doc.status}</span></td>`;
                    }
                    
                    rows += `
                        <tr>
                            <td>${doc.document_number}</td>
                            <td>${doc.document_title}</td>
                            <td>${doc.date_received}</td>
                            <td>${doc.date_released || "N/A"}</td>
                            ${status}
                            <td>
                                <a href="uploads/${doc.document_file}" download class="btn btn-primary btn-sm">Download</a>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${doc.id}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#documentTable tbody").html(rows);
                

                // Handle pagination
                const totalPages = Math.ceil(response.total / response.limit);
                generatePagination(totalPages, response.page);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }
    // Function to generate pagination buttons
    function generatePagination(totalPages, currentPage) {
        let pagination = "";

        // Previous button
        if (currentPage > 1) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            `;
        }

        // Generate page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                pagination += `
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                pagination += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
        }

        // Next button
        if (currentPage < totalPages) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                </li>
            `;
        } else {
            pagination += `
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            `;
        }

        $("#pagination").html(pagination);

        // Attach click event to pagination buttons
        $("#pagination .page-link").click(function (e) {
            e.preventDefault();
            const page = $(this).data("page");
            const search = $("#searchInput").val();
            fetchDocuments(page, search);
        });
    }
    
    // ADD DOCUMENT onclick btn
    $(document).on('click', '#addBtns' , function(){
        $('#addDocumentForm')[0].reset();
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveDocumentButton">Save</button>`)
    })

    // UPDATE  DOCUMENTS onclick btn
    $(document).on('click', '#update-btn' , function(){
        const documentId = $(this).data('update-id');
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateDocumentButton">Save</button>`)
        $('#addDocumentForm')[0].reset();
        $.ajax({
            url: "data/getDocumentDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: documentId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#documentId").val(response.data.id);
                    $("#documentNumber").val(response.data.document_number);
                    $("#documentTitle").val(response.data.document_title);
                    $("#status").val(response.data.status);
                    if (response.data.document_file) {
                        const filePath = response.data.document_file; // Path to the file
                        const fileName = filePath.split("/").pop(); // Extract file name from the path
                        $("#filePreview").html(`
                            <p>Attached File: <a href="${filePath}" target="_blank">${fileName}</a></p>
                        `);
                    } else {
                        $("#filePreview").html("<p>No file attached.</p>");
                    }
                    $("#addModal").modal("show");
                } else {
                    alert("Failed to fetch document details.");
                }
            },
            error: function () {
                alert("An error occurred while fetching the document details.");
            },
        });
    })
    
    $(document).on('click', '#updateDocumentButton' , function(){
        var documentId = $("#documentId").val()
        var documentNumber = $("#documentNumber").val();
        var documentTitle = $("#documentTitle").val();
        var status = $("#status").val();
        var documentFile = $("#documentFile")[0].files[0]; // File input
        
        if (!documentNumber || !documentTitle || !documentFile) {
            alert("Please fill in all fields, including uploading a document.");
            return;
        }

        var formData = new FormData();
        formData.append('documentId', documentId);
        formData.append('documentNumber', documentNumber);
        formData.append('status', status);
        formData.append('documentTitle', documentTitle);
        formData.append('documentFile', documentFile);
        $.ajax({
            url: "data/updateDocument.php",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success === true) {
                    Swal.fire(
                        'Saved!',
                        'Successfully Addded.',
                        'success'
                    );
                    $("#addModal").modal("hide");
                    fetchDocuments();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    });
    // Function to add documents
    $(document).on('click', '#saveDocumentButton' , function(){
    
        var documentNumber = $("#documentNumber").val();
        var documentTitle = $("#documentTitle").val();
        var documentFile = $("#documentFile")[0].files[0]; // File input
        
        if (!documentNumber || !documentTitle || !documentFile) {
            alert("Please fill in all fields, including uploading a document.");
            return;
        }

        var formData = new FormData();
        formData.append('documentNumber', documentNumber);
        formData.append('documentTitle', documentTitle);
        formData.append('documentFile', documentFile);

        $.ajax({
            url: "data/add_document.php",
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire(
                        'Saved!',
                        'Successfully Addded.',
                        'success'
                    );
                    $("#addModal").modal("hide");
                    fetchDocuments();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    });
        // Handle search input
        $("#searchInput").on("keyup", function () {
            const search = $(this).val();
            currentPage = 1; // Reset to first page on new search
            fetchDocuments(currentPage, search);
        }); 
        fetchDocuments();
        setInterval(updateNotif, 2000);
    // Delete document using SweetAlert
    $(document).on("click", ".delete-btn", function() {
        const documentId = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with delete request
                $.ajax({
                    url: "data/delete_document.php",
                    type: "POST",
                    data: { id: documentId },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'Your document has been deleted.',
                                'success'
                            );
                            fetchDocuments(currentPage); // Refresh the document list
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the document.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the document.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    function updateNotif(){
        $.ajax({
            url: "data/updateNotif.php",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
});


</script>