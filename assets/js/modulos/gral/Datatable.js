function DataTableClass(tableName, endPoint, args) {
  /* Initialize Bootstrap Datatables Integration */
  App.datatables();

  var Data = {};

  this.loadTable = function(loadAjax)
  {
    this.appendData(this.processing);
    this.appendData(this.ajax);
    this.appendData(loadAjax);
    this.appendData(this.language);
    this.appendData(this.init);
    /* Initialize Datatables */
    $($(tableName)).dataTable(Data);
    /* Add placeholder attribute to the search input */
    $('.dataTables_filter input').attr('placeholder', 'Filtrar');
  }

  this.appendData = function(data)
  {
    $.extend(Data,data)
    return Data;
  }

  this.processing =
  {
    "processing": true,
    "serverSide": true,
  }

  this.ajax =
  {
    "ajax":
    {
      url: BASE_URL+endPoint,
      type: "POST",
      dataType : 'json',
      "data": function ( d ) {
        d.postData = args;
      },
      "dataSrc": function (dataJson)
      {
        return dataJson.records;
      },
    }
  }

  this.language =
  {
    "language":
    {
      "emptyTable"	: message_global.dataTable_emptyTable,
      "info"			: message_global.dataTable_info,
      "infoEmpty"		: message_global.dataTable_infoEmpty,
      "infoFiltered"	: message_global.dataTable_infoFiltered,
      "lengthMenu"	: message_global.dataTable_lengthMenu,
      "loadingRecords": message_global.dataTable_loadingRecords,
      "processing"	: message_global.dataTable_processing,
      "zeroRecords"	: message_global.dataTable_zeroRecords,
      "paginate"		:
      {
        "first"		: message_global.dataTable_paginate_first,
        "last"		: message_global.dataTable_paginate_last,
        "next"		: message_global.dataTable_paginate_next,
        "previous"	: message_global.dataTable_paginate_previous
      }
    }
  }

  this.init =
  {
    initComplete: function() {
      $(tableName+'_filter input').unbind();
      $(tableName+'_filter input').bind('keyup', function(e) {
        if(e.keyCode == 13)
        {
          $($(tableName)).DataTable().search( this.value ).draw();
        }
      });
    }
  }
}
