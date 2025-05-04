import inputAutocomplete from '../input/auto-complete.js'

export default class {
    isExecutable(url) {
        // {any*}/club/{uuid*}/edit/{queryParam}
        let regExp = new RegExp('^.*\/clubs\/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\/edit(\\?.*|)$');

        return regExp.test(url)
    }
    execute(event) {
        console.log('use club edit executable')
        let items = {}

        let itemList = document.getElementById('club_teams')

        for (let inputItem of itemList.getElementsByTagName('input')) {
            let itemId = inputItem.getAttribute('id')
            if (itemId === null) {
                console.warn('edit:execute: id not found')
                return
            }

            let tryGetLabel = document.querySelectorAll('[for="'+itemId+'"]')
            if (tryGetLabel.length !== 1) {
                console.warn('edit:execute: label not found for input with id '+ itemId)
                return
            }
            let labelItem = tryGetLabel[0]

            // Warning, can remove additional class
            if (inputItem.checked) {
                labelItem.removeAttribute('class')
            } else {
                labelItem.setAttribute('class', 'rda-display-none')
            }

            items[itemId] = labelItem.innerText

            inputItem.addEventListener('change', function(event) {
                if (confirm('Souhaitez vous vraiment retirer cette équipe de l\'association?')) {
                    labelItem.setAttribute('class', 'rda-display-none')
                } else {
                    inputItem.checked = true
                }
            })
        }

        itemList.removeAttribute('class')
        itemList.setAttribute('class', 'rda-list-wrapper')


        new inputAutocomplete(document.getElementById(
            'test_auto_input'), items, function (id, value, input) {
                document.getElementById(id).checked = true
                document.getElementById(id).removeAttribute('class')
                document.querySelectorAll('[for="'+id+'"]')[0].removeAttribute('class')
            }
        )
    }
}
