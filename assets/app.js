import './bootstrap.js'
import './styles/app.css'
import ClubListWatcherPage from './js/club/list.js'
import TeamListWatcherPage from './js/team/list.js'



const pages = [
    new ClubListWatcherPage(),
    new TeamListWatcherPage(),
]

document.addEventListener("turbo:load", function (event) {
    //for (const page of pages) {
    //    if (page.isExecutable(event.detail.url)) {
    //        page.execute(event)
    //    }
    //}
})
