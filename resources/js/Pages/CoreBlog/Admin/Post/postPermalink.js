export function getPermalink(item, props) {
    if (item.type === 'post' || item.type === 'page') {
        return '/' + item.name;
    }
    let post_slug = '';
    if(props.admin.post_types[item.type].rewrite) {
        post_slug = props.admin.post_types[item.type].rewrite;
    } else {
        post_slug = props.admin.post_types[item.type].type;
    }
    return '/' + post_slug + '/' + item.name;
}
