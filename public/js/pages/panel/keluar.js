const table = {
    keluar: $("table#keluar").DataTable({
        processing: true,
        responsive: true,
        ajax: {
            url: baseUrl + "/api/keluar",
            dataSrc: "",
        },
        columns: [
            {
                data: "tgl_keluar",
            },
            {
                data: "obat",
                render: function (data, type, row) {
                    return data.nama;
                },
            },
            {
                data: "qty",
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
    $("#form-keluar")[0].reset();
    $("#form-keluar [name=id]").val("");
});
$("body").on("click", ".btn-delete", function () {
    const el = $(this);
    const data = cloud.get("keluar")?.find((v) => v.id == el.data("id"));
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
                url: baseUrl + "/api/keluar/" + data.id,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: (res) => {
                    cloud.pull("keluar");
                    Toast.fire({
                        icon: "success",
                        title: "Data berhasil di hapus",
                    });
                },
            });
        }
    });
});

$("body").on("submit", "#form-keluar", function (e) {
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
        url: baseUrl + (data.id ? "/api/keluar/" + data.id : "/api/keluar"),
        data: data,
        dataType: "json",
        success: (res) => {
            if (!data.id) {
                $(this)[0].reset();
            }
            cloud.pull("keluar");
            Toast.fire({
                icon: "success",
                title: "Data berhasil di simpan",
            });
        },
        error: (jqXHR, textStatus, errorThrown) => {
            Toast.fire({
                icon: "error",
                title: jqXHR.responseJSON.message,
            });
        },
    });
});

$(document).ready(async function () {
    await cloud.add(baseUrl + "/api/keluar", {
        name: "keluar",
    });
    cloud.addCallback("keluar", function () {
        table.keluar.ajax.reload();
    });
});
