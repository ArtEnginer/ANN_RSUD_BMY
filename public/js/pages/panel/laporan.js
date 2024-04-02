let lplpo = false;

$(document).ready(async function () {
    await cloud.add(baseUrl + "/api/obat", {
        name: "obat",
    });
    await cloud.add(baseUrl + "/api/masuk", {
        name: "masuk",
    });
    await cloud.add(baseUrl + "/api/keluar", {
        name: "keluar",
    });
    cloud.addCallback("masuk", function () {
        // table.obat.ajax.reload();
    });

    const mix = [...cloud.get("masuk"), ...cloud.get("keluar")]
        .map((v) => {
            if (v.tgl_keluar) {
                v.tanggal = v.tgl_keluar
                    ? moment(v.tgl_keluar).format("YYYY-MM-DD")
                    : "-";
                v.type = "keluar";
                v.keluar = v.qty;
                v.masuk = "-";
                v.permintaan = "-";
                delete v.tgl_keluar;
            }
            if (v.tgl_masuk) {
                v.tanggal = v.tgl_masuk
                    ? moment(v.tgl_masuk).format("YYYY-MM-DD")
                    : "-";
                v.type = "masuk";
                v.masuk = v.qty;
                v.keluar = "-";
                delete v.tgl_masuk;
            }
            return v;
        })
        .sort(function (a, b) {
            return new moment(a.tanggal) - new moment(b.tanggal);
        });
    console.log(mix);

    const container = document.querySelector("#lplpo");

    lplpo = new Handsontable(container, {
        data: [
            ["tanggal", "obat", "permintaan", "masuk", "keluar"],
            ...mix.map((v) => [v.tanggal, v.obat.nama, v.permintaan, v.masuk, v.keluar])
        ],
        rowHeaders: true,
        colHeaders: true,
        width: "100%",
        height: "auto",
        colWidths: [150, 200, 100, 100, 100],
        manualColumnResize: true,
        autoWrapRow: true,
        autoWrapCol: true,
        licenseKey: "non-commercial-and-evaluation", // for non-commercial use only
    });
});
