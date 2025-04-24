import './bootstrap.js'
import './styles/app.css'
import './styles/filters.css'
import './styles/infobox.css'
import './styles/game_list.css'
import './styles/page/main.css'
import './styles/widget/search_bar.css'
import './styles/page/flattrack_ranking.css'
import ClubListWatcherPage from './js/club/list.js'
import TeamListWatcherPage from './js/team/list.js'

const pages = [
    new ClubListWatcherPage(),
    new TeamListWatcherPage(),
]

let inputMemory = '';

const initSearchBar = function () {
    let timer = null
    document.getElementById("search_bar").addEventListener("input", function (event){
        if (timer != null) {
            window.clearTimeout(timer);
        }
        if (2 < event.target.value.length) {
            timer = setTimeout(function () {document.getElementById("search_bar_submit").click()}, 500)
        }

        inputMemory = event.target.value
    })
}

document.addEventListener("turbo:load", function (event) {
    console.log("turbo-load")

    for (const page of pages) {
       if (page.isExecutable(event.detail.url)) {
           page.execute(event)
       }
    }

    initSearchBar()

    document.getElementsByTagName("body")[0].addEventListener('click', function (event) {
        if (event.target.closest('#search_results') !== null) {
            return
        }

        if (document.getElementById("search_results").getElementsByTagName('ul').length > 0) {
            document.getElementById("search_results").getElementsByTagName('ul')[0].setAttribute('style', 'display:none;')
        }
    })
})

document.addEventListener("turbo:submit-end", function (event) {
    // history.pushState(history.state, null, event.detail.formSubmission.location.href)
})

document.addEventListener("turbo:frame-render", function (event) {
    console.log("turbo:frame-render")
    initSearchBar()
    document.getElementById("search_bar").value = inputMemory
    document.getElementById("search_bar").focus()
    document.getElementById("search_bar").selectionStart = document.getElementById("search_bar").selectionEnd = document.getElementById("search_bar").value.length;
})
