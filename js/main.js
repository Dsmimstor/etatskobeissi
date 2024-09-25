

document.addEventListener("click",function(e){
if(e.target.classList.contains("gallery-item")){
const scr = e.target.getAttribute("src");
document.querySelector(".modal-img").src = src;
const myModal = new bootsrap.Modal(document.getElementById('gallery-modal'));
myModal.show();
}
})