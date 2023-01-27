/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/contacts.js ***!
  \**********************************/
$('document').ready(function () {
  changeStatus();
  dataTables();
  $('.fancybox').fancybox({});
});

function dataTables() {
  var searchParams = new URLSearchParams(window.location.search);
  var table = $('#kt_datatable');
  var locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
  var apiUrl = table.attr('data-url');
  var columnsName = {
    'ar': {
      'id': 'ID',
      'name': 'الاسم',
      'email': 'ايميل',
      'id_number': 'رقم الهوية',
      'phone_number': 'رقم الهاتف',
      'items': 'العقارات',
      'created_at': 'تاريخ الانشاء',
      'Actions': 'الاجراءات'
    },
    'en': {
      'id': 'ID',
      'name': 'Name',
      'email': 'Email',
      'id_number': 'ID Number',
      'phone_number': 'Phone',
      'items': 'Items',
      'created_at': 'Submit Date',
      'Actions': 'Actions'
    }
  };
  var datatable = table.KTDatatable({
    // datasource definition
    data: {
      type: 'remote',
      source: {
        read: {
          url: apiUrl,
          // sample custom headers
          headers: {
            'x-my-custom-header': 'some value',
            'x-test-header': 'the value',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          map: function map(raw) {
            // sample data mapping
            var dataSet = raw;

            if (typeof raw.data !== 'undefined') {
              dataSet = raw.data;
            }

            return dataSet;
          },
          params: {
            query: {
              search: searchParams.has('search') ? searchParams.get('search') : null,
              role: searchParams.has('role') ? searchParams.get('role') : null,
              from_date: searchParams.has('from_date') ? searchParams.get('from_date') : null,
              to_date: searchParams.has('to_date') ? searchParams.get('to_date') : null
            }
          }
        }
      },
      pageSize: 10,
      serverPaging: true,
      serverFiltering: true,
      serverSorting: true
    },
    // layout definition
    layout: {
      scroll: false,
      footer: false
    },
    // column sorting
    sortable: true,
    pagination: true,
    // columns definition
    columns: [{
      field: 'id',
      title: columnsName[locale]['id'],
      width: 90,
      textAlign: 'center'
    }, {
      field: 'name',
      title: columnsName[locale]['name']
    }, {
      field: 'id_number',
      title: columnsName[locale]['id_number']
    }, {
      field: 'phone_number',
      title: columnsName[locale]['phone_number']
    }, {
      field: 'created_at',
      title: columnsName[locale]['created_at'],
      type: 'date',
      format: 'MM/BB/YYYY'
    }, {
      field: 'Actions',
      title: columnsName[locale]['Actions'],
      sortable: false,
      width: 125,
      overflow: 'visible',
      autoHide: false,
      template: function template(row) {
        return row.actions;
      }
    }]
  });
  var url = new URL(window.location.href);
  $('#kt_datatable_search_status').on('change', function () {
    datatable.search($(this).val().toLowerCase(), 'status');
    url.searchParams.set('status', $(this).val().toLowerCase());
    window.history.replaceState(null, null, url);
  });
  $('#kt_datatable_search_role').on('change', function () {
    datatable.search($(this).val().toLowerCase(), 'role');
    url.searchParams.set('role', $(this).val().toLowerCase());
    window.history.replaceState(null, null, url);
  });
  $('#kt_datatable_search_search').on('keyup', function () {
    datatable.search($(this).val().toLowerCase(), 'search');
    url.searchParams.set('search', $(this).val().toLowerCase());
    window.history.replaceState(null, null, url);
  });
  $('#kt_datatable_search_from_date').on('change', function () {
    datatable.search($(this).val().toLowerCase(), 'from_date');
    url.searchParams.set('from_date', $(this).val().toLowerCase());
    window.history.replaceState(null, null, url);
  });
  $('#kt_datatable_search_to_date').on('change', function () {
    datatable.search($(this).val().toLowerCase(), 'to_date');
    url.searchParams.set('to_date', $(this).val().toLowerCase());
    window.history.replaceState(null, null, url);
  });
  table.on('datatable-on-layout-updated', function () {
    changeStatus(table);
  });
}

function changeStatus(table) {
  $('.change-status').on('click', function () {
    var id = this.getAttribute('data-id');
    var action = this.getAttribute('data-action');
    confirmChangeStatus(id, action, 0, table);
  });
  $('select[name="statusItem"]').on('change', function () {
    var id = this.getAttribute('data-id');
    confirmChangeStatus(id, 'change', this.value, table);
  });
  $('.deleteRow').on('click', function (e) {
    clickLinkConfirm(this, "Are you sure you want to delete this item?");
    e.preventDefault();
  });
}

function clickLinkConfirm(element, message) {
  Swal.fire({
    title: "Confirm!",
    text: message,
    icon: "warning",
    buttonsStyling: false,
    confirmButtonText: "<i class='la la-thumbs-o-up'></i> Yes delete it!",
    showCancelButton: true,
    cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "btn btn-default"
    }
  }).then(function (result) {
    if (result.value) {
      $(element).find('form').submit();
    } else if (result.dismiss === "cancel") {
      Swal.fire("Cancelled", "Your item is safe :)", "error");
    }
  });
}
/******/ })()
;