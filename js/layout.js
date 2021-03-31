window.FontAwesomeConfig = {
    searchPseudoElements: true
}

function mobileMenu(hamburgerMenu){
    let mobileMenu = document.querySelector(".mobileNav");

    if(hamburgerMenu.checked){
        mobileMenu.classList.add("checked");
    } else{
        mobileMenu.classList.remove("checked");
    }
}