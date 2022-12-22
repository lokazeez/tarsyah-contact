// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

$('document').ready(function () {
    fetchChartData();
    // recentOrder();
    // bestCustomers();
});

function fetchChartData() {
    // $.ajax({
    //     method: 'GET',
    //     url: '/admin/total-sales-usd'
    // }).done(function(data) {
    //     chartRender(data,2);
    // });

    $.ajax({
        method: 'GET',
        url: '/admin/total-sales-ll'
    }).done(function(data) {
        chartRender(data,1);
    });

    // $.ajax({
    //     method: 'GET',
    //     url: '/admin/top-selling-product-usd'
    // }).done(function(data) {
    //     barChartRender(data,3);
    // });

    $.ajax({
        method: 'GET',
        url: '/admin/top-selling-product-ll'
    }).done(function(data) {
        barChartRender(data,4);
    });

    // $.ajax({
    //     method: 'GET',
    //     url: '/admin/total-sales-category-usd'
    // }).done(function(data) {
    //     PieChartRender(data,5);
    // });

    $.ajax({
        method: 'GET',
        url: '/admin/total-sales-category-ll'
    }).done(function(data) {
        donutChartRender(data,6);
        // PieChartRender(data,6);
    });
    // $.ajax({
    //     method: 'GET',
    //     url: '/admin/total-vendor-sales-usd'
    // }).done(function(data) {
    //     donutChartRender(data,7);
    // });
    $.ajax({
        method: 'GET',
        url: '/admin/total-vendor-sales-ll'
    }).done(function(data) {
        donutChartRender(data,8);
    });
}
function donutChartRender(data,chartId) {
    let element = document.getElementById("chart_" + chartId);
    if (!element) {
        return;
    }
    var options = {
        series: data.value,
        chart: {
            type: 'donut',
        },
        labels: data.labels,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        title: {
            text: data.title,
            align: 'left'
        },

        // colors: [primary, success, warning, danger, info]
    };

    var chart = new ApexCharts(element, options);
    chart.render();
}

function PieChartRender(data,chartId){
    let element = document.getElementById("chart_"+chartId);
    if (!element) {
        return;
    }
    let options = {
        series: data.value,
        chart: {
            width: 380,
            type: 'pie',
        },
        labels: data.labels,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        title: {
            text: data.title,
            align: 'left'
        },
        fill: {
            opacity: 0.5
        },
    };

    var chart = new ApexCharts(element, options);
    chart.render();



}
function barChartRender(data,chartId){
    let element = document.getElementById("chart_"+chartId);
    if (!element) {
        return;
    }
    let options = {
        series: [{
            data: data.value
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: data.name,
        },
        yaxis: {
            title: {
                text: data.currency
            }
        },
        title: {
            text: data.title,
            align: 'left'
        },
        fill: {
            opacity: 0.5
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val +" "+ data.currency
                }
            }
        },
    };

    var chart = new ApexCharts(element, options);
    chart.render();
}
function chartRender(data,chartId) {

    var element = document.getElementById("chart_"+chartId);

    if (!element) {
        return;
    }

    var options = {
        series: data,
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Feb','Mar','Apr','May','Jun','Jul','Feb','Mar','Apr','May','Jun','Jul'],
        },
        yaxis: {
            title: {
                text: data[0].currency
            }
        },
        title: {
            text: data[0].title,
            align: 'left'
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val +" "+ data[0].currency
                }
            }
        },
        colors: [primary, success, warning],
    };

    var chart = new ApexCharts(element, options);
    chart.render();
}

