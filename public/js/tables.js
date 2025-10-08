$(document).ready(function () {
    var table = $('#students').DataTable({
        language: {
            search : "Search Student :  "
        }
    });

    // Filter by Year and Subject
    $('#filterYear').on('change', function () {
        var year = $('#filterYear').val();

        // Reset filters
        table.columns().search('');

        if (year) {
            table.column(2).search('^' + year + '$', true, false);
        }

        table.draw();
    });

    $('#StudentSubject').DataTable({
        language: {
            search : "Search Student : "
        }
    });
    $('#GradingTable').DataTable({
        searching : false,
        lengthChange : false,
        paging : false,
        info : false
    });
});