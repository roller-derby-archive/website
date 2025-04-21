export default class {
    levelMap = ['all', 'casual', 'n3', 'n2', 'n3', 'elite']
    isExecutable(url) {
        // {any*}/teams{queryParam}
        return new RegExp('^.*\/teams(/?.*)$').test(url)
    }
    execute(event) {
        const filter = document.getElementById("list_filter_button")

        let url = new URL(window.location.href);
        let showDisband = url.searchParams.get('filters[show_disband]')

        if (showDisband === 'all') {
            document.getElementById('list_filter_activity_all').checked = true;
        }

        if (showDisband === 'only') {
            document.getElementById('list_filter_activity_off').checked = true;
        }

        if (showDisband === null ) {
            document.getElementById('list_filter_activity_on').checked = true;
        }

        filter.addEventListener('input', e => {
            let url = new URL(window.location.href);

            if (e.target.value === 'all') {
                url.searchParams.set('filters[show_disband]', 'all');
            }

            if (e.target.value === 'off') {
                url.searchParams.set('filters[show_disband]', 'only');
            }

            if (e.target.value === 'on') {
                url.searchParams.delete('filters[show_disband]');
            }

            if (e.target.value === 'N1') {
                url.searchParams.set('filters[level]', 'N1;N2');
            }

            window.location.href = url.href;
        })
    }
}
