const table = {
    pengguna: $("table#pengguna").DataTable({
        processing: true,
        responsive: true,
        ajax: {
            url: baseUrl + "/api/pengguna",
            dataSrc: "",
        },
        columns: [
            {
                data: "name",
                render: function (data, type, row) {
                    return data;
                },
            },
            {
                data: "email",
                render: function (data, type, row) {
                    return data;
                },
            },
            {
                data: "group",
                render: function (data, type, row) {
                    return data;
                },
            },
            {
                data: "id",
                render: function (data, type, row) {
                    return `<div style="display: flex; gap: 5px; color: white;">
              <a href="#!" class="btn-action stack-navigator btn-edit orange darken-1" data-id="${data}" data-stack="open.form" data-stack-title="Edit Data Pengguna">
                  <i class="material-icons">edit</i>
              </a>
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
    $("#form-pengguna")[0].reset();
    $("#form-pengguna [name=id]").val("");
});
$("body").on("click", ".btn-edit", function () {
    const el = $(this);
    const data = cloud.get("pengguna")?.find((v) => v.id == el.data("id"));
    $.each(data, function (i, v) {
        $("#form-pengguna [name=" + i + "]").val(v);
        $("select").formSelect();
    });
    M.updateTextFields();
    console.log(data);
});
$("body").on("click", ".btn-delete", function () {
    const el = $(this);
    const data = cloud.get("pengguna")?.find((v) => v.id == el.data("id"));
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
                url: baseUrl + "/api/pengguna/" + data.id,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: (res) => {
                    cloud.pull("pengguna");
                    Toast.fire({
                        icon: "success",
                        title: "Data berhasil di hapus",
                    });
                },
            });
        }
    });
});

$("body").on("submit", "#form-pengguna", function (e) {
    e.preventDefault();
    const data = {};
    $(this)
        .find("input, select")
        .each(function (i, e) {
            if ($(this).attr("name"))
                data[$(this).attr("name")] = $(this).val();
        });
    if (data.group == null) {
        Toast.fire({
            icon: "error",
            title: "Group Pengguna harus dipilih",
        });
        return;
    }
    console.log(data);
    $.ajax({
        type: data.id ? "PUT" : "POST",
        url: baseUrl + (data.id ? "/api/pengguna/" + data.id : "/api/pengguna"),
        data: data,
        dataType: "json",
        success: (res) => {
            if (!data.id) {
                $(this)[0].reset();
            }
            cloud.pull("pengguna");
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
        }
    });
});

$(document).ready(async function () {
    await cloud.add(baseUrl + "/api/pengguna", {
        name: "pengguna",
    });
    cloud.addCallback("pengguna", function () {
        table.pengguna.ajax.reload();
    });
});
