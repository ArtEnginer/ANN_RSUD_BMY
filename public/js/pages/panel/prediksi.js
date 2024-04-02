const openResult = async (data) => {
    $(`.stack-page[data-stack=result]`).addClass("active");
    $(`.stack-page[data-stack=form]`).removeClass("active");
    stackPush("result");
    // renderResult(data);
    console.log(data);
};

$("body").on("click", ".btn-view", (e) => {
    const el = $(e.currentTarget);
    const data = cloud.get("prediksi")?.find((v) => v.id == el.data("id"));
    renderResult(data.result);
    console.log(data);
});

let resMape = false;
let resGraph = false;
const renderResult = async (result) => {
    $("#result-data thead th").slice(1).remove();
    $("#result-data tbody tr td").remove();
    $("#result-dataset tbody").empty();
    $("#result-predict tbody").empty();
    $("#result-predict #min").text("0");
    $("#result-predict #max").text("0");
    $("#result-predict #average").text("0");

    $("#result-graph").empty();
    $("#result-mape").empty();

    const tahun = new Set();
    await cloud.pull("prediksi");
    const pred = await cloud
        .get("prediksi")
        .find((v) => v.id == result.id_prediction);

    $.each(result.raw, function (t, v) {
        const tgl = moment(t);
        tahun.add(tgl.year());
    });

    tahun.forEach(function (thn) {
        console.log(thn);
        $("#result-data thead tr").append(`<th>${thn}</th>`);
        $("#result-data tbody tr").append(`<td data-tahun="${thn}">-</td>`);
    });

    $.each(result.raw, function (t, v) {
        const tgl = moment(t);
        $(
            `#result-data tbody tr:nth-child(${
                tgl.month() + 1
            }) td[data-tahun="${tgl.year()}"]`
        ).text(v.qty);
    });
    $.each(pred.data, function (i, d) {
        $("#result-dataset tbody").append(
            `<tr><td>${i + 1}</td>
            <td>${d.x1}</td>
            <td>${d.x2}</td>
            <td>${d.x3}</td>
            <td>${d.x4}</td>
            <td>${d.x5}</td>
            <td>${d.x6}</td>
            <td>${d.x7}</td>
            <td>${d.x8}</td>
            <td>${d.x9}</td>
            <td>${d.x10}</td>
            <td>${d.x11}</td>
            <td>${d.x12}</td>
            <td>${d.y}</td>
            </tr>`
        );
    });
    $.each(pred.data, function (i, d) {
        $("#result-predict tbody").append(
            `<tr><td>${i + 1}</td>
            <td>${d.y}</td>
            <td>${result.predicts[i].toFixed(2)}</td>
            <td>JARAK</td>
            </tr>`
        );
    });
    console.log(result, tahun, pred);

    if (resMape) resMape.destroy();
    if (resGraph) resGraph.destroy();

    resMape = new Chart(document.getElementById("result-mape"), {
        type: "line",
        data: {
            labels: Object.keys(result.scores),
            datasets: [
                {
                    label: "MAPE",
                    data: Object.values(result.scores).map((v) => Math.abs(v)),
                    fill: false,
                    borderColor: "rgb(75, 192, 192)",
                    tension: 0.1,
                },
            ],
        },
    });
    resGraph = new Chart(document.getElementById("result-graph"), {
        type: "line",
        data: {
            labels: Object.keys(result.predicts),
            datasets: [
                {
                    label: "Aktual",
                    data: Object.values(pred.data).map((v) => v.y),
                    fill: false,
                    borderColor: "blue",
                    tension: 0.1,
                },
                {
                    label: "Prediksi",
                    data: Object.values(result.predicts),
                    fill: false,
                    borderColor: "orange",
                    tension: 0.1,
                },
            ],
        },
        options: {
            responsive: true,
            interaction: {
                mode: "index",
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: "Hasil Prediksi vs Aktual",
                },
            },
        },
    });
    $("#forecast").text(result.forecast);
};

