<script>
$(document).ready(function() {
    // Function to fetch and update counts
    function fetchEmployeeCounts() {
        $.ajax({
            url: 'data/getDashboardData.php', // Your PHP file to get the data
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the count values in the respective tiles
                    $('#allDocsCount').text(response.data.total_documents);
                    $('#pendingCount').text(response.data.pending_count);
                    $('#processingCount').text(response.data.processing_count);
                    $('#completeCount').text(response.data.complete_count);
                } else {
                    console.error('Failed to fetch employee counts:', response.message);
                }
            },
            error: function() {
                console.error('An error occurred while fetching employee counts.');
            }
        });
    }

    // Call the function to fetch employee counts on page load
    fetchEmployeeCounts();
    
    // Optionally, you can set an interval to update the counts every 24 hours (86400000 ms)
    setInterval(fetchEmployeeCounts, 86400000); // 24 hours
});
</script>