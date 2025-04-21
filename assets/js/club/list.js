export default class {
    //isExecutable() {
    //    // {any*}/club/{uuid*}{queryParam}
    //    let matches = text.match(/^.*\/clubs\/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}(\?.*)$/)
    //}

    isExecutable(url) {
        // {any*}/clubs{queryParam}
        let regExp = new RegExp('^.*\/clubs(/?.*)$');

        return regExp.test(url)
    }
    execute(event) {
        const filter = document.getElementById("club_list_filter")

        let url = new URL(window.location.href);
        let show_closed = url.searchParams.get('filters[show_closed]')

        if (show_closed === 'all') {
            document.getElementById("list_filter_activity_all").checked = true;
        }

        if (show_closed === 'only') {
            document.getElementById("list_filter_activity_off").checked = true;
        }

        if (show_closed === null ) {
            document.getElementById("list_filter_activity_on").checked = true;
        }

        filter.addEventListener('input', e => {
            let url = new URL(window.location.href);

            if (e.target.value === 'all') {
                url.searchParams.set('filters[show_closed]', 'all');
            }

            if (e.target.value === 'off') {
                url.searchParams.set('filters[show_closed]', 'only');
            }

            if (e.target.value === 'on') {
                url.searchParams.delete('filters[show_closed]');
            }

            window.location.href = url.href;
        })
    }
}
