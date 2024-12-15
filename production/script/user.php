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
            url: "data/fetch_users.php",
            type: "GET",
            data: { page: page, search: search, role: role },
            dataType: "json",
            success: function (response) {
                console.log(response)
                let rows = "";
                response.data.forEach(function (doc) {
                    if(role === 'Admin'){
                        var deleteBtn =  `<button class="btn btn-danger btn-sm delete-btn" data-id="${doc.id}">Delete</button>`
                    }else {
                        var deleteBtn = '';
                    }
                    
                    rows += `
                        <tr>
                            <td>${doc.name}</td>
                            <td>${doc.username}</td>
                            <td>${doc.role}</td>
                            ${status}
                            <td>
                                ${deleteBtn}
                                <button class="btn btn-success btn-sm" id="update-btn" data-update-id="${doc.id}">Update</button>
                            </td>
                        </tr>
                    `;
                });
                $("#userTable tbody").html(rows);
                

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
        $("#fPass").closest('.mb-3').show(); // Hide Password field
        $("#frePass").closest('.mb-3').show(); // Hide Re-type Password field
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="saveUserButton">Save</button>`)
        $('#modalHeader').html(`
                <h5 class="modal-title" id="addModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
    })

    // UPDATE  DOCUMENTS onclick btn
    $(document).on('click', '#update-btn' , function(){
        const id = $(this).data('update-id');
        $('#footerModal').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateUserButton">Save</button>`)
        $('#modalHeader').html(`
                <h5 class="modal-title" id="addModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>`)
        $('#addDocumentForm')[0].reset();
        $("#fPass").closest('.mb-3').hide(); // Hide Password field
        $("#frePass").closest('.mb-3').hide(); // Hide Re-type Password field
        $.ajax({
            url: "data/getUserDetails.php", // Endpoint to fetch details
            type: "GET",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $("#userId").val(response.data.id);
                    $("#fName").val(response.data.name);
                    $("#fUsername").val(response.data.username);
                    $("#fRole").val(response.data.role);
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
    
    $(document).on('click', '#updateUserButton' , function(){
        var userId = $("#userId").val();
        var fName = $("#fName").val();
        var fusername = $("#fUsername").val();
        var fRole = $("#fRole").val();
        console.log(fName)
        if (!fName || !fusername || !fRole) {
            alert("Please fill in all fields.");
            return;
        }

        var formData = new FormData();
        formData.append('userId', userId);
        formData.append('fName', fName);
        formData.append('fusername', fusername);
        formData.append('fRole', fRole);
        $.ajax({
            url: "data/updateUser.php",
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
    $(document).on('click', '#saveUserButton' , function(){
    
        var fName = $("#fName").val();
        var fusername = $("#fUsername").val();
        var fRole = $("#fRole").val();
        var fPass = $("#fPass").val();
        var frePass = $("#frePass").val();
        console.log(fName)
        if (!fName || !fusername || !fPass || !fRole) {
            alert("Please fill in all fields.");
            return;
        }
        if(fPass != frePass){
            alert("Password is incorrect.");
            return;
        }

        var formData = new FormData();
        formData.append('fName', fName);
        formData.append('fusername', fusername);
        formData.append('fPass', fPass);
        formData.append('fRole', fRole);

        $.ajax({
            url: "data/add_user.php",
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
                    url: "data/delete_user.php",
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