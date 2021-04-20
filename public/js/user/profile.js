let button_information = document.getElementById("switch-button-information")
let button_posts = document.getElementById("switch-button-posts")

button_information.addEventListener('click', () => {
    document.getElementById('infos').style.display = "block"
    document.getElementById('user-posts').style.display = "none"
})

button_posts.addEventListener('click', () => {
    document.getElementById('infos').style.display = "none"
    document.getElementById('user-posts').style.display = "block"
})