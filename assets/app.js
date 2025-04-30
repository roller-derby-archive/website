import './bootstrap.js'
import './styles/app.css'
import './styles/filters.css'
import './styles/infobox.css'
import './styles/team/game_list.css'
import './styles/page/main.css'
import './styles/header.css'
import './styles/widget/search_bar.css'
import './styles/page/flattrack_ranking.css'
import datepicker from 'js-datepicker'
import ClubListWatcherPage from './js/club/list.js'
import TeamListWatcherPage from './js/team/list.js'

const pages = [
    new ClubListWatcherPage(),
    new TeamListWatcherPage(),
]

let inputMemory = '';

const initSearchBar = function () {
    let timer = null
    document.getElementById("search_bar_text_input").addEventListener("input", function (event){
        if (timer != null) {
            window.clearTimeout(timer);
        }
        if (2 < event.target.value.length) {
            timer = setTimeout(function () {document.getElementById("search_bar_submit").click()}, 300)
        }

        inputMemory = event.target.value
    })
}

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

document.addEventListener("turbo:load", function (event) {
    console.log("turbo-load")

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
            btn.addEventListener("click", addFormToCollection)
        })
    ;

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

        if (document.getElementById("search_bar").getElementsByTagName('ul').length > 0) {
            document.getElementById("search_bar").getElementsByTagName('ul')[0].setAttribute('style', 'display:none;')
        }
    })
})

document.addEventListener("turbo:submit-end", function (event) {
    // history.pushState(history.state, null, event.detail.formSubmission.location.href)
})

document.addEventListener("turbo:frame-render", function (event) {
    console.log("turbo:frame-render")
    console.log(event.target)
    initSearchBar()
    document.getElementById("search_bar_text_input").value = inputMemory
    document.getElementById("search_bar_text_input").focus()
    document.getElementById("search_bar_text_input").selectionStart = document.getElementById("search_bar_text_input").selectionEnd = document.getElementById("search_bar_text_input").value.length;
})
