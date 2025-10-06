$('#myTable').DataTable({
    responsive: {
        details: {
            type: 'column'
        }
    },
    "language": {
        "paginate": {
            "previous": LANG_PREVIOUS,
            "next": LANG_NEXT
        },
        "search": LANG_SEARCH,
        "zeroRecords": LANG_NO_FOUND,
        "infoEmpty": LANG_NO_RESULT_FOUND,
        "info": LANG_PAGE+" _PAGE_ - _PAGES_",
        "lengthMenu": LANG_DISPLAY+" _MENU_",
        "infoFiltered": LANG_TOTAL_RECORD+ "( _MAX_)"
    },
    columnDefs: [{
        className: 'control',
        orderable: false,
        targets: 0
    }]
});