export default class {
    //isExecutable() {
    //    // {any*}/club/{uuid*}{queryParam}
    //    let matches = text.match(/^.*\/clubs\/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}(\?.*)$/)
    //}
    isExecutable(url) {
        // {any*}/clubs{queryParam}
        let regExp = new RegExp('^.*\/clubs(\\?.*|)$');

        return regExp.test(url)
    }
    execute(event) {
        console.log('use club list executable')
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
            window.location.href = "/clubs";
        })
    }
}
