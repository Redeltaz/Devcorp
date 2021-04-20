let button_information = document.getElementById("switch-button-information")
let button_posts = document.getElementById("switch-button-posts")
let button_projects = document.getElementById("switch-button-projects")
let button_add_project = document.getElementById("button-add-project")
let isShowed = false


button_information.addEventListener('click', () => {
    document.getElementById('infos').style.display = "block"
    document.getElementById('user-posts').style.display = "none"
    document.getElementById('user-projects').style.display = "none"
})

button_posts.addEventListener('click', () => {
    document.getElementById('infos').style.display = "none"
    document.getElementById('user-projects').style.display = "none"
    document.getElementById('user-posts').style.display = "block"
})

button_projects.addEventListener('click', () => {
    document.getElementById('infos').style.display = "none"
    document.getElementById('user-projects').style.display = "block"
    document.getElementById('user-posts').style.display = "none"
})

button_add_project.addEventListener('click', () => {
    if(!isShowed){
        isShowed = true
        document.getElementById('projects-form-container').style.display = "block"
    } else {
        isShowed = false
        document.getElementById('projects-form-container').style.display = "none"
    }
})