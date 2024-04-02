const table = {
    masuk: $("table#masuk").DataTable({
        processing: true,
        responsive: true,
        ajax: {
            url: baseUrl + "/api/masuk",
            dataSrc: "",
        },
        columns: [
            {
                data: "tgl_masuk",
                render: function (data, type, row) {
                    return data;
                },
            },
            {
                data: "obat",
                render: function (data, type, row) {
                    return data.nama;
                },
            },
            {
                data: "qty",
                render: function (data, type, row) {
                    return `${row.permintaan} / ${data}`;
                },
            },
            {
                data: "expired",
                render: function (data, type, row) {
                    return data;
                },
            },
            {
                data: "id",
                render: function (data, type, row) {
                    return `<div style="display: flex; gap: 5px; color: white;">
              <a href="#!" class="btn-action btn-delete red darken-2" data-id="${data}">
                  <i class="material-icons">delete</i>
              </a>
          </div>`;
                },
            },
        ],
    }),
};

$("body").on("click", ".stack-navigator", function () {
    $("#form-masuk")[0].reset();
    $("#form-masuk [name=id]").val("");
});
$("body").on("click", ".btn-delete", function () {
    const el = $(this);
    const data = cloud.get("masuk")?.find((v) => v.id == el.data("id"));
    Swal.fire({
        title: "Apakah anda yakin ingin menghapus data ini ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: baseUrl + "/api/masuk/" + data.id,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: (res) => {
                    cloud.pull("masuk");
                    Toast.fire({
                        icon: "success",
                        title: "Data berhasil di hapus",
                    });
                },
            });
        }
    });
});

$("body").on("submit", "#form-masuk", function (e) {
    e.preventDefault();
    const data = {};
    $(this)
        .find("input, select")
        .each(function (i, e) {
            if ($(this).attr("name"))
                data[$(this).attr("name")] = $(this).val();
        });
    if (data.id_obat == null) {
        Toast.fire({
            icon: "error",
            title: "Obat harus dipilih",
        });
        return;
    }
    console.log(data);
    $.ajax({
        type: data.id ? "PUT" : "POST",
        url: baseUrl + (data.id ? "/api/masuk/" + data.id : "/api/masuk"),
        data: data,
        dataType: "json",
        success: (res) => {
            if (!data.id) {
                $(this)[0].reset();
            }
            cloud.pull("masuk");
            Toast.fire({
                icon: "success",
                title: "Data berhasil di simpan",
            });
        },
    });
});

$(document).ready(async function () {
    await cloud.add(baseUrl + "/api/masuk", {
        name: "masuk",
    });
    cloud.addCallback("masuk", function () {
        table.masuk.ajax.reload();
    });
});
