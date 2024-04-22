
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css"></link>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>



<div id="moduleNav"><a href="/admin.php?poi&new" class="button bluebutton">New POI</a></div>
<p class="message"><?php echo $message; ?></p>

<h2>POI LIST</h2>
<table id="poiTable" class="display" style="width:100%">
    <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Start</th>
                <th>End</th>
                <th>Categories</th>
            </tr>
        </thead>
    </table>
<br/>
<br/>
<script>
    //let table = new DataTable('#poiTable');
    $(document).ready(function() {
        $('#poiTable').DataTable({
            //ajax: "functions/poiTableFunction.php",
            "ajax": {
                "url": "poiModule/functions/poiTableFunction.php",
                "dataType": "json",
                "dataSrc": "data"
            },
            "columnDefs": [
                {
                    "target": 0,
                    "visible": false,
                    "searchable": false
                }
            ],
            "columns": [
                { 
                    "data": "id",
                    "render": $.fn.dataTable.render.number(',', '.', 0, '') // Format as integer
                },
                { 
                    "data": "title",
                    "render": function(data, type, row, meta) {
                        return '<a href="admin.php?poi=' + row.id + '">' + data + '</a>';
                    }
                },
                { 
                    "data": "startDate",
                    "render": $.fn.dataTable.render.number('', '.', 0, '') // Format as integer
                },
                { 
                    "data": "endDate",
                    "render": $.fn.dataTable.render.number('', '.', 0, '') // Format as integer 
                },
                { "data": "category" }
                // Add more columns as needed
            ],
        });
    });
    


</script>

