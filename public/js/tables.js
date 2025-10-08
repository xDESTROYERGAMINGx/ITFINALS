$(document).ready(function () {
    var table = $('#table').DataTable({
        language: {
            search: "Search :  "
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