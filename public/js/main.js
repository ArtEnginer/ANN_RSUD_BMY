const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});

const cloud = new Puller();

function stackPush(page) {
    $(".stack-navbar").fadeOut(400, () => {
        setTimeout(() => {
            $(`.stack-navbar[data-stack=${page}]`).fadeIn("fast");
        }, 400);
    });
    $(".stack-title").fadeOut(400, () => {
        setTimeout(() => {
            $(`.stack-title[data-stack=${page}]`).fadeIn("fast");
        }, 400);
    });
}

$("body").on("click", ".stack-navigator", function (e) {
    e.preventDefault();
    const el = $(this);
    const [action, page] = el.data("stack").split(".");
    switch (action) {
        case "open":
            $(`.stack-page[data-stack=${page}]`).addClass("active");
            stackPush(page);
            break;
        case "close":
            const prev = el.data("stack-prev");
            $(`.stack-page[data-stack=${page}]`).removeClass("active");
            stackPush(prev);
            break;
        default:
            break;
    }
    if (el.data("stack-title")) {
        $(`.stack-title[data-stack=${page}]`).text(el.data("stack-title"));
    }
});

$(document).ready(function () {
    $("select").formSelect();

    $(".navbar-item").removeClass("active");
    $(`.navbar-item[data-page=${page}]`).addClass("active");
});