function recentOrder() {
    let table = $('#kt_datatable');
    let locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
    let columnsName = {
        'ar' : {
            'customer': 'الزبون',
            'vendor': 'البائع',
            'amount' : 'المبلغ',
            'order_date' : 'تاريخ الطلب',
            'status' : 'الحالة',
        },
        'en' : {
            'customer': 'Customer',
            'vendor': 'Vendor',
            'amount' : 'Amount',
            'order_date' : 'Order Date',
            'status' : 'Status',
        },
    };

    let datatable = $('#kt_datatable').KTDatatable({
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/admin/orders/recentOrder' ,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    map: function(raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        console.log('recent')
                        return dataSet;
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
        sortable: false,

        pagination: true,

        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },

        // columns definition
        columns: [{
            field: 'OrderID',
            title: '#',
            width: 30,
            type: 'number',
            selector: false,
            textAlign: 'center',
        }, {
            field: 'Customer',
            title: columnsName[locale]['customer'],
        }, {
            field: 'Vendor',
            title: columnsName[locale]['vendor'],
        }, {
            field: 'Amount',
            title: columnsName[locale]['amount'],
        }, {
            field: 'OrderDate',
            title: columnsName[locale]['order_date'],
            type: 'date',
            format: 'MM/BB/YYYY',
        },{
            field: 'Status',
            title: (locale === "ar") ? 'حالة الطلب' : 'Status Order',
            template: function(row) {
                var status = {
                    1: {
                        'title:en': 'Pending',
                        'title:ar': 'معلق',
                        'class': ' label-light-info'
                    },
                    2: {
                        'title:en': 'Onging',
                        'title:ar': 'جاري',
                        'class': ' label-light-danger'
                    },
                    3: {
                        'title:en': 'Cancelled',
                        'title:ar': 'ملغاة',
                        'class': ' label-light-success'
                    },
                    4: {
                        'title:en': 'Delivered',
                        'title:ar': 'تم التسليم',
                        'class': ' label-light-success'
                    },
                    5: {
                        'title:en': 'Returned',
                        'title:ar': 'طلب اعادة',
                        'class': ' label-light-success'
                    },
                    6: {
                        'title:en': 'Refunded',
                        'title:ar': 'معاد الدفع',
                        'class': ' label-light-success'
                    },
                };
                return '<span class="label font-weight-bold label-lg ' + status[row.Status].class + ' label-inline">' + status[row.Status]['title:'+locale] + '</span>';
            },
        },
        ],
    });

    setInterval(function() {
        if($("#kt_datatable:hover").length == 0){
            datatable.reload()
        }
    }, 10000);

};


function bestCustomers() {
    let table = $('#kt_datatable_customers');
    let locale = table.attr('data-locale') === '' ? "en" : table.attr('data-locale');
    let columnsName = {
        'ar' : {
            'customer': 'الزبون',
            'order_count' : 'عدد الطلبات',
            'join_date' : 'تاريخ الانضمام',
            'status' : 'الحالة',
        },
        'en' : {
            'customer': 'Customer',
            'order_count': 'Orders',
            'amount' : 'Amount',
            'join_date' : 'Joining Date',
            'status' : 'Status',
        },
    };

    let datatable = $('#kt_datatable_customers').KTDatatable({
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/admin/orders/bestCustomers' ,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    map: function(raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        console.log('recent')
                        return dataSet;
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
        sortable: false,

        pagination: true,

        search: {
            input: $('#kt_datatable_customers_search_query'),
            key: 'generalSearch'
        },

        // columns definition
        columns: [ {
            field: 'Customer',
            title: columnsName[locale]['customer'],
        }, {
            field: 'OrderCount',
            title: columnsName[locale]['order_count'],
        }, {
            field: 'JoinDate',
            title: columnsName[locale]['join_date'],
            type: 'date',
            format: 'MM/BB/YYYY',
        },{
            field: 'Status',
            title: (locale === "ar") ? 'حالة الزبون' : 'Customer Status',
            template: function(row) {
                var status = {
                    0: {
                        'title:en': 'Inactive',
                        'title:ar': 'معلق',
                        'class': ' label-light-danger'
                    },
                    1: {
                        'title:en': 'Active',
                        'title:ar': 'مفعل',
                        'class': ' label-light-success'
                    }
                };
                return '<span class="label font-weight-bold label-lg ' + status[row.Status].class + ' label-inline">' + status[row.Status]['title:'+locale] + '</span>';
            },
        },
        ],
    });

    setInterval(function() {
        if($("#kt_datatable_customers:hover").length == 0){
            datatable.reload()
        }
    }, 10000);

};

// function donutChartRender(data)
// {
//
//     var element = document.getElementById("chart_11");
//
//     if (!element) {
//         return;
//     }
//
//     var options = {
//         series: data,
//         chart: {
//             width: 380,
//             type: 'donut',
//         },
//         labels: ['Active Users', 'Inactive Users', 'Stores', 'Buyer Users'],
//         responsive: [{
//             breakpoint: 480,
//             options: {
//                 chart: {
//                     width: 200
//                 },
//                 legend: {
//                     position: 'bottom'
//                 }
//             }
//         }],
//         colors: [primary, success, warning, danger, info]
//     };
//
//     var chart = new ApexCharts(element, options);
//     chart.render();
// }