$("body").on("click", ".btn-delete", function () {
    const el = $(this);
    const data = cloud.get("prediksi")?.find((v) => v.id == el.data("id"));
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
                url: baseUrl + "/api/prediksi/" + data.id,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: (res) => {
                    cloud.pull("prediksi");
                    Toast.fire({
                        icon: "success",
                        title: "Data berhasil di hapus",
                    });
                },
            });
        }
    });
});

$("body").on("submit", "#form-prediksi", function (e) {
    e.preventDefault();
    const data = {};
    $(this)
        .find("input, select")
        .each(function (i, e) {
            console.log($(this).attr("name"), $(this).val());
            if ($(this).attr("name")?.includes("[]")) {
                data[$(this).attr("name")] = data[$(this).attr("name")]
                    ? [...data[$(this).attr("name")], $(this).val()]
                    : [$(this).val()];
            } else {
                if ($(this).attr("name"))
                    data[$(this).attr("name")] = $(this).val();
            }
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
        url: baseUrl + (data.id ? "/api/prediksi/" + data.id : "/api/prediksi"),
        data: data,
        dataType: "json",
        success: async (res) => {
            if (!data.id) {
                $(this)[0].reset();
            }
            await cloud.pull("prediksi");
            console.log(res);
            // openResult(res);
            $(`.stack-page[data-stack=form]`).removeClass("active");
            Toast.fire({
                icon: "success",
                title: "Data berhasil di simpan",
            });
        },
    });
});

$("body").on("click", ".btn-layer", function (e) {
    e.preventDefault();
    $(this)
        .closest(".row")
        .before(
            `<div class="row"><div class="input-field col s10"><input name="layer[]" type="number" class="validate" required></div><div class="input-field col s2"><button class="btn waves-effect waves-light red remove-layer" type="button"><i class="material-icons">delete</i></button></div></div>`
        );
});
$("body").on("click", ".remove-layer", function (e) {
    e.preventDefault();
    if ($(".remove-layer").length <= 1) {
        return;
    }
    $(this)
        .closest(".row")
        .fadeOut("fast", function () {
            $(this).remove();
        });
});

$(document).ready(async function () {
    const table = {
        prediksi: $("table#prediksi").DataTable({
            processing: true,
            responsive: true,
            ajax: {
                url: baseUrl + "/api/prediksi",
                dataSrc: "",
            },
            columns: [
                {
                    data: "created_at",
                    render: function (data, type, row) {
                        return data.split("T")[0];
                    },
                },
                {
                    data: "obat",
                    render: function (data, type, row) {
                        return data.nama;
                    },
                },
                {
                    data: "layer",
                    render: function (data, type, row) {
                        return data;
                    },
                },
                {
                    data: "result.scores",
                    render: function (data, type, row) {
                        return Object.keys(data).length;
                    },
                },
                {
                    data: "result",
                    render: function (data, type, row) {
                        return Math.abs(data.scores[Object.keys(data.scores).length].toFixed(2));
                    },
                },
                {
                    data: "id",
                    render: function (data, type, row) {
                        const btnDelete =
                            cloud.get("user").group == "gudang"
                                ? `
                        <a href="#!" class="btn-action btn-delete red darken-2" data-id="${data}">
                            <i class="material-icons">delete</i>
                        </a>`
                                : "";
                        return `<div style="display: flex; gap: 5px; color: white;">
                  <a href="#!" class="btn-action stack-navigator btn-view blue darken-2" data-id="${data}" data-stack="open.result">
                      <i class="material-icons">visibility</i>
                  </a>
                  ${btnDelete}
              </div>`;
                    },
                },
            ],
        }),
    };
    await cloud.add(baseUrl + "/api/prediksi", {
        name: "prediksi",
    });
    cloud.addCallback("prediksi", function () {
        table.prediksi.ajax.reload();
    });
});
