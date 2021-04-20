let isShowed = false;

var responsiveButton = document.getElementById("responsive-button")
var nav = document.querySelector("nav")
var navContent = document.getElementById("navbar-content")
var searchBar = document.getElementById("search-bar")

window.addEventListener("resize", () => {
    if (window.innerWidth >= 1025) {
        navContent.style.cssText = "display: flex; height : auto"
        searchBar.style.display = "flex"
    }
})

responsiveButton.addEventListener("click", () => {
    if (isShowed == false) {
        navContent.style.cssText = "display: flex; height : 45vh"
        nav.style.cssText = "height: 50vh; position: fixed; width:100%"
        searchBar.style.display = "none"
        isShowed = true
    } else {
        navContent.style.cssText = "display: none; height : auto"
        nav.style.cssText = "height: auto; position : static; width:100%"
        isShowed = false
    }
})