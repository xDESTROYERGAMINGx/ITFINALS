$(document).ready(function () {
    var table = $('#students').DataTable({
        language: {
            search: "Search Student :  "
        }
    });

    // Filter by Year and Subject
    $('#filterYear').on('change', function () {
        var year = $('#filterYear').val();

        if (year ) {
            table.column(2).search('^' + year + '$', true, false);
        } else {
            table.column(2).search('');
        }

        table.draw();
    });
});

$(document).ready(function () {
    $('#StudentSubject').DataTable({
        language: {
            search: "Search Student : "
        }
    });
    $('#GradingTable').DataTable({
        searching: false,
        lengthChange: false,
        paging: false,
        info: false
    });
    $('#availableSubject').DataTable({
        language: {
            search: "Search Available Subject : "
        }
    });
});