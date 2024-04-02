$(document).ready(async function () {
  await cloud.add(baseUrl + "/api/obat", {
    name: "obat",
  });
  await cloud.add(baseUrl + "/api/prediksi", {
    name: "prediksi",
  });
  cloud.addCallback("obat", function () {
    $(".counter[data-count=obat]").text(cloud.get("obat").length).counterUp({
      delay: 50,
      time: 100,
    });
  });
  cloud.addCallback("prediksi", function () {
    $(".counter[data-count=prediksi]").text(cloud.get("prediksi").length).counterUp({
      delay: 50,
      time: 100,
    });
  });
  cloud.pull();
});
