window.onload = function () {
    console.log("Hello world!");
    var hocvien = document.getElementById("hocvien-btn");
    if (hocvien != null) {
        console.log("Read done")
    }
    else {
        console.log("Fucked somewhere")
    }
    hocvien.addEventListener("click", (e) => {
        document.getElementById("hocvienWrapper").style.display = "";
        document.getElementById("Procedure1Wrapper").style.display = "none";
    });

    var prod1 = document.getElementById("prod1-btn");
    prod1.addEventListener("click", (e) => {
        document.getElementById("hocvienWrapper").style.display = "none";
        document.getElementById("Procedure1Wrapper").style.display = "";
    });
};