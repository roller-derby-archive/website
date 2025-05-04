export default class {
    levelMap = ['all', 'casual', 'n3', 'n2', 'n3', 'elite']
    isExecutable(url) {
        // {any*}/teams{queryParam}
        return new RegExp('^.*\/teams(\\?.*|)$').test(url)
    }
    execute(event) {
        this.setupFilter('list_filter_activity_', {'active': 'active', 'inactive': 'inactive', 'both': 'both'}, 'activity', 'active')
        this.setupFilter('list_filter_level_', {'casual': 'Loisir', 'n3':'N3', 'n2':'N2', 'n1':'N1', 'elite':'Elite'}, 'level', null, true)
        this.setupFilter('list_filter_category_', {'junior': 'J', 'fplus':'F+', 'mixed':'M'}, 'category', null, true)
        this.setupFilter('list_filter_type_', {'team_a': 'A', 'team_b': 'B', 'team_c': 'C', 'team_d': 'D', 'alliance': 'S', 'regional': 'R', 'national': 'N'}, 'type', null, true)

        document.getElementsByClassName('rda-reset-input')[0].addEventListener("click", (event) => {
            window.location.href = "/teams";
        })
    }

    setupFilter(idPrefix, values, filterName, defaultValue = null, multiple = false) {
        let url = new URL(window.location.href);
        let filterValues = multiple ? url.searchParams.getAll('filters['+filterName+'][]') : url.searchParams.get('filters['+filterName+']')

        if (multiple) {
            for (let key in values) {
                let value = values[key]
                for (let filterValue of filterValues) {
                    if (filterValue === value) {
                        document.getElementById(idPrefix+key).checked = true
                    }
                }

            }
        } else {
            for (let key in values) {
                let value = values[key]
                if (filterValues === value) {
                    document.getElementById(idPrefix+key).checked = true
                    return
                }
            }
        }


        if (defaultValue !== null) {
            document.getElementById(idPrefix+defaultValue).checked = true
        }
    }
}
