$('document').ready(function() {
    changeStatus();
    dataTables();
    showMoreIfo();
});

function dataTables() {
    let searchParams = new URLSearchParams(window.location.search);
    let table = $('#kt_datatable');
    let locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
    let apiUrl = table.attr('data-url');
    let apiStatus = table.attr('data-status');
    let columnsName = {
        'ar' : {
            'id': 'ID',
            'name': 'الاسم',
            'email': 'ايميل',
            'role': 'النوع',
            'created_at' : 'تاريخ الانشاء',
            'status' : 'الحالة',
            'Actions' : 'الاجراءات',
        },
        'en' : {
            'id': 'ID',
            'name': 'Name',
            'email': 'Email',
            'role': 'Role',
            'created_at' : 'Creation Date',
            'status' : 'Status',
            'Actions' : 'Actions',
        },
    };

    let datatable = table.KTDatatable({
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: apiUrl ,
                    // sample custom headers
                    headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    map: function(raw) {
                        // sample data mapping
                        let dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                    params :{
                        query :{
                            status : searchParams.has('status') ? searchParams.get('status') : null,
                            search : searchParams.has('search') ? searchParams.get('search') : null,
                            role : searchParams.has('role') ? searchParams.get('role') : null,
                            from_date : searchParams.has('from_date') ? searchParams.get('from_date') : null,
                            to_date : searchParams.has('to_date') ? searchParams.get('to_date') : null
                        }
                    },
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,

        },
        // layout definition
        layout: {
            scroll: false,
            footer: false,
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition
        columns: [{
            field: 'id',
            title: columnsName[locale]['id'],
            width: 90,
            textAlign: 'center',
            template: function(row) {
                return row.image;
            }
        }, {
            field: 'name',
            title: columnsName[locale]['name'],
        }, {
            field: 'email',
            title: columnsName[locale]['email'],
        }, {
            field: 'role',
            title: columnsName[locale]['role'],
            sortable: false,
        }, {
            field: 'created_at',
            title: columnsName[locale]['created_at'],
            type: 'date',
            format: 'MM/BB/YYYY',
        }, {
            field: 'status',
            title: columnsName[locale]['status'],
            template: function(row) {

                let status = {
                    0: {
                        'title:en': 'Inactive',
                        'title:ar': 'غير مفعل',
                        'class': ' label-light-danger'
                    },
                    1: {
                        'title:en': 'Active',
                        'title:ar': 'مفعل',
                        'class': ' label-light-success'
                    },
                };
                if (apiStatus !== 'undefined' && apiStatus !== undefined) {
                    return status[apiStatus]['title:' + locale];
                }
                let options = ' ';

                for (const key in status) {
                    options += '<option value="' + key + '" ' + (row.status == key ? 'selected' : "") + '>' + status[key]['title:' + locale] + '</option>\n';
                }
                return ' <span class="text-dark-75 font-weight-bolder d-block font-size-lg">\n' +
                    '         <span class="label label-lg label-inline ' + status[row.status].class + ' mr-2">\n' +
                    '               <select class="btn btn-dropdown dropdown-toggle"\n' +
                    '                    id="statusItem" name="statusItem" data-id="'+ row.id +'"\n' +
                    '                    style="width: 100% !important; opacity: 1 !important;">\n'+
                    options+
                    '               </select>\n' +
                    '         </span>\n' +
                    '  </span>';
            },
        },{
            field: 'Actions',
            title: columnsName[locale]['Actions'],
            sortable: false,
            width: 125,
            overflow: 'visible',
            autoHide: false,
            template: function(row) {
               return row.actions
            },
        }
        ],
    });
    const url = new URL(window.location.href);

    $('#kt_datatable_search_status').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
        url.searchParams.set('status', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_role').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'role');
        url.searchParams.set('role', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_search').on('keyup', function() {
        datatable.search($(this).val().toLowerCase(), 'search');
        url.searchParams.set('search', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_from_date').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'from_date');
        url.searchParams.set('from_date', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    $('#kt_datatable_search_to_date').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'to_date');
        url.searchParams.set('to_date', $(this).val().toLowerCase());
        window.history.replaceState(null, null, url);
    });

    table.on('datatable-on-layout-updated', function() {
        changeStatus(table);
    });
}
function showMoreIfo() {
    let MoreInfo = $('input[name="moreInformation"]');
    console.log(MoreInfo);
    console.log('tset');
    MoreInfo.prop('checked', false);
    $('#moreInfo').hide();
    MoreInfo.on('change', function () {
        if ($(this).is(":unchecked")) {
            $('#moreInfo').slideUp();
        } else {
            $('#moreInfo').slideDown();
        }
    });
}

function changeStatus(table) {
    $('.change-status').on('click', function(){
        let id = this.getAttribute('data-id');
        let action = this.getAttribute('data-action');
        confirmChangeStatus(id, action, 0, table);
    });

    $('select[name="statusItem"]').on('change', function () {
        let id = this.getAttribute('data-id');
        confirmChangeStatus(id, 'change', this.value, table);
    });

    $('.deleteRow').on('click', function(e) {
        clickLinkConfirm(this, "Are you sure you want to delete this item?");
        e.preventDefault();
    });

    $('.fancybox').fancybox({});
}

function confirmChangeStatus(id, action = 'change', status= 0, table = null){

    if (action === 'active'){
        status =  1 //Order::STATUS_ONGOING
    }else if (action === 'inactive') {
        status =  0 //Order::STATUS_CANCELLED
    }

    Swal.fire({
        title: "Confirm!",
        text: "Are you sure you want to "+ action +" this order?",
        icon: "warning",
        buttonsStyling: false,
        confirmButtonText: "<i class='la la-thumbs-o-up'></i> Yes "+ action + " it!",
        showCancelButton: true,
        cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-default"
        }
    }).then(function (result) {
        if (result.value) {
            setOrderStatus(id, status, table)
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your order is safe :)",
                "error"
            )
        }
    });
}

