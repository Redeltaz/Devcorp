let searchInput = document.querySelector('.search')
let container = document.querySelector('.container')

searchInput.addEventListener('input', async () => {
    let searchValue = searchInput.value
    let res;

    if(searchValue === ""){
        res = await fetch('/forum/allPostes')
    }else{
        res = await fetch(`/forum/allPostes?search=${searchValue}`)
    }

    let data = await res.json()

    container.innerHTML = ""
    data.forEach((poste) => {
        let newPoste = document.createElement('div')
        newPoste.setAttribute('class', 'content')

        newPoste.innerHTML = `<hr>
        <a href="/forum/show/${poste.id}" class="show">
        <h1 class="posteTitle">${poste.title}</h1>
        <p class="posteUser" class="posteUser">${poste.user}</p>
        <p class="posteContent">${poste.content}</p>
        `

        let langages = document.createElement('div')
        langages.setAttribute('class', 'posteLangages')
        poste.langages.forEach((langage) => {
            let newLangage = document.createElement('p')
            newLangage.textContent = langage
            langages.appendChild(newLangage)
        })
        newPoste.appendChild(langages)
        
        container.appendChild(newPoste)
    })
});