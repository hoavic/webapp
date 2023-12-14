export function getPermalink(item) {
    if (item.type === 'post' || item.type === 'page') {
        return '/' + item.name;
    }
    return '/' + item.type + '/' + item.name;
}