function setOrderStatus(id, status, table){
    $.ajax(
        {
            url: '/admin/datatables/setStatus/' + id,
            data: {
                status: status,
                type: 'admin'
            },
            success: function(result){
                if (table != null){
                    table.reload();
                }else{
                    setInterval(function(){
                        window.location.reload();
                    }, 2000);
                }
                Swal.fire({
                    text: result,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "<i class='la la-thumbs-o-up'></i> OK!",
                    showCancelButton: false,
                    customClass: {
                        confirmButton: "btn btn-danger",
                    }
                });
            }
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
    }).then(function(result) {
        if (result.value) {
            $(element).find('form').submit();
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your item is safe :)",
                "error"
            )
        }
    });
}

jQuery(document).ready(function() {
    let $registerForm = $('#sheen_value_form');
    let _method = $('input[name="_method"]').val();
    let passwordRequired = _method !== 'PUT';
    if ($registerForm.length) {
        $registerForm.validate({
            rules: {
                name: {
                    required: true
                },
                username: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    required: passwordRequired
                }
            },
            messages: {
                name: {
                    required: 'please enter name'
                },
                username: {
                    required: 'please enter username'
                },
                email: {
                    required: 'please enter email'
                },
                password: {
                    required: 'please enter password'
                }
            }
        });
    }

    const roles = [2, 3, 4];
    let storeShifts = $('#shifts_form');
    let mileBenefitPercentage = $('#mile_percentage');
    let phoneNumber = $('#phone_number');
    let whatsapp = $('#whatsapp');
    let websiteUrl = $('#website_url');
    let facebook = $('#facebook');
    let instagram = $('#instagram');
    let about = $('#about');
    let companyName = $('#company_name');
    let coverImage = $('#cover_image');
    let arTab = $('#ar-tab-1');



    let role = $('#role');
    let index = roles.findIndex(el => el == role.val())

    if (index <= -1) {
        storeShifts.hide();
        mileBenefitPercentage.parent().parent().hide();
        phoneNumber.parent().parent().hide();
        whatsapp.parent().parent().hide();
        websiteUrl.parent().parent().hide();
        facebook.parent().parent().hide();
        instagram.parent().parent().hide();
        about.parent().parent().hide();
        companyName.parent().parent().hide();
        coverImage.parent().hide();
        arTab.parent().hide();
    }
    role.on("select2:select", function(event) {
        let value = $(event.currentTarget).find("option:selected").val();
        let index = roles.findIndex(el => el == value)
        if (index > -1){
            storeShifts.fadeIn();
            mileBenefitPercentage.parent().parent().fadeIn();
            phoneNumber.parent().parent().fadeIn();
            whatsapp.parent().parent().fadeIn();
            websiteUrl.parent().parent().fadeIn();
            facebook.parent().parent().fadeIn();
            instagram.parent().parent().fadeIn();
            about.parent().parent().fadeIn();
            companyName.parent().parent().fadeIn();
            coverImage.parent().fadeIn();
            arTab.parent().fadeIn();

        } else{
            storeShifts.fadeOut();
            mileBenefitPercentage.parent().parent().fadeOut();
            phoneNumber.parent().parent().fadeOut();
            whatsapp.parent().parent().fadeOut();
            websiteUrl.parent().parent().fadeOut();
            facebook.parent().parent().fadeOut();
            instagram.parent().parent().fadeOut();
            about.parent().parent().fadeOut();
            companyName.parent().parent().fadeOut();
            coverImage.parent().fadeOut();
            arTab.parent().fadeOut();
        }
    });

    let nameAr = $('input[name="company_name:ar"]');
    $registerForm.on('submit', function(e) {
        let role = $('#role');
        let index = roles.findIndex(el => el == role.val())

        if (index > -1 && nameAr.val() === '') {
            e.preventDefault();
            $('#ar-tab-1').trigger('click');
            nameAr.addClass('is-invalid');
            nameAr.parent().append('<div class="invalid-feedback text-right">company name is required</div>');
            return false;
        }
    });


});

