// const getQueryParams = (url) => {
//     const paramArr = url.slice(url.indexOf('?') + 1).split('&');
//     const params = {};
//     paramArr.map(param => {
//         const [key, val] = param.split('=');
//         params[key] = decodeURIComponent(val);
//     })
//     return params;
// }

const urlParams = new URLSearchParams(window.location.search);
let orderKey = urlParams.get('orderKey');
let orderDirection = urlParams.get('orderDirection');

window.MyApp = {
    sortData: (sort) => {
        if (sort === orderKey) {
            MyApp.filterFn({
                orderKey: sort,
                orderDirection: orderDirection === 'asc' ? 'desc' : 'asc'
            })
        } else {
            MyApp.filterFn({
                orderKey: sort,
                orderDirection: 'asc'
            })
        }
    },

    filterFn: (filterObject) => {
        const page = 1
        const data = {...filterObject, page}

        let url = new URL(window.location.href);
        let params = new URLSearchParams(url.search);

        for (const key in data) {
            params.set(key, data[key]);
        }

        window.location.href = `${window.location.href.split('?')[0]}?${params.toString()}`
    }
}
