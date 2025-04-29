export default class {
    levelMap = ['all', 'casual', 'n3', 'n2', 'n3', 'elite']
    isExecutable(url) {
        // {any*}/teams{queryParam}
        return new RegExp('^.*\/teams(\\?.*)$').test(url)
    }
    execute(event) {
        console.log('use team list executable')
        let url = new URL(window.location.href);
        let activity = url.searchParams.get('filters[activity]')

        switch (activity) {
            case 'active':
                document.getElementById("list_filter_activity_active").checked = true;break;
            case 'inactive':
                document.getElementById("list_filter_activity_inactive").checked = true;break;
            case 'both':
                document.getElementById("list_filter_activity_both").checked = true;break;
            default:
                document.getElementById("list_filter_activity_active").checked = true;break;
        }

        document.getElementsByClassName('rda-reset-input')[0].addEventListener("click", (event) => {
            window.location.href = "/teams";
        })
    }
}
