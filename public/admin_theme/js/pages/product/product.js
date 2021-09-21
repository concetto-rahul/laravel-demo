function deleteProduct(id){
    $.get(baseUrl + "/admin/product/delete/" + id, function (data, status) {
        pageModel.html("");
        pageModel.html(data);
        pageModel.modal("show");
    });
}

$(function() {
    $('#product-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax:{
            url: productTable,
            dataType: "json",
            type: "POST",
            data: { _token: csrfToken },
        },
        columns: [
            { data: "name", orderable: true },
            { data: "sku_code", orderable: true },
            { data: "created_at", orderable: true },
            { data: "added_by", orderable: true },
            { data: "actions", orderable: false },
        ]
    });
});