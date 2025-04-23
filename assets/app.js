import './bootstrap.js'
import './styles/app.css'
import './styles/filters.css'
import './styles/infobox.css'
import './styles/game_list.css'
import './styles/page/main.css'
import './styles/page/flattrack_ranking.css'
import ClubListWatcherPage from './js/club/list.js'
import TeamListWatcherPage from './js/team/list.js'

const pages = [
    new ClubListWatcherPage(),
    new TeamListWatcherPage(),
]

document.addEventListener("turbo:load", function (event) {
    console.log("turbo-load")

    for (const page of pages) {
       if (page.isExecutable(event.detail.url)) {
           page.execute(event)
       }
    }
})

document.addEventListener("turbo:submit-end", function (event) {
    // history.pushState(history.state, null, event.detail.formSubmission.location.href)
})

document.addEventListener("turbo:render", function (event) {
    // console.log("render")
    // history.pushState(history.state, null, event.currentTarget.URL)
    // console.log(event.currentTarget.URL)
})
