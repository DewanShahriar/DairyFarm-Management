var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
var bill_table;
var base_url = $('#base').val();
console.log(base_url);

function get_accounts_list() {
    
    bill_table = $('#userListTable').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        serverSide: true,
        processing: true,
        ajax:{
            dataType: "JSON",
            type: "post",
            url: base_url + "admin/accouts-list",
            data: {
               
        	},
        },
        columns:[
            // {
            //     "className":      'details-control',
            //     "orderable":      false,
            //     "data":           null,
            //     "defaultContent": ''
            // },
            {
                title: "SL",
                data: null,
                render: function(){
                    return bill_table.page.info().start + bill_table.column(0).nodes().length;
                }           
            },
            {
                title: "Manage Project",
                data: "pname"
            },
            {
                title: "Account Head",
                data: "hname"
            },
            {
                title: "Date",
                data: "date"
            },
            {
                title: "Description",
                data: "description"
            },
            {
                title: "Quantity",
                data: "quantity"
            },
            {
                title: "Rate",
                data: "rate"
            },
            {
                title: "Amount",
                data: "amount"
                
            },
            {
                title: "Action",
                data: null,
                render: function(data){
                    return '<a onclick= '' >ada</a>'
                }
                
            },
            
        ],
        columnDefs: [{
            targets: "datatable-nosort",
            orderable: false,
        }],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language": {
            "info": "_START_-_END_ of _TOTAL_ entries",
            searchPlaceholder: "Search"
        },
        dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},
                {extend: 'print',
                     customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                	}
                }
            ]
    });
}