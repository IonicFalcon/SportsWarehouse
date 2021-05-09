window.FontAwesomeConfig = {
    searchPseudoElements: true
}

function mobileMenuToggle(){
    let mobileMenu = document.querySelector(".mobileNav");
    mobileMenu.classList.toggle("checked");
}

$(".userOptions span.account").click(() => {
    if(screen.width > 450){
        let accountPopup = document.querySelector(".userOptions .accountPopup");
        let overlay = document.querySelector(".overlay");
        let body = document.querySelector(".root");

        accountPopup.classList.toggle("open")
        overlay.classList.toggle("modalOpen");
        body.classList.toggle("modalOpen");
    } else{
        mobileMenuToggle();
    }
});