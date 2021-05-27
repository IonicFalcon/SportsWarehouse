$(".themeSelect").click(event=>{
    $(event.target).children("input").prop("checked", true).change();
});

$(".themeSelect input").change(event=>{
    document.querySelectorAll(".themeSelect").forEach(option=>{
        option.classList.remove("selected");
    });

    $(event.target).parent()[0].classList.add("selected");
    
});

$("#lightMode").change(()=>{
    document.querySelector(".root").style.background = "unset";
    document.querySelector(".customTheme").classList.remove("selected");

    document.cookie = "theme=light";
})

$("#darkMode").change(()=>{
    document.querySelector(".root").style.background = "#353935";
    document.querySelector(".customTheme").classList.remove("selected");

    document.cookie = "theme=dark";
})

$("#custom").change(()=>{
    document.querySelector(".customTheme").classList.add("selected");
})

$("#customColour").change(event=>{
    document.querySelector(".root").style.background = event.target.value;

    document.cookie = "theme=custom";
    document.cookie = `customTheme=${event.target.value}`;
})