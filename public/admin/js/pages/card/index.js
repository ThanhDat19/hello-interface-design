const element_index = {
    table       : $('#card-table'),
    btn_create  : $('#btnCreate'),
    url_get_data: "/api/card/getData",
};
let table = null;
function renderDatatable () {
    let targets = 0;
    table = element_index.table.DataTable({
        processing: true,
        serverSide: true,
        language  : {
			paginate: {
				next    : '<i class="fa-solid fa-angle-right"></i>',
				previous: '<i class="fa-solid fa-angle-left"></i>'
			}
			
		},
        buttons: [
			{ 
                extend: 'excel', 
                text: '<i class="fa-solid fa-file-excel"></i> Export Report (Chưa làm)',
                className: 'btn btn-sm border-0'
			}
        ],
        ordering    : false,
        searching   : true,
        select      : false,
        pageLength  : 5,
        lengthChange: false,
		//dom: 'Bfrtip',
		'dom': 'ZBfrltip',
		ajax: {
            url     : element_index.url_get_data,
            dataType: 'json',
            type    : 'GET',
        },
        columnDefs: [
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `<div>${row.card_code}</div>`;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>${row.card_name ?? ''}</div>
                    `;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>${row.card_type ? (row.card_type.name ?? '') : ''}</div>
                    `;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>${row.description ?? ''}</div>
                    `;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>${row.create_user ? row.create_user.nickname ?? '' : ''}</div>
                    <div>${row.update_user ? row.update_user.nickname ?? '' : ''}</div>
                    `;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>${row.create_date ? formatedDate(row.create_date) : ''}</div>
                    <div>${row.update_date ? formatedDate(row.update_date) : ''}</div>
                    `;
                },
                targets: targets++
            },
            {
                class: 'left',
                render: function ( col, type, row, index ) {
                    return `
                    <div>
                        <a href="${window.routes.page_card_edit}/${row.card_id}" class ="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <a href="" class ="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        <a href="" class ="btn btn-warning btn-sm ms-auto"><i class="bi bi-book"></i></a>
                    </div>
                    `;
                    
                    
                },
                targets: targets++
            },

        ],
        drawCallback: function () {
            // Code
        },
        footerCallback: async function( tfoot, data, start, end, display ){
            // Code
        },
        createdRow: function ( row, data, index ) {
            // Code
        },
        initComplete: (settings, json)=>{
            // Code
        }
    });
}

$(document).ready(function () {
    renderDatatable();
})
