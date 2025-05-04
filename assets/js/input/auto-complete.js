export default class {
    #input
    #items
    #searchItems = {}
    #selectCallback = function (id, value, input = null) {
        if (null === input) {
            return
        }

        input.value = value
    }
    #itemListClass
    #currentFocus

    /*
    * input: Dom element of type input
    * items: An associative array of id => text
    * selectCallback: an optional action callback to execute on select item. signature: function (id, value, input = null)
    */
    constructor(input, items, selectCallback = null) {
        this.#input = input;
        this.#items = items;
        if (null !== selectCallback) {
            this.#selectCallback = selectCallback;
        }

        // Improve search list
        for (let itemId in items) {
            this.#searchItems[itemId] = this.#formatForSearch(items[itemId])
        }

        this.#autocomplete()
        let self = this
        document.addEventListener("click", function (e) {
            self.#removeItemListClass()
        })
    }

    #autocomplete() {
        let self = this
        this.#input.addEventListener("input", function(event) {
            let inputValue = self.#formatForSearch(this.value)
            // Clean open list
            self.#removeItemListClass()

            // Ignore complete before 3 letter min.
            if (inputValue.length < 3) {
                return
            }

            // Create item list container and add it to parent dom element
            let itemListElement = document.createElement("ul")
            itemListElement.setAttribute('class', self.#itemListClass)
            this.parentNode.appendChild(itemListElement)

            // Same logic of SQL LIKE operator
            let regExp = new RegExp('.*'+inputValue+'.*')

            // Filter list with search value and create it
            for (let itemId in self.#searchItems) {
                let searchValue = self.#searchItems[itemId]
                if (regExp.test(searchValue)) {
                    let itemElement = document.createElement("li")
                    itemElement.innerText = self.#items[itemId]
                    itemElement.addEventListener('click', function(event) {
                        self.#selectCallback(itemId, self.#items[itemId], self.#input)
                        self.#input.value = ''
                    })
                    itemListElement.appendChild(itemElement)
                }
            }
        })
    }

    // Transform name like that "Women's Team Of Sweden" on "womensteamofsweden"
    #formatForSearch(value) {
        value = value.toLowerCase()
        return  value.replace(/[\W\d]/g,'');
    }

    // Clean open item list
    #removeItemListClass() {
        for (let itemList of document.getElementsByClassName(this.#itemListClass)) {
            itemList.remove()
        }
    }
}

function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value
        /*close any already open lists of autocompleted values*/
        closeAllLists()
        if (!val) { return false}
        currentFocus = -1
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV")
        a.setAttribute("id", this.id + "autocomplete-list")
        a.setAttribute("class", "autocomplete-items")
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a)
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV")
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>"
                b.innerHTML += arr[i].substr(val.length)
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>"
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists()
                })
                a.appendChild(b)
            }
        }
    })
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list")
        if (x) x = x.getElementsByTagName("div")
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++
            /*and and make the current item more visible:*/
            addActive(x)
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--
            /*and and make the current item more visible:*/
            addActive(x)
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault()
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click()
            }
        }
    })
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false
        /*start by removing the "active" class on all items:*/
        removeActive(x)
        if (currentFocus >= x.length) currentFocus = 0
        if (currentFocus < 0) currentFocus = (x.length - 1)
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active")
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active")
        }
    }
}
