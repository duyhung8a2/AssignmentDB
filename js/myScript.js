window.onload = function () {
console.log("Hello world!");
var lophoc = document.getElementById("lophoc-btn");
var hocvien = document.getElementById("hocvien-btn")
if (lophoc != null) {
    console.log("Read done")
}
else {
    console.log("Fucked somewhere")
}
lophoc.addEventListener("click", (e) => {
    document.getElementById("hocvienWrapper").style.display = "none";
    document.getElementById("lophocWrapper").style.display = "";
});

hocvien.addEventListener("click", (e) => {
    document.getElementById("hocvienWrapper").style.display = "";
    document.getElementById("lophocWrapper").style.display = "none";
});
};