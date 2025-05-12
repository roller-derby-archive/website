import './bootstrap.js'
import './styles/app.scss'
import './styles/team/game_list.css'
import './styles/page/flattrack_ranking.css'
import 'js-datepicker/dist/datepicker.min.css'
import datepicker from 'js-datepicker'
import ClubListWatcherPage from './js/club/list.js'
import ClubEditWatcherPage from './js/club/edit.js'
import TeamListWatcherPage from './js/team/list.js'
import HomeWatcherPage from './js/page/home.js'

const pages = [
    new ClubListWatcherPage(),
    new ClubEditWatcherPage(),
    new TeamListWatcherPage(),
    new HomeWatcherPage(),
]

function addFormToCollection(e) {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
    );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
}

document.addEventListener('turbo:load', function (event) {
    console.log('turbo-load')

    for (const themeButton of document.getElementsByClassName('rda-theme')) {
        themeButton.addEventListener('click', function (event) {
            console.log("themeName="+event.target.getAttribute('value'))
            document.cookie = "themeName="+event.target.getAttribute('value')
        })
    }

    if (0 !== document.getElementsByClassName('js-datepicker').length) {
        datepicker('.js-datepicker', {
            formatter: (input, date, instance) => {
                input.value = date.toLocaleDateString()
            }
        })
    }

    document
        .querySelectorAll('.add_item_link')
        .forEach(btn => {
            btn.addEventListener('click', addFormToCollection)
        })
    ;

    for (const page of pages) {
       if (page.isExecutable(event.detail.url)) {
           page.execute(event)
       }
    }
})
