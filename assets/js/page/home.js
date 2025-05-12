export default class {
    #searchElem
    #inputElem
    isExecutable(url) {
        // {any*}/{queryParam}
        let regExp = new RegExp('^.*\/(\\?.*|)$');

        return regExp.test(url)
    }
    execute(event) {
        let self = this
        console.log('use home page executable')

        // constructor
        let contentElem = document.getElementById('rda_page_home_content')
        if (!contentElem) {
            console.error('Content Search element not found in home page. Search autocomplete offline.')
        }

        this.#searchElem = document.getElementsByTagName('search').length === 0 ? false : document.getElementsByTagName('search')[0]
        if (!this.#searchElem) {
            console.error('Search element not found in home page. Search autocomplete offline.')
        }

        this.#inputElem = document.getElementById('rda_search_bar_text_input')
        if (!this.#inputElem) {
            console.error('Search input element not found in home page. Search autocomplete offline.')
        }

        // Clean result listener
        document.addEventListener('click',  () => {
            self.#removeResults()
        })

        // Input listener
        this.#inputElem.addEventListener('input', () => {
            self.#removeResults()

            if (self.#inputElem.value.length < 3) {
                return
            }

            self.#getSearchResults(self.#inputElem.value).then((results) => {
                self. #displayResults(results)
            }).catch(function (error) {
                console.log(error)
            })
        })
    }

    async #getSearchResults(needle) {
        const response = await fetch('/api/search?needle='+needle);
        return await response.json();
    }

    #displayResults(results) {
        let resultsContainerElem = document.createElement("ul")
        resultsContainerElem.setAttribute('id', 'rda_search_bar_results')

        for (const result of results) {
            let resultElem = document.createElement("li")
            let resultLinkElem = document.createElement("a")
            resultLinkElem.setAttribute('class', 'rda-search-result-'+result.entity+' rda-'+result.entity+'-icon')
            resultLinkElem.setAttribute('href', '/'+result.entity+'s/'+result.id)
            resultLinkElem.innerText = result.name
            resultElem.appendChild(resultLinkElem)
            resultsContainerElem.appendChild(resultElem)
        }

        this.#removeResults()
        this.#searchElem.appendChild(resultsContainerElem)
        this.#addKeyFocus(resultsContainerElem)
    }

    #removeResults() {
        let resultsContainerElem = document.getElementById('rda_search_bar_results')
        if (resultsContainerElem) {
            resultsContainerElem.remove()
        }
    }

    #addKeyFocus(resultsContainerElem) {
        let self = this
        let currentFocus = -1
        document.addEventListener("keydown", function (keyBoardEvent) {
            // Do nothing if event already consumed
            if (keyBoardEvent.defaultPrevented) {
                return;
            }

            switch (keyBoardEvent.key) {
                case "ArrowDown":
                    // Stop at max
                    if (currentFocus === (resultsContainerElem.getElementsByTagName('li').length - 1)) {
                        break
                    }

                    currentFocus++
                    self.#setActive(resultsContainerElem, currentFocus)
                    break
                case "ArrowUp":
                    // Stop at min
                    if (currentFocus === 0) {
                        break
                    }

                    currentFocus--
                    self.#setActive(resultsContainerElem, currentFocus)
                    break
                case "Enter":
                    keyBoardEvent.preventDefault()
                    if (currentFocus > -1) {
                        resultsContainerElem.getElementsByTagName('li')[currentFocus].getElementsByTagName('a')[0].click()
                    }
                    break
                default:
                    return
            }

            // Avoid double trigger
            keyBoardEvent.preventDefault();
        },true);
    }

    #setActive(resultsContainerElem, currentFocus) {
        let results = resultsContainerElem.getElementsByTagName('li')
        for (let result of results) {
            result.removeAttribute('style')
        }

        results[currentFocus].setAttribute('style', 'background-color: white;')
    }
}
