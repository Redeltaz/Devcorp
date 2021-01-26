let like = document.querySelector(".like");
let totalLike = document.querySelector(".likeDisplay");
let dislike = document.querySelector(".dislike");
let totalDislike = document.querySelector(".dislikeDisplay")

like.addEventListener('click', async (e) => {
    e.preventDefault()

    let url = like.href;

    let res = await fetch(url)

    if(res.status === 403){
        alert("Connectez-vous")
        return false
    }

    let data = await res.json()
    totalLike.textContent = data.likes
})

dislike.addEventListener('click', async (e) => {
    e.preventDefault()

    let url = dislike.href;

    let res = await fetch(url)

    if(res.status === 403){
        alert("Connectez-vous")
        return false
    }

    let data = await res.json()
    totalDislike.textContent = data.dislikes
})