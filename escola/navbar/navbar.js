const hamburger = document.querySelector(".hamburger");
hamburger.onclick = () =>{
    navBar = document.querySelector(".nav-bar");
    navBar.classList.toggle("active");
}